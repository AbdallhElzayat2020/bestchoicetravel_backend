@extends('frontend.layouts.master')

@php
    $metaTitle = $experience->meta_title ?: $experience->title . ' - Nile Cruise Program';
    $metaDescription =
        $experience->meta_description ?:
        \Illuminate\Support\Str::limit(strip_tags($experience->short_description ?: $experience->description), 160);
    $metaKeywords = $experience->meta_keywords;
    $firstImage = $experience->images->first();
    $bannerPath = $experience->banner_image ? asset('uploads/cruise-experiences/' . $experience->banner_image) : null;
    $coverImageUrl =
        $bannerPath ?:
        ($firstImage
            ? asset('uploads/cruise-experiences/' . $firstImage->image)
            : asset('assets/frontend/assets/images/destination-01.png'));
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
                        @php
                            $longDescription = $experience->description
                                ? \Illuminate\Support\Str::of($experience->description)->stripTags(
                                    '<p><br><ul><ol><li><strong><em><b><i>',
                                )
                                : null;
                        @endphp
                        @if ($longDescription)
                            <div class="section-description scroll-animate" data-animation="fadeInUp" data-delay="100">
                                {!! $longDescription !!}
                            </div>
                        @elseif ($bannerSubtitle)
                            <p class="section-description scroll-animate" data-animation="fadeInUp" data-delay="100">
                                {{ $bannerSubtitle }}
                            </p>
                        @endif
                    </div>
                </div>

                @if ($experience->images->count())
                    <div class="tours-section-gallery scroll-animate mt-4" data-animation="fadeInUp" data-delay="150">
                        <div class="row g-3 justify-content-center">
                            @foreach ($experience->images as $image)
                                @php
                                    $imgSrc = asset('uploads/cruise-experiences/' . $image->image);
                                @endphp
                                <div class="col-6 col-md-3 col-lg-3">
                                    <button type="button" class="gallery-image-btn" data-img-src="{{ $imgSrc }}"
                                        aria-label="Open image">
                                        <div class="gallery-image-inner">
                                            <img src="{{ $imgSrc }}" alt="{{ $experience->title }} image"
                                                class="img-fluid w-100 gallery-image">
                                            <div class="gallery-image-overlay">
                                                <span class="gallery-image-icon">
                                                    <i class="fa-solid fa-eye"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

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


        <section class="faq-section section-padding my-3" id="faq">
            <div class="container">
                <div class="section-header scroll-animate" data-animation="fadeInUp">

                    <h2 class="section-title">
                        Answers to <span class="highlight">Common Questions</span>
                    </h2>
                </div>

                <div class="faq-layout">
                    <div class="faq-list">
                        @if ($experience->faqs && $experience->faqs->count())
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
                        @else
                            <p class="text-center text-muted mt-3">No FAQs available for this cruise yet.</p>
                        @endif
                    </div>
                </div>
            </div>
        </section>

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

        .tours-section-gallery .col-6 {
            display: flex;
            justify-content: center;
        }

        .tours-section-gallery .gallery-image-btn {
            padding: 0;
            border: none;
            background: transparent;
            cursor: pointer;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .tours-section-gallery .gallery-image-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.25);
        }

        .tours-section-gallery .gallery-image-inner {
            position: relative;
            width: 100%;
            border-radius: 12px;
            overflow: hidden;
        }

        .tours-section-gallery .gallery-image-inner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            aspect-ratio: 16 / 9;
            transition: filter 0.2s ease;
        }

        .tours-section-gallery .gallery-image-overlay {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(0, 0, 0, 0.35);
            opacity: 0;
            transition: opacity 0.2s ease;
        }

        .tours-section-gallery .gallery-image-icon {
            width: 44px;
            height: 44px;
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.95);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #8b7138;
            font-size: 20px;
        }

        .tours-section-gallery .gallery-image-btn:hover .gallery-image-inner img {
            filter: blur(1.5px) brightness(0.75);
        }

        .tours-section-gallery .gallery-image-btn:hover .gallery-image-overlay {
            opacity: 1;
        }

        .experience-lightbox {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1050;
        }

        .experience-lightbox.open {
            display: flex;
        }

        .experience-lightbox-backdrop {
            position: absolute;
            inset: 0;
            background: rgba(0, 0, 0, 0.9);
        }

        .experience-lightbox-dialog {
            position: relative;
            z-index: 1;
            max-width: 95vw;
            max-height: 95vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .experience-lightbox-image {
            max-width: 95vw;
            max-height: 95vh;
            object-fit: contain;
            border-radius: 12px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
        }

        .experience-lightbox-close {
            position: absolute;
            top: -40px;
            right: -10px;
            width: 32px;
            height: 32px;
            border-radius: 999px;
            border: none;
            background: rgba(255, 255, 255, 0.9);
            color: #000;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
        }

        @media (max-width: 768px) {
            .experience-lightbox-close {
                top: 12px;
                right: 12px;
            }
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

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buttons = document.querySelectorAll('.gallery-image-btn');
            if (!buttons.length) return;

            let lightbox = document.getElementById('experienceLightbox');
            if (!lightbox) {
                const wrapper = document.createElement('div');
                wrapper.id = 'experienceLightbox';
                wrapper.className = 'experience-lightbox';
                wrapper.innerHTML = `
                    <div class="experience-lightbox-backdrop"></div>
                    <div class="experience-lightbox-dialog">
                        <button type="button" class="experience-lightbox-close" aria-label="Close">&times;</button>
                        <img src="" alt="Preview" class="experience-lightbox-image">
                    </div>
                `;
                document.body.appendChild(wrapper);
                lightbox = wrapper;
            }

            const lightboxImg = lightbox.querySelector('.experience-lightbox-image');
            const lightboxClose = lightbox.querySelector('.experience-lightbox-close');
            const lightboxBackdrop = lightbox.querySelector('.experience-lightbox-backdrop');

            const openLightbox = (src, alt) => {
                if (!src) return;
                lightboxImg.src = src;
                lightboxImg.alt = alt || 'Preview';
                lightbox.classList.add('open');
                document.body.classList.add('modal-open');
            };

            const closeLightbox = () => {
                lightbox.classList.remove('open');
                document.body.classList.remove('modal-open');
            };

            lightboxClose.addEventListener('click', closeLightbox);
            lightboxBackdrop.addEventListener('click', closeLightbox);
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && lightbox.classList.contains('open')) {
                    closeLightbox();
                }
            });

            buttons.forEach((btn) => {
                btn.addEventListener('click', () => {
                    const src = btn.dataset.imgSrc;
                    const img = btn.querySelector('img');
                    openLightbox(src, img ? img.alt : '');
                });
            });
        });
    </script>
@endpush
