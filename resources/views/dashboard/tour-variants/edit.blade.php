@extends('dashboard.layouts.master')

@section('title', 'Edit Tour Variant')

@push('css')
<style>
    body {
        background: #1a1d29;
    }
    .main-card {
        background: #1e2130;
        border: 1px solid #2a2d3a;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.3);
        overflow: hidden;
    }
    .main-card-header {
        background: linear-gradient(135deg, #1e2130 0%, #252836 100%);
        border-bottom: 1px solid #2a2d3a;
        padding: 1.5rem 2rem;
    }
    .main-card-header h5 {
        color: #e4e6eb;
        font-weight: 600;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .main-card-header i {
        color: #667eea;
        font-size: 1.75rem;
    }
    .main-card-body {
        background: #1a1d29;
        padding: 2rem;
    }
    .section-card {
        background: #1e2130;
        border: 1px solid #2a2d3a;
        border-radius: 12px;
        margin-bottom: 1.5rem;
        overflow: hidden;
        transition: all 0.3s ease;
        box-shadow: 0 4px 16px rgba(0,0,0,0.2);
    }
    .section-card:hover {
        border-color: #3a3d4a;
        box-shadow: 0 6px 24px rgba(0,0,0,0.3);
        transform: translateY(-2px);
    }
    .section-header {
        background: linear-gradient(135deg, #252836 0%, #2a2d3a 100%);
        border-bottom: 1px solid #3a3d4a;
        padding: 1.25rem 1.75rem;
        position: relative;
        overflow: hidden;
    }
    .section-header::before {
        content: '';
        position: absolute;
        left: 0;
        top: 0;
        width: 4px;
        height: 100%;
        background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
    }
    .section-header.info::before { background: linear-gradient(180deg, #667eea 0%, #764ba2 100%); }
    .section-header.images::before { background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%); }
    .section-header.settings::before { background: linear-gradient(180deg, #fa709a 0%, #fee140 100%); }
    .section-header h6 {
        margin: 0;
        font-weight: 600;
        font-size: 1.1rem;
        color: #e4e6eb;
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .section-header i {
        font-size: 1.5rem;
        color: #667eea;
    }
    .section-header.info i { color: #667eea; }
    .section-header.images i { color: #f093fb; }
    .section-header.settings i { color: #fa709a; }
    .section-body {
        padding: 1.75rem;
        background: #1e2130;
    }
    .form-label {
        color: #b0b3b8;
        font-weight: 500;
        margin-bottom: 0.5rem;
    }
    .form-control, .form-select {
        background: #252836;
        border: 1px solid #3a3d4a;
        color: #e4e6eb;
        padding: 0.75rem;
    }
    .form-control:focus, .form-select:focus {
        background: #252836;
        border-color: #667eea;
        color: #e4e6eb;
        box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
    }
    .form-control::placeholder {
        color: #6c757d;
    }
    .btn-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border: none;
        padding: 0.75rem 1.5rem;
        font-weight: 500;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
    }
    .btn-label-primary {
        background: #252836;
        border: 1px solid #667eea;
        color: #667eea;
    }
    .btn-label-primary:hover {
        background: #667eea;
        color: #fff;
    }
    .btn-label-danger {
        background: #252836;
        border: 1px solid #f5576c;
        color: #f5576c;
    }
    .btn-label-danger:hover {
        background: #f5576c;
        color: #fff;
    }
    .text-muted {
        color: #8a8d94 !important;
    }
    .text-danger {
        color: #ff6b6b !important;
    }
    .img-thumbnail {
        border: 2px solid #3a3d4a;
        background: #252836;
        border-radius: 8px;
        max-width: 300px;
        margin-top: 1rem;
    }
    .invalid-feedback {
        color: #ff6b6b;
        font-size: 0.85rem;
    }
</style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card main-card">
                    <div class="card-header main-card-header">
                        <h5>
                            <i class="ti ti-edit"></i>
                            Edit Tour Variant
                        </h5>
                    </div>
                    <div class="card-body main-card-body">
                        <form action="{{ route('admin.tour-variants.update', $variant->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div class="section-card mt-3">
                                <div class="section-header info">
                                    <h6>
                                        <i class="ti ti-info-circle"></i>
                                        Basic Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title"
                                            value="{{ old('title', $variant->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                            name="description" rows="4">{{ old('description', $variant->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Image Section -->
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Variant Image
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="mb-4">
                                        @if($variant->image)
                                            <div class="mb-3">
                                                <label class="form-label">Current Image</label>
                                                <div>
                                                    <img src="{{ asset('uploads/tour-variants/' . $variant->image) }}" alt="{{ $variant->title }}"
                                                        class="img-thumbnail" style="max-width: 200px;">
                                                </div>
                                            </div>
                                        @endif
                                        <label for="image" class="form-label">Change Image</label>
                                        <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image"
                                            accept="image/*">
                                        <small class="text-muted">Recommended size: 400x400px. Max size: 5MB</small>
                                        @error('image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="imagePreview" class="mt-3"></div>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Information Section -->
                            <div class="section-card">
                                <div class="section-header settings">
                                    <h6>
                                        <i class="ti ti-settings"></i>
                                        Additional Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="additional_duration" class="form-label">Additional Duration</label>
                                            <input type="number" class="form-control @error('additional_duration') is-invalid @enderror" id="additional_duration" name="additional_duration"
                                                value="{{ old('additional_duration', $variant->additional_duration) }}" min="0">
                                            @error('additional_duration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="additional_duration_type" class="form-label">Duration Type</label>
                                            <select class="form-select @error('additional_duration_type') is-invalid @enderror" id="additional_duration_type" name="additional_duration_type">
                                                <option value="days" {{ old('additional_duration_type', $variant->additional_duration_type) == 'days' ? 'selected' : '' }}>Days</option>
                                                <option value="hours" {{ old('additional_duration_type', $variant->additional_duration_type) == 'hours' ? 'selected' : '' }}>Hours</option>
                                            </select>
                                            @error('additional_duration_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="additional_price" class="form-label">Additional Price ($)</label>
                                            <input type="number" step="0.01" class="form-control @error('additional_price') is-invalid @enderror" id="additional_price" name="additional_price"
                                                value="{{ old('additional_price', $variant->additional_price) }}" min="0">
                                            @error('additional_price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="active" {{ old('status', $variant->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $variant->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sort_order" class="form-label">Sort Order</label>
                                        <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order"
                                            value="{{ old('sort_order', $variant->sort_order) }}" min="0">
                                        @error('sort_order')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.tour-variants.index') }}" class="btn btn-label-danger">
                                    <i class="ti ti-x me-1"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>
                                    Update Variant
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            // Image preview
            $('#image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreview').html(`
                            <img src="${e.target.result}" alt="Preview" class="img-thumbnail">
                        `);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#imagePreview').html('');
                }
            });
        });
    </script>
@endpush

