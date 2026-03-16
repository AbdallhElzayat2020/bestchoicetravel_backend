@extends('frontend.layouts.master')
@php
    $metaTitle = optional($page ?? null)->meta_title ?: 'About Us';
    $metaDescription = optional($page ?? null)->meta_description ?: null;
    $metaAuthor = optional($page ?? null)->meta_author ?: null;
    $metaKeywords = optional($page ?? null)->meta_keywords ?: null;
@endphp
@section('meta_title', $metaTitle)
@if ($metaDescription)
@section('meta_description', $metaDescription)
@endif
@if ($metaAuthor)
@section('meta_author', $metaAuthor)
@endif
@if ($metaKeywords)
@section('meta_keywords', $metaKeywords)
@endif
@section('content')
    @php
        $aboutBanner = $aboutSections['about_banner'] ?? null;
        $aboutHero = $aboutSections['about_hero'] ?? null;
        $aboutStory = $aboutSections['about_story'] ?? null;
        $aboutWhy = $aboutSections['about_why'] ?? null;

        $aboutWhyItems = [];
        if ($aboutWhy && $aboutWhy->content) {
            $decoded = json_decode($aboutWhy->content, true);
            if (is_array($decoded)) {
                $aboutWhyItems = $decoded;
            }
        }
    @endphp

    <!-- About Us Banner (full-width colored strip with title) -->
    <section class="about-banner" id="about-intro">
        <div class="about-banner-overlay"></div>
        <div class="container">
            <div class="about-banner-inner">
                <h1 class="about-banner-title">{{ $aboutBanner && $aboutBanner->title ? $aboutBanner->title : 'About Us' }}</h1>
                <p class="about-banner-subtitle">
                    {{ $aboutBanner && $aboutBanner->subtitle ? $aboutBanner->subtitle : 'Discover who we are and why travelers choose us' }}
                </p>
            </div>
        </div>
    </section>

    <!-- About Hero Section -->
    <section class="about-hero section-padding">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-6">
                    <div class="about-hero-badge scroll-animate" data-animation="fadeInUp">
                        <span class="star-icon">✦</span>
                        <span>{{ $aboutHero && $aboutHero->subtitle ? $aboutHero->subtitle : 'ABOUT TRAVEL EGYPT TOURS' }}</span>
                    </div>
                    <h1 class="about-hero-title scroll-animate" data-animation="fadeInUp" data-delay="100">
                        @if ($aboutHero && $aboutHero->title)
                            {!! nl2br(e($aboutHero->title)) !!}
                        @else
                            A Boutique <span class="highlight">Egypt Specialist</span> Tour Operator
                        @endif
                    </h1>
                    <p class="about-hero-text scroll-animate" data-animation="fadeInUp" data-delay="200">
                        {{ $aboutHero && $aboutHero->description
                            ? $aboutHero->description
                            : "We are a dedicated Egyptian travel company crafting premium, small‑group and private journeys
                        across Cairo, Luxor, Aswan, the Nile, Red Sea and beyond — built for travellers who want
                        comfort, authenticity and zero stress." }}
                    </p>

                </div>
                <div class="col-lg-6">
                    <div class="about-hero-media scroll-animate" data-animation="fadeInUp" data-delay="200">
                        <div class="about-hero-main">
                            @php
                                $aboutHeroImage = $aboutHero && $aboutHero->image_path
                                    ? asset($aboutHero->image_path)
                                    : asset('assets/frontend/images/hero-bg.png');
                            @endphp
                            <img src="{{ $aboutHeroImage }}" alt="Travelers in Egypt"
                                class="about-hero-image"
                                onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1539650116574-75c0c6d73a6e?auto=format&fit=crop&w=900&q=90';">
                        </div>
                        <div class="about-hero-badge-card">
                            <div class="about-hero-badge-icon">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div class="about-hero-badge-text">
                                <strong>4.9/5</strong>
                                <span>Average guest rating</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Story & Numbers Section -->
    <section class="about-story section-padding">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <h2 class="about-section-title scroll-animate" data-animation="fadeInUp">
                        @if ($aboutStory && $aboutStory->title)
                            {!! nl2br(e($aboutStory->title)) !!}
                        @else
                            Our Story as a <span class="highlight">Local Tour Operator</span>
                        @endif
                    </h2>
                    @php
                        $storyText = $aboutStory && $aboutStory->description ? $aboutStory->description : null;
                        $storyParts = $storyText ? preg_split("/\r\n|\n|\r/", $storyText) : [];
                        $storyParts = array_values(array_filter(array_map('trim', $storyParts)));
                    @endphp
                    @if (count($storyParts))
                        @foreach ($storyParts as $i => $p)
                            <p class="about-section-text scroll-animate" data-animation="fadeInUp"
                                data-delay="{{ ($i + 1) * 100 }}">
                                {{ $p }}
                            </p>
                        @endforeach
                    @else
                        <p class="about-section-text scroll-animate" data-animation="fadeInUp" data-delay="100">
                            Travel Egypt Tours was founded by a team of Egyptians who grew up between the temples of Luxor,
                            the narrow streets of Old Cairo and the golden dunes of the Sahara. We started as on‑the‑ground
                            guides, then grew into a boutique tour operator that designs journeys we would proudly host our
                            own families on.
                        </p>
                        <p class="about-section-text scroll-animate" data-animation="fadeInUp" data-delay="200">
                            Today, our travel designers, licensed Egyptologists and operations team work together to
                            combine iconic highlights with hidden gems, boutique stays and curated experiences — from
                            Nile cruises and desert safaris to Red Sea escapes.
                        </p>
                    @endif
                </div>
                <div class="col-lg-6">
                    <div class="about-stats-grid">
                        <div class="about-stat-card scroll-animate" data-animation="fadeInUp" data-delay="0">
                            <span class="about-stat-number">12+</span>
                            <span class="about-stat-label">Years of Experience</span>
                        </div>
                        <div class="about-stat-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                            <span class="about-stat-number">50K+</span>
                            <span class="about-stat-label">Travellers Hosted</span>
                        </div>
                        <div class="about-stat-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                            <span class="about-stat-number">98%</span>
                            <span class="about-stat-label">Guest Satisfaction</span>
                        </div>
                        <div class="about-stat-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                            <span class="about-stat-number">80+</span>
                            <span class="about-stat-label">Partner Hotels &amp; Cruises</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Travel With Us Section -->
    <section class="about-values section-padding" id="why-travel-with-us">
        <div class="container">
            <div class="about-why-header text-center scroll-animate" data-animation="fadeInUp">
                <h2 class="about-why-title">
                    @if ($aboutWhy && $aboutWhy->title)
                        {!! nl2br(e($aboutWhy->title)) !!}
                    @else
                        Why <span class="about-why-title-underline">Travel</span> With Us?
                    @endif
                </h2>
            </div>

            <div class="about-values-grid about-values-grid--four">
                @if (count($aboutWhyItems))
                    @foreach ($aboutWhyItems as $i => $item)
                        @php
                            $color = $item['color'] ?? 'blue';
                            $iconClass = $item['icon'] ?? null;
                        @endphp
                        <div class="about-value-card scroll-animate" data-animation="fadeInUp" data-delay="{{ $i * 100 }}">
                            <div class="about-value-icon about-value-icon--{{ $color }}">
                                @if ($iconClass)
                                    <i class="{{ $iconClass }}"></i>
                                @else
                                    <i class="fa-solid fa-star"></i>
                                @endif
                            </div>
                            <h3 class="about-value-title">{{ $item['title'] ?? '' }}</h3>
                            <p class="about-value-text">{{ $item['text'] ?? '' }}</p>
                        </div>
                    @endforeach
                @else
                    <div class="about-value-card scroll-animate" data-animation="fadeInUp" data-delay="0">
                        <div class="about-value-icon about-value-icon--blue">
                            <i class="fa-solid fa-globe"></i>
                        </div>
                        <h3 class="about-value-title">Global Reach</h3>
                        <p class="about-value-text">
                            Serving travelers from USA, UK, Australia &amp; worldwide with seamless booking and support.
                        </p>
                    </div>

                    <div class="about-value-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                        <div class="about-value-icon about-value-icon--gold about-value-icon--check" aria-hidden="true"></div>
                        <h3 class="about-value-title">Expert Guides</h3>
                        <p class="about-value-text">
                            Professional Egyptologist guides for every journey — history, culture, and hidden gems.
                        </p>
                    </div>

                    <div class="about-value-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                        <div class="about-value-icon about-value-icon--green">
                            <i class="fa-solid fa-clock"></i>
                        </div>
                        <h3 class="about-value-title">24/7 Support</h3>
                        <p class="about-value-text">
                            Local support ensuring a seamless travel experience from arrival to departure.
                        </p>
                    </div>

                    <div class="about-value-card scroll-animate" data-animation="fadeInUp" data-delay="300">
                        <div class="about-value-icon about-value-icon--blue">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h3 class="about-value-title">Handpicked</h3>
                        <p class="about-value-text">
                            Carefully selected hotels and luxury Nile cruises for comfort and authenticity.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endsection
