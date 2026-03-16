@extends('dashboard.layouts.master')

@section('title', 'Testimonial Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Testimonial Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.testimonials.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="d-flex align-items-center gap-4">
                        @if($testimonial->image)
                            <img src="{{ asset('uploads/testimonials/' . $testimonial->image) }}" alt="{{ $testimonial->name }}"
                                class="rounded-circle"
                                style="width: 120px; height: 120px; object-fit: cover; border: 3px solid #ddd;">
                        @else
                            <div class="bg-label-secondary rounded-circle d-flex align-items-center justify-content-center"
                                style="width: 120px; height: 120px; border: 3px solid #ddd;">
                                <i class="ti ti-user" style="font-size: 48px;"></i>
                            </div>
                        @endif
                        <div>
                            <h4 class="mb-1">{{ $testimonial->name }}</h4>
                            @if($testimonial->job_title || $testimonial->company)
                                <p class="text-muted mb-0">
                                    @if($testimonial->job_title)
                                        {{ $testimonial->job_title }}
                                    @endif
                                    @if($testimonial->job_title && $testimonial->company)
                                        at
                                    @endif
                                    @if($testimonial->company)
                                        <strong>{{ $testimonial->company }}</strong>
                                    @endif
                                </p>
                            @endif
                            @if($testimonial->rating)
                                <div class="mt-2">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $testimonial->rating)
                                            <i class="ti ti-star-filled text-warning" style="font-size: 20px;"></i>
                                        @else
                                            <i class="ti ti-star text-muted" style="font-size: 20px;"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">({{ $testimonial->rating }}/5)</span>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Description</label>
                    <div class="card bg-label-secondary p-3">
                        <p class="mb-0">{{ $testimonial->description }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p class="form-control-plaintext">
                        @if($testimonial->status == 'active')
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-danger">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sort Order</label>
                    <p class="form-control-plaintext">{{ $testimonial->sort_order }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="form-control-plaintext">{{ $testimonial->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Updated At</label>
                    <p class="form-control-plaintext">{{ $testimonial->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Delete Testimonial
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
