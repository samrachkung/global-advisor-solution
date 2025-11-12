@extends('layouts.app')

@section('title', $post->translation()?->title . ' - Global Advisor Solution')

@section('content')
<!-- Hero Section -->
<section class="blog-hero" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 4rem 0;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <nav aria-label="breadcrumb" data-aos="fade-down">
                    <ol class="breadcrumb text-white-50 mb-3">
                        <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('blog.index') }}" class="text-white">Blog</a></li>
                        <li class="breadcrumb-item active text-warning">{{ Str::limit($post->translation()?->title, 50) }}</li>
                    </ol>
                </nav>

                <h1 class="display-4 fw-bold text-white mb-4" data-aos="fade-up">
                    {{ $post->translation()?->title }}
                </h1>

                <div class="d-flex flex-wrap align-items-center gap-4 text-white" data-aos="fade-up" data-aos-delay="100">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-user-circle me-2 text-warning"></i>
                        <span>{{ $post->author->name }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="far fa-calendar me-2 text-warning"></i>
                        <span>{{ $post->published_at->format('F d, Y') }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="far fa-eye me-2 text-warning"></i>
                        <span>{{ number_format($post->views_count) }} views</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fas fa-folder me-2 text-warning"></i>
                        <span>{{ $post->category->translation()?->name }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Main Content -->
<section class="blog-content py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <!-- Featured Image -->
                @if($post->featured_image)
                <div class="featured-image mb-5" data-aos="zoom-in">
                    <img src="{{ asset('uploads/blogs/' . $post->featured_image) }}"
                         alt="{{ $post->translation()?->title }}"
                         class="img-fluid rounded-4 shadow-lg w-100"
                         style="max-height: 500px; object-fit: cover;">
                </div>
                @endif

                <!-- Article Content -->
                <article class="blog-article" data-aos="fade-up">
                    <div class="card border-0 shadow-sm mb-5">
                        <div class="card-body p-4 p-md-5">
                            <!-- Excerpt -->
                            <div class="alert alert-light border-start border-primary border-4 mb-4">
                                <p class="lead mb-0 text-muted">
                                    <i class="fas fa-quote-left text-primary me-2"></i>
                                    {{ $post->translation()?->excerpt }}
                                </p>
                            </div>

                            <!-- Content -->
                            <div class="article-content">
                                {!! $post->translation()?->content !!}
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Share Buttons -->
                <div class="share-section mb-5" data-aos="fade-up">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h5 class="mb-3 d-flex align-items-center">
                                <i class="fas fa-share-alt text-primary me-2"></i>
                                Share this article
                            </h5>
                            <div class="d-flex gap-2 flex-wrap">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="btn btn-facebook">
                                    <i class="fab fa-facebook-f me-2"></i>Facebook
                                </a>
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->translation()?->title) }}"
                                   target="_blank"
                                   class="btn btn-twitter">
                                    <i class="fab fa-twitter me-2"></i>Twitter
                                </a>
                                <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}"
                                   target="_blank"
                                   class="btn btn-linkedin">
                                    <i class="fab fa-linkedin-in me-2"></i>LinkedIn
                                </a>
                                <a href="https://telegram.me/share/url?url={{ urlencode(request()->url()) }}&text={{ urlencode($post->translation()?->title) }}"
                                   target="_blank"
                                   class="btn btn-telegram">
                                    <i class="fab fa-telegram-plane me-2"></i>Telegram
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Related Posts -->
                @if($relatedPosts->count() > 0)
                <div class="related-posts" data-aos="fade-up">
                    <h3 class="mb-4 d-flex align-items-center">
                        <i class="fas fa-newspaper text-primary me-3"></i>
                        Related Articles
                    </h3>
                    <div class="row g-4">
                        @foreach($relatedPosts as $related)
                        <div class="col-md-4">
                            <div class="card h-100 border-0 shadow-sm hover-lift">
                                @if($related->featured_image)
                                <img src="{{ asset('uploads/blogs/' . $related->featured_image) }}"
                                     class="card-img-top"
                                     alt="{{ $related->translation()?->title }}"
                                     style="height: 200px; object-fit: cover;">
                                @endif
                                <div class="card-body">
                                    <h5 class="card-title">
                                        <a href="{{ route('blog.show', $related->slug) }}" class="text-decoration-none text-dark">
                                            {{ Str::limit($related->translation()?->title, 60) }}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted small">
                                        {{ Str::limit($related->translation()?->excerpt, 100) }}
                                    </p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="far fa-calendar me-1"></i>
                                            {{ $related->published_at->format('M d, Y') }}
                                        </small>
                                        <a href="{{ route('blog.show', $related->slug) }}" class="btn btn-sm btn-outline-primary">
                                            Read More
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
/* Article Content Styling */
.article-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: #374151;
}

.article-content h2 {
    color: #1e3a8a;
    font-weight: 700;
    margin-top: 2rem;
    margin-bottom: 1rem;
    padding-bottom: 0.5rem;
    border-bottom: 3px solid #f59e0b;
}

.article-content h3 {
    color: #2563eb;
    font-weight: 600;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.article-content p {
    margin-bottom: 1.5rem;
}

.article-content ul, .article-content ol {
    margin-bottom: 1.5rem;
    padding-left: 2rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 12px;
    margin: 2rem 0;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.article-content blockquote {
    border-left: 4px solid #f59e0b;
    padding-left: 1.5rem;
    margin: 2rem 0;
    font-style: italic;
    color: #6b7280;
}

/* Share Buttons */
.btn-facebook {
    background: #1877f2;
    color: white;
    border: none;
}

.btn-facebook:hover {
    background: #145dbf;
    color: white;
}

.btn-twitter {
    background: #1da1f2;
    color: white;
    border: none;
}

.btn-twitter:hover {
    background: #1a8cd8;
    color: white;
}

.btn-linkedin {
    background: #0077b5;
    color: white;
    border: none;
}

.btn-linkedin:hover {
    background: #006399;
    color: white;
}

.btn-telegram {
    background: #0088cc;
    color: white;
    border: none;
}

.btn-telegram:hover {
    background: #006fa8;
    color: white;
}

/* Hover Effects */
.hover-lift {
    transition: all 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 30px rgba(0,0,0,0.15) !important;
}

/* Featured Image Animation */
.featured-image img {
    transition: transform 0.3s ease;
}

.featured-image:hover img {
    transform: scale(1.02);
}
</style>
@endpush
