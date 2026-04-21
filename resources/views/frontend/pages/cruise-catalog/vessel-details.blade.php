@extends('frontend.layouts.master')

@php
    $metaTitle = $vessel->meta_title ?: $vessel->title;
    $metaDescription =
        $vessel->meta_description ?:
        ($vessel->short_description
            ? \Illuminate\Support\Str::limit(strip_tags($vessel->short_description), 160)
            : 'Discover this cruise vessel and its available programs.');
    $metaImage = $vessel->cover_image ? asset('uploads/cruise-catalog/' . $vessel->cover_image) : null;

    $galleryImages = collect();
    if ($vessel->cover_image) {
        $galleryImages->push([
            'src' => asset('uploads/cruise-catalog/' . $vessel->cover_image),
            'alt' => $vessel->title . ' cover',
        ]);
    }
    foreach ($vessel->images as $image) {
        $galleryImages->push([
            'src' => asset('uploads/cruise-catalog/' . $image->image_path),
            'alt' => $image->alt ?: $vessel->title . ' image',
        ]);
    }
@endphp

@section('meta_title', $metaTitle)
@if ($metaDescription)
    @section('meta_description', $metaDescription)
@endif
@if ($vessel->meta_keywords)
    @section('meta_keywords', $vessel->meta_keywords)
@endif
@if ($metaImage)
    @section('meta_image', $metaImage)
@endif

@section('content')
    <main class="tour-page">


        <section class="tour-hero section-padding">
            <div class="container">
                <div class="tour-hero-header row g-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="tour-title scroll-animate" data-animation="fadeInUp" data-delay="50">{{ $vessel->title }}
                        </h1>
                    </div>
                </div>

                <div class="tour-main-layout row g-4">
                    <div class="col-lg-8">
                        <div class="tour-gallery scroll-animate" data-animation="fadeInUp" data-delay="250">
                            @php
                                $hasGalleryImages = $galleryImages->count() > 0;
                                $fallbackCover = $vessel->cover_image
                                    ? asset('uploads/cruise-catalog/' . $vessel->cover_image)
                                    : asset('assets/frontend/assets/images/blogs/01.png');
                            @endphp

                            @if ($hasGalleryImages)
                                <div class="row g-3 g-lg-4 tour-gallery-row align-items-stretch">
                                    <div class="col-md-8 tour-gallery-col-main">
                                        <div class="swiper tour-gallery-main">
                                            <div class="swiper-wrapper">
                                                @foreach ($galleryImages as $image)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}"
                                                            loading="lazy" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="tour-gallery-main-nav">
                                                <div class="tour-gallery-prev"></div>
                                                <div class="tour-gallery-next"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4 tour-gallery-col-thumbs">
                                        <div class="swiper tour-gallery-thumbs">
                                            <div class="swiper-wrapper">
                                                @foreach ($galleryImages as $image)
                                                    <div class="swiper-slide">
                                                        <img src="{{ $image['src'] }}" alt="{{ $image['alt'] }}"
                                                            loading="lazy" />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="row g-3 g-lg-4 tour-gallery-row align-items-stretch">
                                    <div class="col-md-8 tour-gallery-col-main">
                                        <div class="tour-gallery-single">
                                            <img src="{{ $fallbackCover }}" alt="{{ $vessel->title }}" loading="lazy" />
                                        </div>
                                    </div>
                                    <div class="col-md-4 tour-gallery-col-thumbs">
                                        <div class="d-grid gap-2">
                                            @for ($i = 0; $i < 3; $i++)
                                                <div class="tour-gallery-thumb">
                                                    <img src="{{ $fallbackCover }}" alt="{{ $vessel->title }}"
                                                        loading="lazy" />
                                                </div>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="tour-intro-text scroll-animate mt-4" data-animation="fadeInUp" data-delay="350">
                            <h2>About this vessel</h2>
                            @if ($vessel->description)
                                {!! $vessel->description !!}
                            @elseif($vessel->short_description)
                                <p>{{ $vessel->short_description }}</p>
                            @else
                                <p>Discover this vessel and plan your next Nile cruise experience.</p>
                            @endif
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <aside class="tour-booking-card scroll-animate" id="booking" data-animation="fadeInUp"
                            data-delay="300">
                            @php
                                $basePrice = (float) $vessel->price_tier_1;
                            @endphp
                            <div class="tour-booking-price-strip">
                                <span class="tour-booking-from">From</span>
                                <span class="tour-booking-new"
                                    id="tour-booking-per-person">${{ number_format($basePrice, 0) }}</span>
                                <span class="tour-booking-per">per person</span>
                            </div>
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show tour-booking-flash mb-3"
                                    role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger tour-booking-flash mb-3" role="alert">
                                    <strong>Could not submit enquiry.</strong>
                                    <ul class="mb-0 mt-1 ps-3 small">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="tour-booking-form" id="vessel-booking-form"
                                action="{{ route('cruise-catalog.enquiry', [$category->slug, $vessel->slug]) }}"
                                method="POST" novalidate>
                                @csrf
                                <input type="hidden" id="base-vessel-price" value="{{ $basePrice }}">
                                <input type="hidden" id="total-price-input" name="total_price"
                                    value="{{ old('total_price', $basePrice) }}">

                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="full_name">Full Name</label>
                                    <input type="text" id="full_name" name="full_name"
                                        class="form-control @error('full_name') is-invalid @enderror"
                                        placeholder="Full name" value="{{ old('full_name') }}" autocomplete="name" />
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        placeholder="you@example.com" value="{{ old('email') }}" autocomplete="email"
                                        inputmode="email" />
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="tel" id="phone" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        placeholder="+20 123 456 7890" value="{{ old('phone') }}" autocomplete="tel" />
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="nationality">Nationality</label>
                                    <input type="text" id="nationality" name="nationality"
                                        class="form-control @error('nationality') is-invalid @enderror"
                                        placeholder="e.g. Egyptian, Italian" value="{{ old('nationality') }}"
                                        autocomplete="country-name" />
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="no_of_travellers">No. of Travellers</label>
                                    <input type="number" id="no_of_travellers" name="no_of_travellers"
                                        class="form-control @error('no_of_travellers') is-invalid @enderror"
                                        min="1" step="1" value="{{ old('no_of_travellers', 1) }}"
                                        inputmode="numeric" />
                                </div>
                                @if (!empty($recaptchaSiteKey ?? null))
                                    <div class="g-recaptcha mb-2" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                                @endif
                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    Submit Enquiry
                                </button>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <section class="tour-details section-padding">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="tour-expect-card">
                            <h2 class="tour-expect-title">Cruise Programs & Itinerary</h2>
                            @if ($vessel->programs->isNotEmpty())
                                <ul class="nav nav-pills vessel-program-tabs mb-4" id="vesselProgramTabs" role="tablist">
                                    @foreach ($vessel->programs as $program)
                                        <li class="nav-item" role="presentation">
                                            <button class="nav-link @if ($loop->first) active @endif"
                                                id="program-tab-{{ $program->id }}" data-bs-toggle="tab"
                                                data-bs-target="#program-pane-{{ $program->id }}" type="button"
                                                role="tab" aria-controls="program-pane-{{ $program->id }}"
                                                aria-selected="{{ $loop->first ? 'true' : 'false' }}">
                                                {{ $program->duration_days ?: 0 }} Days - {{ $program->title }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content" id="vesselProgramTabsContent">
                                    @foreach ($vessel->programs as $program)
                                        <div class="tab-pane fade @if ($loop->first) show active @endif"
                                            id="program-pane-{{ $program->id }}" role="tabpanel"
                                            aria-labelledby="program-tab-{{ $program->id }}">
                                            @php
                                                $programDays = $program->days->where('day_status', 'active')->values();
                                            @endphp
                                            @if ($programDays->isNotEmpty())
                                                <div class="vessel-days-list">
                                                    @foreach ($programDays as $day)
                                                        <div class="vessel-day-item mb-2">
                                                            <button
                                                                class="btn vessel-day-trigger w-100 text-start d-flex justify-content-between align-items-center"
                                                                type="button" data-bs-toggle="collapse"
                                                                data-bs-target="#day-{{ $program->id }}-{{ $day->id }}"
                                                                aria-expanded="false"
                                                                aria-controls="day-{{ $program->id }}-{{ $day->id }}">
                                                                <span><strong>Day {{ $day->day_number }}:</strong>
                                                                    {{ $day->day_title }}</span>
                                                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                                            </button>
                                                            <div class="collapse"
                                                                id="day-{{ $program->id }}-{{ $day->id }}">
                                                                <div class="vessel-day-content">
                                                                    @if (!empty($day->details))
                                                                        {!! $day->details !!}
                                                                    @else
                                                                        <p class="mb-0 text-muted">No details available for
                                                                            this day yet.</p>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <p class="text-muted mb-0">No days available for this program yet.</p>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-muted mb-0">No programs linked to this vessel yet.</p>
                            @endif
                        </div>
                    </div>

                </div>
            </div>
        </section>

        {{-- <section class="tour-related section-padding">
            <div class="container">
                <div class="section-header scroll-animate" data-animation="fadeInUp">
                    <div class="section-label">
                        <span class="star-icon">✦</span>
                        <span>RELATED VESSELS</span>
                        <span class="star-icon">✦</span>
                    </div>
                    <h2 class="section-title">You May Also <span class="highlight">Like</span></h2>
                </div>
                <div class="row g-4">
                    @forelse ($relatedVessels as $related)
                        @php
                            $relatedCover = $related->cover_image
                                ? asset('uploads/cruise-catalog/' . $related->cover_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');
                        @endphp
                        <div class="col-md-4">
                            <a href="{{ route('cruise-catalog.vessel', [$category->slug, $related->slug]) }}" class="related-tour-card">
                                <div class="related-tour-image">
                                    <img src="{{ $relatedCover }}" alt="{{ $related->title }}" loading="lazy" />
                                    <div class="category-badge">{{ strtoupper($category->name) }}</div>
                                </div>
                                <div class="related-tour-body">
                                    <h3 class="related-tour-title">{{ $related->title }}</h3>
                                    <div class="related-tour-price-row">
                                        <span class="related-tour-price-label">From</span>
                                        <span class="related-tour-price">${{ number_format((float) $related->price_tier_1, 0) }}</span>
                                        <span class="related-tour-price-unit">/ person</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted mb-0">No related vessels found in this category yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section> --}}
    </main>

    <div class="tour-lightbox-modal" id="tourLightbox" aria-hidden="true">
        <div class="tour-lightbox-backdrop" id="tourLightboxBackdrop"></div>
        <div class="tour-lightbox-dialog" role="dialog" aria-modal="true" aria-labelledby="tourLightboxTitle">
            <button class="tour-lightbox-close" id="tourLightboxClose" aria-label="Close gallery">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="tour-lightbox-content">
                <img id="tourLightboxImage" src="" alt="Vessel image preview">
            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .vessel-program-tabs {
            gap: .5rem;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding-bottom: .25rem;
        }

        .vessel-program-tabs .nav-link {
            border-radius: 999px;
            border: 1px solid #e7edf7;
            background: #fff;
            color: #3f4d67;
            font-weight: 700;
            white-space: nowrap;
        }

        .vessel-program-tabs .nav-link.active {
            background: #f4a81c;
            border-color: #f4a81c;
            color: #fff;
        }

        .vessel-day-trigger {
            border: 1px solid #edf2f8;
            border-radius: 14px;
            background: #fff;
            color: #24476d;
            font-weight: 700;
            padding: 1rem 1.25rem;
        }

        .vessel-day-content {
            border: 1px solid #edf2f8;
            border-top: 0;
            border-radius: 0 0 14px 14px;
            padding: .9rem 1.2rem;
            color: #4a5568;
            background: #fcfdff;
        }
    </style>
@endpush

@push('scripts')
    @if (!empty($recaptchaSiteKey ?? null))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const basePrice = parseFloat(document.getElementById('base-vessel-price')?.value || '0') || 0;
            const travellersInput = document.getElementById('no_of_travellers');
            const totalPriceElement = document.getElementById('total-price');
            const perPersonPriceElement = document.getElementById('tour-booking-per-person');
            const totalInput = document.getElementById('total-price-input');

            function updateTotals() {
                const travellers = Math.max(1, parseInt(travellersInput?.value || '1', 10) || 1);
                const total = basePrice * travellers;
                if (totalPriceElement) totalPriceElement.textContent = '$' + Math.round(total).toLocaleString();
                if (perPersonPriceElement) perPersonPriceElement.textContent = '$' + Math.round(basePrice)
                    .toLocaleString();
                if (totalInput) totalInput.value = total.toFixed(2);
            }

            travellersInput?.addEventListener('input', function() {
                if ((parseInt(this.value || '1', 10) || 1) < 1) this.value = 1;
                updateTotals();
            });
            updateTotals();

            if (typeof Swiper !== 'undefined') {
                const thumbsEl = document.querySelector('.tour-gallery-thumbs');
                const mainEl = document.querySelector('.tour-gallery-main');

                if (thumbsEl && mainEl) {
                    const thumbs = new Swiper(thumbsEl, {
                        spaceBetween: 12,
                        slidesPerView: 4,
                        watchSlidesProgress: true,
                        breakpoints: {
                            0: {
                                direction: 'horizontal'
                            },
                            768: {
                                direction: 'vertical'
                            }
                        }
                    });

                    new Swiper(mainEl, {
                        spaceBetween: 12,
                        navigation: {
                            nextEl: '.tour-gallery-next',
                            prevEl: '.tour-gallery-prev',
                        },
                        thumbs: {
                            swiper: thumbs
                        }
                    });
                }
            }

            const lightbox = document.getElementById('tourLightbox');
            const lightboxImage = document.getElementById('tourLightboxImage');
            const closeBtn = document.getElementById('tourLightboxClose');
            const backdrop = document.getElementById('tourLightboxBackdrop');
            const galleryImages = document.querySelectorAll('.tour-gallery-main img, .tour-gallery-single img');

            function closeLightbox() {
                if (!lightbox) return;
                lightbox.classList.remove('is-open');
                lightbox.setAttribute('aria-hidden', 'true');
            }

            galleryImages.forEach(img => {
                img.style.cursor = 'zoom-in';
                img.addEventListener('click', function() {
                    if (!lightbox || !lightboxImage) return;
                    lightboxImage.src = this.src;
                    lightboxImage.alt = this.alt || 'Vessel image';
                    lightbox.classList.add('is-open');
                    lightbox.setAttribute('aria-hidden', 'false');
                });
            });

            closeBtn?.addEventListener('click', closeLightbox);
            backdrop?.addEventListener('click', closeLightbox);
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') closeLightbox();
            });
        });
    </script>
@endpush
