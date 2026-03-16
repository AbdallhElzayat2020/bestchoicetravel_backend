@extends('dashboard.layouts.master')

@section('title', 'Tour Variant Details')

@push('css')
    <style>
        body {
            background: #1a1d29;
        }

        .main-card {
            background: #1e2130;
            border: 1px solid #2a2d3a;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }

        .main-card-header {
            background: linear-gradient(135deg, #1e2130 0%, #252836 100%);
            border-bottom: 1px solid #2a2d3a;
            padding: 1.5rem 2rem;
        }

        .main-card-header h5 {
            color: #e4e6eb;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .main-card-header i {
            color: #667eea;
            font-size: 1.75rem;
        }

        .main-card-body {
            background: #1a1d29;
            padding: 2rem;
        }

        .section-card {
            background: #1e2130;
            border: 1px solid #2a2d3a;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.2);
        }

        .section-header {
            background: linear-gradient(135deg, #252836 0%, #2a2d3a 100%);
            border-bottom: 1px solid #3a3d4a;
            padding: 1.25rem 1.75rem;
            position: relative;
            overflow: hidden;
        }

        .section-header::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .section-header.info::before {
            background: linear-gradient(180deg, #667eea 0%, #764ba2 100%);
        }

        .section-header.images::before {
            background: linear-gradient(180deg, #f093fb 0%, #f5576c 100%);
        }

        .section-header.details::before {
            background: linear-gradient(180deg, #30cfd0 0%, #330867 100%);
        }

        .section-header h6 {
            margin: 0;
            font-weight: 600;
            font-size: 1.1rem;
            color: #e4e6eb;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .section-header i {
            font-size: 1.5rem;
            color: #667eea;
        }

        .section-header.info i {
            color: #667eea;
        }

        .section-header.images i {
            color: #f093fb;
        }

        .section-header.details i {
            color: #30cfd0;
        }

        .section-body {
            padding: 1.75rem;
            background: #1e2130;
        }

        .image-container {
            background: #252836;
            border: 1px solid #3a3d4a;
            border-radius: 12px;
            padding: 1rem;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
            margin-bottom: 1.5rem;
        }

        .image-container img {
            max-width: 100%;
            max-height: 400px;
            object-fit: contain;
            border-radius: 8px;
        }

        .info-item {
            padding: 0.75rem 0;
            border-bottom: 1px solid #2a2d3a;
        }

        .info-item:last-child {
            border-bottom: none;
        }

        .info-label {
            color: #8a8d94;
            font-size: 0.9rem;
            margin-bottom: 0.25rem;
        }

        .info-value {
            color: #e4e6eb;
            font-size: 1rem;
            font-weight: 500;
        }

        .description-content {
            color: #b0b3b8;
            line-height: 1.8;
        }

        .badge {
            padding: 0.5rem 1rem;
            border-radius: 6px;
            font-weight: 500;
        }
    </style>
@endpush

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card main-card">
                    <div class="card-header main-card-header d-flex justify-content-between align-items-center">
                        <h5>
                            <i class="ti ti-info-circle"></i>
                            Tour Variant Details
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tour-variants.edit', $variant->id) }}" class="btn btn-label-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                            <a href="{{ route('admin.tour-variants.index') }}" class="btn btn-label-danger">
                                <i class="ti ti-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body main-card-body">
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Image Section -->
                        @if($variant->image)
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Variant Image
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="image-container">
                                        <img src="{{ asset('uploads/tour-variants/' . $variant->image) }}"
                                            alt="{{ $variant->title }}">
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Basic Information Section -->
                        <div class="section-card">
                            <div class="section-header info">
                                <h6>
                                    <i class="ti ti-info-circle"></i>
                                    Basic Information
                                </h6>
                            </div>
                            <div class="section-body">
                                <div class="info-item">
                                    <div class="info-label">Title</div>
                                    <div class="info-value">{{ $variant->title }}</div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Description</div>
                                    <div class="info-value description-content">
                                        {{ $variant->description ?? 'N/A' }}
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Status</div>
                                    <div class="info-value">
                                        @if($variant->status == 'active')
                                            <span class="badge bg-label-success">Active</span>
                                        @else
                                            <span class="badge bg-label-danger">Inactive</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Sort Order</div>
                                    <div class="info-value">{{ $variant->sort_order }}</div>
                                </div>
                            </div>
                        </div>

                        <!-- Additional Information Section -->
                        <div class="section-card">
                            <div class="section-header details">
                                <h6>
                                    <i class="ti ti-settings"></i>
                                    Additional Information
                                </h6>
                            </div>
                            <div class="section-body">
                                <div class="info-item">
                                    <div class="info-label">Additional Duration</div>
                                    <div class="info-value">
                                        @if($variant->additional_duration > 0)
                                            +{{ $variant->additional_duration }} {{ $variant->additional_duration_type }}
                                        @else
                                            None
                                        @endif
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Additional Price</div>
                                    <div class="info-value">
                                        @if($variant->additional_price > 0)
                                            +${{ number_format($variant->additional_price, 2) }}
                                        @else
                                            Free
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Timestamps Section -->
                        <div class="section-card">
                            <div class="section-header details">
                                <h6>
                                    <i class="ti ti-clock"></i>
                                    Timestamps
                                </h6>
                            </div>
                            <div class="section-body">
                                <div class="info-item">
                                    <div class="info-label">Created At</div>
                                    <div class="info-value">
                                        {{ $variant->created_at->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}
                                    </div>
                                </div>
                                <div class="info-item">
                                    <div class="info-label">Updated At</div>
                                    <div class="info-value">
                                        {{ $variant->updated_at->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
