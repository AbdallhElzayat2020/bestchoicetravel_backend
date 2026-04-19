@extends('dashboard.layouts.master')

@section('title', 'Reserved vessels')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Reserved vessels (Nile cruise enquiries)</h5>
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
                            <th>Vessel</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($enquiries as $row)
                            <tr class="{{ $row->is_read ? '' : 'table-warning' }}"
                                style="{{ $row->is_read ? '' : 'background-color: #fff3cd !important;' }}">
                                <td>{{ $row->id }}</td>
                                <td>
                                    <strong>{{ $row->cruiseVesselTitle() ?? '—' }}</strong>
                                    @if (!$row->is_read)
                                        <span class="badge bg-label-danger ms-1">New</span>
                                    @endif
                                </td>
                                <td>{{ $row->name }}</td>
                                <td>{{ $row->email }}</td>
                                <td>{{ $row->phone ?? '—' }}</td>
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
                                        <a href="{{ route('admin.bookings.cruise-vessels.show', $row) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        @if ($row->is_read)
                                            <form action="{{ route('admin.bookings.cruise-vessels.mark-unread', $row) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-warning"
                                                    title="Mark as Unread">
                                                    <i class="ti ti-mail"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.bookings.cruise-vessels.mark-read', $row) }}"
                                                method="POST">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-label-success"
                                                    title="Mark as Read">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No vessel enquiries yet</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $enquiries->links() }}
            </div>
        </div>
    </div>
@endsection
