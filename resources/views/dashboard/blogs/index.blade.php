@extends('dashboard.layouts.master')

@section('title', 'Blogs')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Blogs</h5>
            <a href="{{ route('admin.blogs.create') }}" class="btn btn-primary">
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
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Published At</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($blogs as $blog)
                            <tr>
                                <td>{{ $blog->id }}</td>
                                <td>
                                    @if($blog->cover_image)
                                        <img src="{{ asset('uploads/blogs/' . $blog->cover_image) }}" alt="{{ $blog->title }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Image</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($blog->title, 50) }}</td>
                                <td>{{ $blog->author ?? 'N/A' }}</td>
                                <td>
                                    @if($blog->published_at)
                                        {{ \Carbon\Carbon::parse($blog->published_at)->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}
                                    @else
                                        <span class="text-muted">Not Published</span>
                                    @endif
                                </td>
                                <td>
                                    @if($blog->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.blogs.show', $blog->id) }}" class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.blogs.edit', $blog->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.blogs.destroy', $blog->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this blog?');">
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
                                <td colspan="8" class="text-center">No blogs found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $blogs->links() }}
            </div>
        </div>
    </div>
@endsection
