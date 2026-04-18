@extends('frontend.layouts.master')

@php
    $metaTitle = $category->name . ' - Cruise Vessels';
    $metaDescription = $category->description
        ? \Illuminate\Support\Str::limit(strip_tags($category->description), 160)
        : ('Explore our vessels in ' . $category->name . '.');
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
    <section class="py-5 border-top">
        <div class="container">
            <nav aria-label="Breadcrumb">
                <ol class="breadcrumb mb-2">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                </ol>
            </nav>
            <h1 class="display-6 fw-bold text-dark mb-2">{{ $category->name }}</h1>
            @if ($category->description)
                <div class="text-muted cruise-category-description">
                    {!! $category->description !!}
                </div>
            @endif
        </div>
    </section>

    <section class="pt-3 pb-5">
        <div class="container">
            @if ($vessels->count())
                <div class="row g-4">
                    @foreach ($vessels as $vessel)
                        @php
                            $coverImage = $vessel->cover_image
                                ? asset('uploads/cruise-catalog/' . $vessel->cover_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');
                            $detailsUrl = route('cruise-catalog.vessel', [$category->slug, $vessel->slug]);
                            $shortText = $vessel->short_description
                                ? \Illuminate\Support\Str::limit(strip_tags($vessel->short_description), 92)
                                : 'Discover this vessel and explore its available cruise programs.';
                        @endphp
                        <div class="col-md-4">
                            <a href="{{ $detailsUrl }}" class="related-tour-card h-100 cruise-vessel-card">
                                <div class="related-tour-image cruise-vessel-card__media">
                                    <img src="{{ $coverImage }}" alt="{{ $vessel->title }}" loading="lazy" />
                                    <div class="cruise-vessel-card__overlay"></div>
                                    <div class="category-badge">{{ strtoupper($category->name) }}</div>
                                </div>
                                <div class="related-tour-body">
                                    <h3 class="related-tour-title">{{ $vessel->title }}</h3>
                                    <p class="text-dark-grey small mb-2">{{ $shortText }}</p>
                                    <div class="related-tour-price-row">
                                        <span class="related-tour-price-label">From</span>
                                        <span class="related-tour-price">${{ number_format((float) $vessel->price_tier_1, 0) }}</span>
                                        <span class="related-tour-price-unit">/ person</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                @if ($vessels->hasPages())
                    <div class="mt-4">
                        {{ $vessels->links() }}
                    </div>
                @endif
            @else
                <div class="p-4 text-center text-muted bg-white rounded-4 border">
                    No vessels are available in this category at the moment.
                </div>
            @endif
        </div>
    </section>
@endsection

@push('css')
    <style>
        .cruise-vessel-card {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(18, 23, 41, .08);
            transition: transform .25s ease, box-shadow .25s ease;
        }
        .cruise-category-description {
            max-width: 760px;
        }

        .cruise-vessel-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 16px 36px rgba(18, 23, 41, .14);
        }

        .cruise-vessel-card__media {
            position: relative;
            height: 220px;
            background: #141b2d;
        }

        .cruise-vessel-card__media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
            transition: transform .35s ease;
        }

        .cruise-vessel-card__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(8, 12, 22, .18) 0%, rgba(8, 12, 22, .55) 100%);
            pointer-events: none;
        }

        .cruise-vessel-card:hover .cruise-vessel-card__media img {
            transform: scale(1.03);
        }

        .cruise-vessel-card .related-tour-title {
            font-size: 1.05rem;
            line-height: 1.35;
            margin-bottom: .5rem;
        }

        .cruise-vessel-card .related-tour-body {
            padding: 1.05rem 1.05rem 1rem;
        }

        .cruise-vessel-card .related-tour-price-row {
            padding-top: .25rem;
        }
    </style>
@endpush
