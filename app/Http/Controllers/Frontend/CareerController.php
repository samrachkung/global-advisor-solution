<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CareerController extends Controller
{
    public function index()
    {
        $jobs = JobPosition::open()
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('frontend.career.index', compact('jobs'));
    }

    public function show($slug)
    {
        $job = JobPosition::where('slug', $slug)
            ->open()
            ->firstOrFail();

        return view('frontend.career.show', compact('job'));
    }

    public function apply(Request $request, $slug)
    {
        $job = JobPosition::where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'full_name'    => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',

            // CV as 1–3 JPG/PNG images
            'resume'       => 'required|array|max:3',
            'resume.*'     => 'required|file|mimes:jpeg,jpg,png|max:5120',

            'cover_letter' => 'nullable|string',
        ]);

        // store each image
        $paths = [];
        if ($request->hasFile('resume')) {
            foreach ($request->file('resume') as $file) {
                $paths[] = $file->store('resumes', 'public');
            }
        }

        // save JSON of paths (adapt column type to text/json)
        $validated['resume']          = json_encode($paths);
        $validated['job_position_id'] = $job->id;
        $validated['status']          = 'pending';

        $application = JobApplication::create($validated);

        // 1) Text message in "Job Apply" topic
        $this->notifyTelegramJobApply($job, $application);

        // 2) Send 1–3 CV images
        $this->sendTelegramJobCvs($job, $application, $paths);

        return redirect()->back()->with('success', __('messages.application_submitted'));
    }

    /**
     * Text notification to Telegram "Job Apply" topic (no CV URL).
     */
    private function notifyTelegramJobApply(JobPosition $job, JobApplication $app): bool
    {
        try {
            $botToken = config('services.telegram.bot_token');
            $chatId   = config('services.telegram.chat_id');
            $threadId = (int) config('services.telegram.job_apply_thread_id', 0);

            if (!$botToken || !$chatId) {
                Log::warning('Telegram not configured for job apply');
                return false;
            }

            $escape = fn($t) => str_replace(
                ['&', '<', '>'],
                ['&amp;', '&lt;', '&gt;'],
                (string) $t
            );

            $jobTitle = $job->translation()?->title ?: $job->title ?: $job->slug;

            $lines   = [];
            $lines[] = "ពាក្យស្នើសុំការងារថ្មី";
            $lines[] = "";
            $lines[] = "ចំណងជើងការងារ / Job: " . $escape($jobTitle);
            $lines[] = "នាយកដ្ឋាន / Dept: "      . $escape($job->department ?? '-');
            $lines[] = "ទីតាំង / Location: "     . $escape($job->location ?? '-');
            $lines[] = "";
            $lines[] = "ឈ្មោះ / Name: "          . $escape($app->full_name);
            $lines[] = "អ៊ីមែល / Email: "        . $escape($app->email);
            $lines[] = "ទូរស័ព្ទ / Phone: "      . $escape($app->phone);
            $lines[] = "";
            if (!empty($app->cover_letter)) {
                $lines[] = "Cover Letter:";
                $lines[] = $escape(mb_strimwidth($app->cover_letter, 0, 500, '...'));
                $lines[] = "";
            }
            $lines[] = "ពេលវេលាទទួល / Received at: " . now()->format('Y-m-d H:i:s');

            $text = implode("\n", $lines);

            // same HTTP pattern as your working share() method
            $apiBase = "https://api.telegram.org/{$botToken}";
            $options = [];
            $caPath  = config('services.telegram.ca_path');
            if ($caPath) {
                $options['verify'] = $caPath;
            }

            $clientJson = Http::withOptions($options);
            if (app()->environment('local')) {
                $clientJson = $clientJson->withoutVerifying();
            }

            $payload = [
                'chat_id'                  => $chatId,
                'text'                     => $text,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => true,
            ];
            if ($threadId > 0) {
                $payload['message_thread_id'] = $threadId;
            }

            $res = $clientJson->post("{$apiBase}/sendMessage", $payload);

            if (!$res->successful()) {
                Log::error('Telegram job apply sendMessage failed', [
                    'status' => $res->status(),
                    'body'   => $res->body(),
                ]);
            }

            return $res->successful();
        } catch (\Throwable $e) {
            Log::error('Telegram job apply exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send up to 3 CV images (JPG/PNG) to "Job Apply" topic.
     * 1 image → sendPhoto; 2–3 images → sendMediaGroup album.
     */
    private function sendTelegramJobCvs(JobPosition $job, JobApplication $app, array $paths): bool
    {
        try {
            $botToken = config('services.telegram.bot_token');
            $chatId   = config('services.telegram.chat_id');
            $threadId = (int) config('services.telegram.job_apply_thread_id', 0);

            if (!$botToken || !$chatId || empty($paths)) {
                Log::warning('Telegram not configured for job CVs or no paths');
                return false;
            }

            $jobTitle = $job->translation()?->title ?: $job->title ?: $job->slug;
            $caption  = "CV / Resume\n"
                      . "Job: {$jobTitle}\n"
                      . "Name: {$app->full_name}\n"
                      . "Email: {$app->email}\n"
                      . "Phone: {$app->phone}";

            $apiBase = "https://api.telegram.org/{$botToken}";
            $options = [];
            $caPath  = config('services.telegram.ca_path');
            if ($caPath) {
                $options['verify'] = $caPath;
            }

            $clientMp = Http::withOptions($options)->asMultipart();
            if (app()->environment('local')) {
                $clientMp = $clientMp->withoutVerifying();
            }

            // If only one image, use sendPhoto
            if (count($paths) === 1) {
                $localPath = storage_path('app/public/' . ltrim($paths[0], '/'));
                if (!is_file($localPath) || !is_readable($localPath)) {
                    Log::warning('Single CV image not found: ' . $localPath);
                    return false;
                }

                $payload = [
                    ['name' => 'chat_id', 'contents' => $chatId],
                    ['name' => 'photo',   'contents' => fopen($localPath, 'r'), 'filename' => basename($localPath)],
                    ['name' => 'caption', 'contents' => $caption],
                    ['name' => 'parse_mode', 'contents' => 'HTML'],
                ];
                if ($threadId > 0) {
                    $payload[] = ['name' => 'message_thread_id', 'contents' => $threadId];
                }

                $res = $clientMp->post("{$apiBase}/sendPhoto", $payload);
                if (!$res->successful()) {
                    Log::error('Telegram single CV sendPhoto failed', [
                        'status' => $res->status(),
                        'body'   => $res->body(),
                    ]);
                }
                return $res->successful();
            }

            // 2–3 images: sendMediaGroup album
            $mediaJson = [];
            $files     = [];

            foreach ($paths as $index => $relativePath) {
                $localPath = storage_path('app/public/' . ltrim($relativePath, '/'));
                if (!is_file($localPath) || !is_readable($localPath)) {
                    Log::warning('CV image not found for mediaGroup: ' . $localPath);
                    continue;
                }

                $fieldName = "photo{$index}";
                $files[] = [
                    'name'     => $fieldName,
                    'contents' => fopen($localPath, 'r'),
                    'filename' => basename($localPath),
                ];

                $item = [
                    'type'  => 'photo',
                    'media' => "attach://{$fieldName}",
                ];
                if ($index === 0) {
                    $item['caption']    = $caption;
                    $item['parse_mode'] = 'HTML';
                }
                $mediaJson[] = $item;
            }

            if (empty($mediaJson)) {
                Log::warning('No valid CV images for mediaGroup');
                return false;
            }

            $payload = [
                ['name' => 'chat_id', 'contents' => $chatId],
                ['name' => 'media',   'contents' => json_encode($mediaJson)],
            ];
            if ($threadId > 0) {
                $payload[] = ['name' => 'message_thread_id', 'contents' => $threadId];
            }

            $payload = array_merge($payload, $files);

            $res = $clientMp->post("{$apiBase}/sendMediaGroup", $payload);

            if (!$res->successful()) {
                Log::error('Telegram CV sendMediaGroup failed', [
                    'status' => $res->status(),
                    'body'   => $res->body(),
                ]);
            }

            return $res->successful();
        } catch (\Throwable $e) {
            Log::error('Telegram job CVs exception: ' . $e->getMessage());
            return false;
        }
    }
}
