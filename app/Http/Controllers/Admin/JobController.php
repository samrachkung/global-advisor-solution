<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobPosition;
use App\Models\JobPositionTranslation;
use App\Models\JobApplication;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPosition::with('translations')
            ->withCount('applications')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $languages = Language::where('status', 'active')->get();
        return view('admin.jobs.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'slug' => 'required|unique:job_positions|max:255',
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract',
            'salary_range' => 'nullable|string|max:255',
            'application_deadline' => 'nullable|date',
            'status' => 'required|in:open,closed',
            'title_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'requirements_en' => 'required|string',
            'responsibilities_en' => 'required|string',
            'benefits_en' => 'nullable|string',
            'title_km' => 'required|string|max:255',
            'description_km' => 'required|string',
            'requirements_km' => 'required|string',
            'responsibilities_km' => 'required|string',
            'benefits_km' => 'nullable|string',
        ]);

        $job = JobPosition::create([
            'slug' => Str::slug($validated['slug']),
            'department' => $validated['department'],
            'location' => $validated['location'],
            'employment_type' => $validated['employment_type'],
            'salary_range' => $validated['salary_range'],
            'application_deadline' => $validated['application_deadline'],
            'status' => $validated['status'],
        ]);

        // Create translations
        $enLang = Language::where('code', 'en')->first();
        JobPositionTranslation::create([
            'job_position_id' => $job->id,
            'language_id' => $enLang->id,
            'title' => $validated['title_en'],
            'description' => $validated['description_en'],
            'requirements' => $validated['requirements_en'],
            'responsibilities' => $validated['responsibilities_en'],
            'benefits' => $validated['benefits_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        JobPositionTranslation::create([
            'job_position_id' => $job->id,
            'language_id' => $kmLang->id,
            'title' => $validated['title_km'],
            'description' => $validated['description_km'],
            'requirements' => $validated['requirements_km'],
            'responsibilities' => $validated['responsibilities_km'],
            'benefits' => $validated['benefits_km'],
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job position created successfully');
    }

    public function edit(JobPosition $job)
    {
        $languages = Language::where('status', 'active')->get();
        $job->load('translations');

        return view('admin.jobs.edit', compact('job', 'languages'));
    }

    public function update(Request $request, JobPosition $job)
    {
        $validated = $request->validate([
            'slug' => 'required|max:255|unique:job_positions,slug,' . $job->id,
            'department' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'employment_type' => 'required|in:full-time,part-time,contract',
            'salary_range' => 'nullable|string|max:255',
            'application_deadline' => 'nullable|date',
            'status' => 'required|in:open,closed',
            'title_en' => 'required|string|max:255',
            'description_en' => 'required|string',
            'requirements_en' => 'required|string',
            'responsibilities_en' => 'required|string',
            'title_km' => 'required|string|max:255',
            'description_km' => 'required|string',
            'requirements_km' => 'required|string',
            'responsibilities_km' => 'required|string',
        ]);

        $job->update([
            'slug' => Str::slug($validated['slug']),
            'department' => $validated['department'],
            'location' => $validated['location'],
            'employment_type' => $validated['employment_type'],
            'salary_range' => $validated['salary_range'],
            'application_deadline' => $validated['application_deadline'],
            'status' => $validated['status'],
        ]);

        // Update translations
        $enLang = Language::where('code', 'en')->first();
        $job->translations()->where('language_id', $enLang->id)->update([
            'title' => $validated['title_en'],
            'description' => $validated['description_en'],
            'requirements' => $validated['requirements_en'],
            'responsibilities' => $validated['responsibilities_en'],
        ]);

        $kmLang = Language::where('code', 'km')->first();
        $job->translations()->where('language_id', $kmLang->id)->update([
            'title' => $validated['title_km'],
            'description' => $validated['description_km'],
            'requirements' => $validated['requirements_km'],
            'responsibilities' => $validated['responsibilities_km'],
        ]);

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job position updated successfully');
    }

    public function destroy(JobPosition $job)
    {
        $job->delete();

        return redirect()->route('admin.jobs.index')
            ->with('success', 'Job position deleted successfully');
    }

    public function applications()
    {
        $applications = JobApplication::with('jobPosition')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.jobs.applications', compact('applications'));
    }

    public function updateApplicationStatus(Request $request, JobApplication $application)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,reviewing,shortlisted,accepted,rejected',
        ]);

        $application->update($validated);

        return redirect()->back()->with('success', 'Application status updated successfully');
    }

}
