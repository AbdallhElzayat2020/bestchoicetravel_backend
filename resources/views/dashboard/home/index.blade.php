@extends('dashboard.layouts.master')

@section('title', 'Dashboard')

@section('content')
    <div class="row mb-4">
        <!-- Statistics Cards -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Categories</h6>
                            <h3 class="mb-0">{{ $stats['totalCategories'] }}</h3>
                            <small class="text-muted">Active: {{ $stats['activeCategories'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-primary">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-folder ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Tours</h6>
                            <h3 class="mb-0">{{ $stats['totalTours'] }}</h3>
                            <small class="text-muted">Active: {{ $stats['activeTours'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-info">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-plane ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Bookings</h6>
                            <h3 class="mb-0">{{ $stats['totalBookings'] }}</h3>
                            <small class="text-muted">Pending: {{ $stats['pendingBookings'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-warning">
                            <span class="avatar-initial rounded bg-label-warning">
                                <i class="ti ti-calendar-event ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Total Users</h6>
                            <h3 class="mb-0">{{ $stats['totalUsers'] }}</h3>
                            <small class="text-muted">Roles: {{ $stats['totalRoles'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-success">
                            <span class="avatar-initial rounded bg-label-success">
                                <i class="ti ti-users ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row mb-4">
        <!-- More Statistics -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Cruise Experiences</h6>
                            <h3 class="mb-0">{{ $stats['totalCruiseExperiences'] }}</h3>
                            <small class="text-muted">Active: {{ $stats['activeCruiseExperiences'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-primary">
                            <span class="avatar-initial rounded bg-label-primary">
                                <i class="ti ti-ship ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Blogs</h6>
                            <h3 class="mb-0">{{ $stats['totalBlogs'] }}</h3>
                            <small class="text-muted">Active: {{ $stats['activeBlogs'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-info">
                            <span class="avatar-initial rounded bg-label-info">
                                <i class="ti ti-news ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Contact Messages</h6>
                            <h3 class="mb-0">{{ $stats['totalContacts'] }}</h3>
                            <small class="text-muted">Unread: {{ $stats['unreadContacts'] }}</small>
                        </div>
                        <div class="avatar avatar-lg bg-label-danger">
                            <span class="avatar-initial rounded bg-label-danger">
                                <i class="ti ti-mail ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-4">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h6 class="text-muted mb-2">Subscribers</h6>
                            <h3 class="mb-0">{{ $stats['totalSubscribers'] }}</h3>
                        </div>
                        <div class="avatar avatar-lg bg-label-success">
                            <span class="avatar-initial rounded bg-label-success">
                            <i class="ti ti-users ti-md"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Recent Categories -->
        <div class="col-lg-6 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Categories</h5>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recent['categories']) && $recent['categories']->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recent['categories'] as $category)
                                        <tr>
                                            <td><a href="{{ route('admin.categories.index') }}">{{ $category->name }}</a></td>
                                            <td>
                                                <span
                                                    class="badge bg-label-{{ $category->status === 'active' ? 'success' : 'danger' }}">
                                                    {{ ucfirst($category->status) }}
                                                </span>
                                            </td>
                                            <td>{{ $category->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No categories found.</p>
                    @endif
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <!-- Recent Bookings -->
        <div class="col-lg-12 mb-4">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Recent Bookings</h5>
                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-primary">View All</a>
                </div>
                <div class="card-body">
                    @if(isset($recentBookings) && $recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Tour</th>
                                        <th>Customer</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Nationality</th>
                                        <th>Travellers</th>
                                        <th>Total Price</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>#{{ $booking->id }}</td>
                                            <td>
                                                <a href="{{ route('admin.bookings.show', $booking->id) }}">
                                                    {{ $booking->tour->title ?? 'N/A' }}
                                                </a>
                                            </td>
                                            <td>{{ $booking->full_name }}</td>
                                            <td>{{ $booking->email }}</td>
                                            <td>{{ $booking->phone }}</td>
                                            <td>{{ $booking->nationality ?? 'N/A' }}</td>
                                            <td>{{ $booking->no_of_travellers ?? 1 }}</td>
                                            <td><strong class="text-success">${{ number_format($booking->total_price, 2) }}</strong></td>
                                            <td>
                                                @if($booking->status == 'pending')
                                                    <span class="badge bg-label-warning">Pending</span>
                                                @elseif($booking->status == 'confirmed')
                                                    <span class="badge bg-label-success">Confirmed</span>
                                                @else
                                                    <span class="badge bg-label-danger">Cancelled</span>
                                                @endif
                                            </td>
                                            <td>{{ $booking->created_at->format('M d, Y') }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">No bookings found.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>

@endsection

