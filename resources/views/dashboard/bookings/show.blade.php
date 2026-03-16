@extends('dashboard.layouts.master')

@section('title', 'Booking Details')

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Booking Details</h5>
            <a href="{{ route('admin.bookings.index', request()->only('status')) }}" class="btn btn-secondary">
                <i class="ti ti-arrow-left me-1"></i>
                Back to List
            </a>
        </div>
        <div class="card-body">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST">
                @csrf
                @method('PUT')
                @if(request('status'))
                    <input type="hidden" name="redirect_status" value="{{ request('status') }}">
                @endif

                <div class="row mb-4">
                    <div class="col-md-12">
                        <div class="alert {{ $booking->status == 'pending' ? 'alert-warning' : ($booking->status == 'confirmed' ? 'alert-success' : 'alert-danger') }}"
                            role="alert">
                            <strong>Status:</strong>
                            <select name="status" class="form-select d-inline-block w-auto ms-2">
                                <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                    <i class="ti ti-clock me-1"></i>Pending
                                </option>
                                <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>
                                    <i class="ti ti-check me-1"></i>Confirmed
                                </option>
                                <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                    <i class="ti ti-x me-1"></i>Cancelled
                                </option>
                            </select>
                            @if($booking->status == 'pending')
                                <span class="badge bg-label-warning ms-2">
                                    <i class="ti ti-clock me-1"></i>New Booking
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Booking ID</label>
                        <p class="form-control-plaintext">#{{ $booking->id }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Tour</label>
                        <p class="form-control-plaintext">
                            <strong>{{ $booking->tour->title ?? 'N/A' }}</strong>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Full Name</label>
                        <p class="form-control-plaintext">{{ $booking->full_name }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Nationality</label>
                        <p class="form-control-plaintext">{{ $booking->nationality ?? 'N/A' }}</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <p class="form-control-plaintext">
                            <a href="mailto:{{ $booking->email }}">{{ $booking->email }}</a>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Phone</label>
                        <p class="form-control-plaintext">
                            <a href="tel:{{ $booking->phone }}">{{ $booking->phone }}</a>
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">No. of Travellers</label>
                        <p class="form-control-plaintext">
                            <strong>{{ $booking->no_of_travellers ?? 1 }}</strong>
                        </p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Accommodation Type</label>
                        <p class="form-control-plaintext">
                            @if($booking->accommodationType)
                                <span class="badge bg-label-info">{{ $booking->accommodationType->price_name }}</span>
                                <span
                                    class="text-muted">(${{ number_format($booking->accommodationType->price_value, 2) }})</span>
                            @else
                                <span class="text-muted">N/A</span>
                            @endif
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label class="form-label fw-bold">Total Price</label>
                        <p class="form-control-plaintext">
                            <strong class="text-success">${{ number_format($booking->total_price, 2) }}</strong>
                            @if($booking->no_of_travellers > 1)
                                <span class="text-muted">({{ $booking->no_of_travellers }} travellers)</span>
                            @endif
                        </p>
                    </div>
                </div>

                @if($booking->selected_variants && is_array($booking->selected_variants) && count($booking->selected_variants) > 0)
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold">Selected Variants</label>
                            <div class="card bg-label-secondary p-3">
                                <ul class="mb-0">
                                    @foreach($booking->selected_variants as $variantId)
                                        @php
                                            $variant = \App\Models\TourVariant::find($variantId);
                                        @endphp
                                        @if($variant)
                                            <li>{{ $variant->title }} (${{ number_format((float) $variant->additional_price, 2) }})</li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12 mb-3">
                        <label for="notes" class="form-label fw-bold">Notes</label>
                        <textarea name="notes" id="notes" class="form-control" rows="4"
                            placeholder="Add notes about this booking...">{{ old('notes', $booking->notes) }}</textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Created At</label>
                        <p class="form-control-plaintext">{{ $booking->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-bold">Updated At</label>
                        <p class="form-control-plaintext">{{ $booking->updated_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                </div>

                <div class="mt-4 d-flex justify-content-between">
                    <form action="{{ route('admin.bookings.update', $booking->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this booking?');">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-primary">
                            <i class="ti ti-check me-1"></i>
                            Update Booking
                        </button>
                    </form>
                </div>
            </form>
        </div>
    </div>
@endsection
