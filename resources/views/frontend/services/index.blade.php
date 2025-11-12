@extends('layouts.app')

@section('title', __('messages.services') . ' - Global Advisor Solution')

@section('content')
    <section class="page-header py-5" style="background: linear-gradient(135deg,#1e3a8a,#2563eb)">
        <div class="container">
            <h1 class="display-4 fw-bold text-white" data-aos="fade-up">{{ __('messages.our_services') }}</h1>
            <p class="text-white-50" data-aos="fade-up" data-aos-delay="100">
                Comprehensive loan solutions for all your financial needs
            </p>
        </div>
    </section>

    <section class="services-listing py-5">
        <div class="container">
            <div class="row g-4">
                @foreach ($loanTypes as $loan)
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
                        <div class="service-card h-100 text-center overflow-hidden">
                            @if ($loan->poster)
                                <div class="service-poster-hero mb-3">
                                    <img src="{{ asset('uploads/services/' . $loan->poster) }}"
                                        alt="{{ $loan->translation()?->title }}">
                                </div>
                            @endif

                            <h4 class="service-title">{{ $loan->translation()?->title }}</h4>
                            <p class="service-description">{{ Str::limit($loan->translation()?->description, 150) }}</p>
                            <a href="{{ route('services.show', $loan->slug) }}" class="btn btn-outline-primary">
                                {{ __('messages.learn_more') }} <i class="fas fa-arrow-right ms-1"></i>
                            </a>
                        </div>


                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
