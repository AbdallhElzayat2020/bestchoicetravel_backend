@extends('dashboard.layouts.master')

@section('title', 'Trip Planner request')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Trip Planner request #{{ $tripPlanner->id }}</h5>
            <div class="d-flex gap-2">
                @if ($tripPlanner->is_read)
                    <form action="{{ route('admin.trip-planners.mark-unread', $tripPlanner->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-mail me-1"></i>
                            Mark as Unread
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.trip-planners.mark-read', $tripPlanner->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>
                            Mark as Read
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.trip-planners.index') }}" class="btn btn-secondary">
                    <i class="ti ti-arrow-left me-1"></i>
                    Back
                </a>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <div class="row mb-4">
                <div class="col-md-12">
                    <div class="alert {{ $tripPlanner->is_read ? 'alert-success' : 'alert-warning' }}" role="alert">
                        <strong>Status:</strong>
                        @if ($tripPlanner->is_read)
                            <span class="badge bg-label-success">Read</span>
                            @if ($tripPlanner->read_at)
                                <span class="ms-2">Read at: {{ $tripPlanner->read_at->format('Y-m-d H:i:s') }}</span>
                            @endif
                        @else
                            <span class="badge bg-label-warning">Unread</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Full name</label>
                    <p class="form-control-plaintext">{{ $tripPlanner->full_name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Nationality</label>
                    <p class="form-control-plaintext">{{ $tripPlanner->nationality }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Phone</label>
                    <p class="form-control-plaintext">
                        @if ($tripPlanner->phone)
                            <a href="tel:{{ $tripPlanner->phone }}">{{ $tripPlanner->phone }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="form-control-plaintext">
                        <a href="mailto:{{ $tripPlanner->email }}">{{ $tripPlanner->email }}</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 mb-3">
                    <label class="form-label fw-bold">Travelers</label>
                    <p class="form-control-plaintext">
                        Adults (+12 years): <strong>{{ $tripPlanner->adults }}</strong> —
                        Children (2 to 11): <strong>{{ $tripPlanner->children }}</strong> —
                        Infants (0 to 2): <strong>{{ $tripPlanner->infants }}</strong>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Arrival date</label>
                    <p class="form-control-plaintext">{{ $tripPlanner->arrival_date?->format('Y-m-d') ?? '—' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Departure date</label>
                    <p class="form-control-plaintext">{{ $tripPlanner->departure_date?->format('Y-m-d') ?? '—' }}</p>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Message</label>
                <div class="border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ $tripPlanner->message }}</div>
            </div>

            <form action="{{ route('admin.trip-planners.destroy', $tripPlanner->id) }}" method="POST"
                onsubmit="return confirm('Delete this request?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="ti ti-trash me-1"></i>
                    Delete
                </button>
            </form>
        </div>
    </div>
@endsection
