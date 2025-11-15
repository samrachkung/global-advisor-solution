<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContactController extends Controller
{
    // Contact page
    public function index()
    {
        return view('frontend.contact');
    }

    // ---------- Normal contact form ----------

    public function store(Request $request)
    {
        // Validation
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to DB
        $message = ContactMessage::create($validated);

        // Notify Telegram (goes to topic)
        $this->notifyTelegramContact($message);

        return back()->with('success', __('messages.message_sent'));
    }

    // ---------- Quick Contact ----------

    public function quickContactForm()
    {
        $loanTypes = LoanType::where('status', 'active')
            ->orderBy('order')
            ->get();

        return view('frontend.quick_contact', compact('loanTypes'));
    }

    public function quickContactStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name'     => 'required|string|max:255',
            'customer_email'    => 'required|email|max:255',
            'customer_phone'    => 'required|string|max:20',
            'loan_type_id'      => 'nullable|exists:loan_types,id',
            'loan_amount'       => 'nullable|numeric|min:0',
            'consultation'      => 'nullable|string|max:50',
            'consultation_date' => 'nullable|date',
            'consultation_time' => 'nullable|date_format:H:i',
        ]);

        // Compute 12‑hour AM/PM string if time is provided
        if (!empty($validated['consultation_time'])) {
            $validated['consultation_time_12'] =
                Carbon::createFromFormat('H:i', $validated['consultation_time'])->format('g:i A');
        }

        $this->notifyTelegramQuickContact($validated);

        return back()->with('success', __('messages.message_sent'));
    }

    // ---------- Telegram helpers ----------

    /**
     * Send normal contact message to Telegram "New Customer" topic.
     */
    private function notifyTelegramContact(ContactMessage $m): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId   = config('services.telegram.chat_id',   env('TELEGRAM_CHAT_ID'));
            $threadId = (int) config('services.telegram.new_customer_thread_id', 0);

            if (!$botToken || !$chatId) {
                Log::warning('Telegram not configured for contact');
                return false;
            }

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn($t) => str_replace(
                ['&', '<', '>'],
                ['&amp;', '&lt;', '&gt;'],
                (string) $t
            );

            $text  = "<b>សារ​ទំនាក់ទំនង​ថ្មី</b>\n\n";
            $text .= "<b>ឈ្មោះ :</b> "    . $escape($m->name)             . "\n";
            $text .= "<b>អ៊ីមែល :</b> "   . $escape($m->email)            . "\n";
            $text .= "<b>ទូរស័ព្ទ :</b> " . $escape($m->phone ?? 'មិន​មាន') . "\n";
            $text .= "<b>ប្រធានបទ :</b> " . $escape($m->subject)          . "\n";
            $text .= "<b>សារ :</b>\n"     . $escape($m->message)          . "\n";
            $text .= "<b>ពេលវេលា :</b> " . now()->format('Y-m-d H:i:s');

            $http = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            $payload = [
                'chat_id'                  => $chatId,
                'text'                     => $text,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => true,
            ];

            // Send inside "New Customer" topic if thread id is configured
            if ($threadId > 0) {
                $payload['message_thread_id'] = $threadId;
            }

            $res = $http->post($apiUrl, $payload);

            return $res->successful();
        } catch (\Throwable $e) {
            Log::error('Telegram contact exception: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Send quick contact message to Telegram "New Customer" topic.
     */
    private function notifyTelegramQuickContact(array $v): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId   = config('services.telegram.chat_id',   env('TELEGRAM_CHAT_ID'));
            $threadId = (int) config('services.telegram.new_customer_thread_id', 0);

            if (!$botToken || !$chatId) {
                Log::warning('Telegram not configured for quick contact');
                return false;
            }

            // Resolve loan type display name
            $loanName = null;
            if (!empty($v['loan_type_id'])) {
                $lt = LoanType::with('translations.language')->find($v['loan_type_id']);
                if ($lt) {
                    $loanName = $lt->translation()?->title
                        ?: ($lt->slug ? ucfirst(str_replace('-', ' ', $lt->slug)) : null);
                }
            }

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn($t) => str_replace(
                ['&', '<', '>'],
                ['&amp;', '&lt;', '&gt;'],
                (string) $t
            );

            $lines   = [];
            $lines[] = "ពត៌មានបឋមអតិថិជន";
            $lines[] = "";
            $lines[] = "ឈ្មោះ : "   . $escape($v['customer_name']);
            $lines[] = "អ៊ីមែល : "  . $escape($v['customer_email']);
            $lines[] = "ទូរស័ព្ទ : " . $escape($v['customer_phone']);

            if ($loanName) {
                $lines[] = "ប្រភេទឥណទាន : " . $escape($loanName);
            }
            if (!empty($v['loan_amount'])) {
                $lines[] = "ចំនួនឥណទាន : $" . number_format((float) $v['loan_amount'], 2);
            }
            if (!empty($v['consultation'])) {
                $lines[] = "ប្រភេទប្រឹក្សា : " . $escape($v['consultation']);
            }
            if (!empty($v['consultation_date'])) {
                $lines[] = "កាលបរិច្ឆេទប្រឹក្សា : " . $v['consultation_date'];
            }

            if (!empty($v['consultation_time_12'])) {
                $lines[] = "ម៉ោងប្រឹក្សា : " . $v['consultation_time_12'];
            } elseif (!empty($v['consultation_time'])) {
                try {
                    $lines[] = "ម៉ោងប្រឹក្សា : " .
                        Carbon::createFromFormat('H:i', $v['consultation_time'])->format('g:i A');
                } catch (\Throwable $e) {
                    $lines[] = "ម៉ោងប្រឹក្សា : " . $v['consultation_time'];
                }
            }

            $text = implode("\n", $lines);

            $http = Http::withHeaders([
                'Accept'       => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            if (app()->environment('local')) {
                $http = $http->withoutVerifying();
            }

            $payload = [
                'chat_id'                  => $chatId,
                'text'                     => $text,
                'parse_mode'               => 'HTML',
                'disable_web_page_preview' => true,
            ];

            // Send inside "New Customer" topic if thread id is configured
            if ($threadId > 0) {
                $payload['message_thread_id'] = $threadId;
            }

            $res = $http->post($apiUrl, $payload);

            return $res->successful();
        } catch (\Throwable $e) {
            Log::error('Telegram quick contact exception: ' . $e->getMessage());
            return false;
        }
    }
}
