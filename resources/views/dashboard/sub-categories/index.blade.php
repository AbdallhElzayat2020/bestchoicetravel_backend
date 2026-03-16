@extends('dashboard.layouts.master')

@section('title', 'Sub Categories')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Sub Categories</h5>
            <a href="{{ route('admin.sub-categories.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Sub Category
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subCategories as $subCategory)
                            <tr>
                                <td>{{ $subCategory->id }}</td>
                                <td>
                                    @if($subCategory->image)
                                        <img src="{{ asset('uploads/sub-categories/' . $subCategory->image) }}"
                                            alt="{{ $subCategory->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $subCategory->name }}</td>
                                <td>
                                    <span class="badge bg-label-primary">{{ $subCategory->category->name }}</span>
                                </td>
                                <td>
                                    <code>{{ $subCategory->slug }}</code>
                                </td>
                                <td>
                                    @if($subCategory->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $subCategory->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.sub-categories.edit', $subCategory->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.sub-categories.destroy', $subCategory->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this sub category?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-label-danger">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No sub categories found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $subCategories->links() }}
            </div>
        </div>
    </div>
@endsection
