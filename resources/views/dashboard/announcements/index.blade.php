@extends('dashboard.layouts.master')

@section('title', 'Announcements')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Announcements</h5>

        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="alert alert-info mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div class="flex-grow-1" style="min-width: 220px;">
                    <strong class="d-block mb-1">Website announcement bar</strong>
                    <span class="small text-muted">The yellow strip reads the message <strong>dynamically from the database</strong> (same source as <code>AnnouncementSeeder</code> / edit below). Only <strong>one</strong> active row is shown (lowest <code>sort_order</code> first). Turn off to keep the navbar flush to the top.</span>
                </div>
                <form method="POST" action="{{ route('admin.announcements.toggle-bar') }}" class="d-flex align-items-center gap-2 mb-0">
                    @csrf
                    <div class="form-check form-switch mb-0">
                        <input class="form-check-input" type="checkbox" role="switch" id="announcementBarToggle"
                            name="enabled" value="1" {{ !empty($announcementBarEnabled) ? 'checked' : '' }}
                            onchange="this.form.submit()">
                        <label class="form-check-label" for="announcementBarToggle">Show on website</label>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Content</th>
                            <th>Status</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($announcements as $announcement)
                            <tr>
                                <td>{{ $announcement->id }}</td>
                                <td>
                                    <strong>{{ \Illuminate\Support\Str::limit($announcement->content, 100) }}</strong>
                                </td>
                                <td>
                                    @if($announcement->status == 'active')
                                        <span class="badge bg-label-success">Active</span>
                                    @else
                                        <span class="badge bg-label-danger">Inactive</span>
                                    @endif
                                </td>
                                <td>{{ $announcement->sort_order }}</td>
                                <td>
                                    <div class="d-flex gap-2">
                                        <a href="{{ route('admin.announcements.show', $announcement->id) }}"
                                            class="btn btn-sm btn-label-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.announcements.edit', $announcement->id) }}"
                                            class="btn btn-sm btn-label-primary">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.announcements.destroy', $announcement->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this announcement?');">
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
                                <td colspan="5" class="text-center">No announcements found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $announcements->links() }}
            </div>
        </div>
    </div>
@endsection
