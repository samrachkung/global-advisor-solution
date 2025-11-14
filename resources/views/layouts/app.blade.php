<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ in_array(app()->getLocale(), ['ar', 'fa', 'he']) ? 'rtl' : 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Global Advisor Solution')</title>

    {{-- Extra page-level meta hook (e.g., keywords) --}}
    @stack('meta')

    {{-- Canonical --}}
    <link rel="canonical" href="@yield('canonical', url()->current())">

    {{-- Hreflang (set available locales) --}}
    @php $locales = ['en','km']; @endphp
    @foreach ($locales as $loc)
        <link rel="alternate" hreflang="{{ $loc }}"
            href="{{ url($loc === app()->getLocale() ? request()->path() : $loc . '/' . request()->path()) }}">
    @endforeach
    <link rel="alternate" hreflang="x-default" href="{{ url('/') }}">

    {{-- SEO and social basics --}}
    <meta name="theme-color" content="#1e3a8a">
    <meta name="color-scheme" content="light only">
    <meta name="description" content="@yield('meta_description', 'Financial consulting, loans and advisory services in Cambodia.')">
    {{-- Open Graph --}}
    <meta property="og:title" content="@yield('og_title', trim(View::getSection('title') ?? 'Global Advisor Solution'))">
    <meta property="og:description" content="@yield('og_description', trim(View::getSection('meta_description') ?? 'Financial consulting, loans and advisory services.'))">
    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:image" content="@yield('og_image', asset('images/logo.png'))">
    <meta property="og:url" content="@yield('og_url', url()->current())">
    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('og_title', trim(View::getSection('title') ?? 'Global Advisor Solution'))">
    <meta name="twitter:description" content="@yield('og_description', trim(View::getSection('meta_description') ?? 'Financial consulting, loans and advisory services.'))">
    <meta name="twitter:image" content="@yield('og_image', asset('images/logo.png'))">

    {{-- Favicons --}}
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('images/brand/apple-touch-icon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    {{-- Google Fonts (Khmer-friendly): preload primary weight for fast paint --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style"
        href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@400;600;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Kantumruy+Pro:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- CSS: Bootstrap, Font Awesome, AOS, Swiper --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet"
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" rel="stylesheet">

    {{-- App CSS (versioned in prod) --}}
    @if (app()->environment('production') && file_exists(public_path('css/custom.css')))
        <link href="{{ asset('css/custom.css') }}?v={{ filemtime(public_path('css/custom.css')) }}" rel="stylesheet">
    @else
        <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
    @endif

    @stack('styles')

    <style>
        html,
        body {
            font-family: "Kantumruy Pro", system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Khmer OS", sans-serif;
            text-rendering: optimizeLegibility;
        }

        img {
            max-width: 100%;
            height: auto;
        }
    </style>

    {{-- Organization JSON-LD --}}
    @php
        $org = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => 'Global Advisor Solution',
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'description' => 'Consulting agency and financial planner in Phnom Penh, Cambodia.',
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => 'Street 317 and Street 335, Sangkat Boeung Kak I, Khan Toul Kork',
                'addressLocality' => 'Phnom Penh',
                'addressCountry' => 'KH',
            ],
            'contactPoint' => [
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+855 98 666 120',
                    'email' => 'globaladvisorsolutions@gmail.com',
                    'contactType' => 'customer service',
                    'areaServed' => 'KH',
                    'availableLanguage' => ['km', 'en'],
                ],
            ],
            'sameAs' => [
                'https://www.facebook.com/GlobalAdvisorSolutions',
                'https://instagram.com/globaladvisorsolutions',
                'https://tiktok.com/@global_advisor',
            ],
        ];
    @endphp
    <script type="application/ld+json">{!! json_encode($org, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE) !!}</script>

    {{-- Breadcrumbs JSON-LD (optional; override in pages) --}}
    @yield('schema_breadcrumbs')

    {{-- Services JSON-LD list (override in services page) --}}
    @yield('schema_services')
</head>

<body>
    @include('layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    {{-- JS (defer non-critical) --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"
        defer></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js" defer></script>

    @if (app()->environment('production') && file_exists(public_path('js/custom.js')))
        <script src="{{ asset('js/custom.js') }}?v={{ filemtime(public_path('js/custom.js')) }}" defer></script>
    @else
        <script src="{{ asset('js/custom.js') }}" defer></script>
    @endif

    <script>
        // Initialize AOS after page is idle to avoid main thread jank
        window.addEventListener('load', function() {
            if ('requestIdleCallback' in window) {
                requestIdleCallback(() => {
                    try {
                        AOS.init({
                            duration: 700,
                            once: true
                        });
                    } catch (e) {}
                });
            } else {
                setTimeout(() => {
                    try {
                        AOS.init({
                            duration: 700,
                            once: true
                        });
                    } catch (e) {}
                }, 0);
            }
        });
    </script>
    <noscript>
        <style>
            [data-aos] {
                opacity: 1 !important;
                transform: none !important;
            }
        </style>
    </noscript>

    @stack('scripts')
</body>

</html>
