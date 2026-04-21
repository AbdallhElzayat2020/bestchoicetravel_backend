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

            <div class="border rounded-3 p-3 mb-3 bg-light-subtle">
                <div class="d-flex justify-content-between align-items-start flex-wrap gap-3">
                    <div class="flex-grow-1">
                        <div class="fw-semibold mb-2">Select Columns to Export:</div>
                        <div class="d-flex flex-wrap gap-3">
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="id" id="vesselColId">
                                <label class="form-check-label" for="vesselColId">ID</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="vessel" id="vesselColVessel">
                                <label class="form-check-label" for="vesselColVessel">Vessel</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="name" id="vesselColCustomer" checked>
                                <label class="form-check-label" for="vesselColCustomer">Customer</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="email" id="vesselColEmail" checked>
                                <label class="form-check-label" for="vesselColEmail">Email</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="phone" id="vesselColPhone">
                                <label class="form-check-label" for="vesselColPhone">Phone</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="subject" id="vesselColSubject">
                                <label class="form-check-label" for="vesselColSubject">Subject</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="message" id="vesselColMessage">
                                <label class="form-check-label" for="vesselColMessage">Message</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="category_id" id="vesselColCategory">
                                <label class="form-check-label" for="vesselColCategory">Category ID</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="sub_category_id" id="vesselColSubCategory">
                                <label class="form-check-label" for="vesselColSubCategory">Sub Category ID</label>
                            </div>
                            <div class="form-check form-check-inline m-0">
                                <input type="checkbox" class="form-check-input vessel-column" value="status" id="vesselColStatus">
                                <label class="form-check-label" for="vesselColStatus">Status</label>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex align-items-center gap-2 flex-wrap">
                        <button type="button" class="btn btn-sm btn-primary" id="vesselSelectAll">Select All</button>
                        <button type="button" class="btn btn-sm btn-outline-secondary" id="vesselDeselectAll">Deselect All</button>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="button" class="btn btn-success" id="vesselExportBtn">
                        <i class="ti ti-file-export me-1"></i> Export to Excel
                    </button>
                </div>
            </div>

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

@push('js')
<script>
    (function () {
        const exportBtn = document.getElementById('vesselExportBtn');
        const selectAllBtn = document.getElementById('vesselSelectAll');
        const deselectAllBtn = document.getElementById('vesselDeselectAll');
        const boxes = document.querySelectorAll('.vessel-column');
        if (!exportBtn) return;

        exportBtn.addEventListener('click', function () {
            let selected = Array.from(boxes).filter(b => b.checked).map(b => b.value);
            if (selected.length === 0) selected = ['email', 'name'];
            window.location.href = '{{ route('admin.bookings.cruise-vessels.export') }}?columns=' + selected.join(',');
        });
        selectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = true));
        deselectAllBtn?.addEventListener('click', () => boxes.forEach(b => b.checked = false));
    })();
</script>
@endpush
