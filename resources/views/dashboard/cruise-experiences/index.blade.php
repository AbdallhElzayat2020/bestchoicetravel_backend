@extends('dashboard.layouts.master')

@section('title', 'Dahbia Cruises')

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cruises Page</h5>
            <a href="{{ route('admin.cruise-experiences.create', $cruiseGroupId ? ['cruise_group_id' => $cruiseGroupId] : []) }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Cruise Page
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
                <table class="table table-bordered align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Group</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th>Status</th>
                            <th>Related Tours</th>
                            <th>Sort Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($experiences as $experience)
                            <tr>
                                <td>{{ $experience->id }}</td>
                                <td>
                                    @if($experience->cruiseGroup)
                                        <span class="badge bg-label-info">{{ $experience->cruiseGroup->name }}</span>
                                    @else
                                        <span class="badge bg-label-secondary">{{ $experience->group_key ?? 'N/A' }}</span>
                                    @endif
                                </td>
                                <td>{{ Str::limit($experience->title, 60) }}</td>
                                <td><code>{{ $experience->slug }}</code></td>
                                <td>
                                    @if($experience->status === 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>
                                    @if($experience->tours->count())
                                        <span class="badge bg-label-primary">{{ $experience->tours->count() }} tours</span>
                                    @else
                                        <span class="text-muted">No tours linked</span>
                                    @endif
                                </td>
                                <td>{{ $experience->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.cruise-experiences.show', $experience->id) }}"
                                            class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.cruise-experiences.edit', $experience->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.cruise-experiences.destroy', $experience->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this cruise page?');">
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
                                <td colspan="8" class="text-center">No cruise pages found for this group.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $experiences->links() }}
            </div>
        </div>
    </div>
@endsection
