@extends('frontend.layouts.master')

@php
    $heroH1 = $category->h1_title ?: $category->name;
    $heroH2 = $category->h2_title ?: $category->name;
    $heroDescription = $category->description ? \Illuminate\Support\Str::limit(strip_tags($category->description), 170) : null;
    $metaTitle = $heroH1 . ' - Cruise Vessels';
    $metaDescription = $category->description
        ? \Illuminate\Support\Str::limit(strip_tags($category->description), 160)
        : 'Explore our vessels in ' . $category->name . '.';
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
    <section class="border-top">
        <div class="container">

            <h1 class="display-6 fw-bold text-dark mb-2">{{ $heroH1 }}</h1>
            @if ($category->description)
                <div class="text-muted cruise-category-description">
                    {!! $category->description !!}
                </div>
            @endif
        </div>
    </section>

    <section class=" pb-5">
        <div class="container">
            @php
                $firstVessel = $vessels->first();
                $bannerImage = $category->banner_image
                    ? asset('uploads/cruise-catalog/' . $category->banner_image)
                    : ($firstVessel && $firstVessel->cover_image
                        ? asset('uploads/cruise-catalog/' . $firstVessel->cover_image)
                        : asset('assets/frontend/assets/images/blogs/01.png'));
                $dynamicSectionTitle = $heroH2;
                $showBanner = $category->banner_image || $vessels->count() > 0;
            @endphp

            @if ($showBanner)
                <div class="cruise-category-banner mb-4">
                    <img src="{{ $bannerImage }}" alt="{{ $category->name }}" class="cruise-category-banner__image">
                    <div class="cruise-category-banner__overlay"></div>
                    <div class="cruise-category-banner__content">
                        <h2 class="cruise-category-banner__title mb-1">{{ $heroH1 }}</h2>
                        @if ($heroDescription)
                            <p class="cruise-category-banner__desc mb-0">{{ $heroDescription }}</p>
                        @endif
                    </div>
                </div>
            @endif

            @if ($vessels->count())
                <h2 class="cruise-dynamic-title mb-4">{{ $dynamicSectionTitle }}</h2>

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
                                        <span
                                            class="related-tour-price">${{ number_format((float) $vessel->price_tier_1, 0) }}</span>
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

        .cruise-category-banner {
            position: relative;
            border-radius: 18px;
            overflow: hidden;
            height: 560px;
            background: #0f2f5f;
            width: 100vw;
            margin-left: calc(50% - 50vw);
            margin-right: calc(50% - 50vw);
        }

        .cruise-category-banner__image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            object-position: center;
            display: block;
        }

        .cruise-category-banner__overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(12, 24, 44, .35) 0%, rgba(12, 24, 44, .68) 100%);
        }

        .cruise-category-banner__content {
            position: absolute;
            inset: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #fff;
            text-align: center;
            padding: 1rem;
        }

        .cruise-category-banner__tag {
            font-size: .75rem;
            font-weight: 700;
            letter-spacing: .08em;
            opacity: .9;
        }

        .cruise-category-banner__title {
            font-size: clamp(2.2rem, 3.8vw, 3.2rem);
            font-weight: 800;
            line-height: 1.15;
        }

        .cruise-category-banner__desc {
            max-width: 760px;
            font-size: .95rem;
            line-height: 1.5;
            opacity: .96;
        }

        @media (max-width: 991.98px) {
            .cruise-category-banner {
                height: 420px;
            }
        }

        @media (max-width: 575.98px) {
            .cruise-category-banner {
                height: 320px;
            }
        }

        .cruise-dynamic-title {
            color: #1d4ea3;
            font-size: clamp(1.6rem, 2.4vw, 2.4rem);
            font-weight: 800;
            line-height: 1.2;
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
