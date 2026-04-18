@extends('dashboard.layouts.master')

@section('title', 'Cruise programs')

@section('content')
    <div class="card">
        <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
            <h5 class="mb-0">Cruise catalog — Programs (itineraries)</h5>
            <a href="{{ route('admin.cruise-catalog.programs.create') }}" class="btn btn-primary">
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
                            <option value="{{ $cat->id }}"
                                @selected(request('cruise_catalog_category_id') == $cat->id)>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
            </form>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($programs as $program)
                            <tr>
                                <td>{{ $program->id }}</td>
                                <td><strong>{{ $program->title }}</strong></td>
                                <td>{{ $program->category->name ?? '—' }}</td>
                                <td>{{ $program->duration_days }}</td>
                                <td>
                                    @if ($program->status === 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.cruise-catalog.programs.edit', $program) }}"
                                            class="btn btn-sm btn-label-primary"><i class="ti ti-edit"></i></a>
                                        <form action="{{ route('admin.cruise-catalog.programs.destroy', $program) }}"
                                            method="POST" onsubmit="return confirm('Delete program?');">
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
                                <td colspan="6" class="text-center text-muted">No programs yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{ $programs->links() }}
        </div>
    </div>
@endsection
