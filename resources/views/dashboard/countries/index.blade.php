@extends('dashboard.layouts.master')

@section('title', 'Countries')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Countries</h5>
            <a href="{{ route('admin.countries.create') }}" class="btn btn-primary">
                <i class="ti ti-plus me-1"></i>
                Add New Country
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
                            <th>Flag</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Slug</th>
                            <th>States</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($countries as $country)
                            <tr>
                                <td>{{ $country->id }}</td>
                                <td>
                                    @if($country->flag)
                                        <img src="{{ asset('uploads/countries/' . $country->flag) }}" alt="{{ $country->name }}"
                                            style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <span class="text-muted">No Flag</span>
                                    @endif
                                </td>
                                <td>{{ $country->name }}</td>
                                <td>
                                    @if($country->code)
                                        <code>{{ $country->code }}</code>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <code>{{ $country->slug }}</code>
                                </td>
                                <td>
                                    <span class="badge bg-label-info">{{ $country->states->count() }}</span>
                                </td>
                                <td>
                                    @if($country->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $country->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.countries.edit', $country->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.countries.destroy', $country->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this country?');">
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
                                <td colspan="9" class="text-center">No countries found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $countries->links() }}
            </div>
        </div>
    </div>
@endsection