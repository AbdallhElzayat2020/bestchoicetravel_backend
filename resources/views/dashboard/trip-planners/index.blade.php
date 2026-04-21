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

            <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <div class="fw-semibold mb-2">Select Columns to Export:</div>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="id" id="tripColId">
                                <label class="form-check-label" for="tripColId">ID</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="full_name" id="tripColName" checked>
                                <label class="form-check-label" for="tripColName">Name</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="email" id="tripColEmail" checked>
                                <label class="form-check-label" for="tripColEmail">Email</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="phone" id="tripColPhone">
                                <label class="form-check-label" for="tripColPhone">Phone</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="nationality" id="tripColNationality">
                                <label class="form-check-label" for="tripColNationality">Nationality</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="adults" id="tripColAdults">
                                <label class="form-check-label" for="tripColAdults">Adults</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="children" id="tripColChildren">
                                <label class="form-check-label" for="tripColChildren">Children</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="infants" id="tripColInfants">
                                <label class="form-check-label" for="tripColInfants">Infants</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="arrival_date" id="tripColArrival">
                                <label class="form-check-label" for="tripColArrival">Arrival Date</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="departure_date" id="tripColDeparture">
                                <label class="form-check-label" for="tripColDeparture">Departure Date</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="message" id="tripColMessage">
                                <label class="form-check-label" for="tripColMessage">Message</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input trip-column" value="status" id="tripColStatus">
                                <label class="form-check-label" for="tripColStatus">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-primary" id="tripSelectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="tripDeselectAll">Deselect All</button>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="tripExportBtn">
                        <i class="ti ti-file-export me-1"></i> Export to Excel
                    </button>
                </div>
            </div>

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

@push('js')
<script>
    (function () {
        const exportBtn = document.getElementById('tripExportBtn');
        const selectAllBtn = document.getElementById('tripSelectAll');
        const deselectAllBtn = document.getElementById('tripDeselectAll');
        const boxes = document.querySelectorAll('.trip-column');
        if (!exportBtn) return;

        exportBtn.addEventListener('click', function () {
            let selected = Array.from(boxes).filter(b => b.checked).map(b => b.value);
            if (selected.length === 0) selected = ['email', 'full_name'];
            window.location.href = '{{ route('admin.trip-planners.export') }}?columns=' + selected.join(',');
        });
        selectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = true));
        deselectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = false));
    })();
</script>
@endpush
