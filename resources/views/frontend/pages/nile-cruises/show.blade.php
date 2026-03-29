@extends('frontend.layouts.master')

@php
    $metaTitle = $experience->meta_title ?: $experience->title . ' - Nile Cruise Program';
    $metaDescription =
        $experience->meta_description ?:
        \Illuminate\Support\Str::limit(strip_tags($experience->short_description ?: $experience->description), 160);
    $metaKeywords = $experience->meta_keywords;
    $bannerPath = $experience->banner_image ? asset('uploads/cruise-experiences/' . $experience->banner_image) : null;
    $coverImageUrl = $bannerPath ?: asset('assets/frontend/assets/images/destination-01.png');
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)
@if ($metaKeywords)
    @section('meta_keywords', $metaKeywords)
@endif
@section('meta_image', $coverImageUrl)

@section('content')
    <main class="tours-page">
        <!-- Hero / Filters -->
        <section class="about-banner" id="about-intro" style="background-image: url('{{ $coverImageUrl }}');">
            <div class="about-banner-overlay"></div>
            <div class="container">
                <div class="about-banner-inner">
                    <h1 class="about-banner-title">{{ $experience->title }}</h1>
                    @php
                        $bannerSubtitle = $experience->short_description
                            ? \Illuminate\Support\Str::limit(strip_tags($experience->short_description), 160)
                            : null;
                    @endphp
                    @if ($bannerSubtitle)
                        <p class="about-banner-subtitle">{{ $bannerSubtitle }}</p>
                    @endif
                </div>
            </div>
        </section>

        <!-- Related Tours for this experience -->
        <section class="tours-section section-padding" id="egypt-tours">
            <div class="container">
                <div class="tours-section-header">
                    <div class="tours-section-heading">
                        <h2 class="section-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                            Signature <span class="highlight">{{ $experience->title }}</span>
                        </h2>
                    </div>
                    @php
                        $longDescription = $experience->description
                            ? \Illuminate\Support\Str::of($experience->description)->stripTags(
                                '<p><br><ul><ol><li><strong><em><b><i>',
                            )
                            : null;
                    @endphp
                    @if ($longDescription)
                        {{-- Full container width (not the narrow heading column) --}}
                        <div
                            class="tours-section-long-description scroll-animate"
                            data-animation="fadeInUp"
                            data-delay="100">
                            <div class="tours-section-prose">
                                {!! $longDescription !!}
                            </div>
                        </div>
                    @elseif ($bannerSubtitle)
                        <div class="tours-section-heading">
                            <p
                                class="section-description tours-section-prose tours-section-prose--short scroll-animate"
                                data-animation="fadeInUp"
                                data-delay="100">
                                {{ $bannerSubtitle }}
                            </p>
                        </div>
                    @endif
                </div>

                <div class="tours-grid" data-tours-grid>
                    @if ($relatedTours->count())
                        @foreach ($relatedTours as $index => $tour)
                            @php
                                $coverImage = $tour->cover_image
                                    ? asset('uploads/tours/' . $tour->cover_image)
                                    : asset('assets/frontend/assets/images/blogs/01.png');

                                $isOnSale = $tour->has_offer && $tour->isOfferActive();
                                $currentPrice =
                                    $isOnSale && $tour->price_after_discount
                                        ? $tour->price_after_discount
                                        : $tour->price;
                                $oldPrice =
                                    $isOnSale && $tour->price_before_discount ? $tour->price_before_discount : null;

                                $durationValue = (int) ($tour->duration ?? 0);
                                $durationText = $durationValue > 0 ? $durationValue . ' Days' : null;

                                $locations = [];
                                if ($tour->state) {
                                    $locations[] = $tour->state->name;
                                }
                                if ($tour->country) {
                                    $locations[] = $tour->country->name;
                                }
                                $locationText = implode(' · ', $locations);
                            @endphp
                            <article class="tours-card scroll-animate" data-tour="{{ $tour->id }}" data-type="egypt"
                                data-days="{{ $durationValue }}" data-price="{{ $currentPrice }}"
                                @if ($isOnSale) data-discount="1" @endif data-animation="fadeInUp"
                                data-delay="{{ $index * 100 }}">
                                <a href="{{ route('tours.show', $tour->slug) }}" class="tours-card-link-wrapper">
                                    <div class="tours-card-image">
                                        <img src="{{ $coverImage }}" alt="{{ $tour->title }}"
                                            onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73a6e?w=800&h=500&fit=crop';" />

                                        @if ($isOnSale)
                                            <span class="tours-card-badge badge-sale badge-right">On Sale</span>
                                        @endif
                                    </div>
                                    <div class="tours-card-body">
                                        <div class="tours-card-top">
                                            @if ($tour->category)
                                                <span class="tours-card-category">{{ $tour->category->name }}</span>
                                            @endif
                                        </div>
                                        <h3 class="tours-card-title">{{ $tour->title }}</h3>
                                        @if ($tour->short_description)
                                            <p class="tours-card-text">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($tour->short_description), 140) }}
                                            </p>
                                        @endif
                                        <div class="tours-card-meta">
                                            @if ($durationText)
                                                <span><i class="fa-regular fa-clock"></i> {{ $durationText }}</span>
                                            @endif
                                            @if ($locationText)
                                                <span><i class="fa-solid fa-location-dot"></i> {{ $locationText }}</span>
                                            @endif
                                        </div>
                                        <div class="tours-card-footer">
                                            <div class="tours-card-price">
                                                @if ($currentPrice !== null)
                                                    <span class="tours-card-price-label">From</span>
                                                    @if ($oldPrice)
                                                        <span
                                                            class="tours-card-price-old">${{ number_format($oldPrice, 0) }}</span>
                                                    @endif
                                                    <span
                                                        class="tours-card-price-main {{ $oldPrice ? 'tours-card-price-main-discount' : '' }}">
                                                        ${{ number_format($currentPrice, 0) }}
                                                    </span>
                                                    <span class="tours-card-price-note">per person</span>
                                                @endif
                                            </div>
                                            <span class="btn btn-primary btn-sm">View Details</span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    @else
                        <p class="text-center text-muted">No tours are linked to this cruise yet.</p>
                    @endif
                </div>

                @if ($relatedTours->hasPages())
                    <div class="mt-4 d-flex justify-content-center">
                        {{ $relatedTours->withQueryString()->links() }}
                    </div>
                @endif
            </div>
        </section>


        @if ($experience->faqs && $experience->faqs->isNotEmpty())
            <section class="faq-section section-padding my-3" id="faq">
                <div class="container">
                    <div class="section-header scroll-animate" data-animation="fadeInUp">

                        <h2 class="section-title">
                            Answers to <span class="highlight">Common Questions</span>
                        </h2>
                    </div>

                    <div class="faq-layout">
                        <div class="faq-list">
                            @foreach ($experience->faqs as $index => $faq)
                                <div class="faq-item scroll-animate" data-animation="fadeInUp"
                                    data-delay="{{ $index * 50 }}">
                                    <button class="faq-question" type="button">
                                        <span>{{ $faq->question }}</span>
                                        <i class="fa-solid fa-chevron-down"></i>
                                    </button>
                                    <div class="faq-answer">
                                        <p>
                                            {!! nl2br(e($faq->answer)) !!}
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        @endif

    </main>

@endsection

@push('css')
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #8b7138;
            border-radius: 10px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #7a6230;
        }

        .tours-card-link-wrapper {
            display: block;
            color: inherit;
            text-decoration: none;
        }

        .tours-card-price-main-discount {
            color: #F51D35;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .tours-card-price-old {
            color: #888;
            font-size: 0.9rem;
            text-decoration: line-through;
            margin-right: 6px;
        }
    </style>
@endpush

