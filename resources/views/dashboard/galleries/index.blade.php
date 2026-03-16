@extends('dashboard.layouts.master')

@section('title', 'Galleries')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Galleries</h5>
            <a href="{{ route('admin.galleries.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Gallery
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
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th>Homepage</th>
                            <th>Published At</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($galleries as $gallery)
                            <tr>
                                <td>{{ $gallery->id }}</td>
                                <td>
                                    @if($gallery->cover_image)
                                        <img src="{{ asset('uploads/galleries/' . $gallery->cover_image) }}"
                                            alt="{{ $gallery->title }}"
                                            style="width: 80px; height: 60px; object-fit: cover; border-radius: 6px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($gallery->title, 50) }}</td>
                                <td>
                                    <span class="badge bg-{{ $gallery->status === 'active' ? 'success' : 'secondary' }}">
                                        {{ ucfirst($gallery->status) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-{{ $gallery->show_on_homepage ? 'info' : 'light' }}">
                                        {{ $gallery->show_on_homepage ? 'Yes' : 'No' }}
                                    </span>
                                </td>
                                <td>{{ $gallery->published_at ? $gallery->published_at->format('Y-m-d') : '—' }}</td>
                                <td>{{ $gallery->sort_order }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('admin.galleries.edit', $gallery->id) }}" class="btn btn-sm btn-primary">
                                        <i class="ti ti-edit"></i>
                                    </a>
                                    <form action="{{ route('admin.galleries.destroy', $gallery->id) }}" method="POST"
                                        onsubmit="return confirm('Delete this gallery?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">No galleries found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $galleries->links() }}
            </div>
        </div>
    </div>
@endsection
