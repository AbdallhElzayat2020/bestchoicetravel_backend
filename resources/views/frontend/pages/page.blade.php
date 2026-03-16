@extends('frontend.layouts.master')

@php
$metaTitle = $page->meta_title ?? $page->name;
$metaDescription = $page->meta_description ?? null;
$metaAuthor = $page->meta_author ?? null;
$metaKeywords = $page->meta_keywords ?? null;
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
    <main class="tours-page">
        <!-- Hero / Filters -->
        @php
            $heroTitle = $page->meta_title ?? $page->name;
            $heroSubtitle = $page->meta_description
                ? \Illuminate\Support\Str::limit(strip_tags($page->meta_description), 160)
                : null;
        @endphp
        <section class="about-banner" id="about-intro" style="background-image: url('{{ asset('assets/images/Nile-Cruise.webp') }}');">
            <div class="about-banner-overlay"></div>
            <div class="container">
                <div class="about-banner-inner">
                    <h1 class="about-banner-title">{{ $heroTitle }}</h1>
                    @if ($heroSubtitle)
                        <p class="about-banner-subtitle">{{ $heroSubtitle }}</p>
                    @endif
                </div>
            </div>
        </section>

        <!-- Egypt Tours -->
        <section class="tours-section section-padding" id="egypt-tours">
            <div class="container">
                <div class="tours-section-header">

                    <div class="tours-section-heading">
                        <h2 class="section-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                            Signature <span class="highlight">{{ $page->name }}</span>
                        </h2>
                        @if ($heroSubtitle)
                            <p class="section-description scroll-animate" data-animation="fadeInUp" data-delay="100">
                                {{ $heroSubtitle }}
                            </p>
                        @endif
                    </div>
                </div>

                <div class="tours-section-gallery scroll-animate mt-4" data-animation="fadeInUp" data-delay="150">
                    <div class="swiper packages-carousel">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="package-card">
                                    <div class="card-image">
                                        <img src="https://images.unsplash.com/photo-1539650116574-75c0c6d73a6e?auto=format&fit=crop&w=800&q=90"
                                            alt="Pyramids Cairo" loading="lazy">
                                        <div class="location-badge">
                                            <span class="pin-icon">📍</span>
                                            <span>GIZA, CAIRO</span>
                                        </div>
                                        <div class="category-badge">HISTORICAL</div>
                                    </div>
                                    <div class="card-content">
                                        <div class="price-section">
                                            <span class="price-label">STARTING FROM</span>
                                            <span class="price">$299</span>
                                        </div>
                                        <h3 class="package-title">Classic Cairo & Pyramids Escape</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="package-card">
                                    <div class="card-image">
                                        <img src="https://images.unsplash.com/photo-1583212292454-1fe6229603b7?auto=format&fit=crop&w=800&q=90"
                                            alt="Red Sea" loading="lazy">
                                        <div class="location-badge">
                                            <span class="pin-icon">📍</span>
                                            <span>RED SEA</span>
                                        </div>
                                        <div class="category-badge">BEACH</div>
                                    </div>
                                    <div class="card-content">
                                        <div class="price-section">
                                            <span class="price-label">STARTING FROM</span>
                                            <span class="price">$350</span>
                                        </div>
                                        <h3 class="package-title">Hurghada & Red Sea Getaway</h3>
                                    </div>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="package-card">
                                    <div class="card-image">
                                        <img src="https://images.unsplash.com/photo-1544551763-46a013bb70d5?auto=format&fit=crop&w=800&q=90"
                                            alt="Nile Cruise" loading="lazy">
                                        <div class="location-badge">
                                            <span class="pin-icon">📍</span>
                                            <span>NILE RIVER</span>
                                        </div>
                                        <div class="category-badge">CRUISE</div>
                                    </div>
                                    <div class="card-content">
                                        <div class="price-section">
                                            <span class="price-label">STARTING FROM</span>
                                            <span class="price">$599</span>
                                        </div>
                                        <h3 class="package-title">Luxor & Aswan Nile Journey</h3>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-pagination"></div>
                        <div class="swiper-button-prev"></div>
                        <div class="swiper-button-next"></div>
                    </div>
                </div>
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

                        <div class="faq-item scroll-animate" data-animation="fadeInUp" data-delay="100">
                            <button class="faq-question" type="button">
                                <span>What’s included in your tour packages?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                <p>
                                    Most packages include accommodation, daily breakfast, private or small‑group tours with
                                    licensed Egyptologist guides, entrance fees to mentioned sites, domestic flights or
                                    trains, and airport transfers. Your proposal clearly lists all inclusions and
                                    exclusions.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item scroll-animate" data-animation="fadeInUp" data-delay="150">
                            <button class="faq-question" type="button">
                                <span>Can you customize an itinerary just for us?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                <p>
                                    Yes – most of our trips are fully tailor‑made. Tell us your dates, interests, preferred
                                    pace and budget, and we’ll design a program only for your couple, family or group.
                                </p>
                            </div>
                        </div>

                        <div class="faq-item scroll-animate" data-animation="fadeInUp" data-delay="200">
                            <button class="faq-question" type="button">
                                <span>Is it safe to travel in Egypt right now?</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </button>
                            <div class="faq-answer">
                                <p>
                                    We operate with local teams on the ground who monitor the situation daily. Tourist
                                    areas such as Cairo, Luxor, Aswan and the Red Sea are heavily protected, and we plan
                                    routes with your comfort and safety as the top priority.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </main>
@endsection

@push('css')
    <style>
        /* Summernote Content Styling */
        .summernote-content {
            color: #4a5568;
            line-height: 1.8;
            font-size: 16px;
        }

        .summernote-content h1,
        .summernote-content h2,
        .summernote-content h3,
        .summernote-content h4,
        .summernote-content h5,
        .summernote-content h6 {
            color: #1a202c;
            font-weight: 700;
            margin-top: 1.5em;
            margin-bottom: 0.75em;
            line-height: 1.3;
        }

        .summernote-content h1 {
            font-size: 2.25rem;
        }

        .summernote-content h2 {
            font-size: 1.875rem;
        }

        .summernote-content h3 {
            font-size: 1.5rem;
        }

        .summernote-content h4 {
            font-size: 1.25rem;
        }

        .summernote-content h5 {
            font-size: 1.125rem;
        }

        .summernote-content h6 {
            font-size: 1rem;
        }

        .summernote-content p {
            margin-bottom: 1em;
            line-height: 1.8;
            color: #4a5568;
        }

        .summernote-content ul,
        .summernote-content ol {
            margin: 1em 0;
            padding-left: 2em;
        }

        .summernote-content ul {
            list-style-type: disc;
        }

        .summernote-content ol {
            list-style-type: decimal;
        }

        .summernote-content li {
            margin-bottom: 0.5em;
            line-height: 1.8;
        }

        .summernote-content ul ul,
        .summernote-content ol ol,
        .summernote-content ul ol,
        .summernote-content ol ul {
            margin-top: 0.5em;
            margin-bottom: 0.5em;
        }

        .summernote-content a {
            color: #8b7138;
            text-decoration: none;
            transition: color 0.2s;
        }

        .summernote-content a:hover {
            color: #7a6230;
            text-decoration: underline;
        }

        .summernote-content strong,
        .summernote-content b {
            font-weight: 700;
            color: #1a202c;
        }

        .summernote-content em,
        .summernote-content i {
            font-style: italic;
        }

        .summernote-content u {
            text-decoration: underline;
        }

        .summernote-content blockquote {
            border-left: 4px solid #8b7138;
            padding-left: 1.5em;
            margin: 1.5em 0;
            font-style: italic;
            color: #718096;
        }

        .summernote-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5em 0;
        }

        .summernote-content table th,
        .summernote-content table td {
            border: 1px solid #e2e8f0;
            padding: 0.75em;
            text-align: left;
        }

        .summernote-content table th {
            background-color: #f7fafc;
            font-weight: 700;
            color: #1a202c;
        }

        .summernote-content table tr:nth-child(even) {
            background-color: #f9fafb;
        }

        .summernote-content img {
            max-width: 100%;
            height: auto;
            border-radius: 0.5rem;
            margin: 1.5em 0;
        }

        .summernote-content img[style*="float: left"],
        .summernote-content .note-image-float-left {
            float: left;
            margin-right: 1.5em;
            margin-bottom: 1em;
        }

        .summernote-content img[style*="float: right"],
        .summernote-content .note-image-float-right {
            float: right;
            margin-left: 1.5em;
            margin-bottom: 1em;
        }

        .summernote-content hr {
            border: none;
            border-top: 2px solid #e2e8f0;
            margin: 2em 0;
        }

        .summernote-content code {
            background-color: #f7fafc;
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            font-family: 'Courier New', monospace;
            font-size: 0.9em;
            color: #e53e3e;
        }

        .summernote-content pre {
            background-color: #f7fafc;
            padding: 1em;
            border-radius: 0.5rem;
            overflow-x: auto;
            margin: 1.5em 0;
        }

        .summernote-content pre code {
            background-color: transparent;
            padding: 0;
            color: inherit;
        }

        /* Text Alignment */
        .summernote-content [style*="text-align: left"] {
            text-align: left;
        }

        .summernote-content [style*="text-align: center"] {
            text-align: center;
        }

        .summernote-content [style*="text-align: right"] {
            text-align: right;
        }

        .summernote-content [style*="text-align: justify"] {
            text-align: justify;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .summernote-content {
                font-size: 15px;
            }

            .summernote-content h1 {
                font-size: 1.875rem;
            }

            .summernote-content h2 {
                font-size: 1.5rem;
            }

            .summernote-content h3 {
                font-size: 1.25rem;
            }

            .summernote-content table {
                font-size: 0.875rem;
            }

            .summernote-content img[style*="float: left"],
            .summernote-content img[style*="float: right"],
            .summernote-content .note-image-float-left,
            .summernote-content .note-image-float-right {
                float: none;
                margin: 1em 0;
            }
        }
    </style>
@endpush
