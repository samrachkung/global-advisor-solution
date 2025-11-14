@csrf
<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Customer Name *</label>
    <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror"
           value="{{ old('customer_name', $customer->customer_name ?? '') }}" required>
    @error('customer_name')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Email</label>
    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
           value="{{ old('email', $customer->email ?? '') }}">
    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Phone Number</label>
    <input type="text" name="phone_number" class="form-control @error('phone_number') is-invalid @enderror"
           value="{{ old('phone_number', $customer->phone_number ?? '') }}">
    @error('phone_number')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
  <div class="col-md-6 mb-3">
    <label class="form-label">Loan Amount (USD)</label>
    <input type="number" step="0.01" name="loan_amount" class="form-control @error('loan_amount') is-invalid @enderror"
           value="{{ old('loan_amount', $customer->loan_amount ?? '') }}">
    @error('loan_amount')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Loan Type</label>
    <select name="loan_type_id" class="form-select @error('loan_type_id') is-invalid @enderror">
      <option value="">-- Select --</option>
      @foreach($loanTypes as $lt)
        <option value="{{ $lt->id }}" {{ old('loan_type_id', $customer->loan_type_id ?? null)==$lt->id ? 'selected' : '' }}>
          {{ $lt->translation()?->title ?? $lt->slug }}
        </option>
      @endforeach
    </select>
    @error('loan_type_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-6 mb-3">
    <label class="form-label">Consultation</label>
    <select name="consultation" class="form-select @error('consultation') is-invalid @enderror">
      <option value="">-- Select --</option>
      @foreach(['Phone','Office','Online','ផ្ទាល់'] as $opt)
        <option value="{{ $opt }}" {{ old('consultation', $customer->consultation ?? '')==$opt ? 'selected':'' }}>{{ $opt }}</option>
      @endforeach
    </select>
    @error('consultation')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-4 mb-3">
    <label class="form-label">Consultation Fee (USD)</label>
    <input type="number" step="0.01" name="consultation_fee" class="form-control @error('consultation_fee') is-invalid @enderror"
           value="{{ old('consultation_fee', $customer->consultation_fee ?? '') }}">
    @error('consultation_fee')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-4 mb-3">
    <label class="form-label">Consultation Date</label>
    <input type="date" name="consultation_date" class="form-control @error('consultation_date') is-invalid @enderror"
           value="{{ old('consultation_date', optional($customer->consultation_date ?? null)->format('Y-m-d')) }}">
    @error('consultation_date')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>

  <div class="col-md-4 mb-3">
    <label class="form-label">Consultation Time</label>
    <input type="time" name="consultation_time" class="form-control @error('consultation_time') is-invalid @enderror"
           value="{{ old('consultation_time', isset($customer->consultation_time) ? \Carbon\Carbon::parse($customer->consultation_time)->format('H:i') : '') }}">
    @error('consultation_time')<div class="invalid-feedback">{{ $message }}</div>@enderror
  </div>
</div>

<div class="row">
  <div class="col-md-6 mb-3">
    <label class="form-label">Attachment (Image/PDF/Doc)</label>
    <input type="file" name="attachment" class="form-control @error('attachment') is-invalid @enderror"
           accept=".jpg,.jpeg,.png,.gif,.webp,.pdf,.doc,.docx">
    @error('attachment')<div class="invalid-feedback">{{ $message }}</div>@enderror

    @if(!empty($customer?->attachment))
      <small class="text-muted d-block mt-2">Current: {{ $customer->attachment }}</small>
    @endif
  </div>

  <div class="col-md-6 mb-3">
    <label class="form-label">Created By</label>
    <input type="text" class="form-control" value="{{ auth()->user()->name }}" disabled>
  </div>
</div>
