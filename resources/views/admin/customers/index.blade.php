@extends('layouts.admin')
@section('title','Customers')
@section('page-title','Customers')

@section('content')
<div class="row">
  <div class="col-12">
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
          <table class="table table-hover align-middle">
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
                <td>{{ $c->customer_name }}</td>
                <td>{{ $c->phone_number ?? '—' }}</td>
                <td>{{ $c->email ?? '—' }}</td>
                <td>{{ $c->loanType?->translation()?->title ?? '—' }}</td>
                <td>{{ $c->loan_amount !== null ? '$'.number_format($c->loan_amount,2) : '—' }}</td>
                <td>
                  <span class="badge bg-{{ $c->status=='complete'?'success':'warning' }}">{{ ucfirst($c->status) }}</span>
                </td>
                <td>
                  @if($c->shared_to_telegram)
                    <span class="badge bg-info">Yes</span>
                  @else
                    <span class="badge bg-secondary">No</span>
                  @endif
                </td>
                <td>{{ $c->created_at->format('Y-m-d H:i') }}</td>
                <td class="text-end">
                  @can('update',$c)
                  <a href="{{ route('admin.customers.edit',$c) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                  @endcan

                  @can('share',$c)
                  <form action="{{ route('admin.customers.share',$c) }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-info" {{ $c->shared_to_telegram ? 'disabled' : '' }}>
                      <i class="fas fa-share-alt"></i>
                    </button>
                  </form>
                  @endcan

                  @can('complete',$c)
                  @if($c->status==='draft')
                  <form action="{{ route('admin.customers.complete',$c) }}" method="POST" class="d-inline">
                    @csrf @method('PATCH')
                    <button type="submit" class="btn btn-sm btn-success">
                      <i class="fas fa-check"></i>
                    </button>
                  </form>
                  @endif
                  @endcan

                  @can('delete',$c)
                  <form action="{{ route('admin.customers.destroy',$c) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete customer?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger"><i class="fas fa-trash"></i></button>
                  </form>
                  @endcan
                </td>
              </tr>
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
