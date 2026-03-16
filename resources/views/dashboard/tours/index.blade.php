@extends('dashboard.layouts.master')

@section('title', 'Tours')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Tours</h5>
            <a href="{{ route('admin.tours.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Tour
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
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Country</th>
                            <th>Duration</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Homepage</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tours as $tour)
                            <tr>
                                <td>{{ $tour->id }}</td>
                                <td>
                                    @if($tour->cover_image)
                                        <img src="{{ asset('uploads/tours/' . $tour->cover_image) }}" alt="{{ $tour->title }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($tour->title, 30) }}</td>
                                <td>
                                    @if($tour->category)
                                        <span class="badge bg-label-info">{{ $tour->category->name }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">No Category</span>
                                    @endif
                                    @if($tour->subCategory)
                                        <br><small class="text-muted">{{ $tour->subCategory->name }}</small>
                                    @endif
                                </td>
                                <td>
                                    @if($tour->country)
                                        {{ $tour->country->name }}
                                    @else
                                        <span class="text-muted">No Country</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $tour->duration }} {{ $tour->duration_type }}
                                </td>
                                <td>
                                    @if($tour->has_offer && $tour->isOfferActive())
                                        <span
                                            class="text-decoration-line-through text-muted">{{ number_format($tour->price_before_discount, 2) }}</span>
                                        <br>
                                        <strong class="text-danger">{{ number_format($tour->price_after_discount, 2) }}</strong>
                                    @else
                                        <strong>{{ number_format($tour->price, 2) }}</strong>
                                    @endif
                                </td>
                                <td>
                                    @if($tour->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($tour->show_on_homepage)
                                        <span class="badge bg-label-primary">Yes</span>
                                    @else
                                        <span class="badge bg-label-secondary">No</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.tours.show', $tour->id) }}" class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.tours.edit', $tour->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.tours.destroy', $tour->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this tour?');">
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
                                <td colspan="10" class="text-center">No tours found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $tours->links() }}
            </div>
        </div>
    </div>
@endsection
