@extends('layouts.admin')

@section('title', 'Slideshows')
@section('page-title', 'Slideshow Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Slideshows</h5>
                <a href="{{ route('admin.slideshows.create') }}" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Add New Slide
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slideshows as $slide)
                            <tr>
                                <td><strong>{{ $slide->order }}</strong></td>
                                <td>
                                    <img src="{{ asset('uploads/slideshows/' . $slide->image) }}"
                                         alt=""
                                         style="width: 100px; height: 60px; object-fit: cover; border-radius: 8px;">
                                </td>
                                <td>{{ $slide->translation()?->title }}</td>
                                <td>{{ Str::limit($slide->link, 30) ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-{{ $slide->status == 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($slide->status) }}
                                    </span>
                                </td>
                                <td>
                                    <a href="{{ route('admin.slideshows.edit', $slide) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.slideshows.destroy', $slide) }}" method="POST" class="d-inline" data-confirm>
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
