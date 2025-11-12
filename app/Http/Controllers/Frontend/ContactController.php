<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Complaint;
use App\Models\LoanType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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

        ContactMessage::create($validated);

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

        return redirect()->back()->with('success', __('messages.complaint_submitted') . ' ' . $complaint->reference_number);
    }
}
