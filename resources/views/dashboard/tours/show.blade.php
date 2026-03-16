@extends('dashboard.layouts.master')

@section('title', 'Tour Details')

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

        .section-card:hover {
            border-color: #3a3d4a;
            box-shadow: 0 6px 24px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
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

        .section-header.days::before {
            background: linear-gradient(180deg, #30cfd0 0%, #330867 100%);
        }

        .section-header.variants::before {
            background: linear-gradient(180deg, #fa709a 0%, #fee140 100%);
        }

        .section-header.details::before {
            background: linear-gradient(180deg, #4facfe 0%, #00f2fe 100%);
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

        .section-header.days i {
            color: #30cfd0;
        }

        .section-header.variants i {
            color: #fa709a;
        }

        .section-header.details i {
            color: #4facfe;
        }

        .section-body {
            padding: 1.75rem;
            background: #1e2130;
        }

        .info-table {
            width: 100%;
            border-collapse: collapse;
        }

        .info-table th {
            background: #252836;
            color: #b0b3b8;
            padding: 0.75rem 1rem;
            text-align: left;
            font-weight: 500;
            font-size: 0.9rem;
            border: 1px solid #3a3d4a;
            width: 40%;
        }

        .info-table td {
            background: #252836;
            color: #e4e6eb;
            padding: 0.75rem 1rem;
            border: 1px solid #3a3d4a;
        }

        .badge {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .badge.bg-label-success {
            background: rgba(67, 233, 123, 0.1);
            color: #43e97b;
            border: 1px solid rgba(67, 233, 123, 0.3);
        }

        .badge.bg-label-danger {
            background: rgba(255, 107, 107, 0.1);
            color: #ff6b6b;
            border: 1px solid rgba(255, 107, 107, 0.3);
        }

        .badge.bg-label-primary {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            border: 1px solid rgba(102, 126, 234, 0.3);
        }

        .badge.bg-label-secondary {
            background: rgba(138, 141, 148, 0.1);
            color: #8a8d94;
            border: 1px solid rgba(138, 141, 148, 0.3);
        }

        h4,
        h5,
        h6 {
            color: #e4e6eb;
        }

        p {
            color: #b0b3b8;
        }

        .text-muted {
            color: #8a8d94 !important;
        }

        .text-danger {
            color: #ff6b6b !important;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 0.7rem 1.75rem;
            font-weight: 500;
            border-radius: 8px;
            transition: all 0.3s ease;
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            color: white;
        }

        .btn-label-secondary {
            background: #252836;
            border: 1px solid #3a3d4a;
            color: #b0b3b8;
            padding: 0.7rem 1.75rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-label-secondary:hover {
            background: #2a2d3a;
            border-color: #4a4d5a;
            color: #e4e6eb;
        }

        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1rem;
            margin-top: 1rem;
        }

        .gallery-item {
            position: relative;
            border-radius: 8px;
            overflow: hidden;
            border: 2px solid #3a3d4a;
            transition: all 0.3s ease;
        }

        .gallery-item:hover {
            border-color: #667eea;
            transform: translateY(-4px);
            box-shadow: 0 8px 24px rgba(102, 126, 234, 0.3);
        }

        .gallery-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        .variant-card {
            background: #252836;
            border: 1px solid #3a3d4a;
            border-radius: 8px;
            padding: 1.25rem;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .variant-card:hover {
            border-color: #fa709a;
            background: #2a2d3a;
        }

        .variant-card h6 {
            color: #e4e6eb;
            margin-bottom: 0.75rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .variant-card h6 i {
            color: #fa709a;
        }

        .variant-info {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
            margin-top: 0.75rem;
        }

        .variant-info-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: #b0b3b8;
            font-size: 0.9rem;
        }

        .variant-info-item i {
            color: #667eea;
        }

        .day-card {
            background: #252836;
            border: 1px solid #3a3d4a;
            border-radius: 8px;
            margin-bottom: 1rem;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .day-card:hover {
            border-color: #30cfd0;
            background: #2a2d3a;
        }

        .day-card-header {
            background: #2a2d3a;
            border-bottom: 1px solid #3a3d4a;
            padding: 1rem 1.25rem;
        }

        .day-card-header strong {
            color: #e4e6eb;
            font-size: 1.05rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .day-card-header strong i {
            color: #30cfd0;
        }

        .day-card-body {
            padding: 1.25rem;
            color: #b0b3b8;
        }

        .cover-image-container {
            border-radius: 12px;
            overflow: hidden;
            border: 2px solid #3a3d4a;
            margin-bottom: 1.5rem;
            background: #252836;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 300px;
        }

        .cover-image-container img {
            width: 100%;
            max-height: 600px;
            object-fit: contain;
            display: block;
            background: #252836;
        }

        .description-content {
            color: #b0b3b8;
            line-height: 1.8;
            font-size: 1rem;
        }

        .description-content p {
            color: #b0b3b8;
            margin-bottom: 1rem;
        }

        .description-content h1,
        .description-content h2,
        .description-content h3,
        .description-content h4,
        .description-content h5,
        .description-content h6 {
            color: #e4e6eb;
            margin-top: 1.5rem;
            margin-bottom: 1rem;
        }

        .description-content ul,
        .description-content ol {
            color: #b0b3b8;
            padding-left: 2rem;
            margin-bottom: 1rem;
        }

        .description-content li {
            color: #b0b3b8;
            margin-bottom: 0.5rem;
        }

        .description-content a {
            color: #667eea;
            text-decoration: none;
        }

        .description-content a:hover {
            color: #764ba2;
            text-decoration: underline;
        }

        .description-content img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            margin: 1rem 0;
            border: 2px solid #3a3d4a;
        }

        .description-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
        }

        .description-content table th,
        .description-content table td {
            border: 1px solid #3a3d4a;
            padding: 0.75rem;
            color: #b0b3b8;
        }

        .description-content table th {
            background: #252836;
            color: #e4e6eb;
        }

        .description-content blockquote {
            border-left: 4px solid #667eea;
            padding-left: 1rem;
            margin: 1rem 0;
            color: #b0b3b8;
            font-style: italic;
        }

        .description-content code {
            background: #252836;
            padding: 0.2rem 0.5rem;
            border-radius: 4px;
            color: #e4e6eb;
            font-family: 'Courier New', monospace;
        }

        .description-content pre {
            background: #252836;
            padding: 1rem;
            border-radius: 8px;
            overflow-x: auto;
            border: 1px solid #3a3d4a;
        }

        .description-content pre code {
            background: transparent;
            padding: 0;
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
                            <i class="ti ti-eye"></i>
                            Tour Details
                        </h5>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.tours.edit', $tour->id) }}" class="btn btn-primary">
                                <i class="ti ti-edit me-1"></i>
                                Edit
                            </a>
                            <a href="{{ route('admin.tours.index') }}" class="btn btn-label-secondary">
                                <i class="ti ti-arrow-left me-1"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body main-card-body">
                        <!-- Basic Information -->
                        <div class="section-card">
                            <div class="section-header info">
                                <h6>
                                    <i class="ti ti-info-circle"></i>
                                    Basic Information
                                </h6>
                            </div>
                            <div class="section-body">
                                <h4 class="mb-4" style="color: #e4e6eb;">{{ $tour->title }}</h4>

                                @if($tour->cover_image)
                                    <div class="cover-image-container">
                                        <img src="{{ asset('uploads/tours/' . $tour->cover_image) }}" alt="{{ $tour->title }}">
                                    </div>
                                @endif

                                @if($tour->short_description)
                                    <div class="mb-4">
                                        <h6 style="color: #e4e6eb; margin-bottom: 0.75rem;">
                                            <i class="ti ti-file-text me-2" style="color: #667eea;"></i>
                                            Short Description
                                        </h6>
                                        <div class="description-content">
                                            {!! $tour->short_description !!}
                                        </div>
                                    </div>
                                @endif

                                @if($tour->description)
                                    <div class="mb-4">
                                        <h6 style="color: #e4e6eb; margin-bottom: 0.75rem;">
                                            <i class="ti ti-article me-2" style="color: #667eea;"></i>
                                            Description
                                        </h6>
                                        <div class="description-content">
                                            {!! $tour->description !!}
                                        </div>
                                    </div>
                                @endif

                                <div class="row mt-4">
                                    <div class="col-md-12">
                                        <table class="info-table">
                                            <tr>
                                                <th>Category</th>
                                                <td>
                                                    @if($tour->category)
                                                        {{ $tour->category->name }}
                                                    @else
                                                        <span class="text-muted">No Category</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($tour->subCategory)
                                                <tr>
                                                    <th>Sub Category</th>
                                                    <td>{{ $tour->subCategory->name }}</td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Country</th>
                                                <td>
                                                    @if($tour->country)
                                                        {{ $tour->country->name }}
                                                    @else
                                                        <span class="text-muted">No Country</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($tour->state)
                                                <tr>
                                                    <th>State</th>
                                                    <td>
                                                        @if($tour->state)
                                                            {{ $tour->state->name }}
                                                        @else
                                                            <span class="text-muted">No State</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Duration</th>
                                                <td>
                                                    <strong style="color: #e4e6eb;">{{ $tour->duration }}</strong>
                                                    <span style="color: #b0b3b8;">{{ $tour->duration_type }}</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td>
                                                    @if($tour->has_offer && $tour->offer_start_date && $tour->offer_end_date)
                                                        @php
                                                            $now = now('Africa/Cairo');
                                                            $startDate = $tour->offer_start_date->setTimezone('Africa/Cairo');
                                                            $endDate = $tour->offer_end_date->setTimezone('Africa/Cairo');
                                                            $isActive = $now >= $startDate && $now <= $endDate;
                                                        @endphp
                                                        @if($isActive)
                                                            <span class="text-decoration-line-through text-muted"
                                                                style="color: #8a8d94;">
                                                                ${{ number_format($tour->price_before_discount, 2) }}
                                                            </span>
                                                            <br>
                                                            <strong class="text-danger" style="font-size: 1.1rem;">
                                                                ${{ number_format($tour->price_after_discount, 2) }}
                                                            </strong>
                                                            <span class="badge bg-label-danger ms-2">Special Offer</span>
                                                        @else
                                                            <strong style="color: #e4e6eb; font-size: 1.1rem;">
                                                                ${{ number_format($tour->price, 2) }}
                                                            </strong>
                                                        @endif
                                                    @else
                                                        <strong style="color: #e4e6eb; font-size: 1.1rem;">
                                                            ${{ number_format($tour->price, 2) }}
                                                        </strong>
                                                    @endif
                                                </td>
                                            </tr>
                                            @if($tour->has_offer && $tour->offer_start_date && $tour->offer_end_date)
                                                <tr>
                                                    <th>Offer Period</th>
                                                    <td>
                                                        <span style="color: #b0b3b8;">
                                                            {{ $tour->offer_start_date->setTimezone('Africa/Cairo')->format('Y-m-d') }}
                                                            <i class="ti ti-arrow-right mx-1"></i>
                                                            {{ $tour->offer_end_date->setTimezone('Africa/Cairo')->format('Y-m-d') }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($tour->status == 'active')
                                                        <span class="badge bg-label-success">Active</span>
                                                    @else
                                                        <span class="badge bg-label-danger">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Show on Homepage</th>
                                                <td>
                                                    @if($tour->show_on_homepage)
                                                        <span class="badge bg-label-primary">Yes</span>
                                                    @else
                                                        <span class="badge bg-label-secondary">No</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td style="color: #b0b3b8;">
                                                    {{ $tour->created_at->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}
                                                    (EET)
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Updated At</th>
                                                <td style="color: #b0b3b8;">
                                                    {{ $tour->updated_at->setTimezone('Africa/Cairo')->format('Y-m-d h:i A') }}
                                                    (EET)
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gallery Images -->
                        @if($tour->tourImages && $tour->tourImages->count() > 0)
                            <div class="section-card">
                                <div class="section-header images">
                                    <h6>
                                        <i class="ti ti-photo"></i>
                                        Gallery Images ({{ $tour->tourImages->count() }})
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <div class="gallery-grid">
                                        @foreach($tour->tourImages as $image)
                                            <div class="gallery-item">
                                                <img src="{{ asset('uploads/tours/' . $image->image) }}"
                                                    alt="Tour Image {{ $loop->iteration }}"
                                                    onclick="window.open(this.src, '_blank')" style="cursor: pointer;">
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Tour Days / Itinerary -->
                        @if($tour->tourDays && $tour->tourDays->count() > 0)
                            <div class="section-card">
                                <div class="section-header days">
                                    <h6>
                                        <i class="ti ti-calendar"></i>
                                        Tour Days / Itinerary ({{ $tour->tourDays->count() }} Days)
                                    </h6>
                                </div>
                                <div class="section-body">
                                    @foreach($tour->tourDays as $day)
                                        <div class="day-card">
                                            <div class="day-card-header">
                                                <strong>
                                                    <i class="ti ti-calendar-event"></i>
                                                    Day {{ $day->day_number }}: {{ $day->day_title }}
                                                </strong>
                                            </div>
                                            <div class="day-card-body">
                                                <div class="description-content">
                                                    {!! $day->details ?? '<span class="text-muted">No details provided</span>' !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Tour Variants -->
                        @if($tour->variants && $tour->variants->count() > 0)
                            <div class="section-card">
                                <div class="section-header variants">
                                    <h6>
                                        <i class="ti ti-adjustments"></i>
                                        Tour Variants / Add-ons ({{ $tour->variants->count() }})
                                    </h6>
                                </div>
                                <div class="section-body">
                                    @foreach($tour->variants as $variant)
                                        <div class="variant-card">
                                            <h6>
                                                <i class="ti ti-adjustments"></i>
                                                {{ $variant->title }}
                                                @if($variant->status == 'active')
                                                    <span class="badge bg-label-success ms-2">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary ms-2">Inactive</span>
                                                @endif
                                            </h6>
                                            @if($variant->description)
                                                <p style="color: #b0b3b8; margin-bottom: 0.75rem;">{{ $variant->description }}</p>
                                            @endif
                                            <div class="variant-info">
                                                @if($variant->additional_duration > 0)
                                                    <div class="variant-info-item">
                                                        <i class="ti ti-clock"></i>
                                                        <span>+{{ $variant->additional_duration }}
                                                            {{ $variant->additional_duration_type }}</span>
                                                    </div>
                                                @endif
                                                @if($variant->additional_price > 0)
                                                    <div class="variant-info-item">
                                                        <i class="ti ti-currency-dollar"></i>
                                                        <span>+${{ number_format($variant->additional_price, 2) }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Seasonal Prices -->
                        @if($tour->seasonalPrices && $tour->seasonalPrices->count() > 0)
                            <div class="section-card">
                                <div class="section-header pricing">
                                    <h6>
                                        <i class="ti ti-calendar-time"></i>
                                        Seasonal Prices ({{ $tour->seasonalPrices->count() }})
                                    </h6>
                                </div>
                                <div class="section-body">
                                    @php
                                        $months = [
                                            1 => 'January',
                                            2 => 'February',
                                            3 => 'March',
                                            4 => 'April',
                                            5 => 'May',
                                            6 => 'June',
                                            7 => 'July',
                                            8 => 'August',
                                            9 => 'September',
                                            10 => 'October',
                                            11 => 'November',
                                            12 => 'December'
                                        ];
                                    @endphp
                                    @foreach($tour->seasonalPrices as $price)
                                        <div class="variant-card" style="margin-bottom: 2rem; padding: 1.5rem; background: #1e2028; border: 1px solid #3a3d4a; border-radius: 12px;">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h6 style="color: #e4e6eb; margin: 0; font-size: 1.1rem;">
                                                    <i class="ti ti-calendar-time me-2" style="color: #43e97b;"></i>
                                                    {{ $price->season_name }}
                                                </h6>
                                                @if($price->status == 'active')
                                                    <span class="badge bg-label-success">Active</span>
                                                @else
                                                    <span class="badge bg-label-secondary">Inactive</span>
                                                @endif
                                            </div>

                                            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem; margin-bottom: 1.5rem;">
                                                <div style="background: #252836; padding: 1rem; border-radius: 8px; border: 1px solid #3a3d4a;">
                                                    <div style="color: #b0b3b8; font-size: 0.85rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                                                        <i class="ti ti-calendar me-2" style="color: #43e97b;"></i>
                                                        <strong style="color: #e4e6eb;">Period</strong>
                                                    </div>
                                                    <div style="color: #e4e6eb; font-size: 1rem;">
                                                        {{ $months[$price->start_month] ?? '' }} - {{ $months[$price->end_month] ?? '' }}
                                                    </div>
                                                </div>

                                                <div style="background: #252836; padding: 1rem; border-radius: 8px; border: 1px solid #3a3d4a;">
                                                    <div style="color: #b0b3b8; font-size: 0.85rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                                                        <i class="ti ti-sort-ascending me-2" style="color: #43e97b;"></i>
                                                        <strong style="color: #e4e6eb;">Sort Order</strong>
                                                    </div>
                                                    <div style="color: #e4e6eb; font-size: 1rem;">
                                                        {{ $price->sort_order }}
                                                    </div>
                                                </div>
                                            </div>

                                            @if($price->description)
                                                <div style="background: #252836; padding: 1rem; border-radius: 8px; border: 1px solid #3a3d4a; margin-bottom: 1.5rem;">
                                                    <div style="color: #b0b3b8; font-size: 0.85rem; margin-bottom: 0.5rem; display: flex; align-items: center;">
                                                        <i class="ti ti-file-text me-2" style="color: #43e97b;"></i>
                                                        <strong style="color: #e4e6eb;">Description</strong>
                                                    </div>
                                                    <p style="color: #b0b3b8; margin: 0; line-height: 1.6;">{{ $price->description }}</p>
                                                </div>
                                            @endif

                                            @if($price->priceItems && $price->priceItems->count() > 0)
                                                <div style="margin-top: 1.5rem;">
                                                    <h6 style="color: #e4e6eb; margin-bottom: 1rem; font-size: 1rem; display: flex; align-items: center;">
                                                        <i class="ti ti-currency-dollar me-2" style="color: #43e97b;"></i>
                                                        Price Items ({{ $price->priceItems->count() }})
                                                    </h6>
                                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                                                        @foreach($price->priceItems as $item)
                                                            <div style="background: #252836; padding: 1.25rem; border-radius: 8px; border: 1px solid #3a3d4a; transition: all 0.3s ease;">
                                                                <div style="display: flex; align-items: center; margin-bottom: 0.75rem;">
                                                                    <i class="ti ti-coins" style="color: #43e97b; font-size: 1.3rem; margin-right: 0.75rem;"></i>
                                                                    <div style="color: #e4e6eb; font-size: 1.6rem; font-weight: 700;">
                                                                        US$ {{ number_format($item->price_value, 2) }}
                                                                    </div>
                                                                </div>
                                                                <div style="color: #b0b3b8; font-size: 0.95rem; margin-bottom: 0.5rem; font-weight: 500;">
                                                                    {{ $item->price_name }}
                                                                </div>
                                                                @if($item->description)
                                                                    <div style="color: #8a8d94; font-size: 0.85rem; line-height: 1.5; margin-top: 0.5rem; padding-top: 0.5rem; border-top: 1px solid #3a3d4a;">
                                                                        {{ $item->description }}
                                                                    </div>
                                                                @endif
                                                                @if($item->sort_order > 0)
                                                                    <div style="color: #6c757d; font-size: 0.75rem; margin-top: 0.5rem;">
                                                                        Sort Order: {{ $item->sort_order }}
                                                                    </div>
                                                                @endif
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @else
                                                <div style="margin-top: 1.5rem; padding: 1.5rem; background: #252836; border-radius: 8px; border: 1px solid #3a3d4a; text-align: center;">
                                                    <i class="ti ti-info-circle" style="color: #8a8d94; font-size: 1.5rem; margin-bottom: 0.5rem;"></i>
                                                    <p style="color: #b0b3b8; font-style: italic; margin: 0;">No price items available for this season.</p>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- SEO Information -->
                        @if($tour->meta_title || $tour->meta_description || $tour->meta_keywords)
                            <div class="section-card">
                                <div class="section-header details">
                                    <h6>
                                        <i class="ti ti-search"></i>
                                        SEO Information
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <table class="info-table">
                                        @if($tour->meta_title)
                                            <tr>
                                                <th>Meta Title</th>
                                                <td>{{ $tour->meta_title }}</td>
                                            </tr>
                                        @endif
                                        @if($tour->meta_description)
                                            <tr>
                                                <th>Meta Description</th>
                                                <td style="color: #b0b3b8;">{{ Str::limit($tour->meta_description, 200) }}</td>
                                            </tr>
                                        @endif
                                        @if($tour->meta_keywords)
                                            <tr>
                                                <th>Meta Keywords</th>
                                                <td style="color: #b0b3b8;">{{ $tour->meta_keywords }}</td>
                                            </tr>
                                        @endif
                                    </table>
                                </div>
                            </div>
                        @endif

                        <!-- Notes -->
                        @if($tour->notes)
                            <div class="section-card">
                                <div class="section-header details">
                                    <h6>
                                        <i class="ti ti-notes"></i>
                                        Notes
                                    </h6>
                                </div>
                                <div class="section-body">
                                    <p style="color: #b0b3b8; line-height: 1.8; white-space: pre-wrap;">{{ $tour->notes }}</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
