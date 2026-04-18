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

                            <div class="row g-3 g-lg-4 tour-gallery-row align-items-stretch">
                                <div class="col-md-8 tour-gallery-col-main">
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
                                            <img src="{{ $fallbackCover }}" alt="{{ $tour->title }}" loading="lazy" />
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-4 tour-gallery-col-thumbs">
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
                            @if (session('success'))
                                <div class="alert alert-success alert-dismissible fade show tour-booking-flash mb-3" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endif
                            @if ($errors->any())
                                <div class="alert alert-danger tour-booking-flash mb-3" role="alert">
                                    <strong>Could not submit booking.</strong>
                                    <ul class="mb-0 mt-1 ps-3 small">
                                        @foreach ($errors->all() as $err)
                                            <li>{{ $err }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form class="tour-booking-form" id="booking-form" action="{{ route('bookings.store') }}" method="POST" novalidate>
                                @csrf
                                <input type="hidden" name="tour_id" value="{{ $tour->id }}">
                                <input type="hidden" id="base-tour-price" name="base_tour_price" value="{{ $basePrice }}">
                                <input type="hidden" id="total-price-input" name="total_price" value="{{ old('total_price') }}">
                                <input type="hidden" id="selected-variants" name="selected_variants" value="{{ old('selected_variants', '[]') }}">
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="full_name">Full Name</label>
                                    <input type="text" id="full_name" name="full_name"
                                        class="form-control @error('full_name') is-invalid @enderror" placeholder="Full name"
                                        value="{{ old('full_name') }}" autocomplete="name" />
                                    <div class="tour-booking-field__error" id="booking-feedback-full_name" role="alert" aria-live="polite">@error('full_name'){{ $message }}@enderror</div>
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="email">Email</label>
                                    <input type="email" id="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror" placeholder="you@example.com"
                                        value="{{ old('email') }}" autocomplete="email" inputmode="email" />
                                    <div class="tour-booking-field__error" id="booking-feedback-email" role="alert" aria-live="polite">@error('email'){{ $message }}@enderror</div>
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="phone">Phone</label>
                                    <input type="tel" id="phone" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror" placeholder="+20 123 456 7890"
                                        value="{{ old('phone') }}" autocomplete="tel" />
                                    <div class="tour-booking-field__error" id="booking-feedback-phone" role="alert" aria-live="polite">@error('phone'){{ $message }}@enderror</div>
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="nationality">Nationality</label>
                                    <input type="text" id="nationality" name="nationality"
                                        class="form-control @error('nationality') is-invalid @enderror"
                                        placeholder="e.g. Egyptian, Italian" value="{{ old('nationality') }}" autocomplete="country-name" />
                                    <div class="tour-booking-field__error" id="booking-feedback-nationality" role="alert" aria-live="polite">@error('nationality'){{ $message }}@enderror</div>
                                </div>
                                <div class="tour-booking-field mb-2">
                                    <label class="form-label" for="no_of_travellers">No. of Travellers</label>
                                    <input type="number" id="no_of_travellers" name="no_of_travellers"
                                        class="form-control @error('no_of_travellers') is-invalid @enderror" min="1" step="1"
                                        value="{{ old('no_of_travellers', 1) }}" inputmode="numeric" />
                                    <div class="tour-booking-field__error" id="booking-feedback-no_of_travellers" role="alert" aria-live="polite">@error('no_of_travellers'){{ $message }}@enderror</div>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">Extra Options</label>
                                    <div class="tour-extras-list">
                                        @php
                                            $oldExtras = old('extra_options', []);
                                            if (! is_array($oldExtras)) {
                                                $oldExtras = [];
                                            }
                                        @endphp
                                        @forelse ($tour->variants ?? [] as $variant)
                                            @php $addPrice = (float) ($variant->additional_price ?? 0); @endphp
                                            <label class="form-check">
                                                <input class="form-check-input variant-checkbox" type="checkbox" name="extra_options[]"
                                                    value="{{ $variant->id }}"
                                                    data-price="{{ $addPrice }}"
                                                    data-title="{{ $variant->title }}"
                                                    @checked(in_array((string) $variant->id, array_map('strval', $oldExtras), true))>
                                                <span class="form-check-label">{{ $variant->title }} (${{ number_format($addPrice, 0) }})</span>
                                            </label>
                                        @empty
                                            <p class="text-muted small mb-0">No extra options for this tour.</p>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="tour-booking-summary">
                                    <div id="tour-booking-breakdown"
                                        class="tour-booking-breakdown"
                                        aria-live="polite"
                                        aria-atomic="true"></div>
                                    <div class="tour-booking-row tour-booking-total">
                                        <span>Total:</span>
                                        <span id="total-price">${{ number_format($basePrice, 0) }}</span>
                                    </div>
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





@push('scripts')
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

            function escapeHtml(text) {
                const div = document.createElement('div');
                div.textContent = text == null ? '' : String(text);
                return div.innerHTML;
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
                    const showBreakdown =
                        Math.round(pricePerPerson * 100) > Math.round(baseTourPrice * 100);
                    if (!showBreakdown) {
                        breakdownElement.innerHTML = '';
                        breakdownElement.style.display = 'none';
                    } else {
                        const rows = [];
                        rows.push({
                            label: 'Base tour',
                            amount: Math.round(baseTourPrice * noOfTravellers),
                        });
                        if (accommodationSelect && accommodationSelect.value) {
                            const opt = accommodationSelect.options[accommodationSelect.selectedIndex];
                            const accP = parsePrice(opt.getAttribute('data-price'));
                            const accLabel =
                                opt.getAttribute('data-label') ||
                                opt.textContent.replace(/\s+/g, ' ').trim() ||
                                'Accommodation';
                            rows.push({
                                label: accLabel,
                                amount: Math.round(accP * noOfTravellers),
                            });
                        }
                        selectedExtras.forEach(function(extra) {
                            rows.push({
                                label: extra.title,
                                amount: Math.round(extra.price * noOfTravellers),
                            });
                        });
                        let html =
                            '<div class="tour-breakdown-panel" role="region" aria-label="Price breakdown">';
                        html +=
                            '<div class="tour-breakdown-panel__head"><i class="fa-solid fa-receipt" aria-hidden="true"></i> Price breakdown</div>';
                        html += '<ul class="tour-breakdown-panel__list">';
                        rows.forEach(function(row) {
                            html += '<li class="tour-breakdown-panel__row">';
                            html +=
                                '<span class="tour-breakdown-panel__label">' +
                                escapeHtml(row.label) +
                                '</span>';
                            html +=
                                '<span class="tour-breakdown-panel__value">$' +
                                row.amount.toLocaleString() +
                                '</span>';
                            html += '</li>';
                        });
                        html += '</ul></div>';
                        breakdownElement.innerHTML = html;
                        breakdownElement.style.display = 'block';
                    }
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

            // Real-time booking form validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            function setFieldState(fieldId, isInvalid, message) {
                const input = document.getElementById(fieldId);
                const feedback = document.getElementById('booking-feedback-' + fieldId);
                if (!input) return;
                if (isInvalid) {
                    input.classList.add('is-invalid');
                    input.setAttribute('aria-invalid', 'true');
                    if (feedback) {
                        feedback.textContent = message || '';
                    }
                } else {
                    input.classList.remove('is-invalid');
                    input.setAttribute('aria-invalid', 'false');
                    if (feedback) feedback.textContent = '';
                }
            }

            function validateFullName() {
                const el = document.getElementById('full_name');
                if (!el) return true;
                const v = el.value.trim();
                if (!v) {
                    setFieldState('full_name', true, 'Please enter your full name.');
                    return false;
                }
                setFieldState('full_name', false);
                return true;
            }

            function validateEmail() {
                const el = document.getElementById('email');
                if (!el) return true;
                const v = el.value.trim();
                if (!v) {
                    setFieldState('email', true, 'Please enter your email.');
                    return false;
                }
                if (!emailPattern.test(v)) {
                    setFieldState('email', true, 'Please enter a valid email address.');
                    return false;
                }
                setFieldState('email', false);
                return true;
            }

            function validatePhone() {
                const el = document.getElementById('phone');
                if (!el) return true;
                const v = el.value.trim();
                if (!v) {
                    setFieldState('phone', true, 'Please enter your phone number.');
                    return false;
                }
                setFieldState('phone', false);
                return true;
            }

            function validateNationality() {
                const el = document.getElementById('nationality');
                if (!el) return true;
                const v = el.value.trim();
                if (!v) {
                    setFieldState('nationality', true, 'Please enter your nationality.');
                    return false;
                }
                setFieldState('nationality', false);
                return true;
            }

            function validateNoOfTravellers() {
                const el = document.getElementById('no_of_travellers');
                if (!el) return true;
                const n = parseInt(el.value, 10);
                if (el.value === '' || isNaN(n) || n < 1) {
                    setFieldState('no_of_travellers', true, 'Enter at least 1 traveller.');
                    return false;
                }
                setFieldState('no_of_travellers', false);
                return true;
            }

            function validateBookingFormAll() {
                const a = validateFullName();
                const b = validateEmail();
                const c = validatePhone();
                const d = validateNationality();
                const f = validateNoOfTravellers();
                return a && b && c && d && f;
            }

            const bookingForm = document.getElementById('booking-form');
            if (bookingForm) {
                const fieldValidators = {
                    full_name: validateFullName,
                    email: validateEmail,
                    phone: validatePhone,
                    nationality: validateNationality,
                    no_of_travellers: validateNoOfTravellers,
                };

                Object.keys(fieldValidators).forEach(function(fieldId) {
                    const input = document.getElementById(fieldId);
                    if (!input) return;
                    const run = fieldValidators[fieldId];
                    input.addEventListener('input', function() {
                        run();
                    });
                    input.addEventListener('blur', function() {
                        run();
                    });
                });

                bookingForm.addEventListener('submit', function(e) {
                    calculateTotal();

                    if (!validateBookingFormAll()) {
                        e.preventDefault();
                        const firstInvalid = bookingForm.querySelector('.form-control.is-invalid');
                        if (firstInvalid) {
                            firstInvalid.focus({ preventScroll: false });
                        }
                        return false;
                    }

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
