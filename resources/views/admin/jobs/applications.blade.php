@extends('layouts.admin')

@section('title', 'Job Applications')
@section('page-title', 'Job Applications')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Job Applications</h5>
                <a href="{{ route('admin.jobs.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to Jobs
                </a>
            </div>
            <div class="card-body">
                @if($applications->isEmpty())
                    <div class="text-center py-5">
                        <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                        <h4 class="text-muted">No Applications Yet</h4>
                        <p class="text-muted">Applications will appear here when candidates apply for jobs</p>
                    </div>
                @else
                    <div class="table-responsive">
                        <!-- REMOVE data-table class from here -->
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Position</th>
                                    <th>Status</th>
                                    <th>Applied Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($applications as $application)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td><strong>{{ $application->full_name }}</strong></td>
                                    <td>{{ $application->email }}</td>
                                    <td>{{ $application->phone }}</td>
                                    <td>
                                        @if($application->jobPosition)
                                            {{ $application->jobPosition->translation()?->title ?? 'N/A' }}
                                        @else
                                            N/A
                                        @endif
                                    </td>
                                    <td>
                                        @if($application->status == 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($application->status == 'reviewing')
                                            <span class="badge bg-info">Reviewing</span>
                                        @elseif($application->status == 'shortlisted')
                                            <span class="badge bg-primary">Shortlisted</span>
                                        @elseif($application->status == 'accepted')
                                            <span class="badge bg-success">Accepted</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>{{ $application->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <button type="button"
                                                class="btn btn-sm btn-primary"
                                                data-bs-toggle="modal"
                                                data-bs-target="#applicationModal{{ $application->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        @if($application->resume)
                                        <a href="{{ asset('uploads/resumes/' . $application->resume) }}"
                                           class="btn btn-sm btn-success"
                                           target="_blank">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        @endif
                                    </td>
                                </tr>

                                <!-- Application Detail Modal -->
                                <div class="modal fade" id="applicationModal{{ $application->id }}" tabindex="-1">
                                    <div class="modal-dialog modal-lg">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white">
                                                <h5 class="modal-title">Application Details</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Full Name:</strong><br>
                                                        {{ $application->full_name }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Email:</strong><br>
                                                        {{ $application->email }}
                                                    </div>
                                                </div>

                                                <div class="row mb-3">
                                                    <div class="col-md-6">
                                                        <strong>Phone:</strong><br>
                                                        {{ $application->phone }}
                                                    </div>
                                                    <div class="col-md-6">
                                                        <strong>Position Applied:</strong><br>
                                                        {{ $application->jobPosition->translation()?->title ?? 'N/A' }}
                                                    </div>
                                                </div>

                                                @if($application->cover_letter)
                                                <div class="mb-3">
                                                    <strong>Cover Letter:</strong>
                                                    <div class="border rounded p-3 mt-2" style="background: #f8f9fa;">
                                                        {{ $application->cover_letter }}
                                                    </div>
                                                </div>
                                                @endif

                                                @if($application->resume)
                                                <div class="mb-3">
                                                    <strong>Resume:</strong><br>
                                                    <a href="{{ asset('uploads/resumes/' . $application->resume) }}"
                                                       target="_blank"
                                                       class="btn btn-sm btn-success mt-2">
                                                        <i class="fas fa-download me-2"></i>Download Resume
                                                    </a>
                                                </div>
                                                @endif

                                                <div class="mb-3">
                                                    <strong>Update Status:</strong>
                                                    <form action="{{ route('admin.job-applications.update', $application) }}" method="POST" class="mt-2">
                                                        @csrf
                                                        @method('PATCH')
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <select name="status" class="form-select" required>
                                                                    <option value="pending" {{ $application->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                                                    <option value="reviewing" {{ $application->status == 'reviewing' ? 'selected' : '' }}>Reviewing</option>
                                                                    <option value="shortlisted" {{ $application->status == 'shortlisted' ? 'selected' : '' }}>Shortlisted</option>
                                                                    <option value="accepted" {{ $application->status == 'accepted' ? 'selected' : '' }}>Accepted</option>
                                                                    <option value="rejected" {{ $application->status == 'rejected' ? 'selected' : '' }}>Rejected</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <button type="submit" class="btn btn-primary w-100">
                                                                    <i class="fas fa-save me-2"></i>Update
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <a href="mailto:{{ $application->email }}" class="btn btn-primary">
                                                    <i class="fas fa-envelope me-2"></i>Email Applicant
                                                </a>
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($applications->hasPages())
                    <div class="mt-4">
                        {{ $applications->links() }}
                    </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
