@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page-title', 'Contact Messages')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Contact Messages</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Subject</th>
                                <th>Status</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($messages as $message)
                            <tr class="{{ !$message->is_read ? 'table-warning' : '' }}">
                                <td>
                                    {{ $message->name }}
                                    @if(!$message->is_read)
                                    <span class="badge bg-danger">New</span>
                                    @endif
                                </td>
                                <td>{{ $message->email }}</td>
                                <td>{{ $message->phone ?? 'N/A' }}</td>
                                <td>{{ Str::limit($message->subject, 40) }}</td>
                                <td>
                                    <span class="badge bg-{{ $message->is_read ? 'secondary' : 'info' }}">
                                        {{ $message->is_read ? 'Read' : 'Unread' }}
                                    </span>
                                </td>
                                <td>{{ $message->created_at->format('M d, Y H:i') }}</td>
                                <td>
                                    <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#messageModal{{ $message->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    @if(!$message->is_read)
                                    <form action="{{ route('admin.messages.mark-read', $message) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">
                                            <i class="fas fa-check"></i>
                                        </button>
                                    </form>
                                    @endif
                                    <form action="{{ route('admin.messages.destroy', $message) }}" method="POST" class="d-inline" data-confirm>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>

                            <!-- Message Modal -->
                            <div class="modal fade" id="messageModal{{ $message->id }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">Message Details</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Name:</strong><br>{{ $message->name }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Email:</strong><br>{{ $message->email }}
                                                </div>
                                            </div>
                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <strong>Phone:</strong><br>{{ $message->phone ?? 'N/A' }}
                                                </div>
                                                <div class="col-md-6">
                                                    <strong>Date:</strong><br>{{ $message->created_at->format('F d, Y h:i A') }}
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <strong>Subject:</strong><br>{{ $message->subject }}
                                            </div>
                                            <div class="mb-3">
                                                <strong>Message:</strong>
                                                <div class="border rounded p-3 mt-2" style="background: #f8f9fa;">
                                                    {{ $message->message }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <a href="mailto:{{ $message->email }}" class="btn btn-primary">
                                                <i class="fas fa-reply me-2"></i>Reply via Email
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
            </div>
        </div>
    </div>
</div>
@endsection
