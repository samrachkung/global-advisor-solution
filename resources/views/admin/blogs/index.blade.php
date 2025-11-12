@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">All Blog Posts</h5>
                <a href="{{ route('admin.blogs.create') }}" class="btn btn-add">
                    <i class="fas fa-plus me-2"></i>Add New Post
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover data-table">
                        <thead>
                            <tr>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Category</th>
                                <th>Author</th>
                                <th>Status</th>
                                <th>Views</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($posts as $post)
                            <tr>
                                <td>
                                    @if($post->featured_image)
                                    <img src="{{ asset('uploads/blogs/' . $post->featured_image) }}" alt="" style="width: 60px; height: 40px; object-fit: cover; border-radius: 5px;">
                                    @else
                                    <div style="width: 60px; height: 40px; background: #e5e7eb; border-radius: 5px;"></div>
                                    @endif
                                </td>
                                <td>{{ $post->translation()?->title ?? 'Untitled' }}</td>
                                <td>{{ $post->category->translation()?->name ?? 'N/A' }}</td>
                                <td>{{ $post->author->name }}</td>
                                <td>
                                    <span class="badge bg-{{ $post->status == 'published' ? 'success' : 'warning' }}">
                                        {{ ucfirst($post->status) }}
                                    </span>
                                </td>
                                <td>{{ $post->views_count }}</td>
                                <td>{{ $post->created_at->format('M d, Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.blogs.edit', $post) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.blogs.destroy', $post) }}" method="POST" class="d-inline" data-confirm>
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
