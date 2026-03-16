@extends('dashboard.layouts.master')

@section('title', 'State Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">State Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.states.edit', $state->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.states.index') }}" class="btn btn-label-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <tr>
                    <th width="30%">ID</th>
                    <td>{{ $state->id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ $state->name }}</td>
                </tr>
                <tr>
                    <th>Slug</th>
                    <td><code>{{ $state->slug }}</code></td>
                </tr>
                <tr>
                    <th>Country</th>
                    <td>{{ $state->country->name }}</td>
                </tr>
                <tr>
                    <th>Status</th>
                    <td>
                        @if($state->status == 'active')
                            <span class="badge bg-label-success">Active</span>
                        @else
                            <span class="badge bg-label-danger">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <th>Sort Order</th>
                    <td>{{ $state->sort_order }}</td>
                </tr>
                <tr>
                    <th>Created At</th>
                    <td>{{ $state->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            </table>
        </div>
    </div>
@endsection