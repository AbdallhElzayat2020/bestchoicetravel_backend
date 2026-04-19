@extends('dashboard.layouts.master')

@section('title', 'Vessel enquiry')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Reserved vessel enquiry</h5>
            <div class="d-flex gap-2">
                @if ($contact->is_read)
                    <form action="{{ route('admin.bookings.cruise-vessels.mark-unread', $contact) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning">
                            <i class="ti ti-mail me-1"></i>
                            Mark as Unread
                        </button>
                    </form>
                @else
                    <form action="{{ route('admin.bookings.cruise-vessels.mark-read', $contact) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success">
                            <i class="ti ti-check me-1"></i>
                            Mark as Read
                        </button>
                    </form>
                @endif
                <a href="{{ route('admin.bookings.cruise-vessels.index') }}" class="btn btn-secondary">
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

            <div class="row mb-3">
                <div class="col-md-12">
                    <div class="alert {{ $contact->is_read ? 'alert-success' : 'alert-warning' }}" role="alert">
                        <strong>Status:</strong>
                        @if ($contact->is_read)
                            <span class="badge bg-label-success">Read</span>
                            @if ($contact->read_at)
                                <span class="ms-2">Read at: {{ $contact->read_at->format('Y-m-d H:i:s') }}</span>
                            @endif
                        @else
                            <span class="badge bg-label-warning">Unread</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Vessel</label>
                    <p class="form-control-plaintext">{{ $contact->cruiseVesselTitle() ?? '—' }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Subject</label>
                    <p class="form-control-plaintext">{{ $contact->subject }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Name</label>
                    <p class="form-control-plaintext">{{ $contact->name }}</p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Email</label>
                    <p class="form-control-plaintext">
                        <a href="mailto:{{ $contact->email }}">{{ $contact->email }}</a>
                    </p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Phone</label>
                    <p class="form-control-plaintext">
                        @if ($contact->phone)
                            <a href="tel:{{ $contact->phone }}">{{ $contact->phone }}</a>
                        @else
                            <span class="text-muted">—</span>
                        @endif
                    </p>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Received</label>
                    <p class="form-control-plaintext">{{ $contact->created_at->format('Y-m-d H:i:s') }}</p>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Details</label>
                <div class="border rounded p-3 bg-light" style="white-space: pre-wrap;">{{ $contact->message }}</div>
            </div>
        </div>
    </div>
@endsection
