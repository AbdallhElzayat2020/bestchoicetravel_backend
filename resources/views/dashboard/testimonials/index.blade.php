@extends('dashboard.layouts.master')

@section('title', 'Testimonials')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Testimonials</h5>
            <a href="{{ route('admin.testimonials.create') }}" class="btn btn-primary">
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

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Job Title</th>
                            <th>Country</th>
                            <th>Rating</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($testimonials as $testimonial)
                            <tr>
                                <td>{{ $testimonial->id }}</td>
                                <td>
                                    @if($testimonial->image)
                                        <img src="{{ asset('uploads/testimonials/' . $testimonial->image) }}"
                                            alt="{{ $testimonial->name }}"
                                            style="width: 60px; height: 60px; object-fit: cover; border-radius: 50%;">
                                    @else
                                        <div class="bg-label-secondary rounded-circle d-flex align-items-center justify-content-center"
                                            style="width: 60px; height: 60px;">
                                            <i class="ti ti-user" style="font-size: 24px;"></i>
                                        </div>
                                    @endif
                                </td>
                                <td><strong>{{ $testimonial->name }}</strong></td>
                                <td>
                                    @if($testimonial->description)
                                        {{ \Illuminate\Support\Str::limit($testimonial->description, 50) }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>{{ $testimonial->job_title ?? 'N/A' }}</td>
                                <td>{{ $testimonial->company ?? 'N/A' }}</td>
                                <td>
                                    @if($testimonial->rating)
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $testimonial->rating)
                                                <i class="ti ti-star-filled text-warning"></i>
                                            @else
                                                <i class="ti ti-star text-muted"></i>
                                            @endif
                                        @endfor
                                        <span class="ms-1">({{ $testimonial->rating }})</span>
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    @if($testimonial->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $testimonial->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.testimonials.show', $testimonial->id) }}"
                                            class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.testimonials.edit', $testimonial->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this testimonial?');">
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
                                <td colspan="10" class="text-center">No testimonials found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $testimonials->links() }}
            </div>
        </div>
    </div>
@endsection