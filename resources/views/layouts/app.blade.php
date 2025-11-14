<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ in_array(app()->getLocale(), ['ar','fa','he']) ? 'rtl' : 'ltr' }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'Global Advisor Solution')</title>

  {{-- SEO and social basics --}}
  <meta name="theme-color" content="#1e3a8a">
  <meta name="color-scheme" content="light only">
  <meta name="description" content="@yield('meta_description','Global Advisor Solution')">
  <meta property="og:title" content="@yield('title','Global Advisor Solution')">
  <meta property="og:type" content="website">
  <meta property="og:image" content="{{ asset('images/logo.png') }}">
  <meta property="og:url" content="{{ url()->current() }}">

  {{-- Favicons --}}
  <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-touch-icon.png') }}">
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

  {{-- Google Fonts (Khmer-friendly) --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap" rel="stylesheet">

  {{-- CSS: Bootstrap, Font Awesome, AOS, Swiper --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet" crossorigin="anonymous" referrerpolicy="no-referrer">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">

  {{-- App CSS (use mix or vite versioning in production) --}}
  @if (app()->environment('production'))
    <link href="{{ asset('css/custom.css') }}?v={{ \Illuminate\Support\Str::of(filemtime(public_path('css/custom.css')))->substr(-7) }}" rel="stylesheet">
  @else
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  @endif

  @stack('styles')

  <style>
    /* Ensure font applied globally and smooth rendering */
    html, body { font-family: "Kantumruy Pro", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Khmer OS", sans-serif; text-rendering: optimizeLegibility; }
    img { max-width: 100%; height: auto; }
  </style>
</head>

<body>
  @include('layouts.partials.navbar')

  <main>
    @yield('content')
  </main>

  @include('layouts.partials.footer')

  {{-- JS: Bootstrap bundle, AOS, Swiper --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

  {{-- App JS (versioned in production) --}}
  @if (app()->environment('production'))
    <script src="{{ asset('js/custom.js') }}?v={{ \Illuminate\Support\Str::of(filemtime(public_path('js/custom.js')))->substr(-7) }}"></script>
  @else
    <script src="{{ asset('js/custom.js') }}"></script>
  @endif

  <script>
    window.addEventListener('load', function () {
      try { AOS.init({ duration: 1000, once: true }); } catch(e) {}
    });
  </script>

  @stack('scripts')
</body>
</html>
