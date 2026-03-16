@extends('dashboard.layouts.master')

@section('title', 'Country Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Country Details</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.countries.edit', $country->id) }}" class="btn btn-primary">
                    <i class="ti ti-edit me-1"></i>
                    Edit
                </a>
                <a href="{{ route('admin.countries.index') }}" class="btn btn-label-secondary">
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered">
                        <tr>
                            <th width="30%">ID</th>
                            <td>{{ $country->id }}</td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>{{ $country->name }}</td>
                        </tr>
                        <tr>
                            <th>Slug</th>
                            <td><code>{{ $country->slug }}</code></td>
                        </tr>
                        <tr>
                            <th>Code</th>
                            <td>{{ $country->code ?? '-' }}</td>
                        </tr>
                        <tr>
                            <th>Status</th>
                            <td>
                                @if($country->status == 'active')
                                    <span class="badge bg-label-success">Active</span>
                                @else
                                    <span class="badge bg-label-danger">Inactive</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <th>Sort Order</th>
                            <td>{{ $country->sort_order }}</td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td>{{ $country->created_at->format('Y-m-d H:i:s') }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6">
                    @if($country->flag)
                        <div class="mb-3">
                            <label class="form-label">Flag</label>
                            <div>
                                <img src="{{ asset('uploads/countries/' . $country->flag) }}" alt="{{ $country->name }}"
                                    style="max-width: 300px; max-height: 300px; border-radius: 4px;">
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            @if($country->states->count() > 0)
                <div class="mt-4">
                    <h6>States ({{ $country->states->count() }})</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($country->states as $state)
                                    <tr>
                                        <td>{{ $state->name }}</td>
                                        <td><code>{{ $state->slug }}</code></td>
                                        <td>
                                            @if($state->status == 'active')
                                                <span class="badge bg-label-success">Active</span>
                                            @else
                                                <span class="badge bg-label-danger">Inactive</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection