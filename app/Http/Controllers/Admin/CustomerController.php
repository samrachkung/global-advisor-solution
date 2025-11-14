<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        Gate::authorize('viewAny', Customer::class);

        $query = Customer::with(['loanType', 'owner'])
            ->orderByRaw("FIELD(status,'draft','complete')")
            ->orderBy('created_at', 'desc');

        // sales/marketing: show own first or all? keep all but highlight ownership
        if (in_array(auth()->user()->role, ['sale', 'marketing'])) {
            // optionally filter by owner: $query->where('owner_id', auth()->id());
        }

        $customers = $query->paginate(20);
        return view('admin.customers.index', compact('customers'));
    }

    public function create()
    {
        \Illuminate\Support\Facades\Gate::authorize('create', Customer::class);
        $loanTypes = LoanType::where('status', 'active')->orderBy('order')->get();
        return view('admin.customers.create', compact('loanTypes'));
    }
    public function store(Request $request)
    {
        Gate::authorize('create', Customer::class);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:30',
            'loan_amount' => 'nullable|numeric|min:0',
            'loan_type_id' => 'nullable|exists:loan_types,id',
            'consultation' => 'nullable|string|max:100',
            'consultation_fee' => 'nullable|numeric|min:0',
            'consultation_date' => 'nullable|date',
            'consultation_time' => 'nullable|date_format:H:i',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx|max:5120',
            'action' => 'required|in:save,save_draft', // coming from submit buttons
        ]);

        $data['status'] = $data['action'] === 'save_draft' ? 'draft' : 'complete';
        unset($data['action']);

        $data['owner_id'] = auth()->id();
        $data['created_by'] = auth()->id();

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('customers', 'public');
        }

        $customer = Customer::create($data);

        return redirect()->route('admin.customers.index')->with('success', $customer->status === 'draft' ? 'Customer saved as draft.' : 'Customer saved.');
    }

    public function edit(Customer $customer)
    {
        Gate::authorize('update', $customer);
        $loanTypes = LoanType::where('status', 'active')->orderBy('order')->get();
        return view('admin.customers.edit', compact('customer', 'loanTypes'));
    }

    public function update(Request $request, Customer $customer)
    {
        Gate::authorize('update', $customer);

        $data = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:30',
            'loan_amount' => 'nullable|numeric|min:0',
            'loan_type_id' => 'nullable|exists:loan_types,id',
            'consultation' => 'nullable|string|max:100',
            'consultation_fee' => 'nullable|numeric|min:0',
            'consultation_date' => 'nullable|date',
            'consultation_time' => 'nullable|date_format:H:i',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx|max:5120',
            'action' => 'nullable|in:save,save_draft', // only used in edit if you keep both buttons
        ]);

        if ($request->has('action')) {
            $data['status'] = $data['action'] === 'save_draft' ? 'draft' : 'complete';
        }
        unset($data['action']);

        if ($request->hasFile('attachment')) {
            // optional: delete old file
            if ($customer->attachment)
                \Storage::disk('public')->delete($customer->attachment);
            $data['attachment'] = $request->file('attachment')->store('customers', 'public');
        }

        $customer->update($data);

        return redirect()->route('admin.customers.index')->with('success', 'Customer updated.');
    }

    public function complete(Customer $customer)
    {
        Gate::authorize('complete', $customer);

        if ($customer->status === 'complete') {
            return back()->with('info', 'Already complete.');
        }

        $customer->update(['status' => 'complete']);

        return back()->with('success', 'Customer marked complete.');
    }

    public function share(Customer $customer)
    {
        \Illuminate\Support\Facades\Gate::authorize('share', $customer);

        $botToken = config('services.telegram.bot_token');
        $chatId = config('services.telegram.chat_id');

        if (!$botToken || !$chatId) {
            return back()->with('error', 'Telegram is not configured.');
        }
        if ($customer->shared_to_telegram) {
            return back()->with('info', 'Already shared to Telegram.');
        }
        if ($customer->status === 'draft') {
            return back()->with('error', 'Cannot share draft. Please complete it first.');
        }

        $loanTitle = optional($customer->loanType)->translation()?->title ?? 'មិនមាន';
        $dateOut = $customer->consultation_date ? \Carbon\Carbon::parse($customer->consultation_date)->format('Y-m-d') : 'មិនមាន';
        $timeOut = $customer->consultation_time ? \Carbon\Carbon::parse($customer->consultation_time)->format('H:i') : 'មិនមាន';
        $loanAmount = $customer->loan_amount !== null ? '$' . number_format((float) $customer->loan_amount, 2) : 'មិនមាន';
        $feeOut = $customer->consultation_fee !== null ? '$' . number_format((float) $customer->consultation_fee, 2) : 'មិនមាន';

        $escape = fn($t) => str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], (string) $t);

        // Sender info
        $sender = auth()->user();
        $senderName = $sender?->name ?? 'Unknown';
        $senderEmail = $sender?->email ?? 'N/A';

        // Build caption with "Sent by ..."
        $caption = "👥 <b>ពត៌មានបឋមអតិថិជន</b>\n\n";
        $caption .= "👤 <b>អតិថិជនឈ្មោះ៖</b> " . $escape($customer->customer_name) . "\n";
        $caption .= "📧 <b>អ៊ីមែល៖</b> " . $escape($customer->email ?? 'មិនមាន') . "\n";
        $caption .= "📞 <b>ទូរស័ព្ទ៖</b> " . $escape($customer->phone_number ?? 'មិនមាន') . "\n";
        $caption .= "💼 <b>ប្រភេទកម្ចី៖</b> " . $escape($loanTitle) . "\n";
        $caption .= "💵 <b>ទំហំកម្ចី៖</b> " . $loanAmount . "\n";
        $caption .= "🗂️ <b>ប្រឹក្សា៖</b> " . $escape($customer->consultation ?? 'មិនមាន') . "\n";
        $caption .= "💳 <b>តម្លៃប្រឹក្សា៖</b> " . $feeOut . "\n";
        $caption .= "📅 <b>កាលបរិច្ឆេទ៖</b> " . $dateOut . "\n";
        $caption .= "⏰ <b>ម៉ោងប្រឹក្សា៖</b> " . $timeOut . "\n\n";
        $caption .= "📨 <i>Sent by</i>: " . $escape($senderName) . " (" . $escape($senderEmail) . ")";

        $apiBase = "https://api.telegram.org/{$botToken}";

        // HTTPS verification options (production verifies CA; dev can skip)
        $options = [];
        $caPath = config('services.telegram.ca_path');
        if ($caPath)
            $options['verify'] = $caPath;

        $clientJson = \Illuminate\Support\Facades\Http::withOptions($options);
        $clientMp = \Illuminate\Support\Facades\Http::withOptions($options)->asMultipart();

        if (app()->environment('local')) {
            $clientJson = $clientJson->withoutVerifying();
            $clientMp = $clientMp->withoutVerifying();
        }

        // Attachment handling
        if ($customer->attachment) {
            $path = storage_path('app/public/' . $customer->attachment);
            if (is_file($path) && is_readable($path)) {
                $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
                $isImage = in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']);

                if ($isImage) {
                    $endpoint = "{$apiBase}/sendPhoto";
                    $payload = [
                        ['name' => 'chat_id', 'contents' => $chatId],
                        ['name' => 'photo', 'contents' => fopen($path, 'r'), 'filename' => basename($path)],
                        ['name' => 'caption', 'contents' => $caption],
                        ['name' => 'parse_mode', 'contents' => 'HTML'],
                    ];
                } else {
                    $endpoint = "{$apiBase}/sendDocument";
                    $payload = [
                        ['name' => 'chat_id', 'contents' => $chatId],
                        ['name' => 'document', 'contents' => fopen($path, 'r'), 'filename' => basename($path)],
                        ['name' => 'caption', 'contents' => $caption],
                        ['name' => 'parse_mode', 'contents' => 'HTML'],
                    ];
                }

                $res = $clientMp->post($endpoint, $payload);
            } else {
                $res = $clientJson->post("{$apiBase}/sendMessage", [
                    'chat_id' => $chatId,
                    'text' => $caption,
                    'parse_mode' => 'HTML',
                    'disable_web_page_preview' => true,
                ]);
            }
        } else {
            $res = $clientJson->post("{$apiBase}/sendMessage", [
                'chat_id' => $chatId,
                'text' => $caption,
                'parse_mode' => 'HTML',
                'disable_web_page_preview' => true,
            ]);
        }

        if ($res->successful()) {
            $customer->update(['shared_to_telegram' => true]);
            return back()->with('success', 'Shared to Telegram.');
        }

        \Illuminate\Support\Facades\Log::error('Telegram share failed', [
            'status' => $res->status(),
            'body' => $res->body()
        ]);
        return back()->with('error', 'Telegram share failed: ' . $res->status());
    }

    public function destroy(Customer $customer)
    {
        Gate::authorize('delete', $customer);
        $customer->delete();
        return back()->with('success', 'Customer deleted.');
    }
}
