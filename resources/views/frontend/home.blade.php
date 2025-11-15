@extends('layouts.app')

@section('title', 'Home - Global Advisor Solution')
@section('meta_description',
    'Loans and financial advisory in Cambodia — construction, vehicle, fast loans and
    consulting.')
@section('canonical', route('home'))
@section('og_image', asset('images/og/home.jpg'))

@section('content')
    <section class="hero-section position-relative">
        <div class="swiper heroSwiper">
            <div class="swiper-wrapper">
                @forelse($slideshows as $slide)
                    <div class="swiper-slide">
                        <div class="slide-content"
                            style="background-image: url('{{ asset('uploads/slideshows/' . $slide->image) }}');">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h1 class="display-3 fw-bold" data-aos="fade-up">
                                            {{ $slide->translation()?->title ?? 'Welcome to Global Advisor Solution' }}
                                        </h1>
                                        <p class="lead" data-aos="fade-up" data-aos-delay="100">
                                            {{ $slide->translation()?->description ?? 'Your Trusted Financial Partner for All Loan Solutions' }}
                                        </p>
                                        @php
                                            $ctaText =
                                                trim($slide->translation()?->button_text ?? '') !== ''
                                                    ? $slide->translation()->button_text
                                                    : __('messages.explore_services');
                                            $ctaLink = $slide->link ?: route('services.index');
                                        @endphp
                                        <a href="{{ $ctaLink }}" class="btn btn-hero hero-cta" data-aos="fade-up"
                                            data-aos-delay="200">
                                            <i class="fas fa-arrow-right me-2"></i> {{ $ctaText }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="swiper-slide">
                        <div class="slide-content"
                            style="background-image: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);">
                            <div class="container">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h1 class="display-3 fw-bold" data-aos="fade-up">Welcome to Global Advisor Solution
                                        </h1>
                                        <p class="lead" data-aos="fade-up" data-aos-delay="100">Your Trusted Financial
                                            Partner for All Loan Solutions</p>
                                        <a href="{{ route('services.index') }}" class="btn btn-hero hero-cta"
                                            data-aos="fade-up" data-aos-delay="200">
                                            <i class="fas fa-arrow-right me-2"></i> {{ __('messages.explore_services') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
            <div class="swiper-pagination"></div>
        </div>

        <button class="hero-nav hero-prev" aria-label="Previous slide"><i class="fas fa-chevron-left"></i></button>
        <button class="hero-nav hero-next" aria-label="Next slide"><i class="fas fa-chevron-right"></i></button>
    </section>

    <section class="services-section">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title" data-aos="fade-up">{{ __('messages.our_services') }}</h2>
                <p class="section-subtitle" data-aos="fade-up" data-aos-delay="100">
                    Comprehensive loan solutions tailored to your financial needs
                </p>
            </div>

            <div class="row g-4">
                @forelse($loanTypes as $loan)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="service-card h-100 text-center overflow-hidden service-card-lg">

                            @if (!empty($loan->poster))
                                <div class="service-poster-hero mb-3 service-poster-lg">
                                    <img src="{{ asset('uploads/services/' . $loan->poster) }}"
                                        alt="{{ $loan->translation()?->title }}">
                                </div>
                            @else
                                <div class="service-poster-hero mb-3 service-poster-lg border rounded">
                                    @php
                                        $iconClass = trim($loan->icon ?? '');
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
                                        <i class="{{ $iconClass }} placeholder-icon" aria-hidden="true"></i>
                                    @elseif($iconClass && !$hasFa)
                                        <div class="placeholder-img">
                                            <img src="{{ asset($iconClass) }}" alt="icon">
                                        </div>
                                    @else
                                        <i class="fa-solid fa-hand-holding-usd placeholder-icon" aria-hidden="true"></i>
                                    @endif
                                </div>
                            @endif

                            <h4 class="service-title">{{ $loan->translation()?->title }}</h4>
                            <p class="service-description">{{ Str::limit($loan->translation()?->description, 120) }}</p>
                            <a href="{{ route('services.show', $loan->slug) }}" class="btn btn-outline-primary">
                                {{ __('messages.learn_more') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>
                    </div>
                @empty
                    <!-- Optional empty state -->
                @endforelse
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .hero-cta {
            padding: .9rem 1.8rem;
            border-radius: 50px;
            font-weight: 700;
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            .hero-cta {
                padding: .6rem 1.2rem;
                font-size: .95rem;
                border-radius: 28px;
            }
        }

        .hero-nav {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            z-index: 5;
            width: 46px;
            height: 46px;
            border-radius: 50%;
            border: none;
            display: grid;
            place-items: center;
            color: #fff;
            background: rgba(245, 158, 11, .95);
            box-shadow: 0 8px 20px rgba(0, 0, 0, .25);
            transition: transform .2s, background .2s, box-shadow .2s;
        }

        .hero-prev {
            left: 18px;
        }

        .hero-next {
            right: 18px;
        }

        .hero-nav:hover {
            background: #fbbf24;
            transform: translateY(-50%) scale(1.06);
            box-shadow: 0 12px 28px rgba(0, 0, 0, .28);
        }

        .hero-nav i {
            font-size: 1.1rem;
        }

        @media (max-width: 575.98px) {
            .hero-nav {
                width: 40px;
                height: 40px;
            }

            .hero-prev {
                left: 10px;
            }

            .hero-next {
                right: 10px;
            }
        }
    </style>
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Ensure Swiper exists
            if (typeof Swiper === 'undefined') {
                console.error('Swiper is not loaded');
                return;
            }

            const heroSwiper = new Swiper('.heroSwiper', {
                loop: true,
                speed: 800, // smoother animation duration (ms)
                autoplay: {
                    delay: 5000,
                    disableOnInteraction: false
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true
                },
                effect: 'fade',
                fadeEffect: {
                    crossFade: true
                },
                // Make it responsive and fluid
                grabCursor: true
            });

            const prevBtn = document.querySelector('.hero-prev');
            const nextBtn = document.querySelector('.hero-next');

            if (prevBtn) {
                prevBtn.addEventListener('click', function() {
                    heroSwiper.slidePrev();
                });
            }

            if (nextBtn) {
                nextBtn.addEventListener('click', function() {
                    heroSwiper.slideNext();
                });
            }
        });
    </script>
@endpush
