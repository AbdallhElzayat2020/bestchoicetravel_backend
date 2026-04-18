@extends('dashboard.layouts.master')

@section('title', 'Tour Variants')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tour Variants</h5>
            <a href="{{ route('admin.tour-variants.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Additional Duration</th>
                            <th>Additional Price</th>
                            <th>Status</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($variants as $variant)
                            <tr>
                                <td>{{ $variant->id }}</td>
                                <td>
                                    @if($variant->image)
                                        <img src="{{ asset('uploads/tour-variants/' . $variant->image) }}"
                                            alt="{{ $variant->title }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ $variant->title }}</td>
                                <td>{{ Str::limit($variant->description ?? 'N/A', 50) }}</td>
                                <td>
                                    @if($variant->additional_duration > 0)
                                        +{{ $variant->additional_duration }} {{ $variant->additional_duration_type }}
                                    @else
                                        <span class="text-muted">None</span>
                                    @endif
                                </td>
                                <td>
                                    @if($variant->additional_price > 0)
                                        +${{ number_format($variant->additional_price, 2) }}
                                    @else
                                        <span class="text-muted">Free</span>
                                    @endif
                                </td>
                                <td>
                                    @if($variant->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $variant->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.tour-variants.show', $variant->id) }}"
                                            class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tour-variants.edit', $variant->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tour-variants.destroy', $variant->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this variant?');">
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
                                <td colspan="9" class="text-center">No variants found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if(method_exists($variants, 'links'))
                <div class="mt-3">
                    {{ $variants->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
