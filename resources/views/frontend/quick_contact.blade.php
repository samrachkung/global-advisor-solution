@extends('layouts.app')

@section('title', 'Quick Contact - Global Advisor Solution')

@push('styles')
<style>
/* Full-page submit loader */
.app-loader{position:fixed;inset:0;background:rgba(255,255,255,.75);backdrop-filter:blur(1px);display:none;align-items:center;justify-content:center;z-index:2000}
.app-loader.show{display:flex}
.loader-spinner{width:56px;height:56px;border-radius:50%;border:4px solid #e5e7eb;border-top-color:#2563eb;animation:spin .9s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
</style>
@endpush

@section('content')
<section class="page-header py-5 bg-light">
  <div class="container">
    <h1 class="display-5 fw-bold" data-aos="fade-up">{{ __('messages.quick_contact') }}</h1>
    <p class="text-white" data-aos="fade-up" data-aos-delay="100">{{ __('messages.get_started_today') }}</p>
  </div>
</section>

<section class="complaint-section py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8" data-aos="fade-up">
        <div class="card shadow-sm">
          <div class="card-body p-4">
            @if(session('success'))
              <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('quick-contact.store') }}" method="POST" enctype="multipart/form-data" class="js-submit-loader">
              @csrf

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.name') }}</label>
                  <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" value="{{ old('customer_name') }}" required>
                  @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.email') }}</label>
                  <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" value="{{ old('customer_email') }}" required>
                  @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.phone') }}</label>
                  <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" value="{{ old('customer_phone') }}" required>
                  @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.loan_type') }}</label>
                  <select name="loan_type_id" class="form-select @error('loan_type_id') is-invalid @enderror">
                    <option value="">{{ __('messages.select') }}</option>
                    @foreach($loanTypes as $loanType)
                      <option value="{{ $loanType->id }}" {{ old('loan_type_id')==$loanType->id?'selected':'' }}>
                        {{ $loanType->translation()?->title }}
                      </option>
                    @endforeach
                  </select>
                  @error('loan_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.loan_amount') }} (USD)</label>
                  <input type="number" step="0.01" name="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror" value="{{ old('loan_amount') }}">
                  @error('loan_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.consultation') }}</label>
                  <select name="consultation" class="form-select @error('consultation') is-invalid @enderror">
                    <option value="">{{ __('messages.select') }}</option>
                    @foreach(['Phone','Office','Online','ផ្ទាល់'] as $opt)
                      <option value="{{ $opt }}" {{ old('consultation')==$opt?'selected':'' }}>{{ $opt }}</option>
                    @endforeach
                  </select>
                  @error('consultation')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.consultation_date') }}</label>
                  <input type="date" name="consultation_date" class="form-control @error('consultation_date') is-invalid @enderror" value="{{ old('consultation_date') }}">
                  @error('consultation_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="col-md-6 mb-3">
                  <label class="form-label">{{ __('messages.consultation_time') }}</label>
                  <input type="time" name="consultation_time" class="form-control @error('consultation_time') is-invalid @enderror" value="{{ old('consultation_time') }}">
                  @error('consultation_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>
              </div>

              <div class="text-end">
                <button type="submit" class="btn btn-primary btn-lg">
                  <i class="fas fa-paper-plane me-2"></i>{{ __('messages.submit') }}
                </button>
              </div>
            </form>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

{{-- Page loader --}}
<div id="qcLoader" class="app-loader" aria-hidden="true">
  <div class="loader-spinner" role="status" aria-label="Loading"></div>
</div>
@endsection

@push('scripts')
<script>
(function(){
  const loader = document.getElementById('qcLoader');
  document.querySelectorAll('form.js-submit-loader').forEach(f=>{
    f.addEventListener('submit', ()=>{
      f.querySelectorAll('button[type="submit"],input[type="submit"]').forEach(b=>b.disabled=true);
      loader?.classList.add('show');
    });
  });
})();
</script>
@endpush
