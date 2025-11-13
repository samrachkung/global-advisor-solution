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
        Gate::authorize('create', Customer::class);
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
            'status' => 'required|in:draft,complete',
        ]);

        $data['owner_id'] = auth()->id();

        $customer = Customer::create($data);

        return redirect()->route('admin.customers.index')->with('success', 'Customer saved.');
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
            'status' => 'required|in:draft,complete',
        ]);

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

        $loanTitle = optional($customer->loanType)->translation()?->title ?? 'មិនមាន';
        $dateOut = $customer->consultation_date ? \Carbon\Carbon::parse($customer->consultation_date)->format('Y-m-d') : 'មិនមាន';
        $timeOut = $customer->consultation_time ? \Carbon\Carbon::parse($customer->consultation_time)->format('H:i') : 'មិនមាន';
        $loanAmount = $customer->loan_amount !== null ? '$' . number_format((float) $customer->loan_amount, 2) : 'មិនមាន';
        $feeOut = $customer->consultation_fee !== null ? '$' . number_format((float) $customer->consultation_fee, 2) : 'មិនមាន';

        $escape = fn($t) => str_replace(['&', '<', '>'], ['&amp;', '&lt;', '&gt;'], (string) $t);

        $text = "👥 <b>ពត៌មានបឋមអតិថិជន</b>\n\n";
        $text .= "👤 <b>អតិថិជនឈ្មោះ៖</b> " . $escape($customer->customer_name) . "\n";
        $text .= "📧 <b>អ៊ីមែល៖</b> " . $escape($customer->email ?? 'មិនមាន') . "\n";
        $text .= "📞 <b>ទូរស័ព្ទ៖</b> " . $escape($customer->phone_number ?? 'មិនមាន') . "\n";
        $text .= "💼 <b>ប្រភេទកម្ចី៖</b> " . $escape($loanTitle) . "\n";
        $text .= "💵 <b>ទំហំកម្ចី៖</b> " . $loanAmount . "\n";
        $text .= "🗂️ <b>ប្រឹក្សា៖</b> " . $escape($customer->consultation ?? 'មិនមាន') . "\n";
        $text .= "💳 <b>តម្លៃប្រឹក្សា</b> " . $feeOut . "\n";
        $text .= "📅 <b>កាលបរិច្ឆេទ៖</b> " . $dateOut . "\n";
        $text .= "⏰ <b>ម៉ៅងប្រឹក្សា៖</b> " . $timeOut;

        $http = \Illuminate\Support\Facades\Http::withHeaders(['Accept' => 'application/json', 'Content-Type' => 'application/json']);
        if (app()->environment('local'))
            $http = $http->withoutVerifying();

        $res = $http->post("https://api.telegram.org/{$botToken}/sendMessage", [
            'chat_id' => $chatId,
            'text' => $text,
            'parse_mode' => 'HTML',
            'disable_web_page_preview' => true,
        ]);

        if ($res->successful()) {
            $customer->update(['shared_to_telegram' => true]);
            return back()->with('success', 'Shared to Telegram.');
        }

        \Illuminate\Support\Facades\Log::error('Customer share Telegram failed', ['status' => $res->status(), 'body' => $res->body()]);
        return back()->with('error', 'Telegram share failed: ' . $res->status());
    }


    public function destroy(Customer $customer)
    {
        Gate::authorize('delete', $customer);
        $customer->delete();
        return back()->with('success', 'Customer deleted.');
    }
}
