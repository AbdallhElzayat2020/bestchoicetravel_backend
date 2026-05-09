@extends('dashboard.layouts.master')

@section('title', 'Edit cruise category')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit category</h5>
            <a href="{{ route('admin.cruise-catalog.categories.index') }}" class="btn btn-label-secondary">Back</a>
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

            <form action="{{ route('admin.cruise-catalog.categories.update', $category) }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label">Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control"
                        value="{{ old('name', $category->name) }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control"
                        value="{{ old('slug', $category->slug) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">H1 title</label>
                    <input type="text" name="h1_title" class="form-control"
                        value="{{ old('h1_title', $category->h1_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">H2 title</label>
                    <input type="text" name="h2_title" class="form-control"
                        value="{{ old('h2_title', $category->h2_title) }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Category banner</label>
                    @if ($category->banner_image)
                        <div class="mb-2">
                            <img src="{{ asset('uploads/cruise-catalog/' . $category->banner_image) }}"
                                alt="Current banner" class="rounded border" style="max-width: 100%; max-height: 180px; object-fit: cover;">
                        </div>
                    @endif
                    <input type="file" name="banner_image" class="form-control" accept="image/*">
                    <small class="text-muted d-block mt-1">Upload a new image to replace the current banner.</small>
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3">{{ old('description', $category->description) }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', $category->status) === 'active')>Active</option>
                            <option value="inactive" @selected(old('status', $category->status) === 'inactive')>Inactive
                            </option>
                        </select>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" class="form-control"
                            value="{{ old('sort_order', $category->sort_order) }}" min="0">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Attach FAQs for Category Page (optional)</label>
                    @php
                        $oldFaqIds = old('faq_ids', $selectedFaqIds ?? []);
                    @endphp
                    @if ($faqs->count())
                        <div class="row">
                            @foreach ($faqs as $faq)
                                <div class="col-12 col-md-6 col-xl-4 mb-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="faq_ids[]"
                                            value="{{ $faq->id }}" id="faq_{{ $faq->id }}"
                                            {{ in_array($faq->id, $oldFaqIds) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="faq_{{ $faq->id }}">
                                            <strong>{{ \Illuminate\Support\Str::limit($faq->question, 80) }}</strong>
                                        </label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info mb-0">
                            No FAQs available yet. Add FAQs first, then assign them to this category.
                        </div>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
