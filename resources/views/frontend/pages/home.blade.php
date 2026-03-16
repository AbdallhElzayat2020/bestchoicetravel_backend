@extends('frontend.layouts.master')
@php
    $homePage = \App\Models\Page::getBySlug('home');
    $metaTitle = $homePage && $homePage->meta_title ? $homePage->meta_title : 'Home Page';
@endphp
@section('meta_title', $metaTitle)
@if ($homePage && $homePage->meta_description)
@section('meta_description', $homePage->meta_description)
@endif
@if ($homePage && $homePage->meta_author)
@section('meta_author', $homePage->meta_author)
@endif
@if ($homePage && $homePage->meta_keywords)
@section('meta_keywords', $homePage->meta_keywords)
@endif

@section('content')

    @php
        $heroSection = $siteSections['home_hero'] ?? null;
        $cruisesSection = $siteSections['home_cruises'] ?? null;
        $dayToursSection = $siteSections['home_day_tours'] ?? null;
        $desertSection = $siteSections['home_desert'] ?? null;
        $egyptJordanSection = $siteSections['home_egypt_jordan'] ?? null;
        $redseaSection = $siteSections['home_redsea'] ?? null;
    @endphp

    <!-- Home/Hero Section -->
    <section class="hero-section section-padding" id="home">
        <div class="hero-image">
            @php
                $heroImage = $heroSection && $heroSection->image_path
                    ? asset($heroSection->image_path)
                    : asset('assets/frontend/images/hero-bg.png');
            @endphp
            <img src="{{ $heroImage }}" alt="Egypt Pyramids" loading="eager"
                class="hero-bg-image"
                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73a6e?ixlib=rb-4.0.3&auto=format&fit=crop&w=1920&q=90';">
        </div>
        <div class="hero-overlay"></div>
        <div class="hero-darkening-overlay"></div>
        <div class="hero-content">
            <div class="container">
                <div class="hero-text">
                    <h1 class="hero-title scroll-animate" data-animation="fadeInUp" data-delay="0">
                        @if ($heroSection && $heroSection->title)
                            {!! nl2br(e($heroSection->title)) !!}
                        @else
                            Discover <span class="highlight">Egypt's Magic</span>
                        @endif
                    </h1>
                    <p class="hero-subtitle scroll-animate" data-animation="fadeInUp" data-delay="200">
                        {{ $heroSection && $heroSection->subtitle ? $heroSection->subtitle : 'Luxury, tailor-made journeys to explore the wonders of ancient and modern Egypt.' }}
                    </p>
                    <div class="hero-buttons scroll-animate" data-animation="fadeInUp" data-delay="400">
                        @php
                            $heroBtnText = $heroSection && $heroSection->button_text ? $heroSection->button_text : 'Egypt Tours';
                            $heroBtnLink = $heroSection && $heroSection->button_link ? $heroSection->button_link : '#packages';
                        @endphp
                        <a href="{{ $heroBtnLink }}" class="btn btn-primary">{{ $heroBtnText }}</a>
                    </div>

                </div>
            </div>
        </div>
        <div class="scroll-indicator">
            <div class="scroll-arrow"></div>
        </div>
    </section>

    <!-- Featured Packages Section -->
    <section class="featured-packages section-padding" id="packages">
        <div class="container">
            <!-- Header Section -->
            <div class="section-header">
                <div class="section-label">
                    <span class="star-icon">✦</span>
                    <span>OUR FEATURED PACKAGES</span>
                    <span class="star-icon">✦</span>
                </div>
                <h2 class="section-title">
                    Choose Your Next <span class="highlight">Adventure</span>
                </h2>
                <p class="section-description">
                    Carefully curated travel experiences designed to show you the very best of Egypt's wonders.
                </p>
            </div>

            <!-- Swiper Carousel -->
            <div class="swiper packages-carousel">
                <div class="swiper-wrapper">
                    @foreach ($activeTours as $tour)
                        @php
                            $coverImage = $tour->cover_image
                                ? asset('uploads/tours/' . $tour->cover_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');

                            $isOnSale = $tour->has_offer && $tour->isOfferActive();
                            $currentPrice =
                                $isOnSale && $tour->price_after_discount ? $tour->price_after_discount : $tour->price;
                            $oldPrice = $isOnSale && $tour->price_before_discount ? $tour->price_before_discount : null;

                            $durationValue = (int) ($tour->duration ?? 0);
                            $durationText = $durationValue > 0 ? $durationValue . ' Days' : null;

                            $locationParts = [];
                            if ($tour->state) {
                                $locationParts[] = $tour->state->name;
                            }
                            if ($tour->country) {
                                $locationParts[] = $tour->country->name;
                            }
                            $location = implode(' · ', $locationParts);
                        @endphp

                        <div class="swiper-slide">
                            <div class="package-card">
                                <div class="card-image">
                                    <img src="{{ $coverImage }}" alt="{{ $tour->title }}" loading="lazy">
                                    @if ($location)
                                        <div class="location-badge">
                                            <span class="pin-icon">📍</span>
                                            <span>{{ strtoupper($location) }}</span>
                                        </div>
                                    @endif
                                    @if ($tour->category)
                                        <div class="category-badge">
                                            {{ strtoupper($tour->category->name) }}
                                        </div>
                                    @endif
                                </div>
                                <div class="card-content">
                                    <div class="price-section">
                                        <span class="price-label">STARTING FROM</span>
                                        @if ($oldPrice)
                                            <span class="price-old">
                                                ${{ number_format($oldPrice, 0) }}
                                            </span>
                                        @endif
                                        @if ($currentPrice !== null)
                                            <span class="price">
                                                ${{ number_format($currentPrice, 0) }}
                                            </span>
                                        @endif
                                    </div>

                                    <h3 class="package-title">{{ $tour->title }}</h3>
                                    <div class="package-details">
                                        @if ($durationText)
                                            <div class="detail-item">
                                                <span class="detail-icon">🕐</span>
                                                <span>{{ $durationText }}</span>
                                            </div>
                                        @endif
                                        @if ($location)
                                            <div class="detail-item">
                                                <span class="detail-icon">📍</span>
                                                <span>{{ $location }}</span>
                                            </div>
                                        @endif
                                    </div>
                                    <a href="{{ route('tours.show', $tour->slug) }}" class="explore-btn">
                                        EXPLORE DETAILS
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <!-- Navigation Buttons -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>

                <!-- Pagination -->
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

    <!-- Royal Nile Cruises Section -->
    <section class="nile-cruises-section section-padding" id="cruises">
        <div class="container">
            <div class="cruises-wrapper">
                <!-- Left Column - Image -->
                <div class="cruises-image-col scroll-animate" data-animation="fadeInLeft">
                    <div class="cruises-image-container">
                        @php
                            $cruisesImage = $cruisesSection && $cruisesSection->image_path
                                ? asset($cruisesSection->image_path)
                                : asset('assets/frontend/images/Aswan.webp');
                        @endphp
                        <img src="{{ $cruisesImage }}" alt="Nile River Cruise"
                            class="cruises-main-image">
                        <div class="cruises-badge">
                            <span class="badge-icon">⚓</span>
                            <div class="badge-text">
                                <strong>15+</strong>
                                <span>Luxury Ships</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column - Content -->
                <div class="cruises-content-col scroll-animate" data-animation="fadeInRight">
                    <div class="cruises-subheading">
                        <span class="star-icon">✦</span>
                        <span>{{ $cruisesSection && $cruisesSection->subtitle ? $cruisesSection->subtitle : 'Luxury Experience' }}</span>
                    </div>
                    <h2 class="cruises-title">
                        @if ($cruisesSection && $cruisesSection->title)
                            {!! nl2br(e($cruisesSection->title)) !!}
                        @else
                            Royal Nile River <span class="highlight">Cruises</span>
                        @endif
                    </h2>
                    <p class="cruises-description">
                        {{ $cruisesSection && $cruisesSection->description
                            ? $cruisesSection->description
                            : 'Enjoy a magical journey aboard the most luxurious Nile ships, where ultimate comfort meets the magic of Pharaonic history. From Luxor to Aswan, witness the greatest temples and monuments while enjoying top-notch services.' }}
                    </p>

                    <!-- Feature Cards Grid -->
                    <div class="cruises-features-grid">
                        <div class="feature-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                            <div class="feature-card-icon">
                                <i class="fa-solid fa-bed"></i>
                            </div>
                            <div class="feature-card-content">
                                <h4 class="feature-card-title">Luxury Rooms</h4>
                                <p class="feature-card-subtitle">Nile View</p>
                            </div>
                        </div>
                        <div class="feature-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                            <div class="feature-card-icon">
                                <i class="fa-solid fa-utensils"></i>
                            </div>
                            <div class="feature-card-content">
                                <h4 class="feature-card-title">World Cuisine</h4>
                                <p class="feature-card-subtitle">Gourmet Dining</p>
                            </div>
                        </div>
                        <div class="feature-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                            <div class="feature-card-icon">
                                <i class="fa-solid fa-mug-hot"></i>
                            </div>
                            <div class="feature-card-content">
                                <h4 class="feature-card-title">Panoramic Bar</h4>
                                <p class="feature-card-subtitle">Signature Drinks</p>
                            </div>
                        </div>
                        <div class="feature-card scroll-animate" data-animation="fadeInUp" data-delay="400">
                            <div class="feature-card-icon">
                                <i class="fa-solid fa-camera-retro"></i>
                            </div>
                            <div class="feature-card-content">
                                <h4 class="feature-card-title">Guided Tours</h4>
                                <p class="feature-card-subtitle">Expert Guides</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="cruises-cta-buttons scroll-animate" data-animation="fadeInUp" data-delay="500">
                        @php
                            $cruiseBtnText = $cruisesSection && $cruisesSection->button_text ? $cruisesSection->button_text : 'Book Your Nile Cruise';
                            $cruiseBtnLink = $cruisesSection && $cruisesSection->button_link ? $cruisesSection->button_link : '#packages';
                        @endphp
                        <a href="{{ $cruiseBtnLink }}" class="btn btn-primary">{{ $cruiseBtnText }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- Egypt Day Tours Section -->
    <section class="redsea-section redsea-section--daytours" id="egypt-day-tours">
        <!-- <div class="redsea-bg"></div> -->
        <!-- <div class="redsea-overlay"></div> -->
        <div class="container redsea-inner">
            <div class="redsea-header scroll-animate" data-animation="fadeInUp">
                <div class="redsea-tag">
                    <span class="redsea-tag-icon"><i class="fa-solid fa-water"></i></span>
                    <span class="redsea-tag-text">
                        {{ $dayToursSection && $dayToursSection->subtitle ? $dayToursSection->subtitle : 'Guided City & Museum Tours' }}
                    </span>
                </div>
                <h2 class="redsea-title">
                    @if ($dayToursSection && $dayToursSection->title)
                        {!! nl2br(e($dayToursSection->title)) !!}
                    @else
                        Discover <span class="highlight">Egypt Day Tours</span>
                    @endif
                </h2>
                <p class="redsea-description">
                    {{ $dayToursSection && $dayToursSection->description
                        ? $dayToursSection->description
                        : 'Explore the best Egypt Day Tours to the Pyramids, Luxor temples, and Aswan with a Nubian experience.' }}
                    Enjoy guided trips,
                    rich history, and unforgettable experiences in one day.
                </p>
            </div>

            <!-- <div class="redsea-stats-grid">
                            <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                                <div class="redsea-stat-icon">
                                    <i class="fa-solid fa-fish"></i>
                                </div>
                                <div class="redsea-stat-number">1000+</div>
                                <div class="redsea-stat-label">Fish Species</div>
                            </div>

                            <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                                <div class="redsea-stat-icon">
                                    <i class="fa-solid fa-sun"></i>
                                </div>
                                <div class="redsea-stat-number">365</div>
                                <div class="redsea-stat-label">Sunny Days</div>
                            </div>

                            <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                                <div class="redsea-stat-icon">
                                    <i class="fa-solid fa-hotel"></i>
                                </div>
                                <div class="redsea-stat-number">50+</div>
                                <div class="redsea-stat-label">Luxury Resorts</div>
                            </div>

                            <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="400">
                                <div class="redsea-stat-icon">
                                    <i class="fa-solid fa-water"></i>
                                </div>
                                <div class="redsea-stat-number">30m</div>
                                <div class="redsea-stat-label">Underwater Visibility</div>
                            </div>
                        </div> -->

            <div class="redsea-cta scroll-animate" data-animation="fadeInUp" data-delay="500">
                <a href="#packages" class="btn btn-brown">Egypt Day Tours</a>
            </div>
        </div>
    </section>

    <!-- Desert Safari Highlight Section -->
    <section class="desert-section" id="desert">
        <div class="container">
            <div class="desert-inner">
                <div class="desert-image-col scroll-animate" data-animation="fadeInLeft">
                    <div class="desert-image-wrapper">
                        @php
                            $desertImage = $desertSection && $desertSection->image_path
                                ? asset($desertSection->image_path)
                                : asset('assets/frontend/images/desert-safar.jpg');
                        @endphp
                        <img src="{{ $desertImage }}" alt="Egyptian Desert Safari"
                            class="desert-image">
                        <div class="desert-image-gradient"></div>
                    </div>
                </div>

                <div class="desert-content-col scroll-animate" data-animation="fadeInRight">
                    <div class="desert-kicker">
                        <span class="desert-kicker-dot"></span>
                        <span class="desert-kicker-text">
                            {{ $desertSection && $desertSection->subtitle ? $desertSection->subtitle : 'An Unforgettable Adventure' }}
                        </span>
                    </div>
                    <h2 class="desert-title">
                        @if ($desertSection && $desertSection->title)
                            {!! nl2br(e($desertSection->title)) !!}
                        @else
                            Egyptian <span class="desert-title-highlight">Desert Safari</span>
                        @endif
                    </h2>
                    <p class="desert-description">
                        {{ $desertSection && $desertSection->description
                            ? $desertSection->description
                            : "Ride across Egypt's golden dunes at sunset, camp under a sky filled with stars, and
                        feel the silence of the desert with our expert Bedouin guides and premium desert camps." }}
                    </p>

                    <div class="desert-feature-list">
                        <div class="desert-feature-item">
                            <i class="fa-solid fa-campground"></i>
                            <div class="desert-feature-text">
                                <span class="desert-feature-title">Luxury Desert Camp</span>
                                <span class="desert-feature-subtitle">Private tents & gourmet dining</span>
                            </div>
                        </div>
                        <div class="desert-feature-item">
                            <i class="fa-solid fa-star"></i>
                            <div class="desert-feature-text">
                                <span class="desert-feature-title">Stargazing Nights</span>
                                <span class="desert-feature-subtitle">Crystal-clear Milky Way views</span>
                            </div>
                        </div>
                    </div>

                    <div class="desert-cta">
                        @php
                            $desertBtnText = $desertSection && $desertSection->button_text ? $desertSection->button_text : 'Book Your Adventure';
                            $desertBtnLink = $desertSection && $desertSection->button_link ? $desertSection->button_link : '#packages';
                        @endphp
                        <a href="{{ $desertBtnLink }}" class="btn btn-primary">{{ $desertBtnText }}</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Egypt & Jordan Highlight Section (mirrored layout) -->
    <section class="desert-section" id="egypt-jordan">
        <div class="container">
            <div class="desert-inner">
                <div class="desert-content-col scroll-animate" data-animation="fadeInLeft">
                    <div class="desert-kicker">
                        <span class="desert-kicker-dot"></span>
                        <span class="desert-kicker-text">
                            {{ $egyptJordanSection && $egyptJordanSection->subtitle ? $egyptJordanSection->subtitle : 'An Unforgettable Adventure' }}
                        </span>
                    </div>
                    <h2 class="desert-title">
                        @if ($egyptJordanSection && $egyptJordanSection->title)
                            {!! nl2br(e($egyptJordanSection->title)) !!}
                        @else
                            Egypt & <span class="desert-title-highlight"> Jordan Tours</span>
                        @endif
                    </h2>
                    <p class="desert-description">
                        {{ $egyptJordanSection && $egyptJordanSection->description
                            ? $egyptJordanSection->description
                            : "Ride across Egypt's golden dunes at sunset, camp under a sky filled with stars, and
                        feel the silence of the desert with our expert Bedouin guides and premium desert camps." }}
                    </p>

                    <div class="desert-feature-list">
                        <div class="desert-feature-item">
                            <i class="fa-solid fa-campground"></i>
                            <div class="desert-feature-text">
                                <span class="desert-feature-title">Luxury Desert Camp</span>
                                <span class="desert-feature-subtitle">Private tents & gourmet dining</span>
                            </div>
                        </div>
                        <div class="desert-feature-item">
                            <i class="fa-solid fa-star"></i>
                            <div class="desert-feature-text">
                                <span class="desert-feature-title">Stargazing Nights</span>
                                <span class="desert-feature-subtitle">Crystal-clear Milky Way views</span>
                            </div>
                        </div>
                    </div>

                    <div class="desert-cta">
                        @php
                            $egyptJordanBtnText = $egyptJordanSection && $egyptJordanSection->button_text ? $egyptJordanSection->button_text : 'Book Your Adventure';
                            $egyptJordanBtnLink = $egyptJordanSection && $egyptJordanSection->button_link ? $egyptJordanSection->button_link : '#packages';
                        @endphp
                        <a href="{{ $egyptJordanBtnLink }}" class="btn btn-primary">{{ $egyptJordanBtnText }}</a>
                    </div>
                </div>

                <div class="desert-image-col scroll-animate" data-animation="fadeInRight">
                    <div class="desert-image-wrapper">
                        @php
                            $egyptJordanImage = $egyptJordanSection && $egyptJordanSection->image_path
                                ? asset($egyptJordanSection->image_path)
                                : asset('assets/frontend/images/jordan.jpeg');
                        @endphp
                        <img src="{{ $egyptJordanImage }}" alt="Egypt & Jordan Tours"
                            class="desert-image">
                        <div class="desert-image-gradient"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>




    <section class="redsea-section section-padding" id="redsea">
        @php
            $redseaImage = $redseaSection && $redseaSection->image_path ? asset($redseaSection->image_path) : null;
        @endphp
        @if ($redseaImage)
            <div class="redsea-bg" style="background-image: url('{{ $redseaImage }}')"></div>
        @else
            <div class="redsea-bg"></div>
        @endif
        <!-- <div class="redsea-overlay"></div> -->
        <div class="container redsea-inner">
            <div class="redsea-header scroll-animate" data-animation="fadeInUp">
                <div class="redsea-tag">
                    <span class="redsea-tag-icon"><i class="fa-solid fa-city"></i></span>
                    <span class="redsea-tag-text">
                        {{ $redseaSection && $redseaSection->subtitle ? $redseaSection->subtitle : 'Red Sea Vacations' }}
                    </span>
                </div>
                <h2 class="redsea-title">
                    @if ($redseaSection && $redseaSection->title)
                        {!! nl2br(e($redseaSection->title)) !!}
                    @else
                        Discover <span class="highlight">Red Sea Vacations</span>
                    @endif
                </h2>
                <p class="redsea-description">
                    {{ $redseaSection && $redseaSection->description
                        ? $redseaSection->description
                        : "Dive into a magical world of colorful coral reefs and incredible marine life. Enjoy unforgettable
                    diving experiences in crystal-clear waters along Egypt's Red Sea coast." }}
                </p>
            </div>

            <!-- <div class="redsea-stats-grid">
                                    <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                                        <div class="redsea-stat-icon">
                                            <i class="fa-solid fa-fish"></i>
                                        </div>
                                        <div class="redsea-stat-number">1000+</div>
                                        <div class="redsea-stat-label">Fish Species</div>
                                    </div>

                                    <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                                        <div class="redsea-stat-icon">
                                            <i class="fa-solid fa-sun"></i>
                                        </div>
                                        <div class="redsea-stat-number">365</div>
                                        <div class="redsea-stat-label">Sunny Days</div>
                                    </div>

                                    <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                                        <div class="redsea-stat-icon">
                                            <i class="fa-solid fa-hotel"></i>
                                        </div>
                                        <div class="redsea-stat-number">50+</div>
                                        <div class="redsea-stat-label">Luxury Resorts</div>
                                    </div>

                                    <div class="redsea-stat-card scroll-animate" data-animation="fadeInUp" data-delay="400">
                                        <div class="redsea-stat-icon">
                                            <i class="fa-solid fa-water"></i>
                                        </div>
                                        <div class="redsea-stat-number">30m</div>
                                        <div class="redsea-stat-label">Underwater Visibility</div>
                                    </div>
                                </div> -->

            <div class="redsea-cta scroll-animate" data-animation="fadeInUp" data-delay="500">
                <a href="#packages" class="btn btn-primary">View Egypt Day Tours</a>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="faq-section section-padding" id="faq">
        <div class="container">
            <div class="section-header scroll-animate" data-animation="fadeInUp">
                <div class="section-label">
                    <span class="star-icon">✦</span>
                    <span>Frequently Asked Questions</span>
                    <span class="star-icon">✦</span>
                </div>
                <h2 class="section-title">
                    Answers to <span class="highlight">Common Questions</span>
                </h2>
            </div>

            <div class="faq-layout">
                <div class="faq-list">
                    @if (isset($homeFaqs) && $homeFaqs->count())
                        @foreach ($homeFaqs as $index => $faq)
                            <div class="faq-item scroll-animate" data-animation="fadeInUp"
                                data-delay="{{ $index * 50 }}">
                                <button class="faq-question" type="button">
                                    <span>{{ $faq->question }}</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <p>{!! nl2br(e($faq->answer)) !!}</p>
                                </div>
                            </div>
                        @endforeach
                    @else
                        {{-- Fallback to static FAQs if none flagged for homepage --}}
                        <div class="faq-item scroll-animate" data-animation="fadeInUp" data-delay="0">
                            <button class="faq-question" type="button">
                                <span>How do I book a tour with Travel Egypt?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                <p>
                                    You can send us an enquiry through the contact form, WhatsApp or email. One of our
                                    travel designers will reply with a tailored itinerary, price and payment link. Once you
                                    approve the program and pay the deposit, your trip is confirmed.
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section section-padding" id="testimonials">
        <div class="container">
            <div class="section-header scroll-animate" data-animation="fadeInUp">
                <div class="section-label">
                    <span class="star-icon">✦</span>
                    <span>Trusted by Travellers</span>
                </div>
                <h2 class="section-title">
                    What Our <span class="highlight">Customers Say</span>
                </h2>
                <p class="section-description">
                    We are proud of the trust of more than 50,000 travellers who chose us to design their dream trip to
                    Egypt.
                </p>
            </div>

            <div class="swiper testimonials-carousel scroll-animate" data-animation="fadeInUp" data-delay="150">
                <div class="swiper-wrapper">
                    <!-- Testimonial 1 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Professional service, beautiful Nile views, and delicious food. The perfect holiday for
                                me and my partner!"
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">E</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Elena Rossi</div>
                                    <div class="testimonial-location">Italy</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 2 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Diving in the Red Sea was life-changing. Highly recommend their adventure packages for
                                anyone visiting Egypt."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">J</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">John Smith</div>
                                    <div class="testimonial-location">Canada</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 3 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Everything was perfectly organized from airport pick-up to private tours at the
                                pyramids. Highly recommended!"
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">D</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">David Brown</div>
                                    <div class="testimonial-location">UK</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 4 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Our family cruise on the Nile was unforgettable. The kids loved it and the guides were
                                incredibly helpful."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">A</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Amira Khalil</div>
                                    <div class="testimonial-location">UAE</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 5 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "As an Egyptian, I was impressed by how smooth everything was. Great service and amazing
                                local knowledge."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">Y</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Youssef Mansour</div>
                                    <div class="testimonial-location">Egypt</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 6 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "From the Red Sea to the desert, every part of our itinerary felt carefully designed and
                                truly special."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">S</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Sophie Müller</div>
                                    <div class="testimonial-location">Germany</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 7 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "The boutique hotels they chose for us in Cairo and Aswan were absolutely stunning and
                                very comfortable."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">M</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Maria Lopez</div>
                                    <div class="testimonial-location">Spain</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 8 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Our kids still talk about the Nile cruise and sound & light show at Karnak. Truly a
                                family trip to remember."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">K</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Karen Wilson</div>
                                    <div class="testimonial-location">USA</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 9 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Excellent communication from the team, flexible changes, and safe drivers everywhere we
                                went."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">L</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Liam O'Connor</div>
                                    <div class="testimonial-location">Ireland</div>
                                </div>
                            </div>
                        </article>
                    </div>

                    <!-- Testimonial 10 -->
                    <div class="swiper-slide">
                        <article class="testimonial-card">
                            <div class="testimonial-top">
                                <div class="testimonial-rating">
                                    <span>★★★★★</span>
                                </div>
                                <div class="testimonial-quote-icon">
                                    <i class="fa-solid fa-quote-right"></i>
                                </div>
                            </div>
                            <p class="testimonial-text">
                                "Best agency we have ever booked with. They made Egypt feel both adventurous and
                                incredibly easy."
                            </p>
                            <div class="testimonial-footer">
                                <div class="testimonial-avatar">N</div>
                                <div class="testimonial-meta">
                                    <div class="testimonial-name">Nadia Karim</div>
                                    <div class="testimonial-location">France</div>
                                </div>
                            </div>
                        </article>
                    </div>
                </div>

                <div class="swiper-pagination testimonials-pagination"></div>
            </div>
        </div>
    </section>

    <section class="review-trust-strip">
        <div class="container">
            <div class="contact-grid contact-grid--reviews">
                <!-- Trustpilot -->
                <a href="https://www.trustpilot.com" target="_blank" rel="noopener" class="review-trust-card scroll-animate"
                    data-animation="fadeInUp" data-delay="100">
                    <div class="review-trust-icon review-trust-icon--trustpilot">
                        <img src="{{ asset('assets/frontend/images/Trustpilot.png') }}" alt="Trustpilot"
                            class="review-trust-img">
                    </div>
                    <div class="review-trust-content">
                        <span class="review-trust-label">Trustpilot</span>
                        <div class="review-trust-row">
                            <span class="review-trust-score">4.6/5</span>
                            <span class="review-trust-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star fa-star-last"></i>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- Google -->
                <a href="https://www.google.com/search?q=travel+egypt+tours" target="_blank" rel="noopener"
                    class="review-trust-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                    <div class="review-trust-icon review-trust-icon--google">
                        <i class="fa-brands fa-google"></i>
                    </div>
                    <div class="review-trust-content">
                        <span class="review-trust-label">Google</span>
                        <div class="review-trust-row">
                            <span class="review-trust-score">4.8/5</span>
                            <span class="review-trust-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star fa-star-last"></i>
                            </span>
                        </div>
                    </div>
                </a>

                <!-- TripAdvisor -->
                <a href="https://www.tripadvisor.com" target="_blank" rel="noopener"
                    class="review-trust-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                    <div class="review-trust-icon review-trust-icon--tripadvisor">
                        <img src="{{ asset('assets/frontend/images/TripAdvisor.jpg') }}" alt="TripAdvisor"
                            class="review-trust-img">
                    </div>
                    <div class="review-trust-content">
                        <span class="review-trust-label">TripAdvisor</span>
                        <div class="review-trust-row">
                            <span class="review-trust-score">4.8/5</span>
                            <span class="review-trust-stars">
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star"></i>
                                <i class="fa-solid fa-star fa-star-last"></i>
                            </span>
                        </div>
                    </div>
                </a>
            </div>

            <div class="review-badges-wrapper scroll-animate" data-animation="fadeInUp" data-delay="200">
                <div class="swiper review-badges-carousel">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="review-badge-card">
                                <div class="review-badge-logo">
                                    <img src="{{ asset('assets/frontend/images/Egypt_Day_Tours.jpeg') }}"
                                        alt="Travel Egypt Partner" class="review-badge-img">
                                </div>
                                <p class="review-badge-label">Safe Travels</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-badge-card">
                                <div class="review-badge-logo">
                                    <img src="{{ asset('assets/frontend/images/Egypt_Day_Tours.jpeg') }}"
                                        alt="Travel Egypt Partner" class="review-badge-img">
                                </div>
                                <p class="review-badge-label">Tripadvisor</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-badge-card">
                                <div class="review-badge-logo">
                                    <img src="{{ asset('assets/frontend/images/Egypt_Day_Tours.jpeg') }}"
                                        alt="Travel Egypt Partner" class="review-badge-img">
                                </div>
                                <p class="review-badge-label">Travellers' Choice Awards</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-badge-card">
                                <div class="review-badge-logo">
                                    <img src="{{ asset('assets/frontend/images/Egypt_Day_Tours.jpeg') }}"
                                        alt="Travel Egypt Partner" class="review-badge-img">
                                </div>
                                <p class="review-badge-label">Travellers' Choice 2020</p>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="review-badge-card">
                                <div class="review-badge-logo">
                                    <img src="{{ asset('assets/frontend/images/Egypt_Day_Tours.jpeg') }}"
                                        alt="Travel Egypt Partner" class="review-badge-img">
                                </div>
                                <p class="review-badge-label">American Society of Travel Advisors</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact / Get in Touch Section -->
    <section class="contact-section section-padding" id="contact">
        <div class="container">
            <div class="contact-header section-header scroll-animate" data-animation="fadeInUp">
                <div class="section-label">
                    <span class="star-icon">✦</span>
                    <span>Get in Touch</span>
                </div>
                <h2 class="section-title">
                    Let's Plan Your <span class="highlight">Dream Trip</span>
                </h2>
                <p class="section-description">
                    Ready to explore Egypt? Our expert team is just a message away. Reach out for tailored itineraries,
                    premium support, and unforgettable experiences.
                </p>
                <div class="mt-3">
                    <a href="contact.html" class="btn btn-primary">
                        Trip Planner
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
