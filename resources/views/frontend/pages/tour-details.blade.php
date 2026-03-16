@extends('frontend.layouts.master')
@php
    $metaTitle = $tour->meta_title ?? $tour->title;
    $metaDescription =
        $tour->meta_description ??
        ($tour->short_description
            ? \Illuminate\Support\Str::limit(strip_tags($tour->short_description), 160)
            : 'Discover amazing tours and travel experiences. Book your next adventure with us.');
    $metaImage = $tour->cover_image ? asset('uploads/tours/' . $tour->cover_image) : null;
@endphp
@section('meta_title', $metaTitle)
@if ($metaDescription)
    @section('meta_description', $metaDescription)
@endif
@if ($tour->meta_keywords)
    @section('meta_keywords', $tour->meta_keywords)
@endif
@if ($metaImage)
    @section('meta_image', $metaImage)
@endif

@section('content')
    <!-- Tour Hero + Gallery + Booking -->
    <main class="tour-page">
        <section class="tour-hero section-padding">
            <div class="container">
                <div class="tour-breadcrumb scroll-animate" data-animation="fadeInUp">
                    <a href="index.html#home">Home</a>
                    <span>/</span>
                    <a href="index.html#packages">Packages</a>
                    <span>/</span>
                    <span>Classic Pyramids &amp; Cairo Highlights</span>
                </div>

                <div class="tour-hero-header row g-4 align-items-center">
                    <div class="col-lg-8">
                        <h1 class="tour-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                            Classic Pyramids &amp; Cairo Highlights
                        </h1>
                        <div class="tour-meta scroll-animate" data-animation="fadeInUp" data-delay="150">
                            <div class="tour-meta-item">
                                <i class="fa-solid fa-location-dot"></i>
                                <span>Giza &amp; Cairo, Egypt</span>
                            </div>
                            <div class="tour-meta-item">
                                <i class="fa-solid fa-clock"></i>
                                <span>3 Days / 2 Nights</span>
                            </div>
                            <div class="tour-meta-item">
                                <i class="fa-solid fa-star text-warning"></i>
                                <span>4.9 (124 reviews)</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tour-main-layout row g-4">
                    <!-- Gallery + short description -->
                    <div class="col-lg-8">
                        <div class="tour-gallery scroll-animate" data-animation="fadeInUp" data-delay="250">
                            @php
                                $galleryImages = $tour->tourImages ?? collect();
                                $hasGalleryImages = $galleryImages->count() > 0;
                                $fallbackCover = $tour->cover_image
                                    ? asset('uploads/tours/' . $tour->cover_image)
                                    : asset('assets/frontend/assets/images/blogs/01.png');
                            @endphp

                            <div class="row g-3 align-items-stretch">
                                <div class="col-md-8">
                                    @if ($hasGalleryImages)
                                        <div class="swiper tour-gallery-main">
                                            <div class="swiper-wrapper">
                                                @foreach ($galleryImages as $image)
                                                    @php
                                                        $imageUrl = asset('uploads/tours/' . $image->image);
                                                        $imageAlt = $image->alt ?: $tour->title . ' image ' . $loop->iteration;
                                                    @endphp
                                                    <div class="swiper-slide">
                                                        <img src="{{ $imageUrl }}" alt="{{ $imageAlt }}" />
                                                    </div>
                                                @endforeach
                                            </div>
                                            <div class="tour-gallery-main-nav">
                                                <div class="tour-gallery-prev"></div>
                                                <div class="tour-gallery-next"></div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="tour-gallery-single">
                                            <img src="{{ $fallbackCover }}" alt="{{ $tour->title }}" class="img-fluid w-100" />
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4">
                                    @if ($hasGalleryImages)
                                        <div class="swiper tour-gallery-thumbs">
                                            <div class="swiper-wrapper">
                                                @foreach ($galleryImages as $image)
                                                    @php
                                                        $thumbUrl = asset('uploads/tours/' . $image->image);
                                                        $thumbAlt = $image->alt ?: $tour->title . ' thumbnail ' . $loop->iteration;
                                                    @endphp
                                                    <div class="swiper-slide">
                                                        <img src="{{ $thumbUrl }}" alt="{{ $thumbAlt }}" />
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Text description under gallery -->
                        <div class="tour-intro-text scroll-animate mt-4" data-animation="fadeInUp" data-delay="350">
                            <h2>About this experience</h2>
                            <p>
                                Spend three unforgettable days between the ancient wonders of the Giza Plateau and the
                                vibrant streets of modern Cairo. This curated itinerary combines must‑see highlights
                                with carefully chosen moments to slow down, enjoy the view, and connect with Egypt’s
                                culture, food, and people.
                            </p>
                            <p>
                                Perfect for first‑time visitors and returning travellers who want a seamless,
                                well‑organized introduction to Cairo with expert local support from the moment you
                                arrive.
                            </p>
                        </div>
                    </div>

                    <!-- Booking card -->
                    <div class="col-lg-4">
                        <aside class="tour-booking-card scroll-animate" id="booking" data-animation="fadeInUp"
                            data-delay="300">
                            @php
                                $basePrice = $tour->current_price ?? $tour->price ?? 0;
                                $hasOffer = $tour->has_offer && $tour->isOfferActive();
                                $oldPrice = $hasOffer && $tour->price_before_discount ? $tour->price_before_discount : null;
                                $displayPrice = $basePrice;
                            @endphp
                            <div class="tour-booking-price-strip">
                                <span class="tour-booking-from">From</span>
                                @if ($oldPrice)
                                    <span class="tour-booking-old">${{ number_format($oldPrice, 0) }}</span>
                                @endif
                                <span class="tour-booking-new" id="tour-booking-per-person">${{ number_format($displayPrice, 0) }}</span>
                                <span class="tour-booking-per">per person</span>
                            </div>
                            <form class="tour-booking-form" id="booking-form">
                                <input type="hidden" id="base-tour-price" name="base_tour_price" value="{{ $basePrice }}">
                                <input type="hidden" id="total-price-input" name="total_price" value="">
                                <input type="hidden" id="selected-variants" name="selected_variants" value="[]">
                                <div class="mb-2">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" id="full_name" name="full_name" class="form-control" placeholder="Full name" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" placeholder="you@example.com" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Phone</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" placeholder="+20 123 456 7890" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Nationality</label>
                                    <input type="text" id="nationality" name="nationality" class="form-control" placeholder="e.g. Egyptian, Italian" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">No. of Travellers</label>
                                    <input type="number" id="no_of_travellers" name="no_of_travellers" class="form-control" min="1" value="1" />
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Extra Options</label>
                                    <div class="tour-extras-list">
                                        @forelse ($tour->variants ?? [] as $variant)
                                            @php $addPrice = (float) ($variant->additional_price ?? 0); @endphp
                                            <label class="form-check">
                                                <input class="form-check-input variant-checkbox" type="checkbox" name="extra_options[]"
                                                    value="{{ $variant->id }}"
                                                    data-price="{{ $addPrice }}"
                                                    data-title="{{ $variant->title }}">
                                                <span class="form-check-label">{{ $variant->title }} (${{ number_format($addPrice, 0) }})</span>
                                            </label>
                                        @empty
                                            <p class="text-muted small mb-0">No extra options for this tour.</p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="tour-booking-summary">
                                    <div id="tour-booking-breakdown" class="tour-booking-breakdown mb-2 small text-muted"></div>
                                    <div class="tour-booking-row tour-booking-total">
                                        <span>Total:</span>
                                        <span id="total-price">${{ number_format($basePrice, 0) }}</span>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-100 mt-2">
                                    Booking Now
                                </button>
                            </form>
                        </aside>
                    </div>
                </div>
            </div>
        </section>

        <!-- Itinerary & Details -->
        <section class="tour-details section-padding">
            <div class="container">
                <div class="row g-5">
                    <div class="col-lg-7">
                        <div class="tour-expect-card">
                            <h2 class="tour-expect-title">What To Expect</h2>

                            <div class="tour-day">
                                <div class="tour-day-number">1</div>
                                <div class="tour-day-body">
                                    <h3 class="tour-day-title">Welcome to Cairo &amp; Giza</h3>
                                    <p>
                                        Arrival in Cairo and transfer to your hotel. In the afternoon, head to the
                                        Giza Plateau for your first breathtaking view of the Great Pyramids and the
                                        Sphinx, followed by a sunset photo stop in the desert.
                                    </p>
                                    <ul>
                                        <li>Airport meet &amp; greet and private transfer</li>
                                        <li>Guided visit to the Pyramids &amp; Sphinx</li>
                                        <li>Welcome dinner overlooking the city</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tour-day">
                                <div class="tour-day-number">2</div>
                                <div class="tour-day-body">
                                    <h3 class="tour-day-title">Egyptian Museum &amp; Old Cairo</h3>
                                    <p>
                                        Dive deeper into Egypt’s history at the Egyptian Museum, then wander through
                                        the lanes of Old Cairo and Khan El‑Khalili bazaar with time for coffee,
                                        souvenirs, and street photography.
                                    </p>
                                    <ul>
                                        <li>Guided tour of key Museum highlights</li>
                                        <li>Visit Old Cairo &amp; historic mosques</li>
                                        <li>Optional evening Nile dinner cruise</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="tour-day">
                                <div class="tour-day-number">3</div>
                                <div class="tour-day-body">
                                    <h3 class="tour-day-title">Last Views &amp; Departure</h3>
                                    <p>
                                        Enjoy a relaxed breakfast and some final views of Cairo before your private
                                        transfer to the airport, or extend your adventure with a Red Sea or Nile
                                        cruise add‑on.
                                    </p>
                                    <ul>
                                        <li>Breakfast at the hotel</li>
                                        <li>Free time for last‑minute shopping</li>
                                        <li>Private transfer to Cairo Airport</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <div class="tour-facts-card">
                            <h3>Tour Details</h3>
                            <dl>
                                <div class="tour-fact-row">
                                    <dt>Category</dt>
                                    <dd>City &amp; Culture</dd>
                                </div>
                                <div class="tour-fact-row">
                                    <dt>Duration</dt>
                                    <dd>3 Days / 2 Nights</dd>
                                </div>
                                <div class="tour-fact-row">
                                    <dt>Departure</dt>
                                    <dd>Daily from Cairo</dd>
                                </div>
                            </dl>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Related Tours -->
        <section class="tour-related section-padding">
            <div class="container">
                <div class="section-header scroll-animate" data-animation="fadeInUp">
                    <div class="section-label">
                        <span class="star-icon">✦</span>
                        <span>RELATED TOURS</span>
                        <span class="star-icon">✦</span>
                    </div>
                    <h2 class="section-title">
                        You May Also <span class="highlight">Like</span>
                    </h2>
                </div>
                <div class="row g-4">
                    @forelse ($relatedTours as $relatedTour)
                        @php
                            $relatedCover = $relatedTour->cover_image
                                ? asset('uploads/tours/' . $relatedTour->cover_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');

                            $isOnSale = $relatedTour->has_offer && $relatedTour->isOfferActive();
                            $currentPrice =
                                $isOnSale && $relatedTour->price_after_discount
                                    ? $relatedTour->price_after_discount
                                    : $relatedTour->price;
                            $oldPrice =
                                $isOnSale && $relatedTour->price_before_discount
                                    ? $relatedTour->price_before_discount
                                    : null;

                            $durationValue = (int) ($relatedTour->duration ?? 0);
                            $durationText = $durationValue > 0 ? $durationValue . ' Days' : null;

                            $locationParts = [];
                            if ($relatedTour->state) {
                                $locationParts[] = $relatedTour->state->name;
                            }
                            if ($relatedTour->country) {
                                $locationParts[] = $relatedTour->country->name;
                            }
                            $location = implode(' · ', $locationParts);
                        @endphp

                        <div class="col-md-4">
                            <a href="{{ route('tours.show', $relatedTour->slug) }}" class="related-tour-card">
                                <div class="related-tour-image">
                                    <img src="{{ $relatedCover }}" alt="{{ $relatedTour->title }}" loading="lazy" />
                                    @if ($location)
                                        <div class="location-badge">
                                            <span class="pin-icon">📍</span>
                                            <span>{{ strtoupper($location) }}</span>
                                        </div>
                                    @endif
                                    @if ($relatedTour->category)
                                        <div class="category-badge">
                                            {{ strtoupper($relatedTour->category->name) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="related-tour-body">
                                    <h3 class="related-tour-title">{{ $relatedTour->title }}</h3>
                                    <div class="related-tour-meta">
                                        @if ($durationText)
                                            <span><i class="fa-regular fa-clock"></i> {{ $durationText }}</span>
                                        @endif
                                        @if ($location)
                                            <span><i class="fa-solid fa-location-dot"></i> {{ $location }}</span>
                                        @endif
                                    </div>
                                    <div class="related-tour-price-row">
                                        <span class="related-tour-price-label">From</span>
                                        @if ($oldPrice)
                                            <span class="related-tour-price related-tour-price-old">
                                                ${{ number_format($oldPrice, 0) }}
                                            </span>
                                        @endif
                                        @if ($currentPrice !== null)
                                            <span
                                                class="related-tour-price {{ $oldPrice ? 'related-tour-price-main-discount' : '' }}">
                                                ${{ number_format($currentPrice, 0) }}
                                            </span>
                                        @endif
                                        <span class="related-tour-price-unit">/ person</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-center text-muted mb-0">
                                No related tours found in this category yet.
                            </p>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>
    </main>

    <!-- Tour Gallery Lightbox Modal -->
    <div class="tour-lightbox-modal" id="tourLightbox" aria-hidden="true">
        <div class="tour-lightbox-backdrop" id="tourLightboxBackdrop"></div>
        <div class="tour-lightbox-dialog" role="dialog" aria-modal="true" aria-labelledby="tourLightboxTitle">
            <button class="tour-lightbox-close" id="tourLightboxClose" aria-label="Close gallery">
                <i class="fa-solid fa-xmark"></i>
            </button>
            <div class="tour-lightbox-content">
                <img id="tourLightboxImage" src="" alt="Tour image preview">
            </div>
        </div>
    </div>
@endsection





@push('js')
    @if (!empty($recaptchaSiteKey ?? null))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Parse price from string (handles "450", "1,950", "45.50")
            function parsePrice(val) {
                if (val === null || val === undefined || val === '') return 0;
                const str = String(val).replace(/,/g, '').trim();
                const n = parseFloat(str);
                return isNaN(n) ? 0 : n;
            }

            const baseTourPrice = parsePrice(document.getElementById('base-tour-price')?.value);

            const variantCheckboxes = document.querySelectorAll('.variant-checkbox');
            const accommodationSelect = document.getElementById('accommodation_type');
            const totalPriceElement = document.getElementById('total-price');
            const perPersonPriceElement = document.getElementById('tour-booking-per-person');
            const breakdownElement = document.getElementById('tour-booking-breakdown');
            const noOfTravellersInput = document.getElementById('no_of_travellers');

            function calculateTotal() {
                const noOfTravellers = Math.max(1, parseInt(noOfTravellersInput?.value || 1, 10) || 1);

                let pricePerPerson = baseTourPrice;

                if (accommodationSelect && accommodationSelect.value) {
                    const selectedOption = accommodationSelect.options[accommodationSelect.selectedIndex];
                    pricePerPerson += parsePrice(selectedOption.getAttribute('data-price'));
                }

                const selectedExtras = [];
                variantCheckboxes.forEach(function(checkbox) {
                    if (checkbox.checked) {
                        const p = parsePrice(checkbox.getAttribute('data-price'));
                        pricePerPerson += p;
                        selectedExtras.push({
                            title: checkbox.getAttribute('data-title') || 'Extra',
                            price: p
                        });
                    }
                });

                const total = pricePerPerson * noOfTravellers;

                if (perPersonPriceElement) {
                    perPersonPriceElement.textContent = '$' + Math.round(pricePerPerson).toLocaleString();
                }
                if (totalPriceElement) {
                    totalPriceElement.textContent = '$' + Math.round(total).toLocaleString();
                }

                if (breakdownElement) {
                    const parts = [];
                    parts.push('Base: $' + Math.round(baseTourPrice * noOfTravellers).toLocaleString());
                    selectedExtras.forEach(function(extra) {
                        const lineTotal = extra.price * noOfTravellers;
                        parts.push(extra.title + ': $' + Math.round(lineTotal).toLocaleString());
                    });
                    breakdownElement.innerHTML = parts.join(' &bull; ');
                    breakdownElement.style.display = parts.length > 1 ? 'block' : 'none';
                }

                const totalPriceInput = document.getElementById('total-price-input');
                if (totalPriceInput) totalPriceInput.value = total;

                const accommodationTypeIdInput = document.getElementById('accommodation-type-id');
                if (accommodationTypeIdInput) {
                    accommodationTypeIdInput.value = (accommodationSelect && accommodationSelect.value) ? accommodationSelect.value : '';
                }

                const selectedVariantsInput = document.getElementById('selected-variants');
                if (selectedVariantsInput) {
                    const ids = [];
                    variantCheckboxes.forEach(function(cb) { if (cb.checked) ids.push(cb.value); });
                    selectedVariantsInput.value = JSON.stringify(ids);
                }
            }


            // Event listeners

            variantCheckboxes.forEach(function(checkbox) {
                checkbox.addEventListener('change', calculateTotal);
            });

            if (accommodationSelect) {
                accommodationSelect.addEventListener('change', function() {
                    calculateTotal();
                    // Update accommodation type id when changed
                    const accommodationTypeIdInput = document.getElementById('accommodation-type-id');
                    if (accommodationTypeIdInput) {
                        accommodationTypeIdInput.value = accommodationSelect.value || '';
                    }
                });
            }

            // Listen to number of travellers changes
            if (noOfTravellersInput) {
                noOfTravellersInput.addEventListener('input', function() {
                    const value = parseInt(this.value) || 1;
                    if (value < 1) {
                        this.value = 1;
                    }
                    calculateTotal();
                });
            }

            // Initialize on page load
            calculateTotal();

            // Function to select accommodation from table
            window.selectAccommodation = function(itemId, price, displayName) {
                if (accommodationSelect) {
                    accommodationSelect.value = itemId;
                    // Trigger change event to recalculate
                    accommodationSelect.dispatchEvent(new Event('change'));

                    // Highlight selected row
                    document.querySelectorAll('.accommodation-row').forEach(function(row) {
                        row.classList.remove('bg-green-zomp');
                        const nameCell = row.querySelector('.accommodation-name');
                        const priceCell = row.querySelector('.accommodation-price');
                        const descCell = row.querySelector('.accommodation-desc');

                        if (row.getAttribute('data-item-id') == itemId) {
                            row.classList.add('bg-green-zomp');
                            if (nameCell) {
                                nameCell.classList.remove('text-dark-grey');
                                nameCell.classList.add('text-white');
                            }
                            if (priceCell) {
                                priceCell.classList.remove('text-green-zomp');
                                priceCell.classList.add('text-white');
                            }
                            if (descCell) {
                                descCell.classList.remove('text-dark-grey');
                                descCell.classList.add('text-white');
                            }
                        } else {
                            if (nameCell) {
                                nameCell.classList.remove('text-white');
                                nameCell.classList.add('text-dark-grey');
                            }
                            if (priceCell) {
                                priceCell.classList.remove('text-white');
                                priceCell.classList.add('text-green-zomp');
                            }
                            if (descCell) {
                                descCell.classList.remove('text-white');
                                descCell.classList.add('text-dark-grey');
                            }
                        }
                    });
                }
            };

            // Initialize Reviews Swiper
            if (typeof Swiper !== 'undefined') {
                const reviewsSwiper = new Swiper('.reviews-swiper', {
                    slidesPerView: 1,
                    spaceBetween: 30,
                    loop: true,
                    navigation: {
                        nextEl: '.reviews-swiper-next',
                        prevEl: '.reviews-swiper-prev',
                    },
                    breakpoints: {
                        768: {
                            slidesPerView: 1,
                        },
                    },
                });
            }

            // Initialize total
            calculateTotal();

            // Handle form submission
            const bookingForm = document.getElementById('booking-form');
            if (bookingForm) {
                bookingForm.addEventListener('submit', function(e) {
                    // Ensure all hidden fields are updated before submission
                    calculateTotal();

                    // Validate required fields
                    const fullName = document.getElementById('full_name');
                    const email = document.getElementById('email');
                    const phone = document.getElementById('phone');
                    const nationality = document.getElementById('nationality');
                    const noOfTravellers = document.getElementById('no_of_travellers');

                    let isValid = true;

                    if (!fullName || !fullName.value.trim()) {
                        isValid = false;
                        if (fullName) {
                            fullName.classList.add('border-red-500');
                        }
                    }

                    if (!email || !email.value.trim() || !email.validity.valid) {
                        isValid = false;
                        if (email) {
                            email.classList.add('border-red-500');
                        }
                    }

                    if (!phone || !phone.value.trim()) {
                        isValid = false;
                        if (phone) {
                            phone.classList.add('border-red-500');
                        }
                    }

                    if (!nationality || !nationality.value.trim()) {
                        isValid = false;
                        if (nationality) {
                            nationality.classList.add('border-red-500');
                        }
                    }

                    if (!noOfTravellers || !noOfTravellers.value || parseInt(noOfTravellers.value) < 1) {
                        isValid = false;
                        if (noOfTravellers) {
                            noOfTravellers.classList.add('border-red-500');
                        }
                    }

                    if (!isValid) {
                        e.preventDefault();
                        alert('Please fill in all required fields correctly.');
                        return false;
                    }

                    // Show loading state
                    const submitButton = bookingForm.querySelector('button[type="submit"]');
                    if (submitButton) {
                        submitButton.disabled = true;
                        submitButton.textContent = 'Submitting...';
                    }
                });
            }
        });
    </script>
@endpush
