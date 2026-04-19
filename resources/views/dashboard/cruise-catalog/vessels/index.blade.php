@extends('dashboard.layouts.master')

@section('title', 'Cruise vessels')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="mb-0">Cruise catalog — Vessels</h5>
            <a href="{{ route('admin.cruise-catalog.vessels.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New
            </a>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="GET" class="row g-2 mb-3">
                <div class="col-md-4">
                    <select name="cruise_catalog_category_id" class="form-select" onchange="this.form.submit()">
                        <option value="">All categories</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(request('cruise_catalog_category_id') == $cat->id)>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Cover</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($vessels as $vessel)
                            <tr>
                                <td>{{ $vessel->id }}</td>
                                <td style="width:90px">
                                    @if ($vessel->cover_image)
                                        <img src="{{ asset('uploads/cruise-catalog/' . $vessel->cover_image) }}"
                                            alt="" class="img-thumbnail" style="max-height:56px;object-fit:cover">
                                    @else
                                        <span class="text-muted small">—</span>
                                    @endif
                                </td>
                                <td><strong>{{ $vessel->title }}</strong></td>
                                <td>{{ $vessel->category->name ?? '—' }}</td>
                                <td class="small">
                                    ${{ number_format($vessel->price_tier_1, 0) }}
                                </td>
                                <td>
                                    @if ($vessel->status === 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.cruise-catalog.vessels.edit', $vessel) }}"
                                            class="btn btn-sm btn-label-primary"><i class="ti ti-edit"></i></a>
                                        <form action="{{ route('admin.cruise-catalog.vessels.destroy', $vessel) }}"
                                            method="POST" onsubmit="return confirm('Delete vessel?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-label-danger"><i
                                                    class="ti ti-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted">No vessels yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $vessels->links() }}
        </div>
    </div>
@endsection
