<footer class="footer bg-dark text-white py-5">
    <div class="container">
        <div class="row">
            <!-- Brand + Social -->
            <div class="col-lg-4 mb-4">
                <h5 class="mb-3">Global Advisor Solution</h5>
                <p class="text-white-50">Your trusted partner for financial advisory services.</p>
                <div class="social-links mt-3 d-flex align-items-center gap-3">
                    <a href="https://www.facebook.com/yourpage" class="text-white" aria-label="Facebook">
                        <i class="fab fa-facebook fa-lg"></i>
                    </a>
                    <a href="https://t.me/yourchannel" class="text-white" aria-label="Telegram">
                        <i class="fab fa-telegram fa-lg"></i>
                    </a>
                    <a href="https://twitter.com/yourprofile" class="text-white" aria-label="Twitter">
                        <i class="fab fa-twitter fa-lg"></i>
                    </a>
                    <a href="https://www.linkedin.com/company/yourcompany" class="text-white" aria-label="LinkedIn">
                        <i class="fab fa-linkedin fa-lg"></i>
                    </a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-2 col-md-6 mb-4">
                <h5 class="mb-3">{{ __('messages.quick_links') }}</h5>
                <ul class="list-unstyled footer-links">
                    <li>
                        <a href="{{ route('home') }}" class="text-white text-decoration-none">
                            <i class="fas fa-home me-2 text-warning"></i>{{ __('messages.home') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('about') }}" class="text-white text-decoration-none">
                            <i class="fas fa-info-circle me-2 text-warning"></i>{{ __('messages.about_us') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.index') }}" class="text-white text-decoration-none">
                            <i class="fas fa-hands-helping me-2 text-warning"></i>{{ __('messages.services') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('blog.index') }}" class="text-white text-decoration-none">
                            <i class="fas fa-newspaper me-2 text-warning"></i>{{ __('messages.blog') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('career.index') }}" class="text-white text-decoration-none">
                            <i class="fas fa-briefcase me-2 text-warning"></i>{{ __('messages.career') }}
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('contact') }}" class="text-white text-decoration-none">
                            <i class="fas fa-envelope me-2 text-warning"></i>{{ __('messages.contact_us') }}
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Services -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">{{ __('messages.services') }}</h5>
                <ul class="list-unstyled footer-links">
                    <li>
                        <a href="{{ route('services.show', 'business-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-briefcase me-2 text-warning"></i>Business Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'personal-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-user me-2 text-warning"></i>Personal Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'agriculture-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-graduation-cap me-2 text-warning"></i>Education Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'construction-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-building me-2 text-warning"></i>Construction Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'vehicle-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-car me-2 text-warning"></i>Vehicle Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'realestate-mortgage-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-home me-2 text-warning"></i>Real Estate Mortgage
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'fast-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-bolt me-2 text-warning"></i>Fast Loan
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('services.show', 'agriculture-loan') }}" class="text-white text-decoration-none">
                            <i class="fas fa-seedling me-2 text-warning"></i>Agriculture Loan
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div class="col-lg-3 col-md-6 mb-4">
                <h5 class="mb-3">{{ __('messages.contact_info') }}</h5>
                <ul class="list-unstyled text-white-50">
                    <li class="mb-2">
                        <i class="fas fa-map-marker-alt me-2 text-warning"></i>
                        Street 317 and Street 335, Sangkat Boeung Kak I, Khan Toul Kork, Phnom Penh, Cambodia
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-phone me-2 text-warning"></i> +855 98 666 120
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-envelope me-2 text-warning"></i> globaladvisorsolutions@gmail.com
                    </li>
                </ul>
            </div>
        </div>

        <hr class="my-4 bg-secondary">

        <div class="row">
            <div class="col-md-6 text-center text-md-start">
                <p class="mb-0 text-white-50">&copy; {{ date('Y') }} Global Advisor Solution. All rights reserved.</p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-white-50 me-3">Privacy Policy</a>
                <a href="#" class="text-white-50">Terms of Service</a>
            </div>
        </div>
    </div>
</footer>
