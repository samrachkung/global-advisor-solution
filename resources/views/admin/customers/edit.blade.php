@extends('layouts.admin')

@section('title','Edit Customer')
@section('page-title','Edit Customer')

@push('styles')
<style>
.app-loader{position:fixed;inset:0;background:rgba(255,255,255,.75);backdrop-filter:blur(1px);display:none;align-items:center;justify-content:center;z-index:2000}
.app-loader.show{display:flex}
.loader-spinner{width:56px;height:56px;border-radius:50%;border:4px solid #e5e7eb;border-top-color:#2563eb;animation:spin .9s linear infinite}
@keyframes spin{to{transform:rotate(360deg)}}
</style>
@endpush

@section('content')
<div class="row">
  <div class="col-lg-10 mx-auto">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <a href="{{ route('admin.customers.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
        <h5 class="mb-0">Edit Customer</h5>
      </div>

      <div class="card-body">
        @if ($errors->any())
          <div class="alert alert-danger"><ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
        @endif

        <form action="{{ route('admin.customers.update',$customer) }}" method="POST" enctype="multipart/form-data" class="js-submit-loader">
          @csrf @method('PUT')
          <input type="hidden" name="action" value="save">

          @include('admin.customers._form', ['customer' => $customer])

          <div class="d-flex gap-2 justify-content-between mt-3">
            <div>
              @can('complete',$customer)
                @if($customer->status==='draft')
                <form action="{{ route('admin.customers.complete',$customer) }}" method="POST" class="d-inline">
                  @csrf @method('PATCH')
                  <button class="btn btn-success"><i class="fas fa-check me-1"></i> Mark Complete</button>
                </form>
                @endif
              @endcan
            </div>
            <div class="d-flex gap-2">
              <a href="{{ route('admin.customers.index') }}" class="btn btn-light"><i class="fas fa-arrow-left me-1"></i> Back</a>
              <button type="submit" name="action" value="save" class="btn btn-primary"><i class="fas fa-save me-1"></i> Update</button>
              <button type="submit" name="action" value="save_draft" class="btn btn-outline-secondary"><i class="fas fa-save me-1"></i> Save as Draft</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<div id="appLoader" class="app-loader" aria-hidden="true"><div class="loader-spinner" role="status" aria-label="Loading"></div></div>
@endsection

@push('scripts')
<script>
(function(){
  const loader=document.getElementById('appLoader');
  document.querySelectorAll('form.js-submit-loader').forEach(f=>{
    f.addEventListener('submit',()=>{
      f.querySelectorAll('button[type="submit"],input[type="submit"]').forEach(b=>b.disabled=true);
      loader?.classList.add('show');
    });
  });
})();
</script>
@endpush
