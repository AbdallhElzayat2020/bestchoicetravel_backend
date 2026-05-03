@extends('dashboard.layouts.master')

@section('title', 'Edit Section: ' . $siteSection->key)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit Section: {{ $siteSection->key }}</h4>
            <a href="{{ route('admin.site-sections.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('admin.site-sections.update', $siteSection) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            @php $key = $siteSection->key; @endphp

                            {{-- Generic fields, but we only show what's needed per section --}}

                            {{-- Title --}}
                            @if (!in_array($key, []))
                                <div class="mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text" name="title" class="form-control"
                                        value="{{ old('title', $siteSection->title) }}">
                                    @error('title')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Subtitle (banner / hero / story etc.) --}}
                            @if (in_array($key, [
                                    'about_banner',
                                    'about_intro',
                                    'about_credentials',
                                    'about_services',
                                    'home_hero',
                                    'home_cruises',
                                    'home_day_tours',
                                    'home_desert',
                                    'home_egypt_jordan',
                                    'home_redsea',
                                ]))
                                <div class="mb-3">
                                    <label class="form-label">Subtitle</label>
                                    <input type="text" name="subtitle" class="form-control"
                                        value="{{ old('subtitle', $siteSection->subtitle) }}">
                                    @error('subtitle')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Description (long text sections: hero/story/home sections) --}}
                            @if (in_array($key, [
                                    'about_intro',
                                    'about_credentials',
                                    'about_mission',
                                    'about_vision',
                                    'about_services',
                                    'about_cta',
                                    'home_hero',
                                    'home_cruises',
                                    'home_day_tours',
                                    'home_desert',
                                    'home_egypt_jordan',
                                    'home_redsea',
                                ]))
                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description" rows="5" class="form-control summernote">{{ old('description', $siteSection->description) }}</textarea>
                                    @error('description')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- About credentials (label + value rows) --}}
                            @if ($key === 'about_credentials')
                                @php
                                    $credentials = [];
                                    if (old('credentials')) {
                                        $credentials = old('credentials');
                                    } elseif ($siteSection->content) {
                                        $decoded = json_decode($siteSection->content, true);
                                        if (is_array($decoded)) {
                                            $credentials = $decoded;
                                        }
                                    }
                                    if (count($credentials) === 0) {
                                        $credentials = [
                                            [
                                                'label' => 'Tourism License',
                                                'value' => 'Category (A) - License No. 1575',
                                            ],
                                            [
                                                'label' => 'Member of',
                                                'value' => 'Egyptian Travel Agents Association (ETAA)',
                                            ],
                                            [
                                                'label' => 'IATA Membership',
                                                'value' => 'No. 90228121',
                                            ],
                                            [
                                                'label' => 'Established',
                                                'value' => '2007',
                                            ],
                                        ];
                                    }
                                @endphp

                                <div class="mb-3">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>Credentials rows</span>
                                        <span class="text-muted small">Edit license / membership details shown on About page</span>
                                    </label>

                                    @foreach ($credentials as $i => $row)
                                        <div class="border rounded p-3 mb-2">
                                            <div class="row">
                                                <div class="col-md-5 mb-2">
                                                    <label class="form-label small">Label</label>
                                                    <input type="text" name="credentials[{{ $i }}][label]"
                                                        class="form-control" value="{{ $row['label'] ?? '' }}">
                                                </div>
                                                <div class="col-md-7 mb-2">
                                                    <label class="form-label small">Value</label>
                                                    <input type="text" name="credentials[{{ $i }}][value]"
                                                        class="form-control" value="{{ $row['value'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif

                            {{-- About services / why choose repeated cards --}}
                            @if (in_array($key, ['about_services', 'about_why_choose']))
                                @php
                                    $items = [];
                                    if (old('items')) {
                                        $items = old('items');
                                    } elseif ($siteSection->content) {
                                        $decoded = json_decode($siteSection->content, true);
                                        if (is_array($decoded)) {
                                            $items = $decoded;
                                        }
                                    }
                                @endphp

                                <div class="mb-3">
                                    <label class="form-label d-flex justify-content-between align-items-center">
                                        <span>Items</span>
                                        <span class="text-muted small">Each item = icon + title + text</span>
                                    </label>

                                    @forelse ($items as $i => $item)
                                        <div class="border rounded p-3 mb-2">
                                            <div class="row">
                                                <div class="col-md-4 mb-2">
                                                    <label class="form-label small">Icon class</label>
                                                    <input type="text" name="items[{{ $i }}][icon]" class="form-control"
                                                        value="{{ $item['icon'] ?? '' }}" placeholder="fa-shield-halved">
                                                </div>
                                                <div class="col-md-8 mb-2">
                                                    <label class="form-label small">Title</label>
                                                    <input type="text" name="items[{{ $i }}][title]" class="form-control"
                                                        value="{{ $item['title'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div>
                                                <label class="form-label small">Text</label>
                                                <textarea name="items[{{ $i }}][text]" rows="2" class="form-control summernote">{{ $item['text'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-muted small">No items found yet. Seed or add values manually.</div>
                                    @endforelse
                                </div>
                            @endif

                            {{-- Button fields (only for sections that have buttons) --}}
                            @if (in_array($key, ['home_hero', 'home_cruises', 'home_day_tours', 'home_desert', 'home_egypt_jordan', 'home_redsea']))
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Text</label>
                                            <input type="text" name="button_text" class="form-control"
                                                value="{{ old('button_text', $siteSection->button_text) }}">
                                            @error('button_text')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label class="form-label">Button Link</label>
                                            <input type="text" name="button_link" class="form-control"
                                                value="{{ old('button_link', $siteSection->button_link) }}">
                                            @error('button_link')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active"
                                        {{ old('status', $siteSection->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive"
                                        {{ old('status', $siteSection->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                    <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            @if ($key === 'home_hero')
                                <div class="mb-3">
                                    <label class="form-label">Vimeo background video (optional)</label>
                                    <input type="text" name="vimeo_url" class="form-control"
                                        value="{{ old('vimeo_url', $siteSection->vimeo_url) }}"
                                        placeholder="https://vimeo.com/123456789 أو رقم الفيديو فقط">
                                    <div class="form-text">
                                        إذا وُجد رابط صالح، يُعرض الفيديو كخلفية للهيرو بدل الصورة. اتركه فارغاً
                                        لاستخدام صورة الخلفية فقط.
                                    </div>
                                    @error('vimeo_url')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                </div>
                            @endif

                            {{-- Image (only for sections that use images) --}}
                            @if (in_array($key, ['about_banner', 'home_hero', 'home_cruises', 'home_day_tours', 'home_desert', 'home_egypt_jordan', 'home_redsea']))
                                <div class="mb-3">
                                    <label class="form-label">Image</label>
                                    <input type="file" name="image" id="section_image" class="form-control" accept="image/*">
                                    @error('image')
                                        <div class="text-danger small">{{ $message }}</div>
                                    @enderror
                                    <div class="mt-2" id="sectionImagePreview">
                                        @if ($siteSection->image_path)
                                            <img src="{{ asset($siteSection->image_path) }}" alt="Section image"
                                                class="img-fluid rounded border" style="max-height: 160px;">
                                        @endif
                                    </div>
                                </div>
                            @endif

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('js')
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.css" rel="stylesheet">
    <script>
        $(document).ready(function() {
            const isAboutSection = @json(str_starts_with($siteSection->key, 'about_'));
            const editorSelector = isAboutSection ? 'textarea' : '.summernote';

            function initSummernoteEditors() {
                if (typeof $.fn.summernote === 'undefined') {
                    return;
                }

                $(editorSelector).each(function() {
                    const $el = $(this);
                    if ($el.next('.note-editor').length) {
                        return;
                    }

                    $el.summernote({
                        height: 220,
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
                });

                // Fix Summernote dropdowns
                $(document).on('click', '.note-btn-group .dropdown-toggle', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    const $this = $(this);
                    const $group = $this.closest('.note-btn-group');
                    const $menu = $group.find('.note-dropdown-menu');
                    $('.note-btn-group').not($group).removeClass('open');
                    $('.note-dropdown-menu').not($menu).removeClass('open').hide();
                    $group.toggleClass('open');
                    $menu.toggleClass('open').toggle();
                });

                $(document).on('click', function(e) {
                    if (!$(e.target).closest('.note-btn-group').length) {
                        $('.note-btn-group').removeClass('open');
                        $('.note-dropdown-menu').removeClass('open').hide();
                    }
                });
            }

            // Image preview
            $('#section_image').on('change', function(e) {
                const file = e.target.files[0];
                const preview = $('#sectionImagePreview');
                if (!file) {
                    return;
                }
                const reader = new FileReader();
                reader.onload = function(evt) {
                    preview.html(
                        `<img src="${evt.target.result}" alt="Section preview" class="img-fluid rounded border" style="max-height: 160px;">`
                    );
                };
                reader.readAsDataURL(file);
            });

            if (typeof $.fn.summernote !== 'undefined') {
                initSummernoteEditors();
            } else {
                $.getScript('https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs4.min.js')
                    .done(function() {
                        initSummernoteEditors();
                    });
            }
        });
    </script>
@endpush
