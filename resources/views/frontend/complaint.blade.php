@extends('layouts.app')

@section('title', 'Customer Complaint - Global Advisor Solution')

@section('content')
<section class="page-header py-5 bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold" data-aos="fade-up">{{ __('messages.customer_complaint') }}</h1>
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

                        <form action="{{ route('complaint.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.name') }}</label>
                                    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" required>
                                    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.email') }}</label>
                                    <input type="email" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" required>
                                    @error('customer_email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.phone') }}</label>
                                    <input type="text" name="customer_phone" class="form-control @error('customer_phone') is-invalid @enderror" required>
                                    @error('customer_phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.loan_type') }}</label>
                                    <select name="loan_type_id" class="form-select @error('loan_type_id') is-invalid @enderror">
                                        <option value="">Select Loan Type</option>
                                        @foreach($loanTypes as $loanType)
                                        <option value="{{ $loanType->id }}">{{ $loanType->translation()?->title }}</option>
                                        @endforeach
                                    </select>
                                    @error('loan_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.priority') }}</label>
                                    <select name="priority" class="form-select @error('priority') is-invalid @enderror" required>
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                    @error('priority')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label class="form-label">{{ __('messages.attachment') }}</label>
                                    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror" accept=".pdf,.jpg,.jpeg,.png">
                                    <small class="text-muted">Max: 5MB</small>
                                    @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.subject') }}</label>
                                <input type="text" name="subject" class="form-control @error('subject') is-invalid @enderror" required>
                                @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">{{ __('messages.description') }}</label>
                                <textarea name="description" class="form-control @error('description') is-invalid @enderror" rows="5" required></textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <button type="submit" class="btn btn-primary btn-lg">{{ __('messages.submit') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
