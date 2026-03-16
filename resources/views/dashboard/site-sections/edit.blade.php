@extends('dashboard.layouts.master')

@section('title', 'Edit Section: ' . $siteSection->key)

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Edit Section: {{ $siteSection->key }}</h4>
            <a href="{{ route('admin.site-sections.index') }}" class="btn btn-outline-secondary btn-sm">Back</a>
        </div>

        <div class="row">
            <div class="col-lg-8">
                <div class="card mb-3">
                    <div class="card-body">
                        <form action="{{ route('admin.site-sections.update', $siteSection) }}" method="POST"
                              enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="form-label">Title</label>
                                <input type="text" name="title" class="form-control"
                                       value="{{ old('title', $siteSection->title) }}">
                                @error('title')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Subtitle</label>
                                <input type="text" name="subtitle" class="form-control"
                                       value="{{ old('subtitle', $siteSection->subtitle) }}">
                                @error('subtitle')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Description</label>
                                <textarea name="description" rows="5"
                                          class="form-control">{{ old('description', $siteSection->description) }}</textarea>
                                @error('description')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

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

                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select name="status" class="form-select">
                                    <option value="active" {{ old('status', $siteSection->status) === 'active' ? 'selected' : '' }}>
                                        Active
                                    </option>
                                    <option value="inactive" {{ old('status', $siteSection->status) === 'inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                                @error('status')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Image</label>
                                <input type="file" name="image" class="form-control">
                                @error('image')
                                <div class="text-danger small">{{ $message }}</div>
                                @enderror
                                @if($siteSection->image_path)
                                    <div class="mt-2">
                                        <img src="{{ asset($siteSection->image_path) }}" alt="Section image" class="img-fluid rounded"
                                             style="max-height: 160px;">
                                    </div>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-primary">
                                Save Changes
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <h6 class="mb-2">Info</h6>
                        <p class="text-muted small mb-1">
                            <strong>Key:</strong> <code>{{ $siteSection->key }}</code>
                        </p>
                        <p class="text-muted small mb-0">
                            استخدم هذا السكشن علشان تغير العنوان، الوصف، الزر، والصورة في واجهة الموقع.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

