@extends('layouts.admin')

@section('title', 'Slideshows')
@section('page-title', 'Slideshow Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Slideshows</h5>
                <a href="{{ route('admin.slideshows.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Slide
                </a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Order</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Link</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($slideshows as $slide)
                                @php
                                    $en = $slide->translations->firstWhere('language.code','en');
                                    $km = $slide->translations->firstWhere('language.code','km');
                                @endphp
                                <tr>
                                    <td><strong>{{ $slide->order }}</strong></td>
                                    <td>
                                        <img src="{{ asset('uploads/slideshows/' . $slide->image) }}"
                                             alt="slide"
                                             style="width: 120px; height: 68px; object-fit: cover; border-radius: 8px;">
                                    </td>
                                    <td>{{ $slide->translation()?->title }}</td>
                                    <td class="text-truncate" style="max-width: 260px;">
                                        @if($slide->link)
                                            <a href="{{ $slide->link }}" target="_blank">{{ $slide->link }}</a>
                                        @else
                                            <span class="text-muted">N/A</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $slide->status == 'active' ? 'success' : 'secondary' }}">
                                            {{ ucfirst($slide->status) }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <!-- View Detail -->
                                        <button type="button" class="btn btn-sm btn-info"
                                                data-bs-toggle="modal"
                                                data-bs-target="#slideModal{{ $slide->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>

                                        <!-- Edit -->
                                        <a href="{{ route('admin.slideshows.edit', $slide) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>

                                        <!-- Delete -->
                                        <form action="{{ route('admin.slideshows.destroy', $slide) }}"
                                              method="POST" class="d-inline"
                                              onsubmit="return confirm('Delete this slide?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>

                                        <!-- Detail Modal -->
                                        <div class="modal fade" id="slideModal{{ $slide->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-lg modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title">
                                                            Slide #{{ $slide->order }}
                                                            <span class="badge ms-2 bg-{{ $slide->status == 'active' ? 'success' : 'secondary' }}">
                                                                {{ ucfirst($slide->status) }}
                                                            </span>
                                                        </h5>
                                                        <button class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-md-5">
                                                                <div class="border rounded p-2 text-center">
                                                                    <img src="{{ asset('uploads/slideshows/'.$slide->image) }}"
                                                                         class="img-fluid rounded" alt="Slide image">
                                                                </div>
                                                                <ul class="list-group mt-3 small">
                                                                    <li class="list-group-item d-flex justify-content-between">
                                                                        <span>Order</span><strong>{{ $slide->order }}</strong>
                                                                    </li>
                                                                    <li class="list-group-item">
                                                                        <div class="text-truncate"><strong>Link:</strong>
                                                                            @if($slide->link)
                                                                                <a href="{{ $slide->link }}" target="_blank">{{ $slide->link }}</a>
                                                                            @else
                                                                                <span class="text-muted">—</span>
                                                                            @endif
                                                                        </div>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <div class="col-md-7">
                                                                <h6 class="text-primary">English</h6>
                                                                <p class="mb-1"><strong>Title:</strong> {{ $en?->title ?? '—' }}</p>
                                                                <p class="mb-2"><strong>Description:</strong><br>{{ $en?->description ?? '—' }}</p>
                                                                <p class="mb-4"><strong>Button:</strong> {{ $en?->button_text ?? __('messages.explore_services') }}</p>

                                                                <h6 class="text-primary">Khmer</h6>
                                                                <p class="mb-1"><strong>[translate:ចំណងជើង]:</strong> {{ $km?->title ?? '—' }}</p>
                                                                <p class="mb-2"><strong>[translate:សេចក្តីអធិប្បាយ]:</strong><br>{{ $km?->description ?? '—' }}</p>
                                                                <p class="mb-0"><strong>[translate:ប៊ូតុង]:</strong> {{ $km?->button_text ?? '—' }}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <a href="{{ route('admin.slideshows.edit', $slide) }}" class="btn btn-primary">
                                                            <i class="fas fa-edit me-2"></i>Edit
                                                        </a>
                                                        <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $slideshows->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
