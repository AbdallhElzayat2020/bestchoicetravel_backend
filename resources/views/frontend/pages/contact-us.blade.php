@extends('frontend.layouts.master')

@php
    // --- Logic Section ---
    $metaTitle = $page && $page->meta_title ? $page->meta_title : 'Contact Us';
    $metaDescription = $page ? $page->meta_description ?? null : null;
    $metaAuthor = $page ? $page->meta_author ?? null : null;
    $metaKeywords = $page ? $page->meta_keywords ?? null : null;

    // البيانات المستخرجة من المحتوى الذي أرسلته[cite: 1]
    $contactWhatsapp = '+20 102 232 2656';
    $whatsappHref = '201022322656';
    $contactTelephone1 = '+20 2 22675570';
    $contactTelephone2 = '+20 2 22675572';
    $contactEmail = 'Info@Bestchoice.Travel';

    // تقسيم العنوان لأسطر كما في المصدر[cite: 1]
    $addressLines = [
        '9 El Mosheer Ahmed Ismail Street',
        'Sheraton Heliopolis - Block 1156, Ground Floor',
        'Cairo, Egypt',
    ];
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
            <div class="hero-content mt-5">
                <h1>Get in Touch With Us</h1>
                <p>
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
            <div class="row g-4">

                <!-- Contact Info Column -->
                <div class="col-lg-7">
                    <div class="info-main-card mb-4">
                        <div class="card-title-area">
                            <h3>Head Office</h3>
                            <span class="badge-blue">Cairo, Egypt</span>
                        </div>

                        <div class="contact-methods-grid">
                            <!-- Address -->
                            <div class="method-box">
                                <div class="icon-wrap"><i class="fa-solid fa-location-dot"></i></div>
                                <div>
                                    <h5>Address</h5>
                                    <p>
                                        @foreach ($addressLines as $line)
                                            {{ $line }} <br>
                                        @endforeach
                                    </p>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            <div class="method-box">
                                <div class="icon-wrap"><i class="fa-brands fa-whatsapp"></i></div>
                                <div>
                                    <h5>Phone / WhatsApp</h5>
                                    <p><a href="https://wa.me/{{ $whatsappHref }}"
                                            target="_blank">{{ $contactWhatsapp }}</a></p>
                                </div>
                            </div>

                            <!-- Phone -->
                            <div class="method-box">
                                <div class="icon-wrap"><i class="fa-solid fa-phone"></i></div>
                                <div>
                                    <h5>Telephone</h5>
                                    <p>
                                        <a
                                            href="tel:{{ str_replace(' ', '', $contactTelephone1) }}">{{ $contactTelephone1 }}</a>
                                        <br>
                                        <a
                                            href="tel:{{ str_replace(' ', '', $contactTelephone2) }}">{{ $contactTelephone2 }}</a>
                                    </p>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="method-box">
                                <div class="icon-wrap"><i class="fa-solid fa-envelope"></i></div>
                                <div>
                                    <h5>Email</h5>
                                    <p><a href="mailto:{{ $contactEmail }}">{{ $contactEmail }}</a></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Why Us Strip -->
                    <div class="trust-strip">
                        <h4 class="mb-3"><i class="fa-solid fa-shield-halved me-2"></i>Why Contact Best Choice Travel</h4>
                        <ul class="trust-list">
                            <li><i class="fa-solid fa-check"></i> Licensed Category (A) Travel Agency (License No. 1575)
                            </li>
                            <li><i class="fa-solid fa-check"></i> Professional travel consultants with years of experience
                            </li>
                            <li><i class="fa-solid fa-check"></i> Personalized travel planning and custom tours</li>
                            <li><i class="fa-solid fa-check"></i> Fast response to inquiries and booking requests</li>
                        </ul>
                    </div>
                </div>

                <!-- Sidebar Column -->
                <div class="col-lg-5">
                    <!-- Office Hours -->
                    <div class="sidebar-blue-card mb-4">
                        <div class="working-hours">
                            <h4><i class="fa-regular fa-clock me-2"></i>Office Hours</h4>
                            <p class="mt-3"><strong>Working Hours:</strong><br>
                                Sunday – Thursday: 9:00 AM – 5:00 PM</p>
                            <p class="small opacity-75">Our online support team is available to assist travelers worldwide
                                and respond quickly[cite: 1].</p>
                        </div>
                        <hr class="border-light opacity-25 my-4">
                        <div class="cta-sidebar text-center">
                            <h5>Start Planning Today</h5>
                            <p class="small mb-4">Your journey to Egypt starts with a simple message.</p>
                            <a href="{{ route('trip-planner') }}" class="btn-unified-action">
                                Trip Planner <i class="fa-solid fa-paper-plane ms-2"></i>
                            </a>
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
            --bct-blue: #2b53a7;
            --bct-blue-dark: #1e3d7d;
            --bct-yellow: #f8e600;
            --bct-bg: #f4f7fa;
        }

        /* Hero */
        .contact-hero-unified {
            height: 450px;
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
            background-position: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(0, 0, 0, 0.8), rgba(43, 83, 167, 0.5));
        }

        .hero-content {
            position: relative;
            z-index: 2;
            max-width: 800px;
        }

        .contact-label {
            color: var(--bct-yellow);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 14px;
            letter-spacing: 1px;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        /* Layout */
        .contact-wrapper {
            background-color: #fff;
        }

        .info-main-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 16px 36px rgba(24, 39, 75, 0.08);
            border: 1px solid rgba(43, 83, 167, 0.16);
            transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
        }

        .info-main-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 44px rgba(24, 39, 75, 0.12);
            border-color: rgba(43, 83, 167, 0.24);
        }

        .card-title-area {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            border-bottom: 1px solid #eee;
            padding-bottom: 20px;
        }

        .badge-blue {
            background: var(--bct-blue);
            color: #fff;
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 700;
        }

        .contact-methods-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 30px;
        }

        .method-box {
            display: flex;
            gap: 15px;
        }

        .icon-wrap {
            width: 48px;
            height: 48px;
            background: rgba(43, 83, 167, 0.08);
            color: var(--bct-blue);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .method-box h5 {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .method-box p,
        .method-box a {
            color: #555;
            text-decoration: none;
            font-size: 15px;
            line-height: 1.6;
        }

        .method-box a:hover {
            color: var(--bct-blue);
            text-decoration: underline;
        }

        /* Trust Strip */
        .trust-strip {
            background: #fff;
            color: var(--text-dark);
            padding: 30px;
            border-radius: 20px;
            border: 1px solid var(--border-light);
        }

        .trust-list {
            list-style: none;
            padding: 0;
            margin: 0;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px;
        }

        .trust-list li {
            font-size: 14px;
            display: flex;
            gap: 10px;
            align-items: flex-start;
        }

        .trust-list li i {
            color: var(--bct-blue);
            margin-top: 4px;
        }

        /* Sidebar */
        .sidebar-blue-card {
            background: #fff;
            color: var(--text-dark);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 16px 36px rgba(24, 39, 75, 0.08);
            border: 1px solid rgba(43, 83, 167, 0.16);
            transition: box-shadow .25s ease, transform .25s ease, border-color .25s ease;
        }

        .sidebar-blue-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 22px 44px rgba(24, 39, 75, 0.12);
            border-color: rgba(43, 83, 167, 0.24);
        }

        .btn-unified-action {
            background: var(--bct-blue);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 16px 30px;
            border-radius: 12px;
            font-weight: 800;
            text-decoration: none;
            width: 100%;
            transition: 0.3s;
        }

        .btn-unified-action:hover {
            background: var(--bct-blue-dark);
            color: #fff;
            transform: translateY(-3px);
        }

        .services-mini-card {
            background: #fff;
            padding: 30px;
            border-radius: 20px;
            border-left: 5px solid var(--bct-blue);
        }

        .mini-service-list {
            list-style: none;
            padding: 0;
            margin-top: 15px;
        }

        .mini-service-list li {
            margin-bottom: 8px;
            font-size: 14px;
            position: relative;
            padding-left: 20px;
        }

        .mini-service-list li::before {
            content: "→";
            position: absolute;
            left: 0;
            color: var(--bct-blue);
            font-weight: bold;
        }

        @media (max-width: 991px) {
            .trust-list {
                grid-template-columns: 1fr;
            }

            .hero-content h1 {
                font-size: 2.5rem;
            }
        }
    </style>
@endpush
