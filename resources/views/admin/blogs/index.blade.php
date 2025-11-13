@extends('layouts.admin')

@section('title', 'Blog Posts')
@section('page-title', 'Blog Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Blog Posts</h5>
        <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Add New Post
        </a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Author</th>
                <th>Status</th>
                <th>Views</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
              @php
                $en = $post->translations->firstWhere('language.code','en');
                $km = $post->translations->firstWhere('language.code','km');
              @endphp
              <tr>
                <td>
                  @if($post->featured_image)
                    <img src="{{ asset('uploads/blogs/' . $post->featured_image) }}" alt="" style="width:60px;height:40px;object-fit:cover;border-radius:5px;">
                  @else
                    <div style="width:60px;height:40px;background:#e5e7eb;border-radius:5px;"></div>
                  @endif
                </td>
                <td>{{ $post->translation()?->title ?? ($en?->title ?? 'Untitled') }}</td>
                <td>{{ $post->category->translation()?->name ?? 'N/A' }}</td>
                <td>{{ $post->author->name }}</td>
                <td>
                  <span class="badge bg-{{ $post->status == 'published' ? 'success' : ($post->status == 'draft' ? 'warning' : 'secondary') }}">
                    {{ ucfirst($post->status) }}
                  </span>
                </td>
                <td>{{ $post->views_count }}</td>
                <td>{{ $post->created_at->format('M d, Y') }}</td>
                <td class="text-end">
                  <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#postModal{{ $post->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <a href="{{ route('admin.blogs.edit', $post) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.blogs.destroy', $post) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this post?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>

              {{-- Quick View Modal --}}
              <div class="modal fade" id="postModal{{ $post->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-xl modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title d-flex align-items-center gap-2">
                        {{ $en?->title ?? 'Untitled' }} / {{ $km?->title ?? '—' }}
                        <span class="badge bg-{{ $post->status == 'published' ? 'success' : ($post->status == 'draft' ? 'warning' : 'secondary') }}">
                          {{ ucfirst($post->status) }}
                        </span>
                      </h5>
                      <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row g-4">
                        <div class="col-lg-4">
                          <div class="border rounded p-2 text-center">
                            @if($post->featured_image)
                              <img src="{{ asset('uploads/blogs/' . $post->featured_image) }}" class="img-fluid rounded" alt="Featured">
                            @else
                              <div class="bg-light rounded" style="height:220px;"></div>
                            @endif
                          </div>
                          <ul class="list-group mt-3 small">
                            <li class="list-group-item d-flex justify-content-between"><span>Slug</span><strong>{{ $post->slug }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Category</span><strong>{{ $post->category->translation()?->name ?? 'N/A' }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Author</span><strong>{{ $post->author->name }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Published</span><strong>{{ $post->published_at ? $post->published_at->format('M d, Y H:i') : '—' }}</strong></li>
                            <li class="list-group-item d-flex justify-content-between"><span>Views</span><strong>{{ $post->views_count }}</strong></li>
                          </ul>
                        </div>

                        <div class="col-lg-8">
                          <h6 class="text-primary">English</h6>
                          <p class="mb-1"><strong>Title:</strong> {{ $en?->title ?? '—' }}</p>
                          @if($en?->excerpt)
                            <p class="mb-2"><strong>Excerpt:</strong> {{ $en->excerpt }}</p>
                          @endif
                          <div class="mb-4">
                            <strong>Content:</strong>
                            <div class="border rounded p-3 mt-1" style="max-height:260px; overflow:auto;">
                              {!! $en?->content !!}
                            </div>
                          </div>

                          <h6 class="text-primary">Khmer</h6>
                          <p class="mb-1"><strong>[translate:ចំណងជើង]:</strong> {{ $km?->title ?? '—' }}</p>
                          @if($km?->excerpt)
                            <p class="mb-2"><strong>[translate:សេចក្តីសង្ខេប]:</strong> {{ $km->excerpt }}</p>
                          @endif
                          <div>
                            <strong>[translate:មាតិកា]:</strong>
                            <div class="border rounded p-3 mt-1" style="max-height:260px; overflow:auto;">
                              {!! $km?->content !!}
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <a href="{{ route('admin.blogs.edit', $post) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              {{-- /Quick View Modal --}}
            @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $posts->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
