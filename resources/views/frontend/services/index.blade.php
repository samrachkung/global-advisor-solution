@extends('layouts.app')

@section('title', __('messages.services').' - Global Advisor Solution')
@section('meta_description', __('messages.our_services').' — Comprehensive loan solutions for all your financial needs.')
@section('canonical', route('services.index'))
@section('og_image', asset('images/og/services.jpg'))

{{-- Breadcrumbs schema --}}
@section('schema_breadcrumbs')
@php
$crumbs = [
  '@context'=>'https://schema.org',
  '@type'=>'BreadcrumbList',
  'itemListElement'=>[
    ['@type'=>'ListItem','position'=>1,'name'=>__('messages.home'),'item'=>url('/')],
    ['@type'=>'ListItem','position'=>2,'name'=>__('messages.services'),'item'=>route('services.index')],
  ]
];
@endphp
<script type="application/ld+json">{!! json_encode($crumbs, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

{{-- Services schema --}}
@section('schema_services')
@php
$items = [];
foreach ($loanTypes as $loan) {
  $items[] = [
    '@type' => 'Service',
    'name' => $loan->translation()?->title,
    'description' => \Illuminate\Support\Str::limit(strip_tags($loan->translation()?->description), 160),
    'url' => route('services.show', $loan->slug),
    'image' => !empty($loan->poster) ? asset('uploads/services/'.$loan->poster) : asset('images/logo.png'),
    'areaServed' => ['KH'],
    'provider' => [
      '@type' => 'Organization',
      'name' => 'Global Advisor Solution',
      'url' => url('/'),
      'logo' => asset('images/logo.png')
    ],
    'serviceType' => 'Financial Service',
  ];
}
$catalog = [
  '@context' => 'https://schema.org',
  '@type' => 'OfferCatalog',
  'name' => 'Loan & Advisory Services',
  'itemListElement' => array_map(fn($svc) => ['@type'=>'Offer','itemOffered'=>$svc], $items),
];
@endphp
<script type="application/ld+json">{!! json_encode($catalog, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES) !!}</script>
@endsection

@section('content')
<section class="page-header py-5" style="background: linear-gradient(135deg,#1e3a8a,#2563eb)">
  <div class="container">
    <h1 class="display-4 fw-bold text-white" data-aos="fade-up">{{ __('messages.our_services') }}</h1>
    <p class="text-white-50" data-aos="fade-up" data-aos-delay="100">Comprehensive loan solutions for all your financial needs</p>
  </div>
</section>

<section class="services-listing py-5">
  <div class="container">
    <div class="row g-4">
      @foreach ($loanTypes as $loan)
      <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 100 }}">
        <div class="service-card h-100 text-center overflow-hidden service-card-lg">
          @if ($loan->poster)
          <div class="service-poster-hero mb-3 service-poster-lg">
            <img src="{{ asset('uploads/services/' . $loan->poster) }}" alt="{{ $loan->translation()?->title }}">
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
