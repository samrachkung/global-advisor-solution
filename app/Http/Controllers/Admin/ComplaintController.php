<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\ComplaintResponse;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        $complaints = Complaint::with('loanType')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function show(Complaint $complaint)
    {
        $complaint->load(['loanType', 'responses.user']);
        return view('admin.complaints.show', compact('complaint'));
    }

    public function update(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,in_progress,resolved,closed',
        ]);

        $complaint->update($validated);

        if ($validated['status'] == 'resolved') {
            $complaint->update(['resolved_at' => now()]);
        }

        return redirect()->back()->with('success', 'Complaint status updated successfully');
    }

    public function respond(Request $request, Complaint $complaint)
    {
        $validated = $request->validate([
            'message' => 'required|string',
            'is_internal' => 'nullable|boolean',
        ]);

        ComplaintResponse::create([
            'complaint_id' => $complaint->id,
            'user_id' => auth()->id(),
            'message' => $validated['message'],
            'is_internal' => $request->has('is_internal'),
        ]);

        return redirect()->back()->with('success', 'Response added successfully');
    }

    public function destroy(Complaint $complaint)
    {
        $complaint->delete();
        return redirect()->route('admin.complaints.index')
            ->with('success', 'Complaint deleted successfully');
    }
}
