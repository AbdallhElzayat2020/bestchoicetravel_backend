@extends('dashboard.layouts.master')

@section('title', 'Slider Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Slider Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.sliders.edit', $slider->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.sliders.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-4">
                    @if($slider->image)
                        <img src="{{ asset('uploads/sliders/' . $slider->image) }}" alt="{{ $slider->title }}"
                            class="img-fluid rounded" style="max-height: 400px; width: 100%; object-fit: cover;">
                    @else
                        <div class="alert alert-warning">No image available</div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Title</label>
                    <p class="form-control-plaintext fs-5">{{ $slider->title }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <div class="card bg-label-secondary p-3">
                        <p class="mb-0">{{ $slider->description ?? 'N/A' }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p class="form-control-plaintext">
                        @if($slider->status == 'active')
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-danger">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sort Order</label>
                    <p class="form-control-plaintext">{{ $slider->sort_order }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Link URL</label>
                    <p class="form-control-plaintext">
                        @if($slider->link)
                            <a href="{{ $slider->link }}" target="_blank" class="text-primary">
                                {{ $slider->link }} <i class="ti ti-external-link"></i>
                            </a>
                        @else
                            <span class="text-muted">N/A</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Button Text</label>
                    <p class="form-control-plaintext">{{ $slider->button_text ?? 'N/A' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="form-control-plaintext">{{ $slider->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Updated At</label>
                    <p class="form-control-plaintext">{{ $slider->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.sliders.destroy', $slider->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this slider?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Delete Slider
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
