<nav class="navbar navbar-expand-lg navbar-dark sticky-top simple-navbar">
    <div class="container align-items-center">

        <!-- Brand -->
        <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}"
            aria-label="Global Advisor Solution Home">
            <img src="{{ asset('images/logo.png') }}" alt="Global Advisor Solution" class="nav-logo-md" width="120"
                height="36" loading="eager">
        </a>

        <!-- Mobile toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">
                        <i class="fas fa-home me-2"></i>{{ __('messages.home') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">
                        <i class="fas fa-info-circle me-2"></i>{{ __('messages.about_us') }}
                    </a>
                </li>

                @php
                    $navLoans = \App\Models\LoanType::with('translations.language')
                        ->where('status', 'active')
                        ->orderBy('order')
                        ->get();
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle {{ request()->routeIs('services.*') ? 'active' : '' }}"
                        href="#" id="servicesDropdown" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        <i class="fas fa-hands-helping me-2"></i>{{ __('messages.services') }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="servicesDropdown">
                        @forelse($navLoans as $navLoan)
                            <li>
                                <a class="dropdown-item" href="{{ route('services.show', $navLoan->slug) }}">
                                    {{ $navLoan->translation()?->title ?? ucfirst(str_replace('-', ' ', $navLoan->slug)) }}
                                </a>
                            </li>
                        @empty
                            <li><span class="dropdown-item text-muted">No services</span></li>
                        @endforelse
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item fw-bold {{ request()->routeIs('quick-contact.*') ? 'active qc-active' : '' }}"
                                href="{{ route('quick-contact.form') }}">
                                <i class="fas fa-bolt me-2"></i> {{ __('messages.quick_contact') }}
                            </a>
                        </li>

                    </ul>
                </li>

                <style>
                    /* Ensure active dropdown item is visible on any theme */
                    .dropdown-menu .dropdown-item.qc-active,
                    .dropdown-menu .dropdown-item.qc-active:active,
                    .dropdown-menu .dropdown-item.qc-active:focus {
                        color: #0d6efd !important;
                        /* bootstrap primary */
                        background-color: rgba(13, 110, 253, 0.08) !important;
                    }

                    .dropdown-menu .dropdown-item.qc-active i {
                        color: #0d6efd !important;
                    }
                </style>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('blog.*') ? 'active' : '' }}"
                        href="{{ route('blog.index') }}">
                        <i class="fas fa-newspaper me-2"></i>{{ __('messages.blog') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('career.*') ? 'active' : '' }}"
                        href="{{ route('career.index') }}">
                        <i class="fas fa-briefcase me-2"></i>{{ __('messages.career') }}
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}"
                        href="{{ route('contact') }}">
                        <i class="fas fa-envelope me-2"></i>{{ __('messages.contact_us') }}
                    </a>
                </li>

                <!-- Language -->
                <li class="nav-item dropdown language-switcher ms-lg-3">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        @php $isKm = app()->getLocale()==='km'; @endphp
                        <img src="{{ asset('images/flags/' . ($isKm ? 'km' : 'en') . '.png') }}"
                            alt="{{ $isKm ? 'Khmer' : 'English' }}" width="20" height="14"
                            class="rounded border">
                        <span>{{ $isKm ? 'KH' : 'EN' }}</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'km' ? 'active' : '' }}"
                                href="{{ route('language.switch', 'km') }}">
                                <img src="{{ asset('images/flags/km.png') }}" alt="Khmer" width="20"
                                    height="14" class="rounded border">
                                <span>ភាសាខ្មែរ</span>
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-2 {{ app()->getLocale() == 'en' ? 'active' : '' }}"
                                href="{{ route('language.switch', 'en') }}">
                                <img src="{{ asset('images/flags/en.png') }}" alt="English" width="20"
                                    height="14" class="rounded border">
                                <span>English</span>
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
