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

            <div class="mb-4">
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
