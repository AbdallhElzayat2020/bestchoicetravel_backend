@extends('dashboard.layouts.master')

@section('title', 'FAQ Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">FAQ Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.faqs.edit', $faq->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.faqs.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back to List
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Question</label>
                    <div class="card bg-label-primary p-3">
                        <h5 class="mb-0">{{ $faq->question }}</h5>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Answer</label>
                    <div class="card bg-label-secondary p-3">
                        <p class="mb-0">{{ $faq->answer }}</p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Status</label>
                    <p class="form-control-plaintext">
                        @if($faq->status == 'active')
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-danger">Inactive</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Sort Order</label>
                    <p class="form-control-plaintext">{{ $faq->sort_order }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Created At</label>
                    <p class="form-control-plaintext">{{ $faq->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Updated At</label>
                    <p class="form-control-plaintext">{{ $faq->updated_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mt-4">
                <form action="{{ route('admin.faqs.destroy', $faq->id) }}" method="POST"
                    onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="ti ti-trash me-1"></i>
                        Delete FAQ
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
