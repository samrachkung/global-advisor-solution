@extends('layouts.admin')

@section('title', 'Job Positions')
@section('page-title', 'Job Positions Management')

@section('content')
<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">All Job Positions</h5>
        <a href="{{ route('admin.jobs.create') }}" class="btn btn-primary">
          <i class="fas fa-plus me-2"></i>Add New Job
        </a>
      </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table table-hover align-middle">
            <thead>
              <tr>
                <th>Title</th>
                <th>Department</th>
                <th>Location</th>
                <th>Type</th>
                <th>Status</th>
                <th>Applications</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
            @foreach($jobs as $job)
              @php
                $en = $job->translations->firstWhere('language.code','en');
                $km = $job->translations->firstWhere('language.code','km');
              @endphp
              <tr>
                <td><strong>{{ $job->translation()?->title ?? ($en?->title ?? '—') }}</strong></td>
                <td>{{ $job->department }}</td>
                <td>{{ $job->location }}</td>
                <td><span class="badge bg-info">{{ ucfirst($job->employment_type) }}</span></td>
                <td>
                  <span class="badge bg-{{ $job->status == 'open' ? 'success' : 'secondary' }}">
                    {{ ucfirst($job->status) }}
                  </span>
                </td>
                <td>{{ $job->applications_count ?? 0 }}</td>
                <td class="text-end">
                  <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#jobModal{{ $job->id }}">
                    <i class="fas fa-eye"></i>
                  </button>
                  <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-sm btn-warning">
                    <i class="fas fa-edit"></i>
                  </a>
                  <form action="{{ route('admin.jobs.destroy', $job) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this job?')">
                    @csrf @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fas fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>

              {{-- Details Modal --}}
              <div class="modal fade" id="jobModal{{ $job->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-scrollable">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title d-flex align-items-center gap-2">
                        {{ $en?->title ?? 'N/A' }} / {{ $km?->title ?? 'N/A' }}
                        <span class="badge bg-{{ $job->status=='open'?'success':'secondary' }}">{{ ucfirst($job->status) }}</span>
                      </h5>
                      <button class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                      <div class="row g-3">
                        <div class="col-md-4">
                          <ul class="list-group small">
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Department</span><strong>{{ $job->department }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Location</span><strong>{{ $job->location }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Type</span><strong>{{ ucfirst($job->employment_type) }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Salary</span><strong>{{ $job->salary_range ?: '—' }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Deadline</span><strong>{{ $job->application_deadline ?: '—' }}</strong>
                            </li>
                            <li class="list-group-item d-flex justify-content-between">
                              <span>Applications</span><strong>{{ $job->applications_count ?? $job->applications()->count() }}</strong>
                            </li>
                          </ul>
                        </div>

                        <div class="col-md-8">
                          <h6 class="text-primary">English</h6>
                          <p class="mb-1"><strong>Title:</strong> {{ $en?->title ?? '—' }}</p>
                          <p class="mb-2"><strong>Description:</strong><br>{!! nl2br(e($en?->description)) !!}</p>
                          <p class="mb-2"><strong>Requirements:</strong><br>{!! nl2br(e($en?->requirements)) !!}</p>
                          <p class="mb-3"><strong>Responsibilities:</strong><br>{!! nl2br(e($en?->responsibilities)) !!}</p>
                          @if($en?->benefits)
                          <p class="mb-4"><strong>Benefits:</strong><br>{!! nl2br(e($en->benefits)) !!}</p>
                          @endif

                          <h6 class="text-primary">Khmer</h6>
                          <p class="mb-1"><strong>[translate:ចំណងជើង]:</strong> {{ $km?->title ?? '—' }}</p>
                          <p class="mb-2"><strong>[translate:សេចក្តីពិពណ៌នា]:</strong><br>{!! nl2br(e($km?->description)) !!}</p>
                          <p class="mb-2"><strong>[translate:តម្រូវការ]:</strong><br>{!! nl2br(e($km?->requirements)) !!}</p>
                          <p class="mb-3"><strong>[translate:កាតព្វកិច្ច]:</strong><br>{!! nl2br(e($km?->responsibilities)) !!}</p>
                          @if($km?->benefits)
                          <p class="mb-1"><strong>[translate:អត្ថប្រយោជន៍]:</strong><br>{!! nl2br(e($km->benefits)) !!}</p>
                          @endif
                        </div>
                      </div>
                    </div>

                    <div class="modal-footer">
                      <a href="{{ route('admin.jobs.edit', $job) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit
                      </a>
                      <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
              {{-- /Details Modal --}}
            @endforeach
            </tbody>
          </table>
        </div>

        <div class="mt-3">
          {{ $jobs->links() }}
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
