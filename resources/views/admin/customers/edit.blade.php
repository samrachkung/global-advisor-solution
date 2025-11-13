@extends('layouts.admin')
@section('title','Edit Customer')
@section('page-title','Edit Customer')
@section('content')
<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.customers.update',$customer) }}" method="POST">
          @csrf @method('PUT')
          @include('admin.customers._form', ['customer'=>$customer])
          <div class="d-flex justify-content-between">
            @can('complete',$customer)
              @if($customer->status==='draft')
              <form action="{{ route('admin.customers.complete',$customer) }}" method="POST">
                @csrf @method('PATCH')
                <button class="btn btn-success"><i class="fas fa-check me-1"></i> Mark Complete</button>
              </form>
              @endif
            @endcan
            <div class="text-end">
              <button class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
