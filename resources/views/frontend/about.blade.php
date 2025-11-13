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
        <img src="{{ asset('images/logo.png') }}" class="img-fluid rounded shadow-sm" alt="{{ __('messages.about_us') }}">
      </div>
      <div class="col-lg-6" data-aos="fade-left">
        <h2 class="display-5 fw-bold mb-4">{{ __('messages.who_we_are') }}</h2>
        <p class="lead">{{ __('messages.about_intro_lead') }}</p>
        <p>{{ __('messages.about_intro_p2') }}</p>
        <p>{{ __('messages.about_intro_p3') }}</p>
      </div>
    </div>

    <!-- Features -->
    <div class="row text-center mb-5">
      <div class="col-md-4 mb-4" data-aos="fade-up">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-users fa-3x text-primary"></i>
          </div>
          <h4 class="mt-3">{{ __('messages.feature_expert_team_title') }}</h4>
          <p>{{ __('messages.feature_expert_team_desc') }}</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-shield-alt fa-3x text-primary"></i>
          </div>
          <h4 class="mt-3">{{ __('messages.feature_trusted_service_title') }}</h4>
          <p>{{ __('messages.feature_trusted_service_desc') }}</p>
        </div>
      </div>
      <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
        <div class="feature-box">
          <div class="feature-icon">
            <i class="fas fa-chart-line fa-3x text-primary"></i>
          </div>
          <h4 class="mt-3">{{ __('messages.feature_fast_processing_title') }}</h4>
          <p>{{ __('messages.feature_fast_processing_desc') }}</p>
        </div>
      </div>
    </div>

    <!-- Stats -->
    <div class="row bg-light rounded p-5 mb-5" data-aos="fade-up">
      <div class="col-lg-3 col-md-6 text-center mb-4">
        <h2 class="display-4 fw-bold text-primary">10+</h2>
        <p class="text-muted">{{ __('messages.years_experience') }}</p>
      </div>
      <div class="col-lg-3 col-md-6 text-center mb-4">
        <h2 class="display-4 fw-bold text-primary">5000+</h2>
        <p class="text-muted">{{ __('messages.happy_clients') }}</p>
      </div>
      <div class="col-lg-3 col-md-6 text-center mb-4">
        <h2 class="display-4 fw-bold text-primary">8</h2>
        <p class="text-muted">{{ __('messages.loan_products') }}</p>
      </div>
      <div class="col-lg-3 col-md-6 text-center mb-4">
        <h2 class="display-4 fw-bold text-primary">98%</h2>
        <p class="text-muted">{{ __('messages.satisfaction_rate') }}</p>
      </div>
    </div>

    <!-- Our Team -->
    <div class="text-center mb-4" data-aos="fade-up">
      <h2 class="section-title">{{ __('messages.our_team') }}</h2>
      <p class="section-subtitle">{{ __('messages.our_team_subtitle') }}</p>
    </div>

    <div class="row g-4">
      @php
        $team = [
          [
            'name' => 'Sok Dara',
            'title' => __('messages.team_ceo'),
            'photo' => 'team-1.jpg',
            'bio'   => __('messages.team_ceo_bio'),
            'social'=> ['linkedin'=>'#','facebook'=>'#']
          ],
          [
            'name' => 'Chanthy Kim',
            'title' => __('messages.team_ops_head'),
            'photo' => 'team-2.jpg',
            'bio'   => __('messages.team_ops_bio'),
            'social'=> ['linkedin'=>'#','facebook'=>'#']
          ],
          [
            'name' => 'Sophea Lim',
            'title' => __('messages.team_sales_head'),
            'photo' => 'team-3.jpg',
            'bio'   => __('messages.team_sales_bio'),
            'social'=> ['linkedin'=>'#','facebook'=>'#']
          ],
          [
            'name' => 'Vuthy Phan',
            'title' => __('messages.team_risk_mgr'),
            'photo' => 'team-4.jpg',
            'bio'   => __('messages.team_risk_bio'),
            'social'=> ['linkedin'=>'#','facebook'=>'#']
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
.feature-box { background:#fff; border-radius:12px; padding:1.25rem; box-shadow:0 6px 18px rgba(0,0,0,0.06); height:100%; }
.section-title { color:#1e3a8a; font-weight:800; margin-bottom:.25rem; }
.section-subtitle { color:#6b7280; margin-bottom:2rem; }
.team-card { background:#fff; border-radius:14px; overflow:hidden; box-shadow:0 6px 18px rgba(0,0,0,.06); transition:transform .25s ease, box-shadow .25s ease; }
.team-card:hover { transform:translateY(-6px); box-shadow:0 14px 32px rgba(0,0,0,.12); }
.team-photo { position:relative; padding-top:100%; background:#f3f4f6; }
.team-photo img { position:absolute; inset:0; width:100%; height:100%; object-fit:cover; }
.team-body { padding:1rem; }
</style>
@endpush
