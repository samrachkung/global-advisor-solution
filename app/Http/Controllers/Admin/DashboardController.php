<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Initialize all stats with default values
        $stats = [
            'total_loan_types' => \App\Models\LoanType::count() ?? 0,
            'total_blog_posts' => 0,
            'published_posts' => 0,
            'total_jobs' => 0,
            'open_jobs' => 0,
            'pending_complaints' => 0,
            'total_complaints' => 0,
            'unread_messages' => 0,
            'total_applications' => 0,
            'pending_applications' => 0,
        ];

        // Safely get blog posts count
        try {
            $stats['total_blog_posts'] = \App\Models\BlogPost::count();
            $stats['published_posts'] = \App\Models\BlogPost::where('status', 'published')->count();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // Safely get jobs count
        try {
            $stats['total_jobs'] = \App\Models\JobPosition::count();
            $stats['open_jobs'] = \App\Models\JobPosition::where('status', 'open')->count();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // Safely get complaints count
        try {
            $stats['pending_complaints'] = \App\Models\Complaint::where('status', 'pending')->count();
            $stats['total_complaints'] = \App\Models\Complaint::count();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // Safely get messages count
        try {
            $stats['unread_messages'] = \App\Models\ContactMessage::where('is_read', false)->count();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // Safely get applications count
        try {
            $stats['total_applications'] = \App\Models\JobApplication::count();
            $stats['pending_applications'] = \App\Models\JobApplication::where('status', 'pending')->count();
        } catch (\Exception $e) {
            // Table doesn't exist yet
        }

        // Get recent data with error handling
        $recentComplaints = collect();
        $recentMessages = collect();
        $recentApplications = collect();

        try {
            $recentComplaints = \App\Models\Complaint::with('loanType')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist
        }

        try {
            $recentMessages = \App\Models\ContactMessage::orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist
        }

        try {
            $recentApplications = \App\Models\JobApplication::with('jobPosition')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        } catch (\Exception $e) {
            // Table doesn't exist
        }

        return view('admin.dashboard', compact('stats', 'recentComplaints', 'recentMessages', 'recentApplications'));
    }
}
