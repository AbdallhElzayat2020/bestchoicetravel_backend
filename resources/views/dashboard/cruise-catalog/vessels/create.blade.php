@extends('dashboard.layouts.master')

@section('title', 'New cruise vessel')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">New vessel</h5>
            <a href="{{ route('admin.cruise-catalog.vessels.index') }}" class="btn btn-label-secondary">Back</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.cruise-catalog.vessels.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="cruise_catalog_category_id" id="vessel_category_id" class="form-select" required>
                        <option value="">—</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('cruise_catalog_category_id') == $cat->id)>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Short description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Full description</label>
                    <textarea name="description" class="form-control" rows="6">{{ old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Price (per person) <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="price_tier_1" class="form-control"
                            value="{{ old('price_tier_1') }}" min="0" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Cover image</label>
                    <input type="file" name="cover_image" id="cover_image_input" class="form-control" accept="image/*">
                    <div id="cover-preview" class="mt-2"></div>
                    <small class="text-muted">Preview the selected image before saving.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Gallery (multiple)</label>
                    <input type="file" name="gallery[]" id="gallery_input" class="form-control" accept="image/*" multiple>
                    <div id="gallery-preview" class="row g-2 mt-2"></div>
                    <small class="text-muted d-block mt-1">Preview all selected images.</small>
                </div>

                <div class="mb-3">
                    <label class="form-label d-block mb-2">Linked programs (same category only)</label>
                    <div id="program_cards" class="row g-2">
                        @foreach ($programs as $p)
                            <div class="col-md-6 program-card-item" data-category="{{ $p->cruise_catalog_category_id }}">
                                <label class="border rounded p-3 d-flex align-items-start gap-2 w-100 h-100 program-card-label"
                                    style="cursor: pointer;">
                                    <input type="checkbox" class="form-check-input mt-1 program-checkbox" name="program_ids[]"
                                        value="{{ $p->id }}" @checked(in_array($p->id, old('program_ids', [])))>
                                    <span class="d-block">
                                        <span class="fw-semibold d-block">{{ $p->title }}</span>
                                        <span class="small text-muted d-block">
                                            {{ $p->category->name ?? '—' }} • {{ $p->duration_days ?: 0 }} days •
                                            {{ $p->status === 'active' ? 'Active' : 'Inactive' }}
                                        </span>
                                    </span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted d-block mt-1">Select programs from the same category only.</small>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}"
                            min="0">
                    </div>
                </div>

                <h6 class="mt-3">SEO</h6>
                <div class="mb-3">
                    <label class="form-label">Meta title</label>
                    <input type="text" name="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta description</label>
                    <textarea name="meta_description" class="form-control" rows="2">{{ old('meta_description') }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Meta keywords</label>
                    <input type="text" name="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                </div>

                <button type="submit" class="btn btn-primary">Save</button>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        (function() {
            const cat = document.getElementById('vessel_category_id');
            const programCards = Array.from(document.querySelectorAll('.program-card-item'));
            const programCheckboxes = Array.from(document.querySelectorAll('.program-checkbox'));

            function refreshProgramCardState() {
                programCheckboxes.forEach(input => {
                    const label = input.closest('.program-card-label');
                    if (!label) return;
                    label.classList.toggle('border-primary', input.checked);
                    label.classList.toggle('bg-primary-subtle', input.checked);
                });
            }

            function filterPrograms() {
                const v = cat.value;
                programCards.forEach(card => {
                    const match = !v || String(card.dataset.category) === String(v);
                    card.style.display = match ? '' : 'none';
                    const checkbox = card.querySelector('.program-checkbox');
                    if (!checkbox) return;
                    checkbox.disabled = !match;
                    if (!match) checkbox.checked = false;
                });
                refreshProgramCardState();
            }
            cat.addEventListener('change', filterPrograms);
            programCheckboxes.forEach(input => input.addEventListener('change', refreshProgramCardState));
            filterPrograms();

            const coverInput = document.getElementById('cover_image_input');
            const coverPreview = document.getElementById('cover-preview');
            let coverObjectUrl = null;
            coverInput?.addEventListener('change', function() {
                if (coverObjectUrl) URL.revokeObjectURL(coverObjectUrl);
                coverObjectUrl = null;
                coverPreview.innerHTML = '';
                const f = this.files && this.files[0];
                if (!f || !f.type.startsWith('image/')) return;
                coverObjectUrl = URL.createObjectURL(f);
                const img = document.createElement('img');
                img.src = coverObjectUrl;
                img.alt = '';
                img.className = 'img-thumbnail';
                img.style.maxHeight = '160px';
                coverPreview.appendChild(img);
            });

            const galleryInput = document.getElementById('gallery_input');
            const galleryPreview = document.getElementById('gallery-preview');
            const galleryObjectUrls = [];
            galleryInput?.addEventListener('change', function() {
                galleryObjectUrls.forEach(u => URL.revokeObjectURL(u));
                galleryObjectUrls.length = 0;
                galleryPreview.innerHTML = '';
                const files = Array.from(this.files || []);
                files.forEach(file => {
                    if (!file.type.startsWith('image/')) return;
                    const url = URL.createObjectURL(file);
                    galleryObjectUrls.push(url);
                    const col = document.createElement('div');
                    col.className = 'col-6 col-md-3';
                    const inner = document.createElement('div');
                    inner.className =
                        'border rounded p-2 bg-light d-flex align-items-center justify-content-center';
                    inner.style.height = '220px';
                    const img = document.createElement('img');
                    img.src = url;
                    img.alt = '';
                    img.className = 'img-fluid rounded';
                    img.style.objectFit = 'contain';
                    img.style.maxHeight = '200px';
                    img.style.maxWidth = '100%';
                    inner.appendChild(img);
                    col.appendChild(inner);
                    galleryPreview.appendChild(col);
                });
            });
        })();
    </script>
@endpush
