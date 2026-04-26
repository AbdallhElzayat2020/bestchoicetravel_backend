@extends('dashboard.layouts.master')

@section('title', 'Edit Page')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit: {{ $page->name }}</h5>
            <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back
            </a>
        </div>
        <div class="card-body">
            @php
                $editablePages = ['terms-and-conditions', 'privacy-policy', 'payment-policy'];
                $isEditable = in_array($page->slug, $editablePages);
            @endphp

            @if($isEditable)
                <div class="alert alert-info mb-4">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Note:</strong> You can edit the page content and SEO meta tags for this page.
                </div>
            @else
                <div class="alert alert-info mb-4">
                    <i class="ti ti-info-circle me-2"></i>
                    <strong>Note:</strong> This is a static page. The page content and URL are managed in the code and
                    cannot be changed from here.
                    You can only edit SEO meta tags (Title, Description, Keywords, Author).
                </div>
            @endif

            <form action="{{ route('admin.pages.update', $page) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h6 class="mb-0">Page Information</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label class="form-label">Page Name</label>
                                    <input type="text" class="form-control" value="{{ $page->name }}" disabled>
                                    <small class="text-muted">This is the page identifier and cannot be changed.</small>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Slug (URL)</label>
                                    <input type="text" class="form-control" value="{{ $page->slug }}" disabled>
                                    <small class="text-muted">This is the page URL and cannot be changed.</small>
                                </div>
                            </div>
                        </div>

                        @if($isEditable)
                            <div class="card mb-4">
                                <div class="card-header">
                                    <h6 class="mb-0">Page Content</h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-3">
                                        <label for="content" class="form-label">Content</label>
                                        <textarea name="content" id="content" rows="10"
                                            class="form-control @error('content') is-invalid @enderror summernote">{{ old('content', $page->content) }}</textarea>
                                        @error('content')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">SEO Settings</h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="meta_title" class="form-label">Meta Title</label>
                                    <input type="text" name="meta_title" id="meta_title"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        value="{{ old('meta_title', $page->meta_title) }}" maxlength="255"
                                        placeholder="Page title for SEO (50-60 characters recommended)">
                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_description" class="form-label">Meta Description</label>
                                    <textarea name="meta_description" id="meta_description" rows="3"
                                        class="form-control @error('meta_description') is-invalid @enderror" maxlength="500"
                                        placeholder="Brief description for search engines (150-160 characters recommended)">{{ old('meta_description', $page->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_author" class="form-label">Meta Author</label>
                                    <input type="text" name="meta_author" id="meta_author"
                                        class="form-control @error('meta_author') is-invalid @enderror"
                                        value="{{ old('meta_author', $page->meta_author) }}" maxlength="255"
                                        placeholder="Author name">
                                    @error('meta_author')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                                    <textarea name="meta_keywords" id="meta_keywords" rows="2"
                                        class="form-control @error('meta_keywords') is-invalid @enderror" maxlength="500"
                                        placeholder="Comma-separated keywords">{{ old('meta_keywords', $page->meta_keywords) }}</textarea>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="ti ti-check me-1"></i>
                        {{ $isEditable ? 'Update Page' : 'Update SEO' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@if($isEditable)
    @push('js')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js"></script>
        <script>
            $(document).ready(function () {
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
                        placeholder: 'Write page content here...',
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
                                ['font', ['bold', 'underline', 'clear']],
                                ['para', ['ul', 'paragraph']],
                                ['table', ['table']],
                                ['insert', ['link', 'picture']]
                            ]
                        }
                    });

                    // Fix Summernote dropdowns
                    $(document).on('click', '.note-btn-group .dropdown-toggle', function (e) {
                        e.preventDefault();
                        e.stopPropagation();
                        var $this = $(this);
                        var $group = $this.closest('.note-btn-group');
                        var $menu = $group.find('.note-dropdown-menu');
                        $('.note-btn-group').not($group).removeClass('open');
                        $('.note-dropdown-menu').not($menu).removeClass('open').hide();
                        $group.toggleClass('open');
                        $menu.toggleClass('open').toggle();
                    });

                    $(document).on('click', function (e) {
                        if (!$(e.target).closest('.note-btn-group').length) {
                            $('.note-btn-group').removeClass('open');
                            $('.note-dropdown-menu').removeClass('open').hide();
                        }
                    });
                }
            });
        </script>
    @endpush
@endif
