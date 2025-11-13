@extends('layouts.admin')

@section('title', 'Loan Types')
@section('page-title', 'Loan Types Management')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">All Loan Types</h5>
                    <a href="{{ route('admin.loan-types.create') }}" class="btn btn-add">
                        <i class="fas fa-plus me-2"></i>Add New Loan Type
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover data-table">
                            <thead>
                                <tr>
                                    <th>Order</th>
                                    <th>Icon</th>
                                    <th>Poster</th>
                                    <th>Title (EN)</th>
                                    <th>Title (KM)</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($loanTypes as $loan)
                                    @php
                                        $enTranslation = $loan->translations->where('language.code', 'en')->first();
                                        $kmTranslation = $loan->translations->where('language.code', 'km')->first();
                                    @endphp
                                    <tr>
                                        <td><strong>{{ $loan->order }}</strong></td>
                                        <td><i class="{{ $loan->icon }} fa-2x text-primary"></i></td>
                                        <td>
                                            @if ($loan->poster)
                                                <img src="{{ asset('uploads/services/' . $loan->poster) }}" alt="Poster"
                                                    style="width: 72px; height: 36px; object-fit: cover;"
                                                    class="rounded border">
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>

                                        <td>{{ $enTranslation?->title ?? 'N/A' }}</td>
                                        <td>{{ $kmTranslation?->title ?? 'N/A' }}</td>
                                        <td>
                                            <span
                                                class="badge bg-{{ $loan->status == 'active' ? 'success' : 'secondary' }}">
                                                {{ ucfirst($loan->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#loanTypeModal{{ $loan->id }}">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <a href="{{ route('admin.loan-types.edit', $loan) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form action="{{ route('admin.loan-types.destroy', $loan) }}" method="POST"
                                                class="d-inline" data-confirm>
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>

                                            <!-- Details Modal -->
                                            <div class="modal fade" id="loanTypeModal{{ $loan->id }}" tabindex="-1"
                                                aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                <i class="{{ $loan->icon }} text-primary me-2"></i>
                                                                {{ $enTranslation?->title ?? 'N/A' }} /
                                                                {{ $kmTranslation?->title ?? 'N/A' }}
                                                            </h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="row g-3">
                                                                <div class="col-md-4">
                                                                    <div class="border rounded p-2 text-center">
                                                                        @if ($loan->poster)
                                                                            <img src="{{ asset('uploads/services/' . $loan->poster) }}"
                                                                                class="img-fluid rounded" alt="Poster">
                                                                        @else
                                                                            <span class="text-muted">No poster</span>
                                                                        @endif
                                                                    </div>
                                                                    <ul class="list-group mt-3 small">
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between">
                                                                            <span>Slug</span><strong>{{ $loan->slug }}</strong>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between">
                                                                            <span>Order</span><strong>{{ $loan->order }}</strong>
                                                                        </li>
                                                                        <li
                                                                            class="list-group-item d-flex justify-content-between">
                                                                            <span>Status</span>
                                                                            <span
                                                                                class="badge bg-{{ $loan->status == 'active' ? 'success' : 'secondary' }}">{{ ucfirst($loan->status) }}</span>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                                <div class="col-md-8">
                                                                    <h6 class="text-primary">English</h6>
                                                                    <p class="mb-1"><strong>Title:</strong>
                                                                        {{ $enTranslation?->title ?? '—' }}</p>
                                                                    <p class="mb-3">
                                                                        <strong>Description:</strong><br>{{ $enTranslation?->description ?? '—' }}
                                                                    </p>
                                                                    @if ($enTranslation?->conditions)
                                                                        <p class="mb-4">
                                                                            <strong>Conditions:</strong><br>{{ $enTranslation->conditions }}
                                                                        </p>
                                                                    @endif

                                                                    <h6 class="text-primary">Khmer</h6>
                                                                    <p class="mb-1"><strong>ចំណងជើង:</strong>
                                                                        {{ $kmTranslation?->title ?? '—' }}</p>
                                                                    <p class="mb-3">
                                                                        <strong>សេចក្តីអធិប្បាយ:</strong><br>{{ $kmTranslation?->description ?? '—' }}
                                                                    </p>
                                                                    @if ($kmTranslation?->conditions)
                                                                        <p class="mb-4">
                                                                            <strong>លក្ខខណ្ឌ:</strong><br>{{ $kmTranslation->conditions }}
                                                                        </p>
                                                                    @endif

                                                                    @php $cond = $loan->conditions; @endphp
                                                                    @if ($cond)
                                                                        <h6 class="text-primary">Loan Conditions</h6>
                                                                        <div class="row g-2">
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Currency</strong><br>{{ $cond->currency_type }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Min
                                                                                        Amount</strong><br>{{ number_format($cond->min_amount, 2) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Max
                                                                                        Amount</strong><br>{{ number_format($cond->max_amount, 2) }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Max
                                                                                        Months</strong><br>{{ $cond->max_duration_months }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Age</strong><br>{{ $cond->min_age }}
                                                                                    - {{ $cond->max_age }}</div>
                                                                            </div>
                                                                            <div class="col-6 col-md-4">
                                                                                <div class="border rounded p-2 small">
                                                                                    <strong>Max Debt
                                                                                        Ratio</strong><br>{{ rtrim(rtrim(number_format($cond->max_debt_ratio, 2), '0'), '.') }}%
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="alert alert-warning small mt-3">No loan
                                                                            conditions found.</div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <a href="{{ route('admin.loan-types.edit', $loan) }}"
                                                                class="btn btn-primary">
                                                                <i class="fas fa-edit me-2"></i>Edit
                                                            </a>
                                                            <button class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Close</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
