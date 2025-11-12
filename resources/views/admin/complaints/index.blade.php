@extends('layouts.admin')

@section('title', 'Complaints')
@section('page-title', 'Complaints Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Complaints</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Reference #</th>
                                <th>Customer</th>
                                <th>Email</th>
                                <th>Subject</th>
                                <th>Priority</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                            <tr>
                                <td><strong>{{ $complaint->reference_number }}</strong></td>
                                <td>{{ $complaint->customer_name }}</td>
                                <td>{{ $complaint->customer_email }}</td>
                                <td>{{ Str::limit($complaint->subject, 30) }}</td>
                                <td>
                                    <span class="badge bg-{{ $complaint->priority == 'high' ? 'danger' : ($complaint->priority == 'medium' ? 'warning' : 'secondary') }}">
                                        {{ ucfirst($complaint->priority) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $complaint->status == 'pending' ? 'warning' : ($complaint->status == 'resolved' ? 'success' : 'info') }}">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </td>
                                <td>{{ $complaint->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.complaints.show', $complaint) }}" class="btn btn-sm btn-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('admin.complaints.edit', $complaint) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
