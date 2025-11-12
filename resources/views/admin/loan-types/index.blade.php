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
                                            <a href="{{ route('admin.loan-types.edit', $loan) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.loan-types.destroy', $loan) }}" method="POST"
                                                class="d-inline" data-confirm>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
