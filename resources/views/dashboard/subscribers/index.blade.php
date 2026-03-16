@extends('dashboard.layouts.master')

@section('title', 'Subscribers')

@push('css')
<style>
    .column-toggle {
        margin-bottom: 15px;
    }
    .column-toggle label {
        margin-right: 15px;
        font-weight: normal;
    }
    .dt-buttons {
        margin-bottom: 15px;
    }
</style>
@endpush

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Subscribers</h5>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- Column Toggle --}}
            <div class="column-toggle d-flex justify-content-between align-items-center flex-wrap gap-3 mb-3">
                <div>
                    <strong>Select Columns to Export:</strong><br>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="id"> ID
                    </label>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="email" checked> Email
                    </label>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="name" checked> Name
                    </label>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="is_active"> Status
                    </label>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="subscribed_at"> Subscribed At
                    </label>
                    <label>
                        <input type="checkbox" class="column-checkbox" value="unsubscribed_at"> Unsubscribed At
                    </label>
                    <button type="button" class="btn btn-sm btn-primary ms-3" id="selectAllColumns">Select All</button>
                    <button type="button" class="btn btn-sm btn-secondary" id="deselectAllColumns">Deselect All</button>
                </div>
                <div>
                    <button type="button" class="btn btn-success" id="exportBtn">
                        <i class="ti ti-file-export me-1"></i> Export to Excel
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table id="subscribersTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Email</th>
                            <th>Name</th>
                            <th>Status</th>
                            <th>Subscribed At</th>
                            <th>Unsubscribed At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscribers as $subscriber)
                            <tr>
                                <td>{{ $subscriber->id }}</td>
                                <td>
                                    <a href="mailto:{{ $subscriber->email }}">{{ $subscriber->email }}</a>
                                </td>
                                <td>{{ $subscriber->name ?? 'N/A' }}</td>
                                <td>
                                    @if($subscriber->is_active)
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $subscriber->subscribed_at->format('Y-m-d H:i') }}</td>
                                <td>
                                    @if($subscriber->unsubscribed_at)
                                        {{ $subscriber->unsubscribed_at->format('Y-m-d H:i') }}
                                    @else
                                        <span class="text-muted">N/A</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <form action="{{ route('admin.subscribers.toggle-status', $subscriber->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('PATCH')
                                            @if($subscriber->is_active)
                                                <button type="submit" class="btn btn-sm btn-label-warning" title="Deactivate">
                                                    <i class="ti ti-ban"></i>
                                                </button>
                                            @else
                                                <button type="submit" class="btn btn-sm btn-label-success" title="Activate">
                                                    <i class="ti ti-check"></i>
                                                </button>
                                            @endif
                                        </form>
                                        <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this subscriber?');">
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
                                <td colspan="7" class="text-center">No subscribers found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script>
    $(document).ready(function() {
        var table = $('#subscribersTable').DataTable({
            pageLength: 25,
            order: [[0, 'desc']],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "Showing 0 to 0 of 0 entries",
                infoFiltered: "(filtered from _MAX_ total entries)",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
        });

        // Export Button
        $('#exportBtn').on('click', function() {
            var selectedColumns = [];
            $('.column-checkbox:checked').each(function() {
                selectedColumns.push($(this).val());
            });

            // Default to email and name if nothing is selected
            if (selectedColumns.length === 0) {
                selectedColumns = ['email', 'name'];
            }

            var url = '{{ route("admin.subscribers.export") }}';
            url += '?columns=' + selectedColumns.join(',');

            window.location.href = url;
        });

        // Select All Columns
        $('#selectAllColumns').on('click', function() {
            $('.column-checkbox').prop('checked', true);
        });

        // Deselect All Columns
        $('#deselectAllColumns').on('click', function() {
            $('.column-checkbox').prop('checked', false);
        });
    });
</script>
@endpush
