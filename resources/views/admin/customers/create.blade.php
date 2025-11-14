@extends('layouts.admin')

@section('title','New Customer')
@section('page-title','New Customer')

@section('content')
<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
          <i class="fas fa-arrow-left me-1"></i> Back
        </a>
        <h5 class="mb-0">Create Customer</h5>
      </div>

      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger">
            <ul class="mb-0">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form action="{{ route('admin.customers.store') }}" method="POST" enctype="multipart/form-data">
          @include('admin.customers._form', ['customer' => null])

          <div class="d-flex gap-2 justify-content-end mt-3">
            <a href="{{ route('admin.customers.index') }}" class="btn btn-light">
              <i class="fas fa-arrow-left me-1"></i> Back
            </a>
            <button type="submit" name="action" value="save_draft" class="btn btn-outline-secondary">
              <i class="fas fa-save me-1"></i> Save as Draft
            </button>
            <button type="submit" name="action" value="save" class="btn btn-primary">
              <i class="fas fa-check me-1"></i> Save
            </button>
          </div>
        </form>

      </div>
    </div>
  </div>
</div>
@endsection
