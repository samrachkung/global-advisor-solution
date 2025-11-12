@extends('layouts.app')

@section('title', __('messages.about_us') . ' - Global Advisor Solution')

@section('content')
<section class="page-header py-5 bg-light">
    <div class="container">
        <h1 class="display-4 fw-bold" data-aos="fade-up">{{ __('messages.about_us') }}</h1>
    </div>
</section>

<section class="about-content py-5">
    <div class="container">
        <!-- Who we are -->
        <div class="row align-items-center mb-5">
            <div class="col-lg-6" data-aos="fade-right">
                <img src="{{ asset('images/about-us.jpg') }}" class="img-fluid rounded shadow-sm" alt="About Us">
            </div>
            <div class="col-lg-6" data-aos="fade-left">
                <h2 class="display-5 fw-bold mb-4">Who We Are</h2>
                <p class="lead">Global Advisor Solution is a leading financial advisory firm specializing in loan consultation services.</p>
                <p>We provide comprehensive loan solutions tailored to meet the diverse needs of our clients, from agriculture and business loans to personal and educational financing.</p>
                <p>With years of experience in the financial sector, our team of experts is committed to helping you achieve your financial goals with transparent, reliable, and customer-focused services.</p>
            </div>
        </div>

        <!-- Features -->
        <div class="row text-center mb-5">
            <div class="col-md-4 mb-4" data-aos="fade-up">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-users fa-3x text-primary"></i>
                    </div>
                    <h4 class="mt-3">Expert Team</h4>
                    <p>Experienced financial advisors ready to assist you</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-shield-alt fa-3x text-primary"></i>
                    </div>
                    <h4 class="mt-3">Trusted Service</h4>
                    <p>Reliable and transparent loan solutions</p>
                </div>
            </div>
            <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line fa-3x text-primary"></i>
                    </div>
                    <h4 class="mt-3">Fast Processing</h4>
                    <p>Quick approval and disbursement process</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="row bg-light rounded p-5 mb-5" data-aos="fade-up">
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <h2 class="display-4 fw-bold text-primary">10+</h2>
                <p class="text-muted">Years Experience</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <h2 class="display-4 fw-bold text-primary">5000+</h2>
                <p class="text-muted">Happy Clients</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <h2 class="display-4 fw-bold text-primary">8</h2>
                <p class="text-muted">Loan Products</p>
            </div>
            <div class="col-lg-3 col-md-6 text-center mb-4">
                <h2 class="display-4 fw-bold text-primary">98%</h2>
                <p class="text-muted">Satisfaction Rate</p>
            </div>
        </div>

        <!-- Our Team -->
        <div class="text-center mb-4" data-aos="fade-up">
            <h2 class="section-title">Our Team</h2>
            <p class="section-subtitle">Passionate professionals dedicated to your success</p>
        </div>

        <div class="row g-4">
            @php
                // Example static team; replace with dynamic $team collection if available
                $team = [
                    [
                        'name' => 'Sok Dara',
                        'title' => 'Chief Executive Officer',
                        'photo' => 'team-1.jpg',
                        'bio'   => 'Leads strategy and growth with 10+ years in financial services.',
                        'social'=> [
                            'linkedin' => '#',
                            'facebook' => '#',
                        ]
                    ],
                    [
                        'name' => 'Chanthy Kim',
                        'title' => 'Head of Operations',
                        'photo' => 'team-2.jpg',
                        'bio'   => 'Ensures operational excellence and client satisfaction.',
                        'social'=> [
                            'linkedin' => '#',
                            'facebook' => '#',
                        ]
                    ],
                    [
                        'name' => 'Sophea Lim',
                        'title' => 'Head of Sales',
                        'photo' => 'team-3.jpg',
                        'bio'   => 'Drives partnerships and loan product distribution.',
                        'social'=> [
                            'linkedin' => '#',
                            'facebook' => '#',
                        ]
                    ],
                    [
                        'name' => 'Vuthy Phan',
                        'title' => 'Risk & Compliance Manager',
                        'photo' => 'team-4.jpg',
                        'bio'   => 'Oversees risk, KYC and regulatory compliance.',
                        'social'=> [
                            'linkedin' => '#',
                            'facebook' => '#',
                        ]
                    ],
                ];
            @endphp

            @foreach($team as $member)
            <div class="col-6 col-md-6 col-lg-3" data-aos="zoom-in">
                <div class="team-card h-100">
                    <div class="team-photo">
                        <img src="{{ asset('images/team/' . $member['photo']) }}" alt="{{ $member['name'] }}">
                    </div>
                    <div class="team-body">
                        <h5 class="mb-1">{{ $member['name'] }}</h5>
                        <p class="text-primary small mb-2">{{ $member['title'] }}</p>
                        <p class="text-muted small mb-3">{{ $member['bio'] }}</p>
                        <div class="d-flex gap-2">
                            @if(!empty($member['social']['linkedin']))
                            <a class="btn btn-sm btn-light border" href="{{ $member['social']['linkedin'] }}" target="_blank" aria-label="LinkedIn">
                                <i class="fab fa-linkedin-in"></i>
                            </a>
                            @endif
                            @if(!empty($member['social']['facebook']))
                            <a class="btn btn-sm btn-light border" href="{{ $member['social']['facebook'] }}" target="_blank" aria-label="Facebook">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection

@push('styles')
<style>
.feature-box { background: #fff; border-radius: 12px; padding: 1.25rem; box-shadow: 0 6px 18px rgba(0,0,0,0.06); height: 100%; }
.section-title { color: #1e3a8a; font-weight: 800; margin-bottom: .25rem; }
.section-subtitle { color: #6b7280; margin-bottom: 2rem; }

.team-card { background: #fff; border-radius: 14px; overflow: hidden; box-shadow: 0 6px 18px rgba(0,0,0,.06); transition: transform .25s ease, box-shadow .25s ease; }
.team-card:hover { transform: translateY(-6px); box-shadow: 0 14px 32px rgba(0,0,0,.12); }
.team-photo { position: relative; padding-top: 100%; background: #f3f4f6; }
.team-photo img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.team-body { padding: 1rem; }
</style>
@endpush
