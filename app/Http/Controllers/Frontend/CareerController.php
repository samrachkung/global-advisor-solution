<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
            'cover_letter' => 'nullable|string'
        ]);

        if ($request->hasFile('resume')) {
            $validated['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $validated['job_position_id'] = $job->id;
        $validated['status'] = 'pending';

        JobApplication::create($validated);

        return redirect()->back()->with('success', __('messages.application_submitted'));
    }
}
