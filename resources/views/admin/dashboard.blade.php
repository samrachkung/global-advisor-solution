@extends('layouts.admin')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h2 class="mb-4">Welcome back, {{ auth()->user()->name }}!</h2>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card primary">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['total_loan_types'] }}</div>
                    <div class="stats-label">Loan Types</div>
                </div>
                <div class="stats-icon primary">
                    <i class="fas fa-hand-holding-usd"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card success">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['published_posts'] }}/{{ $stats['total_blog_posts'] }}</div>
                    <div class="stats-label">Blog Posts</div>
                </div>
                <div class="stats-icon success">
                    <i class="fas fa-newspaper"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card warning">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['pending_complaints'] }}</div>
                    <div class="stats-label">Pending Complaints</div>
                </div>
                <div class="stats-icon warning">
                    <i class="fas fa-exclamation-triangle"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card info">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['unread_messages'] }}</div>
                    <div class="stats-label">Unread Messages</div>
                </div>
                <div class="stats-icon info">
                    <i class="fas fa-envelope"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-xl-3 col-md-6">
        <div class="stats-card primary">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['open_jobs'] }}/{{ $stats['total_jobs'] }}</div>
                    <div class="stats-label">Open Positions</div>
                </div>
                <div class="stats-icon primary">
                    <i class="fas fa-briefcase"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card danger">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['pending_applications'] }}</div>
                    <div class="stats-label">Pending Applications</div>
                </div>
                <div class="stats-icon danger">
                    <i class="fas fa-file-alt"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card success">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['total_applications'] }}</div>
                    <div class="stats-label">Total Applications</div>
                </div>
                <div class="stats-icon success">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6">
        <div class="stats-card warning">
            <div class="stats-header">
                <div>
                    <div class="stats-number">{{ $stats['total_complaints'] }}</div>
                    <div class="stats-label">Total Complaints</div>
                </div>
                <div class="stats-icon warning">
                    <i class="fas fa-chart-bar"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Activity -->
<div class="row g-4">
    <!-- Recent Complaints -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Complaints</h5>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-add">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Ref #</th>
                                <th>Customer</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentComplaints as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->reference_number }}</strong></td>
                                <td>{{ $complaint->customer_name }}</td>
                                <td>
                                    <span class="badge bg-{{ $complaint->status == 'pending' ? 'warning' : 'success' }}">
                                        {{ ucfirst($complaint->status) }}
                                    </span>
                                </td>
                                <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No complaints yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Messages -->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Recent Messages</h5>
                <a href="{{ route('admin.messages.index') }}" class="btn btn-sm btn-add">
                    View All <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentMessages as $message)
                            <tr>
                                <td>{{ $message->name }}</td>
                                <td>{{ Str::limit($message->subject, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $message->is_read ? 'secondary' : 'info' }}">
                                        {{ $message->is_read ? 'Read' : 'New' }}
                                    </span>
                                </td>
                                <td>{{ $message->created_at->format('M d') }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted">No messages yet</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
