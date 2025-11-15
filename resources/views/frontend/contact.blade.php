@extends('layouts.app')

@section('title', __('messages.contact_us') . ' - Global Advisor Solution')

@push('styles')
<style>
/* Full-page submit loader (same as quick contact) */
.app-loader {
    position: fixed;
    inset: 0;
    background: rgba(255,255,255,.75);
    backdrop-filter: blur(1px);
    display: none;
    align-items: center;
    justify-content: center;
    z-index: 2000;
}
.app-loader.show { display: flex; }
.loader-spinner {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    border: 4px solid #e5e7eb;
    border-top-color: #2563eb;
    animation: spin .9s linear infinite;
}
@keyframes spin {
    to { transform: rotate(360deg); }
}

/* Optional: reuse the contact-info card style like quick contact */
.contact-info .info-icon {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    background: #eef2ff;
    color: #1e3a8a;
}
.contact-info a { text-decoration: none; }
.contact-info a:hover { text-decoration: underline; }
</style>
@endpush

@section('content')
<section class="page-header py-5 bg-light">
    <div class="container">
        <h1 class="display-4 fw-bold" data-aos="fade-up">
            {{ __('messages.contact_us') }}
        </h1>
    </div>
</section>

<section class="contact-section py-5">
    <div class="container">
        <div class="row g-4">
            <!-- Form column (same UX as quick contact) -->
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card shadow-sm h-100">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">{{ __('messages.send_message') }}</h3>

                        @if(session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST" class="js-submit-loader">
                            @csrf

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text"
                                           name="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name') }}"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.email') }}</label>
                                    <input type="email"
                                           name="email"
                                           class="form-control @error('email') is-invalid @enderror"
                                           value="{{ old('email') }}"
                                           required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.phone') }}</label>
                                <input type="text"
                                       name="phone"
                                       class="form-control @error('phone') is-invalid @enderror"
                                       value="{{ old('phone') }}">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.subject') }}</label>
                                <input type="text"
                                       name="subject"
                                       class="form-control @error('subject') is-invalid @enderror"
                                       value="{{ old('subject') }}"
                                       required>
                                @error('subject')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.message') }}</label>
                                <textarea name="message"
                                          class="form-control @error('message') is-invalid @enderror"
                                          rows="5"
                                          required>{{ old('message') }}</textarea>
                                @error('message')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    {{ __('messages.send_message') }}
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Contact info column (same look as quick contact) -->
            <div class="col-lg-4" data-aos="fade-left">
                <div class="card shadow-sm contact-info h-100">
                    <div class="card-body p-4">
                        <h5 class="mb-3">{{ __('messages.contact_info') }}</h5>

                        <div class="d-flex gap-3 mb-3">
                            <div class="info-icon"><i class="fas fa-map-marker-alt"></i></div>
                            <div>
                                <div class="fw-semibold">{{ __('messages.address') }}</div>
                                <div class="text-muted">
                                    Street 317 and Street 335, Sangkat Boeung Kak I,
                                    Khan Toul Kork, Phnom Penh, Cambodia
                                </div>
                            </div>
                        </div>

                        <div class="d-flex gap-3 mb-3">
                            <div class="info-icon"><i class="fas fa-phone"></i></div>
                            <div>
                                <div class="fw-semibold">{{ __('messages.phone') }}</div>
                                <a href="tel:+85598666120">+855 98 666 120</a>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <div class="info-icon"><i class="fas fa-envelope"></i></div>
                            <div>
                                <div class="fw-semibold">{{ __('messages.email') }}</div>
                                <a href="mailto:globaladvisorsolutions@gmail.com">
                                    globaladvisorsolutions@gmail.com
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Page loader -->
<div id="contactLoader" class="app-loader" aria-hidden="true">
    <div class="loader-spinner" role="status" aria-label="Loading"></div>
</div>
@endsection

@push('scripts')
<script>
(function() {
    const loader = document.getElementById('contactLoader');
    document.querySelectorAll('form.js-submit-loader').forEach(f => {
        f.addEventListener('submit', () => {
            f.querySelectorAll('button[type="submit"],input[type="submit"]').forEach(b => b.disabled = true);
            loader?.classList.add('show');
        });
    });
})();
</script>
@endpush
