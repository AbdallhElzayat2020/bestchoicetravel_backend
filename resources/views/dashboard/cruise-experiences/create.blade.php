@extends('dashboard.layouts.master')

@section('title', 'Create Dahbia Cruise Page')

@push('css')
    <style>
        /* Dark style for Related Tours select (Select2) */
        .select2-container--default .select2-selection--multiple {
            background-color: #252836;
            border: 1px solid #3a3d4a;
            color: #e4e6eb;
            min-height: 42px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered {
            padding: 4px 8px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background: linear-gradient(135deg, #3a3d4a 0%, #4b4f5f 100%);
            border: none;
            color: #e4e6eb;
            border-radius: 999px;
            padding: 2px 10px;
            font-size: 0.8rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: #ff8b8b;
            margin-right: 4px;
        }

        .select2-container--default .select2-selection--multiple:focus,
        .select2-container--default.select2-container--focus .select2-selection--multiple {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .select2-container--default .select2-selection--multiple .select2-search__field {
            background-color: #252836 !important;
            color: #e4e6eb;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__placeholder {
            color: #8a8d94;
        }

        .select2-dropdown {
            background-color: #111827; /* deep dark */
            border-color: #1f2937;
        }

        .select2-search--dropdown .select2-search__field {
            background-color: #111827;
            border: 1px solid #374151;
            color: #e5e7eb;
        }

        .select2-results__option {
            color: #e5e7eb;
            padding: 6px 10px;
            font-size: 0.9rem;
        }

        .select2-results__option[aria-selected="true"] {
            background-color: #065f46; /* green-ish for selected */
            color: #ecfdf5;
        }

        .select2-results__option--highlighted[aria-selected="false"] {
            background-color: #1f2937;
            color: #f9fafb;
        }

        .select2-results__option[aria-disabled="true"] {
            color: #6b7280;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__clear {
            color: #ff8b8b;
        }

        /* Fix Summernote dropdown z-index and overflow issues */
        .note-editor {
            position: relative;
        }

        .note-popover,
        .note-dropdown-menu {
            z-index: 9999 !important;
            position: absolute !important;
        }

        .note-popover .popover-content,
        .note-dropdown-menu {
            z-index: 10000 !important;
        }

        /* Ensure parent containers don't clip the dropdown */
        .card-body {
            overflow: visible !important;
        }

        .row {
            overflow: visible !important;
        }

        .col-md-12,
        .col-lg-12 {
            overflow: visible !important;
        }
    </style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Create Dahbia Cruise Page</h5>
            <a href="{{ route('admin.cruise-experiences.index') }}" class="btn btn-label-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.cruise-experiences.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row">
                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="cruise_group_id" class="form-label">Cruise Group <span class="text-danger">*</span></label>
                            <select name="cruise_group_id" id="cruise_group_id"
                                class="form-select @error('cruise_group_id') is-invalid @enderror" required>
                                <option value="">Select a Cruise Group</option>
                                @foreach($cruiseGroups as $cruiseGroup)
                                    <option value="{{ $cruiseGroup->id }}" {{ old('cruise_group_id') == $cruiseGroup->id ? 'selected' : '' }}>
                                        {{ $cruiseGroup->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cruise_group_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" id="title"
                                class="form-control @error('title') is-invalid @enderror" value="{{ old('title') }}"
                                required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="h1_title" class="form-label">H1 Title (Frontend Hero)</label>
                            <input type="text" name="h1_title" id="h1_title"
                                class="form-control @error('h1_title') is-invalid @enderror" value="{{ old('h1_title') }}"
                                placeholder="If empty, main Title will be used">
                            @error('h1_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="h2_title" class="form-label">H2 Title (Tours Section Heading)</label>
                            <input type="text" name="h2_title" id="h2_title"
                                class="form-control @error('h2_title') is-invalid @enderror" value="{{ old('h2_title') }}"
                                placeholder="Example: Egypt Nile Cruises">
                            @error('h2_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="slug" class="form-label">Slug</label>
                            <input type="text" name="slug" id="slug"
                                class="form-control @error('slug') is-invalid @enderror" value="{{ old('slug') }}"
                                placeholder="Auto-generated from title if left empty">
                            <small class="text-muted">Lowercase, use hyphens only (example: dahbia-nile-program).</small>
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="short_description" class="form-label">Short Description</label>
                            <textarea name="short_description" id="short_description" rows="3"
                                class="form-control @error('short_description') is-invalid @enderror">{{ old('short_description') }}</textarea>
                            @error('short_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="banner_image" class="form-label">Banner Image (Hero)</label>
                            <input type="file" name="banner_image" id="banner_image"
                                   class="form-control @error('banner_image') is-invalid @enderror" accept="image/*">
                            <small class="text-muted">This image will appear at the top banner of the cruise page. Recommended
                                size: 1600x600px.</small>
                            @error('banner_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Program Content</label>
                            <textarea name="description" id="description" rows="6"
                                class="form-control @error('description') is-invalid @enderror summernote">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                    <div class="col-lg-12">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                            <select name="status" id="status" class="form-select @error('status') is-invalid @enderror"
                                required>
                                <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive
                                </option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sort_order" class="form-label">Sort Order</label>
                            <input type="number" name="sort_order" id="sort_order"
                                class="form-control @error('sort_order') is-invalid @enderror"
                                value="{{ old('sort_order', 0) }}" min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Related Tours</label>

                            @if($tours->count())
                                <p class="text-muted mb-2">Select tours that are related to this cruise program. They will be suggested at the bottom of the page.</p>
                                <div class="row">
                                    @foreach($tours as $tour)
                                        @php
                                            $cover = $tour->cover_image
                                                ? asset('uploads/tours/' . $tour->cover_image)
                                                : asset('assets/frontend/assets/images/destination-01.png');
                                            $price = $tour->current_price ?? $tour->price;
                                        @endphp
                                        <div class="col-12 col-md-6 col-xl-4 mb-3">
                                            <div class="card h-100" style="background: #252836; border: 1px solid #3a3d4a; border-radius: 12px;">
                                                <div class="card-body">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                               name="tour_ids[]" value="{{ $tour->id }}"
                                                               id="related_tour_{{ $tour->id }}"
                                                                {{ in_array($tour->id, old('tour_ids', [])) ? 'checked' : '' }}>
                                                        <label class="form-check-label w-100" for="related_tour_{{ $tour->id }}">
                                                            <div class="d-flex align-items-start gap-3">
                                                                <img src="{{ $cover }}" alt="{{ $tour->title }}"
                                                                     style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                                                <div class="flex-grow-1">
                                                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                                                        <strong style="color:#e4e6eb;">{{ \Illuminate\Support\Str::limit($tour->title, 40) }}</strong>
                                                                        <span class="badge bg-label-success">
                                                                            ${{ number_format($price, 2) }}
                                                                        </span>
                                                                    </div>
                                                                    @if($tour->short_description)
                                                                        <p class="text-muted mb-0" style="font-size: 0.85rem;">
                                                                            {{ \Illuminate\Support\Str::limit(strip_tags($tour->short_description), 80) }}
                                                                        </p>
                                                                    @endif
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
                                    <i class="ti ti-info-circle me-1"></i>
                                    No tours available yet. Create tours first to link them here.
                                </div>
                            @endif

                            @error('tour_ids.*')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Attach Existing FAQs (optional)</label>
                            <p class="text-muted mb-2">
                                اختر من الأسئلة الشائعة الموجودة في صفحة
                                <strong>FAQs</strong> لربطها بهذه الرحلة.
                            </p>
                            @if($faqs->count())
                                <div class="row">
                                    @foreach($faqs as $faq)
                                        <div class="col-12 col-md-6 col-xl-4 mb-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="faq_ids[]"
                                                       value="{{ $faq->id }}" id="faq_{{ $faq->id }}"
                                                       {{ in_array($faq->id, old('faq_ids', [])) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="faq_{{ $faq->id }}">
                                                    <strong>{{ \Illuminate\Support\Str::limit($faq->question, 80) }}</strong>
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="alert alert-info">
                                    لا توجد أسئلة شائعة بعد. يمكنك إضافتها من قائمة <strong>FAQs</strong> أولاً.
                                </div>
                            @endif
                        </div>

                        <div class="mb-3">
                            <label for="meta_title" class="form-label">Meta Title</label>
                            <input type="text" name="meta_title" id="meta_title"
                                class="form-control @error('meta_title') is-invalid @enderror"
                                value="{{ old('meta_title') }}" maxlength="60">
                            <small class="text-muted">Used for SEO (50-60 characters).</small>
                            @error('meta_title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_description" class="form-label">Meta Description</label>
                            <textarea name="meta_description" id="meta_description" rows="3"
                                class="form-control @error('meta_description') is-invalid @enderror" maxlength="160">{{ old('meta_description') }}</textarea>
                            <small class="text-muted">Short description for search engines.</small>
                            @error('meta_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="meta_keywords" class="form-label">Meta Keywords</label>
                            <input type="text" name="meta_keywords" id="meta_keywords"
                                class="form-control @error('meta_keywords') is-invalid @enderror"
                                value="{{ old('meta_keywords') }}" placeholder="keyword1, keyword2">
                            @error('meta_keywords')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2 mt-3">
                    <a href="{{ route('admin.cruise-experiences.index') }}" class="btn btn-label-secondary">
                        <i class="ti ti-x me-1"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
    <script>
        $(document).ready(function() {
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
                    placeholder: 'Write full program details here...',
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
        });
    </script>
@endpush
