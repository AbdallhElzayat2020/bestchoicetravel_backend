@extends('dashboard.layouts.master')

@section('title', 'Cruise Groups')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Cruise Groups</h5>
            <a href="{{ route('admin.cruise-groups.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Cruise Group
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
                            <th>Name</th>
                            <th>Slug</th>
                            <th>Group Key</th>
                            <th>Cruise Experiences</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($groups as $group)
                            <tr>
                                <td>{{ $group->id }}</td>
                                <td><strong>{{ $group->name }}</strong></td>
                                <td>
                                    <code>{{ $group->slug }}</code>
                                </td>
                                <td>
                                    <code>{{ $group->group_key }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $group->cruise_experiences_count }}</span>
                                </td>
                                <td>
                                    @if($group->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $group->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.cruise-groups.edit', $group->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.cruise-groups.destroy', $group->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this cruise group?');">
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
                                <td colspan="8" class="text-center">No cruise groups found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $groups->links() }}
            </div>
        </div>
    </div>
@endsection

