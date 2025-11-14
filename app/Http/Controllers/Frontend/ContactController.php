<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Complaint;
use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $message = ContactMessage::create($validated);
        $this->notifyTelegramContact($message);

        return back()->with('success', __('messages.message_sent'));
    }

    // Old complaint entrypoints (optional)
    public function complaintForm()
    {
        $loanTypes = LoanType::where('status', 'active')->get();
        return view('frontend.complaint', compact('loanTypes'));
    }

    public function complaintStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'loan_type_id' => 'nullable|exists:loan_types,id',
            'subject' => 'required|string|max:255',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'priority' => 'required|in:low,medium,high'
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('complaints', 'public');
        }

        $validated['status'] = 'pending';
        $complaint = Complaint::create($validated);
        $this->notifyTelegramComplaint($complaint);

        return back()->with('success', __('messages.complaint_submitted') . ' ' . ($complaint->reference_number ?? ''));
    }

    // New Quick Contact
    public function quickContactForm()
    {
        $loanTypes = LoanType::where('status', 'active')->orderBy('order')->get();
        return view('frontend.quick_contact', compact('loanTypes'));
    }

    public function quickContactStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'loan_type_id' => 'nullable|exists:loan_types,id',
            'loan_amount' => 'nullable|numeric|min:0',
            'consultation' => 'nullable|string|max:50',
            'consultation_date' => 'nullable|date',
            'consultation_time' => 'nullable|date_format:H:i',
        ]);

        $this->notifyTelegramQuickContact($validated);

        return back()->with('success', __('messages.message_sent'));
    }

    // =============== Telegram helpers (Khmer messages) ===============

    private function notifyTelegramContact(ContactMessage $m): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId = config('services.telegram.chat_id', env('TELEGRAM_CHAT_ID'));
            if (!$botToken || !$chatId) {
                Log::warning('Telegram not configured for contact');
                return false;
            }

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn($t) => str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], (string) $t);

            // Khmer content
            $text = "📨 <b>សារ​ទំនាក់ទំនង​ថ្មី</b>\n\n";
            $text .= "👤 <b>ឈ្មោះ :</b> " . $escape($m->name) . "\n";
            $text .= "📧 <b>អ៊ីមែល :</b> " . $escape($m->email) . "\n";
            $text .= "📞 <b>ទូរស័ព្ទ :</b> " . $escape($m->phone ?? 'មិន​មាន') . "\n";
            $text .= "📝 <b>ប្រធានបទ :</b> " . $escape($m->subject) . "\n";
            $text .= "💬 <b>សារ :</b>\n" . $escape($m->message) . "\n";
            $text .= "🕒 <b>ពេលវេលា :</b> " . now()->format('Y-m-d H:i:s');

            $http = Http::withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json']);
            if (app()->environment('local'))
                $http = $http->withoutVerifying();
            $res = $http->post($apiUrl, ['chat_id' => $chatId, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true]);

            if ($res->successful()) {
                Log::info('Telegram contact sent', ['id' => $m->id]);
                return true;
            }
            Log::error('Telegram contact failed', ['status' => $res->status(), 'body' => $res->body()]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Telegram contact exception: ' . $e->getMessage());
            return false;
        }
    }

    private function notifyTelegramComplaint(Complaint $c): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId = config('services.telegram.chat_id', env('TELEGRAM_CHAT_ID'));
            if (!$botToken || !$chatId)
                return false;

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn($t) => str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], (string) $t);

            // Khmer content
            $text = "⚠️ <b>ការប្តឹងថ្មី</b>\n\n";
            $text .= "👤 <b>ឈ្មោះ :</b> " . $escape($c->customer_name) . "\n";
            $text .= "📧 <b>អ៊ីមែល :</b> " . $escape($c->customer_email) . "\n";
            $text .= "📞 <b>ទូរស័ព្ទ :</b> " . $escape($c->customer_phone) . "\n";
            $text .= "🏷️ <b>ប្រធានបទ :</b> " . $escape($c->subject) . "\n";
            $text .= "📌 <b>អាទិភាព :</b> " . strtoupper($c->priority) . "\n";
            if ($c->loan_type_id)
                $text .= "💼 <b>ប្រភេទឥណទាន ID :</b> " . $c->loan_type_id . "\n";
            $text .= "📝 <b>ការពិពណ៌នា :</b>\n" . $escape($c->description) . "\n";
            $text .= "🕒 <b>ពេលវេលា :</b> " . now()->format('Y-m-d H:i:s');

            $http = Http::withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json']);
            if (app()->environment('local'))
                $http = $http->withoutVerifying();
            $res = $http->post($apiUrl, ['chat_id' => $chatId, 'text' => $text, 'parse_mode' => 'HTML', 'disable_web_page_preview' => true]);

            if ($res->successful()) {
                Log::info('Telegram complaint sent', ['id' => $c->id]);
                return true;
            }
            Log::error('Telegram complaint failed', ['status' => $res->status(), 'body' => $res->body()]);
            return false;
        } catch (\Throwable $e) {
            Log::error('Telegram complaint exception: ' . $e->getMessage());
            return false;
        }
    }

    private function notifyTelegramQuickContact(array $v): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId = config('services.telegram.chat_id', env('TELEGRAM_CHAT_ID'));
            if (!$botToken || !$chatId)
                return false;

            // Resolve loan type name (not ID)
            $loanName = null;
            if (!empty($v['loan_type_id'])) {
                $lt = \App\Models\LoanType::with('translations.language')->find($v['loan_type_id']);
                if ($lt) {
                    $loanName = $lt->translation()?->title ?: ($lt->slug ? ucfirst(str_replace('-', ' ', $lt->slug)) : null);
                }
            }

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn($t) => str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], (string) $t);

            // Build message with Khmer labels and no emojis, matching your example format
            $lines = [];
            $lines[] = "ទំនាក់ទំនងរហ័ស";
            $lines[] = "";
            $lines[] = "ឈ្មោះ : " . $escape($v['customer_name']);
            $lines[] = "អ៊ីមែល : " . $escape($v['customer_email']);
            $lines[] = "ទូរស័ព្ទ : " . $escape($v['customer_phone']);
            if ($loanName) {
                $lines[] = "ប្រភេទឥណទាន : " . $escape($loanName);
            }
            if (!empty($v['loan_amount'])) {
                $lines[] = "ចំនួនថវិកាកម្ចី : $" . number_format((float) $v['loan_amount'], 2);
            }
            if (!empty($v['consultation'])) {
                $lines[] = "ប្រភេទប្រឹក្សា : " . $escape($v['consultation']);
            }
            if (!empty($v['consultation_date'])) {
                $lines[] = "កាលបរិច្ឆេទប្រឹក្សា : " . $v['consultation_date'];
            }
            if (!empty($v['consultation_time'])) {
                $lines[] = "ម៉ោងប្រឹក្សា : " . $v['consultation_time'];
            }
            $lines[] = "ពេលវេលា : " . now()->format('Y-m-d H:i:s');

            $text = implode("\n", $lines);

            $http = \Illuminate\Support\Facades\Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/json'
            ]);
            if (app()->environment('local'))
                $http = $http->withoutVerifying();

            $res = $http->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML', // safe: labels are plain text in square brackets
                'disable_web_page_preview' => true,
            ]);

            return $res->successful();
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error('Telegram quick contact exception: ' . $e->getMessage());
            return false;
        }
    }

}
