@extends('layouts.app')

@section('title', $job->translation()?->title . ' - Global Advisor Solution')

@section('content')
<!-- Header -->
<section class="page-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 3.5rem 0;">
    <div class="container">
        <div class="text-white">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb text-white-50">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('career.index') }}" class="text-white">Career</a></li>
                    <li class="breadcrumb-item active text-warning">{{ Str::limit($job->translation()?->title, 60) }}</li>
                </ol>
            </nav>
            <h1 class="display-5 fw-bold mb-2" data-aos="fade-down">{{ $job->translation()?->title }}</h1>
            <div class="d-flex flex-wrap gap-3" data-aos="fade-up">
                <span class="badge bg-warning text-dark">{{ ucfirst($job->employment_type) }}</span>
                <span><i class="fas fa-building me-2 text-warning"></i>{{ $job->department }}</span>
                <span><i class="fas fa-map-marker-alt me-2 text-warning"></i>{{ $job->location }}</span>
                @if($job->salary_range)
                <span><i class="fas fa-dollar-sign me-2 text-warning"></i>{{ $job->salary_range }}</span>
                @endif
            </div>
        </div>
    </div>
</section>

<!-- Content -->
<section class="job-detail py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Left: Description -->
            <div class="col-lg-8">
                <!-- About role -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-3"><i class="fas fa-file-alt text-primary me-2"></i>{{ __('messages.job_description') }}</h3>
                        <div class="content">{!! nl2br(e($job->translation()?->description)) !!}</div>
                    </div>
                </div>

                <!-- Responsibilities -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-3"><i class="fas fa-tasks text-primary me-2"></i>{{ __('messages.responsibilities') }}</h3>
                        <div class="content">{!! nl2br(e($job->translation()?->responsibilities)) !!}</div>
                    </div>
                </div>

                <!-- Requirements -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-3"><i class="fas fa-check-circle text-primary me-2"></i>{{ __('messages.requirements') }}</h3>
                        <div class="content">{!! nl2br(e($job->translation()?->requirements)) !!}</div>
                    </div>
                </div>

                <!-- Benefits -->
                @if($job->translation()?->benefits)
                <div class="card border-0 shadow-sm" data-aos="fade-up" data-aos-delay="300">
                    <div class="card-body p-4 p-md-5">
                        <h3 class="card-title mb-3"><i class="fas fa-gift text-primary me-2"></i>{{ __('messages.benefits') }}</h3>
                        <div class="content">{!! nl2br(e($job->translation()->benefits)) !!}</div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Right: Apply box -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm sticky-top" style="top: 100px;" data-aos="fade-left">
                    <div class="card-body p-4">
                        <h4 class="card-title mb-4 d-flex align-items-center">
                            <i class="fas fa-paper-plane text-primary me-2"></i>{{ __('messages.apply_now') }}
                        </h4>

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('career.apply', $job->slug) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.full_name') }}</label>
                                <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" required>
                                @error('full_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.email') }}</label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" required>
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.phone') }}</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" required>
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.resume') }}</label>
                                <input type="file" name="resume" class="form-control @error('resume') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                                <small class="text-muted">PDF, DOC, DOCX (Max: 5MB)</small>
                                @error('resume')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.cover_letter') }}</label>
                                <textarea name="cover_letter" class="form-control" rows="4"></textarea>
                            </div>

                            <button type="submit" class="btn btn-primary w-100">
                                {{ __('messages.submit_application') }}
                            </button>
                        </form>

                        <hr class="my-4">

                        <ul class="list-unstyled text-muted small">
                            @if($job->application_deadline)
                            <li class="mb-2"><i class="far fa-calendar me-2 text-primary"></i>Deadline: {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}</li>
                            @endif
                            <li class="mb-2"><i class="fas fa-map-marker-alt me-2 text-primary"></i>{{ $job->location }}</li>
                            <li class="mb-2"><i class="fas fa-briefcase me-2 text-primary"></i>{{ ucfirst($job->employment_type) }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.content { color: #374151; line-height: 1.8; }
.content ul { padding-left: 1.25rem; }
.content li { margin-bottom: 0.5rem; }
</style>
@endpush
