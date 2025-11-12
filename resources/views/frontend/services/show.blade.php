@extends('layouts.app')

@section('title', $loanType->translation()?->title . ' - Global Advisor Solution')

@section('content')
<section class="page-header py-5"
  @if($loanType->poster)
    style="background: linear-gradient(135deg, rgba(30,58,138,.75), rgba(37,99,235,.55)), url('{{ asset('uploads/services/' . $loanType->poster) }}') center/cover no-repeat;"
  @else
    style="background: linear-gradient(135deg,#1e3a8a,#2563eb)"
  @endif
>
  <div class="container">
    <h1 class="display-4 fw-bold text-white" data-aos="fade-up">{{ $loanType->translation()?->title }}</h1>
    <nav aria-label="breadcrumb" data-aos="fade-up" data-aos-delay="100">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('messages.home') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('services.index') }}">{{ __('messages.services') }}</a></li>
        <li class="breadcrumb-item active text-white-50">{{ $loanType->translation()?->title }}</li>
      </ol>
    </nav>
  </div>
</section>

<section class="service-detail py-5">
  <div class="container">
    <div class="row">
      <div class="col-lg-8">

        {{-- Big poster above About This Service --}}
        @if($loanType->poster)
        <div class="card shadow-sm mb-4" data-aos="fade-up">
          <div class="service-detail-poster">
            <img src="{{ asset('uploads/services/' . $loanType->poster) }}"
                 alt="{{ $loanType->translation()?->title }}">
          </div>
        </div>
        @endif

        <div class="card shadow-sm mb-4" data-aos="fade-up">
          <div class="card-body">
            <h3 class="card-title mb-4">About This Service</h3>
            <div class="service-description">
              {!! nl2br(e($loanType->translation()?->description)) !!}
            </div>
          </div>
        </div>

        @if($loanType->conditions)
        <div class="card shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
          <div class="card-body">
            <h3 class="card-title mb-4">Conditions</h3>
            <div class="row">
              <div class="col-md-6">
                <p><strong>Currency Type:</strong> {{ $loanType->conditions->currency_type }}</p>
                <p><strong>Loan Amount:</strong> ${{ number_format($loanType->conditions->min_amount) }} - ${{ number_format($loanType->conditions->max_amount) }}</p>
              </div>
              <div class="col-md-6">
                <p><strong>Duration:</strong> Up to {{ $loanType->conditions->max_duration_months }} months</p>
                <p><strong>Age Requirement:</strong> {{ $loanType->conditions->min_age }} - {{ $loanType->conditions->max_age }} years</p>
              </div>
            </div>
            @if($loanType->translation()?->conditions)
            <hr>
            <div class="conditions-detail">
              {!! nl2br(e($loanType->translation()->conditions)) !!}
            </div>
            @endif
          </div>
        </div>
        @endif

        @if($loanType->collateralTypes->count() > 0)
        <div class="card shadow-sm" data-aos="fade-up" data-aos-delay="200">
          <div class="card-body">
            <h3 class="card-title mb-4">Collateral Types</h3>
            <ul class="list-unstyled">
              @foreach($loanType->collateralTypes as $collateral)
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
            <h4 class="card-title mb-4">Ready to Apply?</h4>
            <p class="text-muted">Get started with your loan application today</p>
            <a href="{{ route('contact') }}" class="btn btn-primary btn-lg w-100 mb-3">
              {{ __('messages.apply_now') }}
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-secondary w-100">
              {{ __('messages.contact_us') }}
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection

@push('styles')
<style>
/* Square big poster on service detail page */
.service-detail-poster{
  position: relative;
  width: 100%;
  padding-top: 100%;          /* 1:1 aspect ratio */
  overflow: hidden;
  border-top-left-radius: .5rem;
  border-top-right-radius: .5rem;
}
.service-detail-poster img{
  position: absolute;
  inset: 0;
  width: 100%;
  height: 100%;
  object-fit: cover;
}
</style>
@endpush
