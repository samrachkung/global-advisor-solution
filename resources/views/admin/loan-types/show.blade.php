@extends('layouts.admin')

@section('title','View Loan Type')
@section('page-title','Loan Type Details')

@section('content')
@php
  $en = $loanType->translations->firstWhere('language.code','en');
  $km = $loanType->translations->firstWhere('language.code','km');
  $c  = $loanType->conditions;
@endphp

<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">
          <i class="{{ $loanType->icon }} text-primary me-2"></i> {{ $en?->title ?? 'N/A' }} / {{ $km?->title ?? 'N/A' }}
        </h5>
        <div>
          <a href="{{ route('admin.loan-types.edit',$loanType) }}" class="btn btn-warning btn-sm">
            <i class="fas fa-edit me-1"></i>Edit
          </a>
          <a href="{{ route('admin.loan-types.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i>Back
          </a>
        </div>
      </div>
      <div class="card-body">
        <div class="row g-4">
          <div class="col-md-4">
            <div class="border rounded p-2 text-center">
              @if($loanType->poster)
                <img src="{{ asset('uploads/services/'.$loanType->poster) }}" class="img-fluid rounded" alt="Poster">
              @else
                <span class="text-muted">No poster</span>
              @endif
            </div>
            <ul class="list-group mt-3 small">
              <li class="list-group-item d-flex justify-content-between">
                <span>Slug</span><strong>{{ $loanType->slug }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Order</span><strong>{{ $loanType->order }}</strong>
              </li>
              <li class="list-group-item d-flex justify-content-between">
                <span>Status</span>
                <span class="badge bg-{{ $loanType->status=='active'?'success':'secondary' }}">{{ ucfirst($loanType->status) }}</span>
              </li>
            </ul>
          </div>

          <div class="col-md-8">
            <h6 class="text-primary">English</h6>
            <p class="mb-1"><strong>Title:</strong> {{ $en?->title ?? '—' }}</p>
            <p class="mb-3"><strong>Description:</strong><br>{{ $en?->description ?? '—' }}</p>
            @if($en?->conditions)
              <p class="mb-4"><strong>Conditions:</strong><br>{{ $en->conditions }}</p>
            @endif

            <h6 class="text-primary">Khmer</h6>
            <p class="mb-1"><strong>ចំណងជើង:</strong> {{ $km?->title ?? '—' }}</p>
            <p class="mb-3"><strong>សេចក្តីអធិប្បាយ:</strong><br>{{ $km?->description ?? '—' }}</p>
            @if($km?->conditions)
              <p class="mb-4"><strong>លក្ខខណ្ឌ:</strong><br>{{ $km->conditions }}</p>
            @endif

            <h6 class="text-primary">Loan Conditions</h6>
            @if($c)
              <div class="row g-2 small">
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Currency</strong><br>{{ $c->currency_type }}</div></div>
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Min Amount</strong><br>{{ number_format($c->min_amount,2) }}</div></div>
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Max Amount</strong><br>{{ number_format($c->max_amount,2) }}</div></div>
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Max Months</strong><br>{{ $c->max_duration_months }}</div></div>
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Age</strong><br>{{ $c->min_age }} - {{ $c->max_age }}</div></div>
                <div class="col-6 col-md-4"><div class="border rounded p-2"><strong>Max Debt Ratio</strong><br>{{ rtrim(rtrim(number_format($c->max_debt_ratio,2),'0'),'.') }}%</div></div>
              </div>
            @else
              <div class="alert alert-warning mt-2">No loan conditions set.</div>
            @endif
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
