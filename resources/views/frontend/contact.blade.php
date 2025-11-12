@extends('layouts.app')

@section('title', __('messages.contact_us') . ' - Global Advisor Solution')

@section('content')
<section class="page-header py-5 bg-light">
    <div class="container">
        <h1 class="display-4 fw-bold" data-aos="fade-up">{{ __('messages.contact_us') }}</h1>
    </div>
</section>

<section class="contact-section py-5">
    <div class="container">
        <div class="row">
            <div class="col-lg-8" data-aos="fade-up">
                <div class="card shadow-sm">
                    <div class="card-body p-4">
                        <h3 class="card-title mb-4">{{ __('messages.send_message') }}</h3>

                        @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('contact.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.email') }}</label>
                                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.phone') }}</label>
                                <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.subject') }}</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" value="{{ old('subject') }}" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.message') }}</label>
                                <textarea name="message" class="form-control @error('message') is-invalid @enderror" rows="5" required>{{ old('message') }}</textarea>
                                @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">{{ __('messages.send_message') }}</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4" data-aos="fade-left">
                <div class="contact-info">
                    <div class="info-card mb-4">
                        <div class="info-icon">
                            <i class="fas fa-map-marker-alt"></i>
                        </div>
                        <h5>{{ __('messages.address') }}</h5>
                        <p>Street 317 and Street 335, Sangkat Boeung Kak I, Khan Toul Kork ,Phnom Penh, Cambodia, Phnom Penh, Cambodia</p>
                    </div>

                    <div class="info-card mb-4">
                        <div class="info-icon">
                            <i class="fas fa-phone"></i>
                        </div>
                        <h5>{{ __('messages.phone') }}</h5>
                        <p>+855 98 666 120</p>
                    </div>

                    <div class="info-card">
                        <div class="info-icon">
                            <i class="fas fa-envelope"></i>
                        </div>
                        <h5>{{ __('messages.email') }}</h5>
                        <p>globaladvisorsolutions@gmail.com</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
