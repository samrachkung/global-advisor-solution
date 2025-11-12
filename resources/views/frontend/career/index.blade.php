@extends('layouts.app')

@section('title', __('messages.career') . ' - Global Advisor Solution')

@section('content')
<section class="page-header" style="background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%); padding: 4rem 0;">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bold mb-2" data-aos="fade-down">{{ __('messages.career') }}</h1>
        <p class="lead mb-0" data-aos="fade-up">Find your next opportunity with us</p>
    </div>
</section>

<section class="jobs-section py-5">
    <div class="container">
        <!-- Filters -->
        <div class="card border-0 shadow-sm mb-4" data-aos="fade-up">
            <div class="card-body">
                <form method="GET" action="{{ route('career.index') }}" class="row g-3">
                    <div class="col-md-4">
                        <input type="text" name="q" value="{{ request('q') }}" class="form-control" placeholder="Search job title or department">
                    </div>
                    <div class="col-md-3">
                        <select name="type" class="form-select">
                            <option value="">All Types</option>
                            <option value="full-time" {{ request('type')=='full-time'?'selected':'' }}>Full-Time</option>
                            <option value="part-time" {{ request('type')=='part-time'?'selected':'' }}>Part-Time</option>
                            <option value="contract" {{ request('type')=='contract'?'selected':'' }}>Contract</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="location" value="{{ request('location') }}" class="form-control" placeholder="Location">
                    </div>
                    <div class="col-md-2 d-grid">
                        <button class="btn btn-primary"><i class="fas fa-search me-2"></i>Search</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Job Cards -->
        <div class="row g-4">
            @forelse($jobs as $job)
            <div class="col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="job-card card h-100 border-0 shadow-sm hover-lift">
                    <div class="card-body p-4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-{{ $job->status=='open' ? 'success' : 'secondary' }}">
                                {{ ucfirst($job->status) }}
                            </span>
                            @if($job->application_deadline)
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i> Apply by {{ \Carbon\Carbon::parse($job->application_deadline)->format('M d, Y') }}
                            </small>
                            @endif
                        </div>

                        <h3 class="h5 mb-2">
                            <a href="{{ route('career.show', $job->slug) }}" class="text-decoration-none text-dark hover-primary">
                                {{ $job->translation()?->title }}
                            </a>
                        </h3>

                        <div class="text-muted small mb-3 d-flex flex-wrap gap-3">
                            <span><i class="fas fa-building me-1 text-primary"></i>{{ $job->department }}</span>
                            <span><i class="fas fa-map-marker-alt me-1 text-primary"></i>{{ $job->location }}</span>
                            <span><i class="fas fa-briefcase me-1 text-primary"></i>{{ ucfirst($job->employment_type) }}</span>
                            @if($job->salary_range)
                            <span><i class="fas fa-dollar-sign me-1 text-primary"></i>{{ $job->salary_range }}</span>
                            @endif
                        </div>

                        <p class="text-muted mb-3">{{ Str::limit($job->translation()?->description, 140) }}</p>

                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('career.show', $job->slug) }}" class="btn btn-outline-primary btn-sm">
                                View Details <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                            <span class="text-muted small">
                                <i class="far fa-calendar-alt me-1"></i> Posted {{ $job->created_at->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    <i class="fas fa-info-circle fa-3x mb-3"></i>
                    <p class="mb-0">No open positions at the moment.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($jobs->hasPages())
        <div class="mt-4" data-aos="fade-up">
            {{ $jobs->links() }}
        </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
.job-card { border-radius: 14px; }
.hover-lift { transition: all 0.3s ease; }
.hover-lift:hover { transform: translateY(-8px); box-shadow: 0 15px 35px rgba(0,0,0,0.15) !important; }
.hover-primary:hover { color: #2563eb !important; }
</style>
@endpush
