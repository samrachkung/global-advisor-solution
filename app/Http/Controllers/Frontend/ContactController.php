<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Complaint;
use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ContactController extends Controller
{
    public function index()
    {
        return view('frontend.contact');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string'
        ]);

        $message = ContactMessage::create($validated);

        // Telegram notify
        $this->notifyTelegramContact($message);

        return redirect()->back()->with('success', __('messages.message_sent'));
    }

    public function complaintForm()
    {
        $loanTypes = LoanType::where('status', 'active')->get();
        return view('frontend.complaint', compact('loanTypes'));
    }

    public function complaintStore(Request $request)
    {
        $validated = $request->validate([
            'customer_name'  => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'loan_type_id'   => 'nullable|exists:loan_types,id',
            'subject'        => 'required|string|max:255',
            'description'    => 'required|string',
            'attachment'     => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'priority'       => 'required|in:low,medium,high'
        ]);

        if ($request->hasFile('attachment')) {
            $validated['attachment'] = $request->file('attachment')->store('complaints', 'public');
        }

        $validated['status'] = 'pending';

        $complaint = Complaint::create($validated);

        // Telegram notify (optional)
        $this->notifyTelegramComplaint($complaint);

        return redirect()->back()->with('success', __('messages.complaint_submitted') . ' ' . ($complaint->reference_number ?? ''));
    }

    // ------------- Telegram helpers -------------

    private function notifyTelegramContact(ContactMessage $m): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId   = config('services.telegram.chat_id',   env('TELEGRAM_CHAT_ID'));

            if (!$botToken || !$chatId) {
                Log::warning('Telegram not configured for contact notification');
                return false;
            }

            // Important: token format must start with "bot"
            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";

            $escape = fn ($text) => str_replace(
                ['&', '<', '>'],
                ['&amp;', '&lt;', '&gt;'],
                (string) $text
            );

            $text  = "📨 <b>New Contact Message</b>\n\n";
            $text .= "👤 <b>Name:</b> "   . $escape($m->name)    . "\n";
            $text .= "📧 <b>Email:</b> "  . $escape($m->email)   . "\n";
            $text .= "📞 <b>Phone:</b> "  . $escape($m->phone ?? 'N/A') . "\n";
            $text .= "📝 <b>Subject:</b> ". $escape($m->subject) . "\n";
            $text .= "💬 <b>Message:</b>\n" . $escape($m->message) . "\n";
            $text .= "🕒 <b>Time:</b> "   . now()->format('Y-m-d H:i:s');

            $http = Http::withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json']);
            if (app()->environment('local')) $http = $http->withoutVerifying();

            $res = $http->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($res->successful()) {
                Log::info('Telegram contact sent', ['id' => $m->id, 'message_id' => $res->json()['result']['message_id'] ?? null]);
                return true;
            }

            Log::error('Telegram contact failed', ['id' => $m->id, 'status' => $res->status(), 'body' => $res->body()]);
            return false;

        } catch (\Throwable $e) {
            Log::error('Telegram contact exception: '.$e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return false;
        }
    }

    private function notifyTelegramComplaint(Complaint $c): bool
    {
        try {
            $botToken = config('services.telegram.bot_token', env('TELEGRAM_BOT_TOKEN'));
            $chatId   = config('services.telegram.chat_id',   env('TELEGRAM_CHAT_ID'));
            if (!$botToken || !$chatId) return false;

            $apiUrl = "https://api.telegram.org/{$botToken}/sendMessage";
            $escape = fn ($t) => str_replace(['&','<','>'], ['&amp;','&lt;','&gt;'], (string) $t);

            $text  = "⚠️ <b>New Complaint Submitted</b>\n\n";
            $text .= "👤 <b>Name:</b> "     . $escape($c->customer_name) . "\n";
            $text .= "📧 <b>Email:</b> "    . $escape($c->customer_email) . "\n";
            $text .= "📞 <b>Phone:</b> "    . $escape($c->customer_phone) . "\n";
            $text .= "🏷️ <b>Subject:</b> " . $escape($c->subject) . "\n";
            $text .= "📌 <b>Priority:</b> " . strtoupper($c->priority) . "\n";
            if ($c->loan_type_id) $text .= "💼 <b>Loan Type ID:</b> " . $c->loan_type_id . "\n";
            $text .= "📝 <b>Description:</b>\n" . $escape($c->description) . "\n";
            $text .= "🕒 <b>Time:</b> " . now()->format('Y-m-d H:i:s');

            $http = Http::withHeaders(['Accept' => 'application/json','Content-Type' => 'application/json']);
            if (app()->environment('local')) $http = $http->withoutVerifying();

            $res = $http->post($apiUrl, [
                'chat_id' => $chatId,
                'text' => $text,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);

            if ($res->successful()) {
                Log::info('Telegram complaint sent', ['id' => $c->id, 'message_id' => $res->json()['result']['message_id'] ?? null]);
                return true;
            }

            Log::error('Telegram complaint failed', ['id' => $c->id, 'status' => $res->status(), 'body' => $res->body()]);
            return false;

        } catch (\Throwable $e) {
            Log::error('Telegram complaint exception: '.$e->getMessage());
            return false;
        }
    }
}
