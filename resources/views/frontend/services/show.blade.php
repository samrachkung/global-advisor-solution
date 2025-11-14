@extends('layouts.app')

@section('title', $loanType->translation()?->title . ' - Global Advisor Solution')
@section('meta_description', Str::limit(strip_tags($loanType->translation()?->description), 160))
@section('canonical', route('services.show', $loanType->slug))
@section('og_image', !empty($loanType->poster) ? asset('uploads/services/' . $loanType->poster) :
    asset('images/logo.png'))
@section('og_type', 'product')

@section('schema_breadcrumbs')
    @php
        $crumbs = [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                ['@type' => 'ListItem', 'position' => 1, 'name' => __('messages.home'), 'item' => url('/')],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => __('messages.services'),
                    'item' => route('services.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $loanType->translation()?->title,
                    'item' => route('services.show', $loanType->slug),
                ],
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($crumbs, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('schema_services')
    @php
        $svc = [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $loanType->translation()?->title,
            'description' => Str::limit(strip_tags($loanType->translation()?->description), 160),
            'url' => route('services.show', $loanType->slug),
            'image' => !empty($loanType->poster)
                ? asset('uploads/services/' . $loanType->poster)
                : asset('images/logo.png'),
            'areaServed' => ['KH'],
            'provider' => [
                '@type' => 'Organization',
                'name' => 'Global Advisor Solution',
                'url' => url('/'),
                'logo' => asset('images/logo.png'),
            ],
            'serviceType' => 'Financial Service',
            'termsOfService' => $loanType->translation()?->conditions ?: null,
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($svc, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
    <section class="page-header py-5"
        @if ($loanType->poster) style="background: linear-gradient(135deg, rgba(30,58,138,.75), rgba(37,99,235,.55)), url('{{ asset('uploads/services/' . $loanType->poster) }}') center/cover no-repeat;"
  @else
    style="background: linear-gradient(135deg,#1e3a8a,#2563eb)" @endif>
        <div class="container">
            @php
                $iconClass = trim($loanType->icon ?? '');
                $hasFa = Str::startsWith($iconClass, [
                    'fa ',
                    'fa-',
                    'fas ',
                    'far ',
                    'fab ',
                    'fa-solid',
                    'fa-regular',
                    'fa-brands',
                ]);
            @endphp
            <h1 class="display-4 fw-bold text-white d-flex align-items-center gap-2" data-aos="fade-up">
                @if ($iconClass && $hasFa)
                    <i class="{{ $iconClass }} text-warning" style="font-size: 1em;"></i>
                @elseif($iconClass && !$hasFa)
                    <img src="{{ asset($iconClass) }}" alt="icon" style="height: 28px; width: 28px; object-fit: contain;">
                @else
                    <i class="fa-solid fa-hand-holding-usd text-warning" style="font-size: 1em;"></i>
                @endif
                {{ $loanType->translation()?->title }}
            </h1>
            <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ __('messages.services') }}</a>
                    </li>
                    <li class="breadcrumb-item active text-white-50">{{ $loanType->translation()?->title }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="service-detail py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">

                    @if (!empty($loanType->poster))
                        <div class="card shadow-sm mb-4" data-aos="fade-up">
                            <div class="service-detail-poster">
                                <img src="{{ asset('uploads/services/' . $loanType->poster) }}"
                                    alt="{{ $loanType->translation()?->title }}">
                            </div>
                        </div>
                    @else
                        <div class="card shadow-sm mb-4" data-aos="fade-up">
                            <div class="d-flex align-items-center justify-content-center"
                                style="height: 320px; background:#f8fafc;">
                                @php
                                    $iconClass = trim($loanType->icon ?? '');
                                    $hasFa = Str::startsWith($iconClass, [
                                        'fa ',
                                        'fa-',
                                        'fas ',
                                        'far ',
                                        'fab ',
                                        'fa-solid',
                                        'fa-regular',
                                        'fa-brands',
                                    ]);
                                @endphp
                                @if ($iconClass && $hasFa)
                                    <i class="{{ $iconClass }}" style="font-size: 112px; color:#2563eb;"
                                        aria-hidden="true"></i>
                                @elseif($iconClass && !$hasFa)
                                    <img src="{{ asset($iconClass) }}" alt="icon"
                                        style="width: 28%; max-width: 180px; min-width: 72px; object-fit: contain;">
                                @else
                                    <i class="fa-solid fa-hand-holding-usd" style="font-size: 112px; color:#2563eb;"
                                        aria-hidden="true"></i>
                                @endif
                            </div>
                        </div>

                    @endif

                    <div class="card shadow-sm mb-4" data-aos="fade-up">
                        <div class="card-body">
                            <h3 class="card-title mb-4">{{ __('messages.about_this_service') }}</h3>
                            <div class="service-description">
                                {!! nl2br(e($loanType->translation()?->description)) !!}
                            </div>
                        </div>
                    </div>

                    @if ($loanType->conditions)
                        <div class="card shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
                            <div class="card-body">
                                <h3 class="card-title mb-4">{{ __('messages.conditions') }}</h3>
                                <div class="row">
                                    <div class="col-md-6">
                                        <p><strong>{{ __('messages.currency_type') }}:</strong> {{ __('messages.both') }}
                                        </p>
                                        <p><strong>{{ __('messages.loan_amount') }}:</strong>
                                            ${{ number_format($loanType->conditions->min_amount) }} -
                                            ${{ number_format($loanType->conditions->max_amount) }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <p><strong>{{ __('messages.duration') }}:</strong>
                                            {{ __('messages.up_to_months', ['months' => $loanType->conditions->max_duration_months]) }}
                                        </p>
                                        <p><strong>{{ __('messages.age_requirement') }}:</strong>
                                            {{ $loanType->conditions->min_age }} - {{ $loanType->conditions->max_age }}
                                            {{ __('messages.years') }}
                                        </p>
                                    </div>
                                </div>
                                @if ($loanType->translation()?->conditions)
                                    <hr>
                                    <div class="conditions-detail">
                                        {!! nl2br(e($loanType->translation()->conditions)) !!}
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif

                    @if ($loanType->collateralTypes->count() > 0)
                        <div class="card shadow-sm" data-aos="fade-up" data-aos-delay="200">
                            <div class="card-body">
                                <h3 class="card-title mb-4">{{ __('messages.collateral_types') }}</h3>
                                <ul class="list-unstyled">
                                    @foreach ($loanType->collateralTypes as $collateral)
                                        <li class="mb-2">
                                            <i class="fas fa-check-circle text-success me-2"></i>
                                            {{ $collateral->translation()?->name }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="card shadow-sm sticky-top" style="top: 100px;" data-aos="fade-left">
                        <div class="card-body text-center">
                            <h4 class="card-title mb-4">{{ __('messages.ready_to_apply') }}</h4>
                            <p class="text-muted">{{ __('messages.get_started_today') }}</p>
                            <a href="{{ route('contact') }}"
                                class="btn btn-primary btn-lg w-100 mb-3">{{ __('messages.apply_now') }}</a>
                            <a href="{{ route('contact') }}"
                                class="btn btn-outline-secondary w-100">{{ __('messages.contact_us') }}</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .service-detail-poster {
            position: relative;
            width: 100%;
            padding-top: 100%;
            overflow: hidden;
            border-top-left-radius: .5rem;
            border-top-right-radius: .5rem;
        }

        .service-detail-poster img {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    </style>
@endpush
