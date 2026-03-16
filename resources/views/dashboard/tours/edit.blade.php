@extends('dashboard.layouts.master')

@section('title', 'Edit Tour')

@php
    use Illuminate\Support\Str;
@endphp

@push('css')
    <style>
        body {
            background: #1a1d29;
        }

        .main-card {
            background: #1e2130;
            border: 1px solid #2a2d3a;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
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
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .section-card:hover {
            border-color: #3a3d4a;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);
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

        .section-header.info::before {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .section-header.images::before {
            background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%);
        }

        .section-header.seo::before {
            background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%);
        }

        .section-header.pricing::before {
            background: linear-gradient(180deg, #43e97b 0%, #38f9d7 100%);
        }

        .section-header.settings::before {
            background: linear-gradient(180deg, #fa709a 0%, #fee140 100%);
        }

        .section-header.days::before {
            background: linear-gradient(180deg, #30cfd0 0%, #330867 100%);
        }

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

        .section-header.info i {
            color: #667eea;
        }

        .section-header.images i {
            color: #f093fb;
        }

        .section-header.seo i {
            color: #4facfe;
        }

        .section-header.pricing i {
            color: #43e97b;
        }

        .section-header.settings i {
            color: #fa709a;
        }

        .section-header.days i {
            color: #30cfd0;
        }

        .section-body {
            padding: 1.75rem;
            background: #1e2130;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #3a3d4a, transparent);
            margin: 2rem 0;
            border: none;
        }

        .form-label {
            font-weight: 500;
            color: #b0b3b8;
            margin-bottom: 0.5rem;
            font-size: 0.9rem;
        }

        .form-control,
        .form-select {
            background: #252836;
            border: 1px solid #3a3d4a;
            color: #e4e6eb;
            border-radius: 8px;
            padding: 0.65rem 1rem;
            transition: all 0.3s ease;
        }

        .form-control:focus,
        .form-select:focus {
            background: #2a2d3a;
            border-color: #667eea;
            color: #e4e6eb;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }

        .form-control::placeholder {
            color: #6c757d;
        }

        .form-control option {
            background: #252836;
            color: #e4e6eb;
        }

        .form-select option {
            background: #252836;
            color: #e4e6eb;
        }

        .text-muted {
            color: #8a8d94 !important;
            font-size: 0.85rem;
        }

        .text-danger {
            color: #ff6b6b !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.7rem 1.75rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-label-secondary {
            background: #252836;
            border: 1px solid #3a3d4a;
            color: #b0b3b8;
            padding: 0.7rem 1.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-label-secondary:hover {
            background: #2a2d3a;
            border-color: #4a4d5a;
            color: #e4e6eb;
        }

        .btn-sm {
            padding: 0.5rem 1rem;
            font-size: 0.875rem;
        }

        .btn-label-danger {
            background: #2a1f1f;
            border: 1px solid #4a2f2f;
            color: #ff6b6b;
        }

        .btn-label-danger:hover {
            background: #3a2f2f;
            border-color: #5a3f3f;
            color: #ff8b8b;
        }

        .image-preview-card {
            background: #252836;
            border: 1px solid #3a3d4a;
            border-radius: 8px;
            padding: 1rem;
            transition: all 0.3s ease;
        }

        .image-preview-card:hover {
            border-color: #667eea;
            background: #2a2d3a;
        }

        .card {
            background: #252836;
            border: 1px solid #3a3d4a;
        }

        .card-header {
            background: #2a2d3a;
            border-bottom: 1px solid #3a3d4a;
            color: #e4e6eb;
        }

        .card-body {
            background: #252836;
            color: #e4e6eb;
        }

        .img-thumbnail {
            border: 2px solid #3a3d4a;
            background: #252836;
        }

        .invalid-feedback {
            color: #ff6b6b;
            font-size: 0.85rem;
        }

        .form-check-input {
            background-color: #252836;
            border: 1px solid #3a3d4a;
        }

        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }

        .form-check-label {
            color: #b0b3b8;
        }

        h6 {
            color: #e4e6eb;
        }

        p {
            color: #b0b3b8;
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
                            Edit Tour
                        </h5>
                    </div>
                    <div class="card-body main-card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="background: #2a1f1f; border: 1px solid #4a2f2f; color: #ff6b6b; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                                <h6 style="color: #ff6b6b; margin-bottom: 0.75rem;">
                                    <i class="ti ti-alert-circle me-2"></i>
                                    Please fix the following errors:
                                </h6>
                                <ul class="mb-0" style="margin-left: 1.5rem;">
                                    @foreach ($errors->all() as $error)
                                        <li style="color: #ff8b8b;">{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="filter: brightness(0) invert(1);"></button>
                            </div>
                        @endif

                        @if (session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert"
                                style="background: #2a1f1f; border: 1px solid #4a2f2f; color: #ff6b6b; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                                <i class="ti ti-alert-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="filter: brightness(0) invert(1);"></button>
                            </div>
                        @endif

                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert"
                                style="background: rgba(67, 233, 123, 0.1); border: 1px solid rgba(67, 233, 123, 0.3); color: #43e97b; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem;">
                                <i class="ti ti-check me-2"></i>
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"
                                    style="filter: brightness(0) invert(1);"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.tours.update', $tour->id) }}" method="POST"
                            enctype="multipart/form-data" id="tourForm">
                            @csrf
                            @method('PUT')

                            <!-- Basic Information Section -->
                            <div class="section-card">
                                <div class="section-header info">
                                    <h6>
                                        <i class="ti ti-info-circle"></i>
                                        Basic Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="category_id" class="form-label">Category</label>
                                            <select class="form-select @error('category_id') is-invalid @enderror"
                                                id="category_id" name="category_id">
                                                <option value="">Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ old('category_id', $tour->category_id) == $category->id ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="country_id" class="form-label">Country <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('country_id') is-invalid @enderror"
                                                id="country_id" name="country_id" required>
                                                <option value="">Select Country</option>
                                                @foreach ($countries as $country)
                                                    <option value="{{ $country->id }}"
                                                        {{ old('country_id', $tour->country_id) == $country->id ? 'selected' : '' }}>
                                                        {{ $country->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('country_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="state_id" class="form-label">State</label>
                                            <select class="form-select @error('state_id') is-invalid @enderror"
                                                id="state_id" name="state_id">
                                                <option value="">Select State</option>
                                                @foreach ($states as $state)
                                                    <option value="{{ $state->id }}"
                                                        {{ old('state_id', $tour->state_id) == $state->id ? 'selected' : '' }}>
                                                        {{ $state->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('state_id')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title <span
                                                class="text-danger">*</span></label>
                                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                                            id="title" name="title" value="{{ old('title', $tour->title) }}"
                                            required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror"
                                            id="slug" name="slug" value="{{ old('slug', $tour->slug) }}"
                                            placeholder="Auto-generated from title if left empty">
                                        <small class="text-muted">Leave empty to auto-generate from title, or enter custom
                                            slug</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" rows="3">{{ old('short_description', $tour->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description"
                                            name="description">{{ old('description', $tour->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Images & Media
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="mb-4">
                                        <label for="cover_image" class="form-label">Cover Image</label>
                                        @if ($tour->cover_image)
                                            <div class="mb-3">
                                                <img src="{{ asset('uploads/tours/' . $tour->cover_image) }}"
                                                    alt="{{ $tour->cover_image_alt ?? $tour->title }}"
                                                    class="img-thumbnail rounded"
                                                    style="max-width: 300px; max-height: 200px;">
                                            </div>
                                        @endif
                                        <input type="file"
                                            class="form-control @error('cover_image') is-invalid @enderror"
                                            id="cover_image" name="cover_image" accept="image/*">
                                        <small class="text-muted">Leave empty to keep current image. Recommended size:
                                            1200x600px. Max size: 2MB</small>
                                        @error('cover_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="coverImagePreview" class="mt-3"></div>
                                    </div>

                                    <div class="mb-4">
                                        <label for="cover_image_alt" class="form-label">Cover Image Alt Text</label>
                                        <input type="text"
                                            class="form-control @error('cover_image_alt') is-invalid @enderror"
                                            id="cover_image_alt" name="cover_image_alt"
                                            value="{{ old('cover_image_alt', $tour->cover_image_alt) }}"
                                            placeholder="Enter alt text for the cover image">
                                        <small class="text-muted">Describe the image for accessibility and SEO</small>
                                        @error('cover_image_alt')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <hr class="divider">

                                    <div class="mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <label class="form-label mb-0">Gallery Images</label>
                                            <button type="button" class="btn btn-sm btn-primary" id="addImageBtn">
                                                <i class="ti ti-plus me-1"></i>
                                                Add Image
                                            </button>
                                        </div>
                                        <small class="text-muted d-block mb-3">Add multiple images for the tour
                                            gallery</small>

                                        <div id="tourImagesContainer">
                                            @if ($tour->tourImages && $tour->tourImages->count() > 0)
                                                @foreach ($tour->tourImages as $image)
                                                    <div class="card mb-3 image-item image-preview-card"
                                                        data-image-id="{{ $image->id }}">
                                                        <div class="card-body">
                                                            <div class="row align-items-end">
                                                                <div class="col-md-5 mb-3">
                                                                    <label class="form-label">Current Image</label>
                                                                    <div class="mb-2">
                                                                        <img src="{{ asset('uploads/tours/' . $image->image) }}"
                                                                            alt="{{ $image->alt ?? 'Tour Image' }}"
                                                                            class="img-thumbnail rounded"
                                                                            style="max-width: 200px; max-height: 150px;">
                                                                    </div>
                                                                    <input type="file" class="form-control image-input"
                                                                        name="tour_images[{{ $image->id }}][image]"
                                                                        accept="image/*">
                                                                    <small class="text-muted">Leave empty to keep current
                                                                        image</small>
                                                                    <input type="hidden"
                                                                        name="tour_images[{{ $image->id }}][id]"
                                                                        value="{{ $image->id }}">
                                                                    <div class="image-preview mt-2"></div>
                                                                </div>
                                                                <div class="col-md-4 mb-3">
                                                                    <label class="form-label">Image Alt Text</label>
                                                                    <input type="text" class="form-control"
                                                                        name="tour_images[{{ $image->id }}][alt]"
                                                                        value="{{ $image->alt }}"
                                                                        placeholder="Enter alt text for the image">
                                                                </div>
                                                                <div class="col-md-2 mb-3">
                                                                    <label class="form-label">Sort Order</label>
                                                                    <input type="number" class="form-control"
                                                                        name="tour_images[{{ $image->id }}][sort_order]"
                                                                        value="{{ $image->sort_order }}" min="0">
                                                                </div>
                                                                <div class="col-md-1 mb-3">
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-label-danger removeImageBtn">
                                                                        <i class="ti ti-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @else
                                                <p class="text-muted mb-0 text-center py-3">No gallery images added yet.
                                                    Click
                                                    "Add Image" to add images.</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- SEO Section -->
                            <div class="section-card">
                                <div class="section-header seo">
                                    <h6>
                                        <i class="ti ti-search"></i>
                                        SEO Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="mb-3">
                                        <label for="meta_title" class="form-label">Meta Title</label>
                                        <input type="text"
                                            class="form-control @error('meta_title') is-invalid @enderror"
                                            id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $tour->meta_title) }}" maxlength="60">
                                        <small class="text-muted">Recommended: 50-60 characters</small>
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                            name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $tour->meta_description) }}</textarea>
                                        <small class="text-muted">Recommended: 150-160 characters</small>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text"
                                            class="form-control @error('meta_keywords') is-invalid @enderror"
                                            id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords', $tour->meta_keywords) }}"
                                            placeholder="keyword1, keyword2, keyword3">
                                        <small class="text-muted">Separate keywords with commas</small>
                                        @error('meta_keywords')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing & Duration Section -->
                            <div class="section-card">
                                <div class="section-header pricing">
                                    <h6>
                                        <i class="ti ti-currency-dollar"></i>
                                        Pricing & Duration
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="row mb-4">
                                        <div class="col-md-6 mb-3">
                                            <label for="duration" class="form-label">Duration <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('duration') is-invalid @enderror"
                                                id="duration" name="duration"
                                                value="{{ old('duration', $tour->duration) }}" min="1" required>
                                            @error('duration')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="duration_type" class="form-label">Duration Type <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('duration_type') is-invalid @enderror"
                                                id="duration_type" name="duration_type" required>
                                                <option value="days"
                                                    {{ old('duration_type', $tour->duration_type) == 'days' ? 'selected' : '' }}>
                                                    Days</option>
                                                <option value="hours"
                                                    {{ old('duration_type', $tour->duration_type) == 'hours' ? 'selected' : '' }}>
                                                    Hours</option>
                                            </select>
                                            @error('duration_type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="divider">

                                    <h6 class="mb-3" style="color: #e4e6eb;">Pricing</h6>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="price" class="form-label">Price <span
                                                    class="text-danger">*</span></label>
                                            <input type="number"
                                                class="form-control @error('price') is-invalid @enderror" id="price"
                                                name="price" value="{{ old('price', $tour->price) }}" step="0.01"
                                                min="0" required>
                                            @error('price')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <div class="form-check mt-4">
                                                <input class="form-check-input" type="checkbox" id="has_offer"
                                                    name="has_offer" value="1"
                                                    {{ old('has_offer', $tour->has_offer) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="has_offer">
                                                    Has Offer
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="offerFields"
                                        style="display: {{ old('has_offer', $tour->has_offer) ? 'block' : 'none' }};">
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="price_before_discount" class="form-label">Price Before
                                                    Discount</label>
                                                <input type="number"
                                                    class="form-control @error('price_before_discount') is-invalid @enderror"
                                                    id="price_before_discount" name="price_before_discount"
                                                    value="{{ old('price_before_discount', $tour->price_before_discount) }}"
                                                    step="0.01" min="0">
                                                @error('price_before_discount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="price_after_discount" class="form-label">Price After
                                                    Discount</label>
                                                <input type="number"
                                                    class="form-control @error('price_after_discount') is-invalid @enderror"
                                                    id="price_after_discount" name="price_after_discount"
                                                    value="{{ old('price_after_discount', $tour->price_after_discount) }}"
                                                    step="0.01" min="0">
                                                @error('price_after_discount')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="offer_start_date" class="form-label">Offer Start Date</label>
                                                <input type="date"
                                                    class="form-control @error('offer_start_date') is-invalid @enderror"
                                                    id="offer_start_date" name="offer_start_date"
                                                    value="{{ old('offer_start_date', $tour->offer_start_date ? $tour->offer_start_date->format('Y-m-d') : '') }}">
                                                @error('offer_start_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6 mb-3">
                                                <label for="offer_end_date" class="form-label">Offer End Date</label>
                                                <input type="date"
                                                    class="form-control @error('offer_end_date') is-invalid @enderror"
                                                    id="offer_end_date" name="offer_end_date"
                                                    value="{{ old('offer_end_date', $tour->offer_end_date ? $tour->offer_end_date->format('Y-m-d') : '') }}">
                                                @error('offer_end_date')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Status & Settings Section -->
                            <div class="section-card">
                                <div class="section-header settings">
                                    <h6>
                                        <i class="ti ti-settings"></i>
                                        Status & Settings
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="status" class="form-label">Status <span
                                                    class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror"
                                                id="status" name="status" required>
                                                <option value="active"
                                                    {{ old('status', $tour->status ?? 'active') == 'active' ? 'selected' : '' }}>
                                                    Active</option>
                                                <option value="inactive"
                                                    {{ old('status', $tour->status ?? 'active') == 'inactive' ? 'selected' : '' }}>
                                                    Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number"
                                                class="form-control @error('sort_order') is-invalid @enderror"
                                                id="sort_order" name="sort_order"
                                                value="{{ old('sort_order', $tour->sort_order ?? 0) }}" min="0">
                                            <small class="text-muted">Lower numbers appear first</small>
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr class="divider">

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="show_on_homepage"
                                                name="show_on_homepage" value="1"
                                                {{ old('show_on_homepage', $tour->show_on_homepage ?? false) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="show_on_homepage">
                                                Show on Homepage
                                            </label>
                                        </div>
                                        <small class="text-muted">Check this to display the tour on the homepage</small>
                                    </div>

                                    <hr class="divider">

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Notes</label>
                                        <textarea class="form-control @error('notes') is-invalid @enderror" id="notes" name="notes" rows="5">{{ old('notes', $tour->notes ?? '') }}</textarea>
                                        <small class="text-muted">Optional notes about this tour</small>
                                        @error('notes')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Tour Days Section -->
                            <div class="section-card">
                                <div class="section-header days">
                                    <h6>
                                        <i class="ti ti-calendar"></i>
                                        Tour Days / Itinerary
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <p class="text-muted mb-0">Manage the itinerary for this tour</p>
                                        <button type="button" class="btn btn-sm btn-primary" id="addDayBtn">
                                            <i class="ti ti-plus me-1"></i>
                                            Add Day
                                        </button>
                                    </div>

                                    <div id="tourDaysContainer">
                                        @if ($tour->tourDays && $tour->tourDays->count() > 0)
                                            @foreach ($tour->tourDays as $index => $day)
                                                <div class="card mb-3 day-item" data-day-index="{{ $day->id }}"
                                                    style="border: 1px solid #3a3d4a; border-radius: 8px;">
                                                    <div class="card-header d-flex justify-content-between align-items-center"
                                                        style="background: #252836; border-bottom: 1px solid #3a3d4a;">
                                                        <h6 class="mb-0" style="color: #e4e6eb;">
                                                            <i class="ti ti-calendar-event me-2"
                                                                style="color: #30cfd0;"></i>
                                                            Day {{ $day->day_number }}
                                                        </h6>
                                                        <button type="button"
                                                            class="btn btn-sm btn-label-danger removeDayBtn">
                                                            <i class="ti ti-trash"></i> Delete Day
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="hidden" name="tour_days[{{ $day->id }}][id]"
                                                            value="{{ $day->id }}">
                                                        <div class="row">
                                                            <div class="col-md-3 mb-3">
                                                                <label class="form-label">Day Number <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="number" class="form-control day-number"
                                                                    name="tour_days[{{ $day->id }}][day_number]"
                                                                    value="{{ $day->day_number }}" min="1"
                                                                    required>
                                                            </div>
                                                            <div class="col-md-9 mb-3">
                                                                <label class="form-label">Day Title <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control day-title"
                                                                    name="tour_days[{{ $day->id }}][day_title]"
                                                                    value="{{ $day->day_title }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Details</label>
                                                            <textarea class="form-control summernote-day" name="tour_days[{{ $day->id }}][details]">{{ $day->details }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted mb-0 text-center py-4">No tour days added yet. Click "Add
                                                Day"
                                                to add itinerary days.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Tour Variants Section -->
                            <div class="section-card">
                                <div class="section-header settings">
                                    <h6>
                                        <i class="ti ti-adjustments"></i>
                                        Tour Variants / Add-ons
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <p class="text-muted mb-3">Select available variants to add to this tour. You can
                                        manage
                                        variants from <a href="{{ route('admin.tour-variants.index') }}" target="_blank"
                                            class="text-primary">Tour Variants</a> page.</p>

                                    @php
                                        $selectedVariantIds = $tour->variants->pluck('id')->toArray();
                                    @endphp

                                    @if ($availableVariants && $availableVariants->count() > 0)
                                        <div class="row">
                                            @foreach ($availableVariants as $variant)
                                                <div class="col-md-6 mb-3">
                                                    <div class="card"
                                                        style="background: #252836; border: 1px solid #3a3d4a;">
                                                        <div class="card-body">
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="selected_variants[]"
                                                                    value="{{ $variant->id }}"
                                                                    id="variant_{{ $variant->id }}"
                                                                    {{ in_array($variant->id, $selectedVariantIds) ? 'checked' : '' }}>
                                                                <label class="form-check-label w-100"
                                                                    for="variant_{{ $variant->id }}">
                                                                    <div class="d-flex align-items-start gap-2">
                                                                        @if ($variant->image)
                                                                            <img src="{{ asset('uploads/tour-variants/' . $variant->image) }}"
                                                                                alt="{{ $variant->title }}"
                                                                                style="width: 60px; height: 60px; object-fit: cover; border-radius: 6px;">
                                                                        @endif
                                                                        <div class="flex-grow-1">
                                                                            <strong
                                                                                style="color: #e4e6eb;">{{ $variant->title }}</strong>
                                                                            @if ($variant->description)
                                                                                <p class="text-muted mb-1"
                                                                                    style="font-size: 0.85rem;">
                                                                                    {{ Str::limit($variant->description, 80) }}
                                                                                </p>
                                                                            @endif
                                                                            <div class="d-flex gap-3 mt-2">
                                                                                @if ($variant->additional_duration > 0)
                                                                                    <small class="text-muted">
                                                                                        <i class="ti ti-clock"></i>
                                                                                        +{{ $variant->additional_duration }}
                                                                                        {{ $variant->additional_duration_type }}
                                                                                    </small>
                                                                                @endif
                                                                                @if ($variant->additional_price > 0)
                                                                                    <small class="text-muted">
                                                                                        <i
                                                                                            class="ti ti-currency-dollar"></i>
                                                                                        +${{ number_format($variant->additional_price, 2) }}
                                                                                    </small>
                                                                                @endif
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="ti ti-info-circle me-2"></i>
                                            No variants available. <a href="{{ route('admin.tour-variants.create') }}"
                                                target="_blank" class="text-primary">Create a variant</a> first.
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Seasonal Prices Section -->
                            <div class="section-card">
                                <div class="section-header pricing">
                                    <h6>
                                        <i class="ti ti-calendar-time"></i>
                                        Seasonal Prices
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <p class="text-muted mb-0">Add seasonal pricing with different rates for different
                                            months (e.g., Summer/Winter prices)</p>
                                        <button type="button" class="btn btn-sm btn-primary" id="addSeasonalPriceBtn">
                                            <i class="ti ti-plus me-1"></i>
                                            Add Seasonal Price
                                        </button>
                                    </div>

                                    <div id="seasonalPricesContainer">
                                        @if ($tour->seasonalPrices && $tour->seasonalPrices->count() > 0)
                                            @foreach ($tour->seasonalPrices as $index => $price)
                                                <div class="card mb-3 seasonal-price-item"
                                                    data-seasonal-price-id="{{ $price->id }}"
                                                    style="border: 1px solid #3a3d4a; border-radius: 8px;">
                                                    <div class="card-header d-flex justify-content-between align-items-center"
                                                        style="background: #252836; border-bottom: 1px solid #3a3d4a;">
                                                        <h6 class="mb-0" style="color: #e4e6eb;">
                                                            <i class="ti ti-calendar-time me-2"
                                                                style="color: #43e97b;"></i>
                                                            {{ $price->season_name }}
                                                        </h6>
                                                        <button type="button"
                                                            class="btn btn-sm btn-label-danger removeSeasonalPriceBtn">
                                                            <i class="ti ti-trash"></i> Delete
                                                        </button>
                                                    </div>
                                                    <div class="card-body">
                                                        <input type="hidden"
                                                            name="seasonal_prices[{{ $price->id }}][id]"
                                                            value="{{ $price->id }}">
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Season Name <span
                                                                        class="text-danger">*</span></label>
                                                                <input type="text" class="form-control"
                                                                    name="seasonal_prices[{{ $price->id }}][season_name]"
                                                                    value="{{ $price->season_name }}" required>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Start Month <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-select"
                                                                    name="seasonal_prices[{{ $price->id }}][start_month]"
                                                                    required>
                                                                    <option value="">Select Month</option>
                                                                    <option value="1"
                                                                        {{ $price->start_month == 1 ? 'selected' : '' }}>
                                                                        January</option>
                                                                    <option value="2"
                                                                        {{ $price->start_month == 2 ? 'selected' : '' }}>
                                                                        February</option>
                                                                    <option value="3"
                                                                        {{ $price->start_month == 3 ? 'selected' : '' }}>
                                                                        March</option>
                                                                    <option value="4"
                                                                        {{ $price->start_month == 4 ? 'selected' : '' }}>
                                                                        April</option>
                                                                    <option value="5"
                                                                        {{ $price->start_month == 5 ? 'selected' : '' }}>
                                                                        May</option>
                                                                    <option value="6"
                                                                        {{ $price->start_month == 6 ? 'selected' : '' }}>
                                                                        June</option>
                                                                    <option value="7"
                                                                        {{ $price->start_month == 7 ? 'selected' : '' }}>
                                                                        July</option>
                                                                    <option value="8"
                                                                        {{ $price->start_month == 8 ? 'selected' : '' }}>
                                                                        August</option>
                                                                    <option value="9"
                                                                        {{ $price->start_month == 9 ? 'selected' : '' }}>
                                                                        September</option>
                                                                    <option value="10"
                                                                        {{ $price->start_month == 10 ? 'selected' : '' }}>
                                                                        October</option>
                                                                    <option value="11"
                                                                        {{ $price->start_month == 11 ? 'selected' : '' }}>
                                                                        November</option>
                                                                    <option value="12"
                                                                        {{ $price->start_month == 12 ? 'selected' : '' }}>
                                                                        December</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">End Month <span
                                                                        class="text-danger">*</span></label>
                                                                <select class="form-select"
                                                                    name="seasonal_prices[{{ $price->id }}][end_month]"
                                                                    required>
                                                                    <option value="">Select Month</option>
                                                                    <option value="1"
                                                                        {{ $price->end_month == 1 ? 'selected' : '' }}>
                                                                        January</option>
                                                                    <option value="2"
                                                                        {{ $price->end_month == 2 ? 'selected' : '' }}>
                                                                        February</option>
                                                                    <option value="3"
                                                                        {{ $price->end_month == 3 ? 'selected' : '' }}>
                                                                        March</option>
                                                                    <option value="4"
                                                                        {{ $price->end_month == 4 ? 'selected' : '' }}>
                                                                        April</option>
                                                                    <option value="5"
                                                                        {{ $price->end_month == 5 ? 'selected' : '' }}>
                                                                        May</option>
                                                                    <option value="6"
                                                                        {{ $price->end_month == 6 ? 'selected' : '' }}>
                                                                        June</option>
                                                                    <option value="7"
                                                                        {{ $price->end_month == 7 ? 'selected' : '' }}>
                                                                        July</option>
                                                                    <option value="8"
                                                                        {{ $price->end_month == 8 ? 'selected' : '' }}>
                                                                        August</option>
                                                                    <option value="9"
                                                                        {{ $price->end_month == 9 ? 'selected' : '' }}>
                                                                        September</option>
                                                                    <option value="10"
                                                                        {{ $price->end_month == 10 ? 'selected' : '' }}>
                                                                        October</option>
                                                                    <option value="11"
                                                                        {{ $price->end_month == 11 ? 'selected' : '' }}>
                                                                        November</option>
                                                                    <option value="12"
                                                                        {{ $price->end_month == 12 ? 'selected' : '' }}>
                                                                        December</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <label class="form-label">Description</label>
                                                                <textarea class="form-control" name="seasonal_prices[{{ $price->id }}][description]" rows="2"
                                                                    placeholder="Description for this season">{{ $price->description ?? '' }}</textarea>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 mb-3">
                                                                <div
                                                                    class="d-flex justify-content-between align-items-center mb-2">
                                                                    <label class="form-label mb-0">Price Items</label>
                                                                    <button type="button"
                                                                        class="btn btn-sm btn-label-primary addPriceItemBtn"
                                                                        data-seasonal-price-index="{{ $price->id }}"
                                                                        data-price-items-container="price-items-{{ $price->id }}">
                                                                        <i class="ti ti-plus"></i> Add Price Item
                                                                    </button>
                                                                </div>
                                                                <div class="price-items-container"
                                                                    id="price-items-{{ $price->id }}"
                                                                    data-seasonal-price-index="{{ $price->id }}">
                                                                    @if ($price->priceItems && $price->priceItems->count() > 0)
                                                                        @foreach ($price->priceItems as $itemIndex => $item)
                                                                            <div class="card mb-2 price-item"
                                                                                data-price-item-id="{{ $item->id }}"
                                                                                style="border: 1px solid #3a3d4a; border-radius: 6px; background: #1e2028;">
                                                                                <div class="card-body p-3">
                                                                                    <div
                                                                                        class="d-flex justify-content-between align-items-start mb-2">
                                                                                        <h6 class="mb-0"
                                                                                            style="color: #e4e6eb; font-size: 0.9rem;">
                                                                                            <i class="ti ti-currency-dollar me-1"
                                                                                                style="color: #43e97b;"></i>
                                                                                            Price Item
                                                                                            {{ $itemIndex + 1 }}
                                                                                        </h6>
                                                                                        <button type="button"
                                                                                            class="btn btn-sm btn-label-danger removePriceItemBtn">
                                                                                            <i class="ti ti-x"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <input type="hidden"
                                                                                        name="seasonal_prices[{{ $price->id }}][price_items][{{ $item->id }}][id]"
                                                                                        value="{{ $item->id }}">
                                                                                    <div class="row">
                                                                                        <div class="col-md-5 mb-2">
                                                                                            <label class="form-label"
                                                                                                style="font-size: 0.85rem;">Price
                                                                                                Name <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <input type="text"
                                                                                                class="form-control form-control-sm"
                                                                                                name="seasonal_prices[{{ $price->id }}][price_items][{{ $item->id }}][price_name]"
                                                                                                value="{{ $item->price_name }}"
                                                                                                placeholder="e.g., Per Person in Single_room"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-4 mb-2">
                                                                                            <label class="form-label"
                                                                                                style="font-size: 0.85rem;">Price
                                                                                                Value
                                                                                                <span
                                                                                                    class="text-danger">*</span></label>
                                                                                            <input type="number"
                                                                                                class="form-control form-control-sm"
                                                                                                name="seasonal_prices[{{ $price->id }}][price_items][{{ $item->id }}][price_value]"
                                                                                                value="{{ $item->price_value }}"
                                                                                                step="0.01"
                                                                                                min="0"
                                                                                                placeholder="0.00"
                                                                                                required>
                                                                                        </div>
                                                                                        <div class="col-md-3 mb-2">
                                                                                            <label class="form-label"
                                                                                                style="font-size: 0.85rem;">Sort
                                                                                                Order</label>
                                                                                            <input type="number"
                                                                                                class="form-control form-control-sm"
                                                                                                name="seasonal_prices[{{ $price->id }}][price_items][{{ $item->id }}][sort_order]"
                                                                                                value="{{ $item->sort_order }}"
                                                                                                min="0">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mb-2">
                                                                                            <label class="form-label"
                                                                                                style="font-size: 0.85rem;">Description</label>
                                                                                            <textarea class="form-control form-control-sm"
                                                                                                name="seasonal_prices[{{ $price->id }}][price_items][{{ $item->id }}][description]" rows="2"
                                                                                                placeholder="Optional description">{{ $item->description ?? '' }}</textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Status</label>
                                                                <select class="form-select"
                                                                    name="seasonal_prices[{{ $price->id }}][status]">
                                                                    <option value="active"
                                                                        {{ $price->status == 'active' ? 'selected' : '' }}>
                                                                        Active</option>
                                                                    <option value="inactive"
                                                                        {{ $price->status == 'inactive' ? 'selected' : '' }}>
                                                                        Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label class="form-label">Sort Order</label>
                                                                <input type="number" class="form-control"
                                                                    name="seasonal_prices[{{ $price->id }}][sort_order]"
                                                                    value="{{ $price->sort_order }}" min="0">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p class="text-muted mb-0 text-center py-4">No seasonal prices added yet. Click
                                                "Add
                                                Seasonal Price" to add pricing seasons.</p>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.tours.index') }}" class="btn btn-label-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>
                                    Update Tour
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
        // Initialize Summernote
        console.log('=== TOURS EDIT PAGE ===');
        console.log('jQuery available:', typeof $ !== 'undefined');
        console.log('Summernote available:', typeof $.fn.summernote !== 'undefined');

        $(document).ready(function() {
            if (typeof $.fn.summernote !== 'undefined') {
                console.log('Initializing Summernote...');

                // Initialize Summernote for main description
                $('#description').summernote({
                    height: 300,
                    tooltip: false,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['fontname', ['fontname']],
                        ['fontsize', ['fontsize']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['table', ['table']],
                        ['insert', ['link', 'picture']],
                        ['view', ['fullscreen', 'codeview', 'help']]
                    ],
                    placeholder: 'Write your content here...',
                    tabsize: 2,
                    focus: false,
                    dialogsInBody: true,
                    popover: {
                        image: [
                            ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                            ['float', ['floatLeft', 'floatRight', 'floatNone']],
                            ['remove', ['removeMedia']]
                        ],
                        link: [
                            ['link', ['linkDialogShow', 'unlink']]
                        ],
                        table: [
                            ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                            ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                        ],
                        air: [
                            ['color', ['color']],
                            ['font', ['bold', 'underline', 'clear']]
                        ]
                    }
                });

                // Initialize Summernote for short description (simpler toolbar)
                $('#short_description').summernote({
                    height: 150,
                    tooltip: false,
                    toolbar: [
                        ['style', ['style']],
                        ['font', ['bold', 'italic', 'underline', 'clear']],
                        ['color', ['color']],
                        ['para', ['ul', 'ol', 'paragraph']],
                        ['view', ['fullscreen', 'codeview']]
                    ],
                    placeholder: 'Write short description...',
                    tabsize: 2,
                    focus: false,
                    dialogsInBody: true
                });

                // Initialize Summernote for existing days
                $('.summernote-day').each(function() {
                    $(this).summernote({
                        height: 200,
                        tooltip: false,
                        toolbar: [
                            ['style', ['style']],
                            ['font', ['bold', 'italic', 'underline', 'clear']],
                            ['fontname', ['fontname']],
                            ['fontsize', ['fontsize']],
                            ['color', ['color']],
                            ['para', ['ul', 'ol', 'paragraph']],
                            ['table', ['table']],
                            ['insert', ['link', 'picture']],
                            ['view', ['fullscreen', 'codeview', 'help']]
                        ],
                        placeholder: 'Write day details here...',
                        tabsize: 2,
                        focus: false,
                        dialogsInBody: true,
                        popover: {
                            image: [
                                ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter',
                                    'resizeNone'
                                ]],
                                ['float', ['floatLeft', 'floatRight', 'floatNone']],
                                ['remove', ['removeMedia']]
                            ],
                            link: [
                                ['link', ['linkDialogShow', 'unlink']]
                            ],
                            table: [
                                ['add', ['addRowDown', 'addRowUp', 'addColLeft',
                                    'addColRight'
                                ]],
                                ['delete', ['deleteRow', 'deleteCol', 'deleteTable']],
                            ],
                            air: [
                                ['color', ['color']],
                                ['font', ['bold', 'underline', 'clear']]
                            ]
                        }
                    });
                });

                // Fix Summernote dropdowns
                $(document).on('click', '.note-btn-group .dropdown-toggle', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    var $this = $(this);
                    var $group = $this.closest('.note-btn-group');
                    var $menu = $group.find('.note-dropdown-menu');
                    // Close other dropdowns
                    $('.note-btn-group').not($group).removeClass('open');
                    $('.note-dropdown-menu').not($menu).removeClass('open').hide();
                    // Toggle current dropdown
                    $group.toggleClass('open');
                    $menu.toggleClass('open').toggle();
                });

                // Close dropdowns when clicking outside
                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.note-btn-group').length) {
                        $('.note-btn-group').removeClass('open');
                        $('.note-dropdown-menu').removeClass('open').hide();
                    }
                });

                console.log('Summernote initialized successfully!');
            } else {
                console.error('Summernote is not available!');
            }

            // Cover image preview
            $('#cover_image').change(function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#coverImagePreview').html('<img src="' + e.target.result +
                            '" class="img-thumbnail rounded" style="max-width: 300px; max-height: 200px; border: 2px solid #3a3d4a;">'
                        );
                    };
                    reader.readAsDataURL(file);
                }
            });

            // Toggle offer fields
            $('#has_offer').change(function() {
                if ($(this).is(':checked')) {
                    $('#offerFields').slideDown();
                } else {
                    $('#offerFields').slideUp();
                }
            });

            // Function to load states
            function loadStates(countryId, selectedStateId = null) {
                console.log('Loading states for country:', countryId);
                if (countryId) {
                    const url = '{{ route('admin.tours.get-states-by-country') }}';
                    console.log('AJAX URL:', url);
                    $.ajax({
                        url: url,
                        type: 'GET',
                        data: {
                            country_id: countryId
                        },
                        dataType: 'json',
                        success: function(data) {
                            console.log('States loaded:', data);
                            $('#state_id').html('<option value="">Select State</option>');
                            if (data && data.length > 0) {
                                $.each(data, function(key, value) {
                                    const selected = (selectedStateId && value.id ==
                                        selectedStateId) ? 'selected' : '';
                                    $('#state_id').append('<option value="' + value.id + '" ' +
                                        selected + '>' + value.name + '</option>');
                                });
                            } else {
                                $('#state_id').append('<option value="">No states available</option>');
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error('Error loading states:', error);
                            console.error('Response:', xhr.responseText);
                            $('#state_id').html('<option value="">Error loading states</option>');
                        }
                    });
                } else {
                    $('#state_id').html('<option value="">Select Country First</option>');
                }
            }

            // Load states when country changes
            $(document).on('change', '#country_id', function() {
                const countryId = $(this).val();
                console.log('Country changed:', countryId);
                console.log('State select element:', $('#state_id').length);
                if (countryId) {
                    loadStates(countryId);
                } else {
                    $('#state_id').html('<option value="">Select Country First</option>');
                }
            });

            @if ($tour->country_id)
                loadStates({{ $tour->country_id }}, {{ $tour->state_id ?? 'null' }});
            @endif

            // Image counter - start from max existing images count
            let imageCounter = {{ $tour->tourImages->count() ?? 0 }};

            // Add new image
            $('#addImageBtn').click(function() {
                const imageHtml =
                    `
                                                                                                                                <div class="card mb-3 image-item image-preview-card" data-image-index="new-${imageCounter}">
                                                                                                                                    <div class="card-body">
                                                                                                                                        <div class="row align-items-end">
                                                                                                                                            <div class="col-md-5 mb-3">
                                                                                                                                                <label class="form-label">Image</label>
                                                                                                                                                <input type="file" class="form-control image-input" name="tour_images[new-${imageCounter}][image]" accept="image/*" required>
                                                                                                                                                <div class="image-preview mt-2"></div>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                                                <label class="form-label">Image Alt Text</label>
                                                                                                                                                <input type="text" class="form-control" name="tour_images[new-${imageCounter}][alt]" placeholder="Enter alt text for the image">
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-2 mb-3">
                                                                                                                                                <label class="form-label">Sort Order</label>
                                                                                                                                                <input type="number" class="form-control" name="tour_images[new-${imageCounter}][sort_order]" value="${imageCounter}" min="0">
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-1 mb-3">
                                                                                                                                                <button type="button" class="btn btn-sm btn-label-danger removeImageBtn">
                                                                                                                                                    <i class="ti ti-trash"></i>
                                                                                                                                                </button>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            `;
                if ($('#tourImagesContainer p').length > 0) {
                    $('#tourImagesContainer p').remove();
                }
                $('#tourImagesContainer').append(imageHtml);
                imageCounter++;
            });

            // Remove image - mark for deletion if it's an existing image
            $(document).on('click', '.removeImageBtn', function() {
                const imageItem = $(this).closest('.image-item');
                const imageId = imageItem.data('image-id');

                if (imageId && !imageId.toString().startsWith('new-')) {
                    // Existing image - add hidden input to mark for deletion
                    if ($('input[name="deleted_images[]"][value="' + imageId + '"]').length === 0) {
                        $('#tourForm').append('<input type="hidden" name="deleted_images[]" value="' +
                            imageId + '">');
                    }
                }

                imageItem.remove();

                if ($('#tourImagesContainer .image-item').length === 0) {
                    $('#tourImagesContainer').html(
                        '<p class="text-muted mb-0 text-center py-3">No gallery images added yet. Click "Add Image" to add images.</p>'
                    );
                }
            });

            // Image preview
            $(document).on('change', '.image-input', function(e) {
                const file = e.target.files[0];
                const preview = $(this).closest('.image-item').find('.image-preview');
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        preview.html('<img src="' + e.target.result +
                            '" class="img-thumbnail rounded" style="max-width: 200px; max-height: 150px; border: 2px solid #3a3d4a;">'
                        );
                    };
                    reader.readAsDataURL(file);
                } else {
                    preview.html('');
                }
            });

            // Day counter - start from max day number + 1
            let dayCounter = {{ $tour->tourDays->max('day_number') ?? 0 }} + 1;

            // Summernote options for day details (reused when adding/restoring days)
            var summernoteDayOptions = {
                height: 200,
                tooltip: false,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                placeholder: 'Write day details here...',
                tabsize: 2,
                focus: false,
                dialogsInBody: true,
                popover: {
                    image: [
                        ['image', ['resizeFull', 'resizeHalf', 'resizeQuarter', 'resizeNone']],
                        ['float', ['floatLeft', 'floatRight', 'floatNone']],
                        ['remove', ['removeMedia']]
                    ],
                    link: [
                        ['link', ['linkDialogShow', 'unlink']]
                    ],
                    table: [
                        ['add', ['addRowDown', 'addRowUp', 'addColLeft', 'addColRight']],
                        ['delete', ['deleteRow', 'deleteCol', 'deleteTable']]
                    ],
                    air: [
                        ['color', ['color']],
                        ['font', ['bold', 'underline', 'clear']]
                    ]
                }
            };

            // Add new day
            $('#addDayBtn').click(function() {
                // 1) Save content of existing day editors so it is not lost when we append
                var savedDetails = [];
                $('#tourDaysContainer .day-item').each(function() {
                    var $ed = $(this).find('.summernote-day');
                    if ($ed.length && $ed.data('summernote')) {
                        try {
                            savedDetails.push($ed.summernote('code'));
                        } catch (e) {
                            savedDetails.push($ed.val() || '');
                        }
                    } else {
                        savedDetails.push($ed.length ? $ed.val() || '' : '');
                    }
                });

                const dayHtml =
                    `
                                                                                                                                <div class="card mb-3 day-item" data-day-index="new-${dayCounter}" style="border: 1px solid #3a3d4a; border-radius: 8px;">
                                                                                                                                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #252836; border-bottom: 1px solid #3a3d4a;">
                                                                                                                                        <h6 class="mb-0" style="color: #e4e6eb;">
                                                                                                                                            <i class="ti ti-calendar-event me-2" style="color: #30cfd0;"></i>
                                                                                                                                            Day ${dayCounter}
                                                                                                                                        </h6>
                                                                                                                                        <button type="button" class="btn btn-sm btn-label-danger removeDayBtn">
                                                                                                                                            <i class="ti ti-trash"></i> Delete Day
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="card-body">
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-3 mb-3">
                                                                                                                                                <label class="form-label">Day Number <span class="text-danger">*</span></label>
                                                                                                                                                <input type="number" class="form-control day-number" name="tour_days[new-${dayCounter}][day_number]" value="${dayCounter}" min="1" required>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-9 mb-3">
                                                                                                                                                <label class="form-label">Day Title <span class="text-danger">*</span></label>
                                                                                                                                                <input type="text" class="form-control day-title" name="tour_days[new-${dayCounter}][day_title]" placeholder="e.g., Day ${dayCounter}: Arrival in Cairo" required>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="mb-3">
                                                                                                                                            <label class="form-label">Details</label>
                                                                                                                                            <textarea class="form-control summernote-day" name="tour_days[new-${dayCounter}][details]" rows="5"></textarea>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            `;
                if ($('#tourDaysContainer p').length > 0) {
                    $('#tourDaysContainer p').remove();
                }
                var $newDay = $(dayHtml);
                $('#tourDaysContainer').append($newDay);

                // 2) Init Summernote only on the new day
                if (typeof $.fn.summernote !== 'undefined') {
                    $newDay.find('.summernote-day').summernote(summernoteDayOptions);
                }

                // 3) Restore existing days' Details so the UI does not appear empty
                $('#tourDaysContainer .day-item').each(function(i) {
                    if (i >= savedDetails.length) return;
                    if (savedDetails[i] === undefined || savedDetails[i] === null) return;
                    var $ed = $(this).find('.summernote-day');
                    if (!$ed.length) return;
                    try {
                        if ($ed.data('summernote')) {
                            $ed.summernote('destroy');
                        }
                        $ed.val(savedDetails[i]);
                        $ed.summernote(summernoteDayOptions);
                    } catch (err) {}
                });

                dayCounter++;
            });

            // Remove day
            $(document).on('click', '.removeDayBtn', function() {
                const dayItem = $(this).closest('.day-item');
                const dayId = dayItem.data('day-index');

                if (dayId && !dayId.toString().startsWith('new-')) {
                    // Existing day - add hidden input to mark for deletion
                    if ($('input[name="deleted_days[]"][value="' + dayId + '"]').length === 0) {
                        $('#tourForm').append('<input type="hidden" name="deleted_days[]" value="' + dayId +
                            '">');
                    }
                }

                dayItem.remove();

                if ($('#tourDaysContainer .day-item').length === 0) {
                    $('#tourDaysContainer').html(
                        '<p class="text-muted mb-0 text-center py-4">No tour days added yet. Click "Add Day" to add itinerary days.</p>'
                    );
                }
            });

            // Variant counter - start from max existing variants count
            let variantCounter = {{ $tour->variants->count() ?? 0 }};

            // Add new variant
            $('#addVariantBtn').click(function() {
                const variantHtml =
                    `
                                                                                                                                <div class="card mb-3 variant-item" data-variant-index="new-${variantCounter}" style="border: 1px solid #3a3d4a; border-radius: 8px;">
                                                                                                                                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #252836; border-bottom: 1px solid #3a3d4a;">
                                                                                                                                        <h6 class="mb-0" style="color: #e4e6eb;">
                                                                                                                                            <i class="ti ti-adjustments me-2" style="color: #fa709a;"></i>
                                                                                                                                            Variant ${variantCounter + 1}
                                                                                                                                        </h6>
                                                                                                                                        <button type="button" class="btn btn-sm btn-label-danger removeVariantBtn">
                                                                                                                                            <i class="ti ti-trash"></i> Delete Variant
                                                                                                                                        </button>
                                                                                                                                    </div>
                                                                                                                                    <div class="card-body">
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-12 mb-3">
                                                                                                                                                <label class="form-label">Title <span class="text-danger">*</span></label>
                                                                                                                                                <input type="text" class="form-control variant-title" name="tour_variants[new-${variantCounter}][title]" placeholder="e.g., Extra Day, VIP Service, etc." required>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-12 mb-3">
                                                                                                                                                <label class="form-label">Description</label>
                                                                                                                                                <textarea class="form-control" name="tour_variants[new-${variantCounter}][description]" rows="2" placeholder="Describe what this variant includes..."></textarea>
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                                                <label class="form-label">Additional Duration</label>
                                                                                                                                                <input type="number" class="form-control" name="tour_variants[new-${variantCounter}][additional_duration]" value="0" min="0">
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                                                <label class="form-label">Duration Type</label>
                                                                                                                                                <select class="form-select" name="tour_variants[new-${variantCounter}][additional_duration_type]">
                                                                                                                                                    <option value="days">Days</option>
                                                                                                                                                    <option value="hours">Hours</option>
                                                                                                                                                </select>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-4 mb-3">
                                                                                                                                                <label class="form-label">Additional Price</label>
                                                                                                                                                <input type="number" class="form-control" name="tour_variants[new-${variantCounter}][additional_price]" value="0" step="0.01" min="0" placeholder="0.00">
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                        <div class="row">
                                                                                                                                            <div class="col-md-6 mb-3">
                                                                                                                                                <label class="form-label">Status</label>
                                                                                                                                                <select class="form-select" name="tour_variants[new-${variantCounter}][status]">
                                                                                                                                                    <option value="active">Active</option>
                                                                                                                                                    <option value="inactive">Inactive</option>
                                                                                                                                                </select>
                                                                                                                                            </div>
                                                                                                                                            <div class="col-md-6 mb-3">
                                                                                                                                                <label class="form-label">Sort Order</label>
                                                                                                                                                <input type="number" class="form-control" name="tour_variants[new-${variantCounter}][sort_order]" value="${variantCounter}" min="0">
                                                                                                                                            </div>
                                                                                                                                        </div>
                                                                                                                                    </div>
                                                                                                                                </div>
                                                                                                                            `;
                if ($('#tourVariantsContainer p').length > 0) {
                    $('#tourVariantsContainer p').remove();
                }
                $('#tourVariantsContainer').append(variantHtml);
                variantCounter++;
            });

            // Remove variant
            $(document).on('click', '.removeVariantBtn', function() {
                const variantItem = $(this).closest('.variant-item');
                const variantId = variantItem.data('variant-id');

                if (variantId && !variantId.toString().startsWith('new-')) {
                    // Existing variant - add hidden input to mark for deletion
                    if ($('input[name="deleted_variants[]"][value="' + variantId + '"]').length === 0) {
                        $('#tourForm').append('<input type="hidden" name="deleted_variants[]" value="' +
                            variantId + '">');
                    }
                }

                variantItem.remove();

                if ($('#tourVariantsContainer .variant-item').length === 0) {
                    $('#tourVariantsContainer').html(
                        '<p class="text-muted mb-0 text-center py-4">No variants added yet. Click "Add Variant" to add optional add-ons.</p>'
                    );
                }
            });

            // Seasonal Prices
            const months = [{
                    value: 1,
                    name: 'January'
                },
                {
                    value: 2,
                    name: 'February'
                },
                {
                    value: 3,
                    name: 'March'
                },
                {
                    value: 4,
                    name: 'April'
                },
                {
                    value: 5,
                    name: 'May'
                },
                {
                    value: 6,
                    name: 'June'
                },
                {
                    value: 7,
                    name: 'July'
                },
                {
                    value: 8,
                    name: 'August'
                },
                {
                    value: 9,
                    name: 'September'
                },
                {
                    value: 10,
                    name: 'October'
                },
                {
                    value: 11,
                    name: 'November'
                },
                {
                    value: 12,
                    name: 'December'
                }
            ];

            let seasonalPriceCounter = {{ $tour->seasonalPrices->count() ?? 0 }};

            // Add new seasonal price
            $('#addSeasonalPriceBtn').click(function() {
                const monthOptions = months.map(m => `<option value="${m.value}">${m.name}</option>`).join(
                    '');
                const seasonalPriceHtml = `
                                                                            <div class="card mb-3 seasonal-price-item" data-seasonal-price-index="new-${seasonalPriceCounter}" style="border: 1px solid #3a3d4a; border-radius: 8px;">
                                                                                <div class="card-header d-flex justify-content-between align-items-center" style="background: #252836; border-bottom: 1px solid #3a3d4a;">
                                                                                    <h6 class="mb-0" style="color: #e4e6eb;">
                                                                                        <i class="ti ti-calendar-time me-2" style="color: #43e97b;"></i>
                                                                                        Seasonal Price ${seasonalPriceCounter + 1}
                                                                                    </h6>
                                                                                    <button type="button" class="btn btn-sm btn-label-danger removeSeasonalPriceBtn">
                                                                                        <i class="ti ti-trash"></i> Delete
                                                                                    </button>
                                                                                </div>
                                                                                <div class="card-body">
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mb-3">
                                                                                            <label class="form-label">Season Name <span class="text-danger">*</span></label>
                                                                                            <input type="text" class="form-control" name="seasonal_prices[new-${seasonalPriceCounter}][season_name]" placeholder="e.g., Summer, Winter, MAY-SEP, OCT-APR" required>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">Start Month <span class="text-danger">*</span></label>
                                                                                            <select class="form-select" name="seasonal_prices[new-${seasonalPriceCounter}][start_month]" required>
                                                                                                <option value="">Select Month</option>
                                                                                                ${monthOptions}
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">End Month <span class="text-danger">*</span></label>
                                                                                            <select class="form-select" name="seasonal_prices[new-${seasonalPriceCounter}][end_month]" required>
                                                                                                <option value="">Select Month</option>
                                                                                                ${monthOptions}
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mb-3">
                                                                                            <label class="form-label">Description</label>
                                                                                            <textarea class="form-control" name="seasonal_prices[new-${seasonalPriceCounter}][description]" rows="2" placeholder="Description for this season"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                <div class="row">
                                                                                    <div class="col-md-12 mb-3">
                                                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                                                            <label class="form-label mb-0">Price Items</label>
                                                                                            <button type="button" class="btn btn-sm btn-label-primary addPriceItemBtn" data-seasonal-price-index="new-${seasonalPriceCounter}" data-price-items-container="price-items-new-${seasonalPriceCounter}">
                                                                                                <i class="ti ti-plus"></i> Add Price Item
                                                                                            </button>
                                                                                        </div>
                                                                                        <div class="price-items-container" id="price-items-new-${seasonalPriceCounter}" data-seasonal-price-index="new-${seasonalPriceCounter}"></div>
                                                                                    </div>
                                                                                </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">Status</label>
                                                                                            <select class="form-select" name="seasonal_prices[new-${seasonalPriceCounter}][status]">
                                                                                                <option value="active">Active</option>
                                                                                                <option value="inactive">Inactive</option>
                                                                                            </select>
                                                                                        </div>
                                                                                        <div class="col-md-6 mb-3">
                                                                                            <label class="form-label">Sort Order</label>
                                                                                            <input type="number" class="form-control" name="seasonal_prices[new-${seasonalPriceCounter}][sort_order]" value="${seasonalPriceCounter}" min="0">
                                                                                        </div>
                                                                                    </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            `;
                if ($('#seasonalPricesContainer p').length > 0) {
                    $('#seasonalPricesContainer p').remove();
                }
                $('#seasonalPricesContainer').append(seasonalPriceHtml);
                seasonalPriceCounter++;
            });

            // Remove seasonal price
            $(document).on('click', '.removeSeasonalPriceBtn', function() {
                const seasonalPriceItem = $(this).closest('.seasonal-price-item');
                const seasonalPriceId = seasonalPriceItem.data('seasonal-price-id');

                if (seasonalPriceId && !seasonalPriceId.toString().startsWith('new-')) {
                    // Existing seasonal price - add hidden input to mark for deletion
                    if ($('input[name="deleted_seasonal_prices[]"][value="' + seasonalPriceId + '"]')
                        .length === 0) {
                        $('#tourForm').append(
                            '<input type="hidden" name="deleted_seasonal_prices[]" value="' +
                            seasonalPriceId + '">');
                    }
                }

                seasonalPriceItem.remove();

                if ($('#seasonalPricesContainer .seasonal-price-item').length === 0) {
                    $('#seasonalPricesContainer').html(
                        '<p class="text-muted mb-0 text-center py-4">No seasonal prices added yet. Click "Add Seasonal Price" to add pricing seasons.</p>'
                    );
                }
            });

            // Price Items Counter
            let priceItemCounter = {};

            // Initialize counters for existing seasonal prices
            @if ($tour->seasonalPrices && $tour->seasonalPrices->count() > 0)
                @foreach ($tour->seasonalPrices as $price)
                    priceItemCounter[{{ $price->id }}] = {{ $price->priceItems->count() ?? 0 }};
                @endforeach
            @endif

            // Add new price item
            $(document).on('click', '.addPriceItemBtn', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const seasonalPriceIndex = $(this).data('seasonal-price-index');
                console.log('Add Price Item clicked for seasonal price:', seasonalPriceIndex);

                if (!priceItemCounter[seasonalPriceIndex]) {
                    priceItemCounter[seasonalPriceIndex] = 0;
                }

                const itemIndex = seasonalPriceIndex.toString().startsWith('new-') ?
                    `new-${priceItemCounter[seasonalPriceIndex]}` :
                    `new-${priceItemCounter[seasonalPriceIndex]}`;

                // Find the container using the data attribute or by ID
                const containerId = $(this).data('price-items-container');
                let container = null;

                if (containerId) {
                    container = $('#' + containerId);
                }

                if (!container || container.length === 0) {
                    container = $(this).closest('.row').find('.price-items-container');
                }
                if (container.length === 0) {
                    container = $(this).closest('.col-md-12').find('.price-items-container');
                }
                if (container.length === 0) {
                    container = $(this).closest('.seasonal-price-item').find('.price-items-container');
                }
                if (container.length === 0) {
                    container = $(
                        `.price-items-container[data-seasonal-price-index="${seasonalPriceIndex}"]`);
                }

                if (container.length === 0) {
                    console.error('Price items container not found! Seasonal Price Index:',
                        seasonalPriceIndex);
                    alert('Error: Could not find price items container. Please refresh the page.');
                    return;
                }

                const priceItemHtml = `
                                                                            <div class="card mb-2 price-item" data-price-item-index="${itemIndex}" style="border: 1px solid #3a3d4a; border-radius: 6px; background: #1e2028;">
                                                                                <div class="card-body p-3">
                                                                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                                                                        <h6 class="mb-0" style="color: #e4e6eb; font-size: 0.9rem;">
                                                                                            <i class="ti ti-currency-dollar me-1" style="color: #43e97b;"></i>
                                                                                            Price Item ${priceItemCounter[seasonalPriceIndex] + 1}
                                                                                        </h6>
                                                                                        <button type="button" class="btn btn-sm btn-label-danger removePriceItemBtn">
                                                                                            <i class="ti ti-x"></i>
                                                                                        </button>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-5 mb-2">
                                                                                            <label class="form-label" style="font-size: 0.85rem;">Price Name <span class="text-danger">*</span></label>
                                                                                            <input type="text" class="form-control form-control-sm" name="seasonal_prices[${seasonalPriceIndex}][price_items][${itemIndex}][price_name]" placeholder="e.g., Per Person in Single_room" required>
                                                                                        </div>
                                                                                        <div class="col-md-4 mb-2">
                                                                                            <label class="form-label" style="font-size: 0.85rem;">Price Value <span class="text-danger">*</span></label>
                                                                                            <input type="number" class="form-control form-control-sm" name="seasonal_prices[${seasonalPriceIndex}][price_items][${itemIndex}][price_value]" value="0" step="0.01" min="0" placeholder="0.00" required>
                                                                                        </div>
                                                                                        <div class="col-md-3 mb-2">
                                                                                            <label class="form-label" style="font-size: 0.85rem;">Sort Order</label>
                                                                                            <input type="number" class="form-control form-control-sm" name="seasonal_prices[${seasonalPriceIndex}][price_items][${itemIndex}][sort_order]" value="${priceItemCounter[seasonalPriceIndex]}" min="0">
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="row">
                                                                                        <div class="col-md-12 mb-2">
                                                                                            <label class="form-label" style="font-size: 0.85rem;">Description</label>
                                                                                            <textarea class="form-control form-control-sm" name="seasonal_prices[${seasonalPriceIndex}][price_items][${itemIndex}][description]" rows="2" placeholder="Optional description"></textarea>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        `;
                container.append(priceItemHtml);
                priceItemCounter[seasonalPriceIndex]++;
            });

            // Remove price item
            $(document).on('click', '.removePriceItemBtn', function() {
                const priceItem = $(this).closest('.price-item');
                const priceItemId = priceItem.data('price-item-id');

                if (priceItemId && !priceItemId.toString().startsWith('new-')) {
                    // Existing price item - add hidden input to mark for deletion
                    if ($('input[name="deleted_seasonal_price_items[]"][value="' + priceItemId + '"]')
                        .length === 0) {
                        $('#tourForm').append(
                            '<input type="hidden" name="deleted_seasonal_price_items[]" value="' +
                            priceItemId + '">');
                    }
                }

                priceItem.remove();
            });

            // Initialize counter for new seasonal prices
            $('#addSeasonalPriceBtn').on('click', function() {
                setTimeout(function() {
                    const newIndex = `new-${seasonalPriceCounter - 1}`;
                    if (!priceItemCounter[newIndex]) {
                        priceItemCounter[newIndex] = 0;
                    }
                }, 100);
            });
        });
    </script>
@endpush
