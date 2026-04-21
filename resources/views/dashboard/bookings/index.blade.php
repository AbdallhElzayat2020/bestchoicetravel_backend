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

            <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <div class="fw-semibold mb-2">Select Columns to Export:</div>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="id" id="bookingColId">
                                <label class="form-check-label" for="bookingColId">ID</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="tour" id="bookingColTour">
                                <label class="form-check-label" for="bookingColTour">Tour</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="full_name" id="bookingColCustomer" checked>
                                <label class="form-check-label" for="bookingColCustomer">Customer</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="email" id="bookingColEmail" checked>
                                <label class="form-check-label" for="bookingColEmail">Email</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="phone" id="bookingColPhone">
                                <label class="form-check-label" for="bookingColPhone">Phone</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="nationality" id="bookingColNationality">
                                <label class="form-check-label" for="bookingColNationality">Nationality</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="no_of_travellers" id="bookingColTravellers">
                                <label class="form-check-label" for="bookingColTravellers">Travellers</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="total_price" id="bookingColPrice">
                                <label class="form-check-label" for="bookingColPrice">Total Price</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="status" id="bookingColStatus">
                                <label class="form-check-label" for="bookingColStatus">Status</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input booking-column" value="notes" id="bookingColNotes">
                                <label class="form-check-label" for="bookingColNotes">Notes</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-primary" id="bookingSelectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="bookingDeselectAll">Deselect All</button>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="bookingExportBtn">
                        <i class="ti ti-file-export me-1"></i> Export to Excel
                    </button>
                </div>
            </div>

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

@push('js')
<script>
    (function () {
        const exportBtn = document.getElementById('bookingExportBtn');
        const selectAllBtn = document.getElementById('bookingSelectAll');
        const deselectAllBtn = document.getElementById('bookingDeselectAll');
        const boxes = document.querySelectorAll('.booking-column');
        if (!exportBtn) return;

        exportBtn.addEventListener('click', function () {
            let selected = Array.from(boxes).filter(b => b.checked).map(b => b.value);
            if (selected.length === 0) selected = ['email', 'full_name'];
            window.location.href = '{{ route('admin.bookings.export') }}?columns=' + selected.join(',');
        });
        selectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = true));
        deselectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = false));
    })();
</script>
@endpush
