@extends('dashboard.layouts.master')

@section('title', 'Site Sections')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Site Sections</h4>
            <span class="text-muted small">تحكم في سكاشن الهوم من مكان واحد</span>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Key</th>
                            <th>Title</th>
                            <th>Status</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($sections as $section)
                            <tr>
                                <td>{{ $section->id }}</td>
                                <td><code>{{ $section->key }}</code></td>
                                <td>{{ $section->title }}</td>
                                <td>
                                    <span
                                        class="badge bg-{{ $section->status === 'active' ? 'success' : 'secondary' }}">{{ ucfirst($section->status) }}</span>
                                </td>
                                <td class="text-end">
                                    <a href="{{ route('admin.site-sections.edit', $section) }}" class="btn btn-sm btn-primary">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No site sections found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

