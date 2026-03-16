@extends('dashboard.layouts.master')

@section('title', 'Edit Blog')

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
    .section-header.seo::before { background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%); }
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
    .section-header.seo i { color: #4facfe; }
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
    .alert {
        border-radius: 8px;
        border: 1px solid;
    }
    .alert-success {
        background: rgba(67, 233, 123, 0.1);
        border-color: #43e97b;
        color: #43e97b;
    }
    .alert-danger {
        background: rgba(245, 87, 108, 0.1);
        border-color: #f5576c;
        color: #f5576c;
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
                            Edit Blog
                        </h5>
                    </div>
                    <div class="card-body main-card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Please fix the following errors:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <form action="{{ route('admin.blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data" id="blogForm">
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
                                            value="{{ old('title', $blog->title) }}" required>
                                        @error('title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="slug" class="form-label">Slug</label>
                                        <input type="text" class="form-control @error('slug') is-invalid @enderror" id="slug" name="slug"
                                            value="{{ old('slug', $blog->slug) }}" placeholder="Auto-generated from title if left empty">
                                        <small class="text-muted">Leave empty to auto-generate from title, or enter custom slug</small>
                                        @error('slug')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="short_description" class="form-label">Short Description</label>
                                        <textarea class="form-control @error('short_description') is-invalid @enderror" id="short_description"
                                            name="short_description" rows="3">{{ old('short_description', $blog->short_description) }}</textarea>
                                        @error('short_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control summernote @error('description') is-invalid @enderror" id="description"
                                            name="description">{{ old('description', $blog->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="category" class="form-label">Category</label>
                                            <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                                <option value="">Select category</option>
                                                @foreach($blogCategories as $category)
                                                    <option value="{{ $category->name }}" {{ old('category', $blog->category) === $category->name ? 'selected' : '' }}>
                                                        {{ $category->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('category')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="author" class="form-label">Author</label>
                                            <input type="text" class="form-control @error('author') is-invalid @enderror" id="author" name="author"
                                                value="{{ old('author', $blog->author) }}">
                                            @error('author')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="published_at" class="form-label">Published At</label>
                                            <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror" id="published_at" name="published_at"
                                                value="{{ old('published_at', $blog->published_at ? \Carbon\Carbon::parse($blog->published_at)->format('Y-m-d\TH:i') : '') }}">
                                            @error('published_at')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Images Section -->
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Cover Image
                                    </h6>
                                </div>
                                <div class="section-body">
                                    @if($blog->cover_image)
                                        <div class="mb-3">
                                            <label class="form-label">Current Cover Image</label>
                                            <div>
                                                <img src="{{ asset('uploads/blogs/' . $blog->cover_image) }}" alt="Current Cover" class="img-thumbnail" style="max-width: 300px;">
                                            </div>
                                        </div>
                                    @endif

                                    <div class="mb-4">
                                        <label for="cover_image" class="form-label">Change Cover Image</label>
                                        <input type="file" class="form-control @error('cover_image') is-invalid @enderror" id="cover_image" name="cover_image"
                                            accept="image/*">
                                        <small class="text-muted">Recommended size: 1200x600px. Max size: 5MB</small>
                                        @error('cover_image')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <div id="coverImagePreview" class="mt-3"></div>
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
                                        <input type="text" class="form-control @error('meta_title') is-invalid @enderror" id="meta_title" name="meta_title"
                                            value="{{ old('meta_title', $blog->meta_title) }}" maxlength="60">
                                        <small class="text-muted">Recommended: 50-60 characters</small>
                                        @error('meta_title')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_description" class="form-label">Meta Description</label>
                                        <textarea class="form-control @error('meta_description') is-invalid @enderror" id="meta_description"
                                            name="meta_description" rows="3" maxlength="160">{{ old('meta_description', $blog->meta_description) }}</textarea>
                                        <small class="text-muted">Recommended: 150-160 characters</small>
                                        @error('meta_description')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                        <input type="text" class="form-control @error('meta_keywords') is-invalid @enderror" id="meta_keywords" name="meta_keywords"
                                            value="{{ old('meta_keywords', $blog->meta_keywords) }}" placeholder="keyword1, keyword2, keyword3">
                                        <small class="text-muted">Separate keywords with commas</small>
                                        @error('meta_keywords')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
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
                                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                                <option value="active" {{ old('status', $blog->status) == 'active' ? 'selected' : '' }}>Active</option>
                                                <option value="inactive" {{ old('status', $blog->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                                            </select>
                                            @error('status')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mb-3">
                                            <label for="sort_order" class="form-label">Sort Order</label>
                                            <input type="number" class="form-control @error('sort_order') is-invalid @enderror" id="sort_order" name="sort_order"
                                                value="{{ old('sort_order', $blog->sort_order) }}" min="0">
                                            @error('sort_order')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                  
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('admin.blogs.index') }}" class="btn btn-label-secondary">
                                    <i class="ti ti-x me-1"></i>
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="ti ti-check me-1"></i>
                                    Update Blog
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Summernote
            if (typeof $.fn.summernote !== 'undefined') {
                $('.summernote').summernote({
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
                    placeholder: 'Write description here...',
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
                    },
                    callbacks: {
                        onInit: function() {
                            $('.note-editor').css('background-color', '#252836');
                            $('.note-editing-area').css('background-color', '#252836');
                            $('.note-editing-area').css('color', '#e4e6eb');
                        }
                    }
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
            }

            // Cover image preview
            $('#cover_image').on('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#coverImagePreview').html(`
                            <img src="${e.target.result}" alt="Cover Preview" class="img-thumbnail">
                        `);
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#coverImagePreview').html('');
                }
            });
        });
    </script>
@endpush

