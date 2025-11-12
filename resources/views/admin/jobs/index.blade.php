@extends('layouts.admin')

@section('title', 'Job Positions')
@section('page-title', 'Job Positions Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Job Positions</h5>
                <a href="{{ route('admin.jobs.create') }}" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Add New Job
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Title</th>
                                <th>Department</th>
                                <th>Location</th>
                                <th>Type</th>
                                <th>Status</th>
                                <th>Applications</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($jobs as $job)
                            <tr>
                                <td><strong>{{ $job->translation()?->title }}</strong></td>
                                <td>{{ $job->department }}</td>
                                <td>{{ $job->location }}</td>
                                <td><span class="badge bg-info">{{ ucfirst($job->employment_type) }}</span></td>
                                <td>
                                    <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($job->status) }}
                                    </span>
                                </td>
                                <td>{{ $job->applications_count ?? 0 }}</td>
                                <td>
                                    <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" data-confirm>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
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
