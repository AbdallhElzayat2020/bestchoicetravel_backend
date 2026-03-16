@extends('dashboard.layouts.master')

@section('title', 'Booked Tours')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Booked Tours</h5>
            <div class="d-flex gap-2">
                <a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}" class="btn btn-sm btn-label-warning">
                    <i class="ti ti-clock me-1"></i>Pending ({{ $pendingCount }})
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'confirmed']) }}"
                    class="btn btn-sm btn-label-success">
                    <i class="ti ti-check me-1"></i>Confirmed ({{ $confirmedCount }})
                </a>
                <a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}"
                    class="btn btn-sm btn-label-danger">
                    <i class="ti ti-x me-1"></i>Cancelled ({{ $cancelledCount }})
                </a>
                <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-label-primary">
                    <i class="ti ti-list me-1"></i>All ({{ $allCount }})
                </a>
            </div>
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
                            <th>Tour</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Nationality</th>
                            <th>Travellers</th>
                            <th>Total Price</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $booking)
                            <tr class="{{ $booking->status == 'pending' ? 'table-warning' : ($booking->status == 'confirmed' ? '' : 'table-danger') }}"
                                style="{{ $booking->status == 'pending' ? 'background-color: #fff3cd !important;' : ($booking->status == 'cancelled' ? 'background-color: #f8d7da !important;' : '') }}">
                                <td>{{ $booking->id }}</td>
                                <td>
                                    <strong>{{ $booking->tour->title ?? 'N/A' }}</strong>
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-label-danger ms-1">New</span>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $booking->full_name }}</strong>
                                    @if($booking->no_of_travellers > 1)
                                        <span class="badge bg-label-info ms-1">{{ $booking->no_of_travellers }} travellers</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                                </td>
                                <td>
                                    <a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a>
                                </td>
                                <td>{{ $booking->nationality ?? 'N/A' }}</td>
                                <td>{{ $booking->no_of_travellers ?? 1 }}</td>
                                <td><strong class="text-success">${{ number_format($booking->total_price, 2) }}</strong></td>
                                <td>
                                    @if($booking->status == 'pending')
                                        <span class="badge bg-label-warning">
                                            <i class="ti ti-clock me-1"></i>Pending
                                        </span>
                                    @elseif($booking->status == 'confirmed')
                                        <span class="badge bg-label-success">
                                            <i class="ti ti-check me-1"></i>Confirmed
                                        </span>
                                    @else
                                        <span class="badge bg-label-danger">
                                            <i class="ti ti-x me-1"></i>Cancelled
                                        </span>
                                    @endif
                                </td>
                                <td>{{ $booking->created_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.bookings.show', ['booking' => $booking->id, 'status' => request('status')]) }}"
                                            class="btn btn-sm btn-label-info" title="View Details">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this booking?');"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-label-danger" title="Delete">
                                                <i class="ti ti-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="ti ti-inbox" style="font-size: 48px;"></i>
                                        <p class="mt-2">No bookings found</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
@endsection
