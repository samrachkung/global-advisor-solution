@extends('layouts.app')

@section('title', __('messages.blog') . ' - Global Advisor Solution')

@section('content')
<!-- Page Header -->
<section class="page-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 4rem 0;">
    <div class="container">
        <div class="text-center text-white">
            <h1 class="display-3 fw-bold mb-3" data-aos="fade-down">{{ __('messages.blog') }}</h1>
            <p class="lead mb-0" data-aos="fade-up">Stay informed with our latest financial insights and updates</p>
        </div>
    </div>
</section>

<!-- Blog Grid -->
<section class="blog-section py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="row g-4">
                    @forelse($posts as $post)
                    <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                        <article class="blog-card h-100 border-0 shadow-sm">
                            @if($post->featured_image)
                            <div class="blog-card-image position-relative overflow-hidden">
                                <img src="{{ asset('uploads/blogs/' . $post->featured_image) }}"
                                     class="w-100"
                                     alt="{{ $post->translation()?->title }}"
                                     style="height: 250px; object-fit: cover; transition: transform 0.3s;">
                                <div class="blog-category position-absolute top-0 start-0 m-3">
                                    <span class="badge bg-primary">{{ $post->category->translation()?->name }}</span>
                                </div>
                            </div>
                            @endif

                            <div class="card-body p-4">
                                <div class="blog-meta d-flex gap-3 mb-3 text-muted small">
                                    <span><i class="far fa-calendar me-1"></i> {{ $post->published_at->format('M d, Y') }}</span>
                                    <span><i class="far fa-eye me-1"></i> {{ $post->views_count }}</span>
                                </div>

                                <h3 class="blog-title h5 mb-3">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ $post->translation()?->title }}
                                    </a>
                                </h3>

                                <p class="blog-excerpt text-muted mb-3">
                                    {{ Str::limit($post->translation()?->excerpt, 120) }}
                                </p>

                                <a href="{{ route('blog.show', $post->slug) }}" class="btn btn-outline-primary btn-sm">
                                    Read More <i class="fas fa-arrow-right ms-2"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                    @empty
                    <div class="col-12">
                        <div class="alert alert-info text-center">
                            <i class="fas fa-info-circle fa-3x mb-3"></i>
                            <p class="mb-0">No blog posts available at the moment.</p>
                        </div>
                    </div>
                    @endforelse
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                <div class="mt-5" data-aos="fade-up">
                    {{ $posts->links() }}
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <div class="sidebar">
                    <!-- Categories Widget -->
                    <div class="sidebar-widget card border-0 shadow-sm mb-4" data-aos="fade-left">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-folder me-2"></i>Categories</h5>
                        </div>
                        <div class="card-body p-0">
                            <ul class="list-group list-group-flush">
                                @foreach($categories as $category)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <a href="#" class="text-decoration-none">
                                        {{ $category->translation()?->name }}
                                    </a>
                                    <span class="badge bg-primary rounded-pill">{{ $category->posts_count }}</span>
                                </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    <!-- Popular Posts Widget -->
                    <div class="sidebar-widget card border-0 shadow-sm" data-aos="fade-left" data-aos-delay="100">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0"><i class="fas fa-fire me-2"></i>Popular Posts</h5>
                        </div>
                        <div class="card-body">
                            <p class="text-muted text-center">Coming soon...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.blog-card {
    transition: all 0.3s ease;
    border-radius: 15px;
    overflow: hidden;
}

.blog-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important;
}

.blog-card-image img:hover {
    transform: scale(1.1);
}

.hover-primary:hover {
    color: #2563eb !important;
}
</style>
@endpush
