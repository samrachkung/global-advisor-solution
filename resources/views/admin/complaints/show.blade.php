@extends('layouts.admin')

@section('title', 'Complaint Details')
@section('page-title', 'Complaint #' . $complaint->reference_number)

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Complaint Details</h5>
                <a href="{{ route('admin.complaints.index') }}" class="btn btn-sm btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back
                </a>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Reference Number:</strong><br>
                        <span class="text-primary">{{ $complaint->reference_number }}</span>
                    </div>
                    <div class="col-md-6">
                        <strong>Status:</strong><br>
                        <span class="badge bg-{{ $complaint->status == 'pending' ? 'warning' : 'success' }}">
                            {{ ucfirst($complaint->status) }}
                        </span>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Customer Name:</strong><br>
                        {{ $complaint->customer_name }}
                    </div>
                    <div class="col-md-6">
                        <strong>Email:</strong><br>
                        {{ $complaint->customer_email }}
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <strong>Phone:</strong><br>
                        {{ $complaint->customer_phone }}
                    </div>
                    <div class="col-md-6">
                        <strong>Priority:</strong><br>
                        <span class="badge bg-{{ $complaint->priority == 'high' ? 'danger' : 'warning' }}">
                            {{ ucfirst($complaint->priority) }}
                        </span>
                    </div>
                </div>

                <div class="mb-3">
                    <strong>Subject:</strong><br>
                    {{ $complaint->subject }}
                </div>

                <div class="mb-3">
                    <strong>Description:</strong><br>
                    <p class="mt-2">{{ $complaint->description }}</p>
                </div>

                @if($complaint->attachment)
                <div class="mb-3">
                    <strong>Attachment:</strong><br>
                    <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="btn btn-sm btn-info mt-2">
                        <i class="fas fa-download me-2"></i>Download Attachment
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Response Form -->
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">Add Response</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.complaints.respond', $complaint) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <textarea name="message" class="form-control" rows="4" placeholder="Type your response here..." required></textarea>
                    </div>
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="is_internal" id="is_internal">
                            <label class="form-check-label" for="is_internal">
                                Internal note (not visible to customer)
                            </label>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane me-2"></i>Send Response
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Update Status</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.complaints.update', $complaint) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select" required>
                            <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>Resolved</option>
                            <option value="closed" {{ $complaint->status == 'closed' ? 'selected' : '' }}>Closed</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Update Status
                    </button>
                </form>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Response History</h5>
            </div>
            <div class="card-body">
                @forelse($complaint->responses as $response)
                <div class="mb-3 pb-3 border-bottom">
                    <div class="d-flex justify-content-between mb-2">
                        <strong>{{ $response->user->name }}</strong>
                        <small class="text-muted">{{ $response->created_at->diffForHumans() }}</small>
                    </div>
                    <p class="mb-0">{{ $response->message }}</p>
                    @if($response->is_internal)
                    <span class="badge bg-secondary mt-2">Internal</span>
                    @endif
                </div>
                @empty
                <p class="text-muted text-center">No responses yet</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
