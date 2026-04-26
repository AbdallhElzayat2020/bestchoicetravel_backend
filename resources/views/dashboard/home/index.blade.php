@extends('dashboard.layouts.master')

@section('title', 'Travel Portal System by MRCO-Egypt')
@section('meta_description',
    'Professional travel portal system by MRCO-Egypt, designed to manage bookings, partners,
    and operations with efficiency, security, and scalability.')

@section('content')
    <div class="mb-4">
        <h4 class="mb-1">Dashboard Overview</h4>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="text-muted small">Tour Bookings</div>
                            <h3 class="mb-0">{{ $stats['totalBookings'] }}</h3>
                        </div>
                        <span class="avatar avatar-md bg-label-primary"><i class="ti ti-calendar-event"></i></span>
                    </div>
                    <div class="d-flex flex-wrap gap-2 mt-auto">
                        <span class="badge bg-label-warning">Pending: {{ $stats['pendingBookings'] }}</span>
                        <span class="badge bg-label-success">Confirmed: {{ $stats['confirmedBookings'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="text-muted small">Nile Cruise Bookings</div>
                            <h3 class="mb-0">{{ $stats['totalCruiseBookings'] }}</h3>
                        </div>
                        <span class="avatar avatar-md bg-label-info"><i class="ti ti-ship"></i></span>
                    </div>
                    <div class="mt-auto">
                        <span class="badge bg-label-danger">Unread: {{ $stats['unreadCruiseBookings'] }}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <div class="text-muted small">Trip Planner Leads</div>
                            <h3 class="mb-0">{{ $stats['totalTripPlannerLeads'] }}</h3>
                        </div>
                        <span class="avatar avatar-md bg-label-warning"><i class="ti ti-map-search"></i></span>
                    </div>
                    <div class="mt-auto">
                        <span class="badge bg-label-danger">Unread: {{ $stats['unreadTripPlannerLeads'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Tours</div>
                        <h4 class="mb-0">{{ $stats['totalTours'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeTours'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-primary"><i class="ti ti-plane"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Categories</div>
                        <h4 class="mb-0">{{ $stats['totalCategories'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeCategories'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-info"><i class="ti ti-folder"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Nile Cruise Tours</div>
                        <h4 class="mb-0">{{ $stats['totalCruiseExperiences'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeCruiseExperiences'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-warning"><i class="ti ti-anchor"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Optional Excursions</div>
                        <h4 class="mb-0">{{ $stats['totalTourVariants'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeTourVariants'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-success"><i class="ti ti-route"></i></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Live Highlights</div>
                        <h4 class="mb-0">{{ $stats['totalAnnouncements'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeAnnouncements'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-danger"><i class="ti ti-speakerphone"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Blogs</div>
                        <h4 class="mb-0">{{ $stats['totalBlogs'] }}</h4>
                        <small class="text-muted">Active: {{ $stats['activeBlogs'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-primary"><i class="ti ti-news"></i></span>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Users & Roles</div>
                        <h4 class="mb-0">{{ $stats['totalUsers'] }}</h4>
                        <small class="text-muted">Roles: {{ $stats['totalRoles'] }}</small>
                    </div>
                    <span class="avatar avatar-md bg-label-success"><i class="ti ti-users"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <div class="text-muted small">Countries / States</div>
                        <h4 class="mb-0">{{ $stats['totalCountries'] }} / {{ $stats['totalStates'] }}</h4>
                    </div>
                    <span class="avatar avatar-md bg-label-success"><i class="ti ti-map-pin"></i></span>
                </div>
            </div>
        </div>
    </div>

@endsection
