@extends('layouts.admin')

@section('title','Customers')
@section('page-title','Customers')

@push('styles')
<style>
/* Mobile-first stack for tables */
@media (max-width: 767.98px) {
  .customers-table thead {
    display: none;
  }
  .customers-table,
  .customers-table tbody,
  .customers-table tr,
  .customers-table td {
    display: block;
    width: 100%;
  }
  .customers-table tr {
    margin-bottom: 1rem;
    border: 1px solid #e9ecef;
    border-radius: .5rem;
    overflow: hidden;
    background: #fff;
  }
  .customers-table td {
    border: none !important;
    border-bottom: 1px solid #f1f3f5 !important;
    padding: .75rem .95rem;
  }
  .customers-table td:last-child {
    border-bottom: none !important;
  }
  .customers-table td::before {
    content: attr(data-label);
    display: block;
    font-weight: 600;
    color: #6c757d;
    margin-bottom: .25rem;
  }
  .customers-table .text-end {
    text-align: left !important;
  }
  .customers-actions .btn {
    margin-right: .35rem;
    margin-bottom: .35rem;
  }
}

/* Action button group */
.custom-actions {
  display: inline-flex;
  align-items: center;
  gap: .35rem;
  flex-wrap: wrap;
}
.custom-actions .btn {
  border: none;
  color: #fff;
  padding: .45rem .55rem;
  line-height: 1;
  border-radius: .5rem;
  box-shadow: 0 0 0 rgba(0,0,0,0);
  transition: transform .05s ease-in-out, box-shadow .15s ease, opacity .15s ease;
}
.custom-actions .btn i { font-size: .9rem; }
/* Brand colors */
.btn-act-view     { background: #475569; }   /* slate */
.btn-act-edit     { background: #f59e0b; }   /* amber */
.btn-act-share    { background: #06b6d4; }   /* cyan */
.btn-act-complete { background: #10b981; }   /* emerald */
.btn-act-delete   { background: #ef4444; }   /* red  */

.custom-actions .btn:hover {
  transform: translateY(-1px);
  box-shadow: 0 6px 12px rgba(0,0,0,.08);
  opacity: .95;
}
.custom-actions .btn:disabled,
.custom-actions .btn[disabled] {
  opacity: .55;
  cursor: not-allowed;
}

@media (max-width: 767.98px) {
  td.custom-actions-cell { text-align: left !important; }
}

/* Compact header on very small screens */
@media (max-width: 575.98px) {
  .card-header .btn, .card-header h5 { font-size: 0.95rem; }
  .card-header .btn i { font-size: .9rem; }
}
</style>
@endpush

@section('content')
@php
  $tgReady = config('services.telegram.bot_token') && config('services.telegram.chat_id');
@endphp

<div class="row">
  <div class="col-12">
    @if(session('error'))
      <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if(session('info'))
      <div class="alert alert-info">{{ session('info') }}</div>
    @endif
    @if(session('success'))
      <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Customers</h5>
        @can('create', App\Models\Customer::class)
          <a href="{{ route('admin.customers.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-1"></i> New Customer
          </a>
        @endcan
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle customers-table">
            <thead>
              <tr>
                <th>Customer</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Loan Type</th>
                <th>Amount</th>
                <th>Status</th>
                <th>Shared</th>
                <th>Date</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($customers as $c)
              <tr>
                <td data-label="Customer">{{ $c->customer_name }}</td>
                <td data-label="Phone">{{ $c->phone_number ?? '—' }}</td>
                <td data-label="Email">{{ $c->email ?? '—' }}</td>
                <td data-label="Loan Type">{{ $c->loanType?->translation()?->title ?? '—' }}</td>
                <td data-label="Amount">{{ $c->loan_amount !== null ? '$'.number_format($c->loan_amount,2) : '—' }}</td>
                <td data-label="Status">
                  <span class="badge bg-{{ $c->status=='complete'?'success':'warning' }}">{{ ucfirst($c->status) }}</span>
                </td>
                <td data-label="Shared">
                  @if($c->shared_to_telegram)
                    <span class="badge bg-info">Yes</span>
                  @else
                    <span class="badge bg-secondary">No</span>
                  @endif
                </td>
                <td data-label="Date">{{ $c->created_at->format('Y-m-d H:i') }}</td>
                <td data-label="Actions" class="text-end customers-actions custom-actions-cell">
                  <div class="custom-actions">

                    {{-- View --}}
                    <button type="button"
                            class="btn btn-act-view"
                            data-bs-toggle="modal"
                            data-bs-target="#customerModal{{ $c->id }}"
                            title="View details">
                      <i class="fas fa-eye"></i>
                    </button>

                    {{-- Edit --}}
                    @can('update',$c)
                    <a href="{{ route('admin.customers.edit',$c) }}"
                       class="btn btn-act-edit"
                       title="Edit">
                      <i class="fas fa-pen"></i>
                    </a>
                    @endcan

                    {{-- Share --}}
                    @php
                      $shareDisabled = (!$tgReady || $c->shared_to_telegram || $c->status==='draft');
                      $shareTitle = $c->status==='draft'
                          ? 'Cannot share draft'
                          : (!$tgReady ? 'Telegram not configured'
                          : ($c->shared_to_telegram ? 'Already shared' : 'Share to Telegram'));
                    @endphp
                    @can('share',$c)
                    <form action="{{ route('admin.customers.share',$c) }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit"
                              class="btn btn-act-share"
                              {{ $shareDisabled ? 'disabled' : '' }}
                              title="{{ $shareTitle }}">
                        <i class="fas fa-share-alt"></i>
                      </button>
                    </form>
                    @endcan

                    {{-- Complete --}}
                    @can('complete',$c)
                      @if($c->status==='draft')
                      <form action="{{ route('admin.customers.complete',$c) }}" method="POST" class="d-inline">
                        @csrf @method('PATCH')
                        <button type="submit"
                                class="btn btn-act-complete"
                                title="Mark Complete">
                          <i class="fas fa-check"></i>
                        </button>
                      </form>
                      @endif
                    @endcan

                    {{-- Delete --}}
                    @can('delete',$c)
                    <form action="{{ route('admin.customers.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete customer?')">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="btn btn-act-delete"
                              title="Delete">
                        <i class="fas fa-trash"></i>
                      </button>
                    </form>
                    @endcan

                  </div>
                </td>
              </tr>

              <!-- Details Modal -->
              <div class="modal fade" id="customerModal{{ $c->id }}" tabindex="-1" aria-labelledby="customerModalLabel{{ $c->id }}" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header bg-primary text-white">
                      <h5 class="modal-title" id="customerModalLabel{{ $c->id }}">Customer Details</h5>
                      <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Customer</div>
                          <div>{{ $c->customer_name }}</div>
                        </div>
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Email</div>
                          <div>{{ $c->email ?? '—' }}</div>
                        </div>

                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Phone</div>
                          <div>{{ $c->phone_number ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Loan Type</div>
                          <div>{{ $c->loanType?->translation()?->title ?? '—' }}</div>
                        </div>

                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Loan Amount</div>
                          <div>{{ $c->loan_amount !== null ? '$'.number_format($c->loan_amount,2) : '—' }}</div>
                        </div>
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Consultation</div>
                          <div>{{ $c->consultation ?? '—' }}</div>
                        </div>

                        <div class="col-md-4">
                          <div class="fw-semibold text-muted mb-1">Fee</div>
                          <div>{{ $c->consultation_fee !== null ? '$'.number_format($c->consultation_fee,2) : '—' }}</div>
                        </div>
                        <div class="col-md-4">
                          <div class="fw-semibold text-muted mb-1">Date</div>
                          <div>{{ optional($c->consultation_date)->format('Y-m-d') ?? '—' }}</div>
                        </div>
                        <div class="col-md-4">
                          <div class="fw-semibold text-muted mb-1">Time</div>
                          <div>{{ $c->consultation_time ? \Carbon\Carbon::parse($c->consultation_time)->format('H:i') : '—' }}</div>
                        </div>

                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Status</div>
                          <div>
                            <span class="badge bg-{{ $c->status=='complete'?'success':'warning' }}">{{ ucfirst($c->status) }}</span>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Shared</div>
                          <div>
                            @if($c->shared_to_telegram)
                              <span class="badge bg-info">Yes</span>
                            @else
                              <span class="badge bg-secondary">No</span>
                            @endif
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Owner</div>
                          <div>{{ $c->owner?->name ?? '—' }}</div>
                        </div>
                        <div class="col-md-6">
                          <div class="fw-semibold text-muted mb-1">Created</div>
                          <div>{{ $c->created_at->format('Y-m-d H:i') }}</div>
                        </div>

                        @if(!empty($c->attachment))
                        <div class="col-12">
                          <div class="fw-semibold text-muted mb-2">Attachment</div>

                          @php
                            $ext = strtolower(pathinfo($c->attachment, PATHINFO_EXTENSION));
                            $isImage = in_array($ext, ['jpg','jpeg','png','gif','webp']);
                          @endphp

                          @if($isImage)
                            <img src="{{ asset('storage/'.$c->attachment) }}" alt="Attachment" class="img-fluid rounded border">
                          @else
                            <a href="{{ asset('storage/'.$c->attachment) }}" target="_blank" class="btn btn-outline-secondary">
                              <i class="fas fa-file me-2"></i>Open Attachment
                            </a>
                          @endif
                        </div>
                        @endif
                      </div>
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                      @can('update',$c)
                      <a href="{{ route('admin.customers.edit',$c) }}" class="btn btn-warning">
                        <i class="fas fa-edit me-1"></i> Edit
                      </a>
                      @endcan

                      @can('share',$c)
                      <form action="{{ route('admin.customers.share',$c) }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-info"
                                {{ (!$tgReady || $c->shared_to_telegram || $c->status==='draft') ? 'disabled' : '' }}>
                          <i class="fas fa-share-alt me-1"></i> Share
                        </button>
                      </form>
                      @endcan
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-3">{{ $customers->links() }}</div>
      </div>
    </div>
  </div>
</div>
@endsection
