@extends('layouts.admin')
@section('title','New Customer')
@section('page-title','New Customer')
@section('content')
<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-body">
        <form action="{{ route('admin.customers.store') }}" method="POST">
          @include('admin.customers._form')
          <div class="text-end">
            <button class="btn btn-primary"><i class="fas fa-save me-1"></i> Save</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
