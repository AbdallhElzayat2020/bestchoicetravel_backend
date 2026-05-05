@extends('frontend.layouts.master')

@php
    $metaTitle = data_get($page, 'meta_title') ?: 'Contact Us';
    $metaDescription = data_get($page, 'meta_description');
    $metaAuthor = data_get($page, 'meta_author');
    $metaKeywords = data_get($page, 'meta_keywords');
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
    <!-- Hero Section -->
    <section class="contact-hero-unified">
        <div class="hero-bg" style="background-image: url('{{ asset('assets/frontend/images/Luxor.webp') }}');"></div>
        <div class="hero-overlay"></div>
        <div class="container position-relative">
            <div class="hero-content">
                <h1>Get in Touch With Us</h1>
                <p class="hero-subtitle">
                    At Best Choice Travel, we are always ready to assist you in planning your perfect journey to Egypt.
                    Whether you need help choosing a tour package, customizing your itinerary, or simply have questions
                    about traveling to Egypt, our experienced travel advisors are here to help.
                </p>
            </div>
        </div>
    </section>

    <!-- Main Contact Section -->
    <section class="contact-wrapper section-padding">
        <div class="container">
            <div class="contact-grid">
                <!-- Left Column -->
                <div class="left-column">
                    <div class="intro-block">
                        <span class="eyebrow">GET IN TOUCH</span>
                        <h2 class="main-heading">We are here to guide you every step of the way.</h2>
                        <p class="intro-text">
                            Whether you are dreaming of a private Nile cruise, a relaxing Red Sea holiday, or a
                            tailor-made cultural tour, our experienced travel specialists are here to assist you
                            with your travel plans.
                        </p>
                    </div>

                    <div class="contact-info-list">
                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="info-content">
                                <h6>LOCATION</h6>
                                <p>
                                    9 El Mosheer Ahmed Ismail Street<br>
                                    Sheraton Heliopolis - Block 1156, Ground Floor<br>
                                    Cairo, Egypt
                                </p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-brands fa-whatsapp"></i>
                            </div>
                            <div class="info-content">
                                <h6>CALL / WHATSAPP</h6>
                                <p>
                                    <a href="https://wa.me/201022322656" target="_blank">+20 102 232 2656</a>
                                    /
                                    <a href="tel:+20222675572">+20 2 22675572</a>
                                </p>
                            </div>
                        </div>

                        <div class="info-item">
                            <div class="info-icon">
                                <i class="fa-solid fa-envelope"></i>
                            </div>
                            <div class="info-content">
                                <h6>EMAIL</h6>
                                <p><a href="mailto:info@grandnilecruises.com">info@grandnilecruises.com</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="support-card">
                        <div class="support-icon">
                            <i class="fa-regular fa-clock"></i>
                        </div>
                        <div class="support-content">
                            <h4>24/7 Local Support</h4>
                            <p>Feel free to reach out to us anytime – we are always happy to hear from you and assist with
                                your luxury travel plans.</p>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="right-column">
                    <div class="why-choose-box">
                        <h3 class="why-title">Why Choose Best Choice Travel</h3>
                        <p class="why-subtitle">Experience Egypt through our eyes</p>

                        <div class="features-grid">
                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-star"></i>
                                </div>
                                <div>
                                    <h5>Licensed Excellence</h5>
                                    <p>Category (A) Travel Agency - License No. 1575</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-user-tie"></i>
                                </div>
                                <div>
                                    <h5>Expert Team</h5>
                                    <p>Egyptian Tourism Specialists</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-globe"></i>
                                </div>
                                <div>
                                    <h5>Global Travelers</h5>
                                    <p>Trusted by Travelers from Around the World</p>
                                </div>
                            </div>

                            <div class="feature-item">
                                <div class="feature-icon">
                                    <i class="fa-solid fa-trophy"></i>
                                </div>
                                <div>
                                    <h5>Award Winning</h5>
                                    <p>Recognized Excellence</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="stats-card">
                        <h3 class="stats-title">Our Journey in Numbers</h3>

                        <div class="stats-grid">
                            <div class="stat-item">
                                <div class="stat-number">15<sup>+</sup></div>
                                <div class="stat-label">Years Experience</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">1975<sup>+</sup></div>
                                <div class="stat-label">Happy Travelers</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">50<sup>+</sup></div>
                                <div class="stat-label">Sightseeing</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">24/7</div>
                                <div class="stat-label">Support</div>
                            </div>
                        </div>

                        <div class="cta-section">
                            <p class="cta-question">Ready to Start Your Journey?</p>
                            <div class="cta-buttons">
                                <a href="https://wa.me/20222675570" target="_blank" class="btn-whatsapp">
                                    WhatsApp Now
                                </a>
                                <a href="tel:+20222675572" class="btn-call">
                                    Call Directly
                                </a>
                            </div>
                        </div>

                        <div class="footer-note">
                            <p>We look forward to welcoming you to Egypt.</p>
                            <p class="company-name">Best Choice Travel</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        :root {
            --bct-navy: #2c4a6e;
            --bct-gold: #c59d5f;
            --bct-bg: #f8f6f3;
            --bct-dark-text: #2d3e50;
        }

        /* Hero */
        .contact-hero-unified {
            height: 725px;
            min-height: 725px;
            position: relative;
            display: flex;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(12, 20, 34, 0.72) 0%, rgba(12, 20, 34, 0.55) 50%, rgba(12, 20, 34, 0.72) 100%);
        }

        .contact-hero-unified .container {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 820px;
            margin: 0 auto;
            text-align: center;
        }

        .hero-content h1 {
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.12;
            margin-bottom: 12px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        }

        .hero-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.92);
            margin: 0;
        }

        /* Main Layout */
        .contact-wrapper {
            background-color: var(--bct-bg);
            padding: 80px 0;
        }

        .contact-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 50px;
            align-items: start;
        }

        /* Left Column */
        .left-column {
            display: flex;
            flex-direction: column;
            gap: 35px;
        }

        .intro-block .eyebrow {
            display: block;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 2px;
            color: var(--bct-gold);
            margin-bottom: 15px;
            text-transform: uppercase;
        }

        .intro-block .main-heading {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 700;
            line-height: 1.2;
            color: var(--bct-dark-text);
            margin-bottom: 20px;
            font-family: 'Playfair Display', serif;
        }

        .intro-block .intro-text {
            font-size: 16px;
            line-height: 1.7;
            color: #555;
            margin: 0;
        }

        /* Contact Info List */
        .contact-info-list {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }

        .info-item {
            display: flex;
            align-items: flex-start;
            gap: 18px;
        }

        .info-icon {
            width: 54px;
            height: 54px;
            background: var(--bct-gold);
            color: #fff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            flex-shrink: 0;
            box-shadow: 0 4px 12px rgba(197, 157, 95, 0.25);
        }

        .info-content h6 {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
            color: #999;
            margin-bottom: 8px;
            text-transform: uppercase;
        }

        .info-content p {
            font-size: 15px;
            color: var(--bct-dark-text);
            margin: 0;
            line-height: 1.6;
        }

        .info-content a {
            color: var(--bct-dark-text);
            text-decoration: none;
            transition: color 0.3s;
        }

        .info-content a:hover {
            color: var(--bct-gold);
        }

        /* Support Card */
        .support-card {
            background: var(--bct-navy);
            color: #fff;
            padding: 35px 30px;
            border-radius: 20px;
            display: flex;
            gap: 20px;
            box-shadow: 0 10px 30px rgba(44, 74, 110, 0.3);
        }

        .support-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            flex-shrink: 0;
        }

        .support-content h4 {
            font-size: 22px;
            font-weight: 700;
            margin-bottom: 10px;
            color: #fff;
        }

        .support-content p {
            font-size: 14px;
            line-height: 1.6;
            color: rgba(255, 255, 255, 0.85);
            margin: 0;
        }

        /* Right Column */
        .right-column {
            display: flex;
            flex-direction: column;
            gap: 30px;
        }

        /* Why Choose Box */
        .why-choose-box {
            background: #fff;
            padding: 35px;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.06);
        }

        .why-title {
            font-size: 24px;
            font-weight: 700;
            color: var(--bct-dark-text);
            margin-bottom: 8px;
        }

        .why-subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 30px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px 22px;
        }

        .feature-item {
            display: flex;
            gap: 12px;
            align-items: flex-start;
            min-height: 96px;
            padding: 14px;
            border-radius: 14px;
            background: #fff;
            border: 1px solid rgba(44, 74, 110, 0.14);
            transition: transform 0.3s ease, border-color 0.3s ease, background-color 0.3s ease;
        }

        .feature-icon {
            width: 40px;
            height: 40px;
            background: #c59d5f;
            color: var(--bct-navy);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
            transition: background-color 0.3s ease, color 0.3s ease, transform 0.3s ease;
        }

        .feature-item>div:last-child {
            min-width: 0;
        }

        .feature-item h5 {
            font-size: 15px;
            font-weight: 700;
            color: var(--bct-dark-text);
            margin: 0 0 6px;
            line-height: 1.3;
            transition: color 0.28s ease;
        }

        .feature-item p {
            font-size: 13px;
            color: #666;
            margin: 0;
            line-height: 1.45;
            word-break: break-word;
            transition: color 0.28s ease;
        }

        .feature-item:hover {
            transform: translateY(-5px);
            background: #fffdf9;
            border-color: rgba(197, 157, 95, 0.35);
        }

        .feature-item:hover .feature-icon {
            background: #c59d5f;
            color: var(--bct-navy);
            transform: translateY(-1px) scale(1.03);
        }

        .feature-item:hover h5 {
            color: #294665;
        }

        .feature-item:hover p {
            color: #6b7280;
        }

        /* Stats Card */
        .stats-card {
            background: linear-gradient(135deg, #b8925f 0%, #c59d5f 50%, #b8925f 100%);
            padding: 45px 40px;
            border-radius: 25px;
            color: #fff;
            box-shadow: 0 15px 40px rgba(197, 157, 95, 0.35);
        }

        .stats-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 35px;
            color: #fff;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 48px;
            font-weight: 700;
            line-height: 1;
            margin-bottom: 8px;
            color: #fff;
        }

        .stat-number sup {
            font-size: 28px;
            font-weight: 700;
        }

        .stat-label {
            font-size: 14px;
            color: rgba(255, 255, 255, 0.9);
            font-weight: 500;
        }

        .cta-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .cta-question {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #fff;
        }

        .cta-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .btn-whatsapp,
        .btn-call {
            padding: 14px 32px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-block;
        }

        .btn-whatsapp {
            background: #fff;
            color: var(--bct-gold);
        }

        .btn-whatsapp:hover {
            background: #f5f5f5;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
        }

        .btn-call {
            background: transparent;
            color: #fff;
            border: 2px solid #fff;
        }

        .btn-call:hover {
            background: #fff;
            color: var(--bct-gold);
            transform: translateY(-2px);
        }

        .footer-note {
            text-align: center;
            border-top: 1px solid rgba(255, 255, 255, 0.2);
            padding-top: 25px;
        }

        .footer-note p {
            font-size: 14px;
            margin-bottom: 5px;
            color: rgba(255, 255, 255, 0.9);
        }

        .company-name {
            font-size: 13px;
            font-weight: 600;
            color: rgba(255, 255, 255, 0.8);
        }

        /* Responsive */
        @media (max-width: 991px) {
            .contact-grid {
                grid-template-columns: 1fr;
                gap: 40px;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: 1fr 1fr;
            }

            .cta-buttons {
                flex-direction: column;
                align-items: stretch;
            }

            .support-card {
                flex-direction: column;
                text-align: center;
                align-items: center;
            }
        }

        @media (max-width: 576px) {
            .contact-wrapper {
                padding: 50px 0;
            }

            .intro-block .main-heading {
                font-size: 1.8rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
                gap: 25px;
            }
        }
    </style>
@endpush
