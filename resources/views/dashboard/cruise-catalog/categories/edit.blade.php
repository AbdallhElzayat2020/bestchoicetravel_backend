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

            <form action="{{ route('admin.cruise-catalog.categories.update', $category) }}" method="POST">
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
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
