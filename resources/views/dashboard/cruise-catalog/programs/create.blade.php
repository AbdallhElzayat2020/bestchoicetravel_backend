@extends('dashboard.layouts.master')

@section('title', 'New cruise program')

@section('content')
    @php
        $dayRows = old('days');
        if ($dayRows === null) {
            $dayRows = [['day_number' => 1, 'day_title' => '', 'day_status' => 'active', 'details' => '']];
        }
    @endphp
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">New program</h5>
            <a href="{{ route('admin.cruise-catalog.programs.index') }}" class="btn btn-label-secondary">Back</a>
        </div>
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.cruise-catalog.programs.store') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Category <span class="text-danger">*</span></label>
                    <select name="cruise_catalog_category_id" class="form-select" required>
                        <option value="">—</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" @selected(old('cruise_catalog_category_id') == $cat->id)>
                                {{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title <span class="text-danger">*</span></label>
                    <input type="text" name="title" class="form-control" value="{{ old('title') }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Slug</label>
                    <input type="text" name="slug" class="form-control" value="{{ old('slug') }}">
                </div>
                <div class="mb-3">
                    <label class="form-label">Short description</label>
                    <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Duration (days) <span class="text-danger">*</span></label>
                        <input type="number" name="duration_days" class="form-control" min="1" max="365"
                            value="{{ old('duration_days', 1) }}" required>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="active" @selected(old('status', 'active') === 'active')>Active</option>
                            <option value="inactive" @selected(old('status') === 'inactive')>Inactive</option>
                        </select>
                    </div>
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Sort order</label>
                        <input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', 0) }}"
                            min="0">
                    </div>
                </div>

                <h6 class="mt-4 mb-2">Day by day</h6>
                <p class="text-muted small">Each row is one day: number, title, status, and description.</p>
                <div id="day-rows" class="d-flex flex-column gap-3">
                    @foreach ($dayRows as $i => $row)
                        <div class="border rounded p-3 day-row">
                            <div class="row g-2">
                                <div class="col-md-2">
                                    <label class="form-label small">Day #</label>
                                    <input type="number" name="days[{{ $i }}][day_number]" class="form-control"
                                        min="1" value="{{ $row['day_number'] ?? $i + 1 }}" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label small">Title</label>
                                    <input type="text" name="days[{{ $i }}][day_title]" class="form-control"
                                        value="{{ $row['day_title'] ?? '' }}" required>
                                </div>
                                <div class="col-md-3">
                                    <label class="form-label small">Status</label>
                                    <select name="days[{{ $i }}][day_status]" class="form-select">
                                        @foreach (['draft', 'active', 'inactive'] as $st)
                                            <option value="{{ $st }}" @selected(($row['day_status'] ?? 'active') === $st)>
                                                {{ ucfirst($st) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="button" class="btn btn-sm btn-outline-danger w-100 remove-day"
                                        @if (count($dayRows) < 2) disabled @endif>Remove</button>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">Description</label>
                                    <textarea name="days[{{ $i }}][details]" class="form-control" rows="2">{{ $row['details'] ?? '' }}</textarea>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary mt-2" id="add-day">+ Add day</button>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        (function() {
            const container = document.getElementById('day-rows');
            const addBtn = document.getElementById('add-day');

            function reindex() {
                const rows = container.querySelectorAll('.day-row');
                rows.forEach((row, i) => {
                    row.querySelectorAll('input, select, textarea').forEach(el => {
                        const name = el.getAttribute('name');
                        if (!name || !name.startsWith('days[')) return;
                        el.setAttribute('name', name.replace(/days\[\d+]/, 'days[' + i + ']'));
                    });
                    const removeBtn = row.querySelector('.remove-day');
                    if (removeBtn) removeBtn.disabled = rows.length < 2;
                });
            }

            addBtn.addEventListener('click', function() {
                const rows = container.querySelectorAll('.day-row');
                const last = rows[rows.length - 1];
                const clone = last.cloneNode(true);
                clone.querySelectorAll('input, textarea').forEach(el => {
                    if (el.type === 'number') el.value = String(parseInt(el.value || '0', 10) + 1);
                    else el.value = '';
                });
                clone.querySelector('select[name$="[day_status]"]').value = 'active';
                container.appendChild(clone);
                reindex();
            });

            container.addEventListener('click', function(e) {
                if (!e.target.classList.contains('remove-day')) return;
                const rows = container.querySelectorAll('.day-row');
                if (rows.length < 2) return;
                e.target.closest('.day-row').remove();
                reindex();
            });
        })();
    </script>
@endpush
