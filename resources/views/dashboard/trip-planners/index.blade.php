@extends('dashboard.layouts.master')

@section('title', 'Trip Planner requests')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Trip Planner requests</h5>
        </div>
        <div class="card-body">
            @if (session('success'))
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
                            <th>Name</th>
                            <th>Email</th>
                            <th>Arrival</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($requests as $row)
                            <tr class="{{ $row->is_read ? '' : 'table-warning' }}"
                                style="{{ $row->is_read ? '' : 'background-color: #fff3cd !important;' }}">
                                <td>{{ $row->id }}</td>
                                <td>
                                    <strong>{{ $row->full_name }}</strong>
                                    @if (!$row->is_read)
                                        <span class="badge bg-label-danger ms-1">New</span>
                                    @endif
                                </td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->arrival_date?->format('Y-m-d') ?? '—' }}</td>
                                <td>
                                    @if ($row->is_read)
                                        <span class="badge bg-label-success">Read</span>
                                    @else
                                        <span class="badge bg-label-warning">Unread</span>
                                    @endif
                                </td>
                                <td>{{ $row->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.trip-planners.show', $row->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if ($row->is_read)
                                            <form action="{{ route('admin.trip-planners.mark-unread', $row->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-warning"
                                                    title="Mark as Unread">
                                                    <i class="ti ti-mail"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.trip-planners.mark-read', $row->id) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-success"
                                                    title="Mark as Read">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.trip-planners.destroy', $row->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Delete this request?');">
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
                                <td colspan="7" class="text-center">No trip planner requests yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $requests->links() }}
            </div>
        </div>
    </div>
@endsection
