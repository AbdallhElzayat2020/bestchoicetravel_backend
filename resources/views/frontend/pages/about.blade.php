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
        $aboutBannerImage =
            $aboutBanner && $aboutBanner->image_path
                ? asset($aboutBanner->image_path)
                : asset('assets/frontend/images/about.webp');
    @endphp

    <!-- Banner Section -->
    <section class="about-banner-premium" style="background-image: url('{{ $aboutBannerImage }}');">
        <div class="banner-overlay"></div>
        <div class="container">
            <div class="banner-content scroll-animate" data-animation="fadeInDown">
                <h1 class="banner-title">{{ $aboutBanner && $aboutBanner->title ? $aboutBanner->title : 'About Us' }}</h1>
                <div class="banner-divider"></div>
                <p class="banner-subtitle">
                    {{ $aboutBanner && $aboutBanner->subtitle ? $aboutBanner->subtitle : 'Discover who we are and why travelers choose us' }}
                </p>
            </div>
        </div>
    </section>

    <section class="about-main-wrapper section-padding">
        <div class="container">

            <!-- Company Intro Section -->
            <div class="about-intro-group mb-5 scroll-animate" data-animation="fadeInUp">
                <div class="about-bct-card intro-card about-intro-head mb-3">
                    <div class="card-glow"></div>
                    <span class="about-bct-eyebrow">About Best Choice Travel</span>
                    <h2 class="main-heading mb-3">Your Trusted Travel Partner in Egypt</h2>

                    <div class="row g-4">
                        <div class="col-lg-12">
                            <p class="content-text mb-0">
                                <span class="fw-bold">Best Choice Travel (BCT)</span> is a professional tour operator and
                                destination management company (DMC) based in Egypt, dedicated to delivering exceptional
                                travel experiences to clients from around the world. Established in
                                <span class="fw-bold">2007</span>, the company has built a strong reputation for providing
                                high-quality travel services, personalized itineraries, and unforgettable journeys across
                                Egypt and the Middle East.
                            </p>
                        </div>
                        <div class="col-lg-12">
                            <p class="content-text mb-0">
                                From the ancient wonders of the Pyramids and the temples of Luxor to the stunning beaches
                                of the Red Sea, Best Choice Travel creates carefully designed travel experiences that
                                combine history, culture, adventure, and luxury.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Credentials Section -->
            <div class="about-bct-card license-card mb-5 scroll-animate" data-animation="fadeInUp">
                <span class="about-bct-eyebrow">Official Credentials</span>
                <h3 class="mb-4">Licensed Travel Company - Category (A)</h3>
                <p class="license-text mb-3">
                    Best Choice Travel is a <strong>fully licensed Egyptian travel agency, classified as Category (A) by
                        the Egyptian Ministry of Tourism</strong>, the highest level of licensing for tourism companies in
                    Egypt.
                </p>
                <ul class="license-bullets mb-3">
                    <li><strong>Tourism License:</strong> Category (A) - License No. <strong>1575</strong></li>
                    <li><strong>Member of:</strong> Egyptian Travel Agents Association (ETAA)</li>
                    <li><strong>IATA Membership:</strong> No. <strong>90228121</strong></li>
                    <li><strong>Established:</strong> 2007</li>
                </ul>
                <p class="license-text mb-0">
                    This license allows the company to provide a range of tourism services, including inbound tourism,
                    tour operations, transportation, and travel arrangements for international visitors.
                </p>
            </div>

            <!-- Mission & Vision Row -->
            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="about-bct-card h-100 scroll-animate" data-animation="fadeInLeft">
                        <div class="icon-circle primary"><i class="fa-solid fa-bullseye"></i></div>
                        <h3>Our Mission</h3>
                        <p class="mb-0">To provide authentic, memorable, and seamless travel experiences while maintaining
                            the highest standards of professionalism and customer satisfaction.</p>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-bct-card h-100 scroll-animate" data-animation="fadeInRight">
                        <div class="icon-circle accent"><i class="fa-solid fa-eye"></i></div>
                        <h3>Our Vision</h3>
                        <p class="mb-0">To become a leading travel company in the MENA region by delivering innovative
                            services that showcase Egypt's beauty and hospitality.</p>
                    </div>
                </div>
            </div>

            <!-- Services Section -->
            <div class="services-container mb-5">
                <div class="text-center mb-5">
                    <span class="about-bct-eyebrow">Travel Solutions</span>
                    <h3 class="fw-bold">What We Offer</h3>
                </div>
                <div class="row g-4">
                    @php
                        $services = [
                            [
                                'icon' => 'fa-map-location-dot',
                                'title' => 'Egypt Tour Packages',
                                'desc' => 'Tailor-made itineraries including Cairo, Luxor, Aswan, and the Red Sea.',
                            ],
                            [
                                'icon' => 'fa-ship',
                                'title' => 'Nile Cruise Experiences',
                                'desc' => 'Luxury cruises and Dahabiya sailing between Luxor and Aswan.',
                            ],
                            [
                                'icon' => 'fa-camera-retro',
                                'title' => 'Day Tours',
                                'desc' => 'Private guided tours across Egypt’s most famous destinations.',
                            ],
                            [
                                'icon' => 'fa-gem',
                                'title' => 'Luxury Travel',
                                'desc' => 'Customized itineraries for discerning travelers seeking exclusivity.',
                            ],
                            [
                                'icon' => 'fa-briefcase',
                                'title' => 'Corporate & MICE',
                                'desc' => 'Professional organization of meetings, conferences, and events.',
                            ],
                            [
                                'icon' => 'fa-van-shuttle',
                                'title' => 'Transportation',
                                'desc' => 'Private airport transfers and modern transportation solutions.',
                            ],
                        ];
                    @endphp
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <div class="service-box-premium h-100">
                                <div class="s-icon"><i class="fa-solid {{ $service['icon'] }}"></i></div>
                                <h5>{{ $service['title'] }}</h5>
                                <p>{{ $service['desc'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>



            <!-- Why Choose Section (Reference-based) -->
            <div class="about-bct-card why-choose-section mt-4 scroll-animate" data-animation="fadeInUp">
                <h3 class="mb-4">Why Choose Best Choice Travel</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="why-choose-item">
                            <div class="why-choose-icon"><i class="fa-solid fa-shield-halved"></i></div>
                            <div>
                                <h5>Licensed & Trusted</h5>
                                <p>Operating under an official tourism license Category (A), ensuring full compliance with
                                    Egyptian tourism regulations.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="why-choose-item">
                            <div class="why-choose-icon"><i class="fa-solid fa-user-tie"></i></div>
                            <div>
                                <h5>Experienced Team</h5>
                                <p>Professional travel advisors, certified Egyptologist guides, and dedicated support staff.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="why-choose-item">
                            <div class="why-choose-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
                            <div>
                                <h5>Tailor-Made Experiences</h5>
                                <p>Every itinerary is customized according to traveler preferences.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="why-choose-item">
                            <div class="why-choose-icon"><i class="fa-solid fa-scale-balanced"></i></div>
                            <div>
                                <h5>Quality & Value</h5>
                                <p>Competitive prices combined with premium travel services.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="why-choose-item">
                            <div class="why-choose-icon"><i class="fa-solid fa-headset"></i></div>
                            <div>
                                <h5>24/7 Customer Support</h5>
                                <p class="mb-0">Dedicated assistance before, during, and after your trip.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Why Us & CTA -->
            <div class="about-bct-card dark-card text-center scroll-animate" data-animation="fadeInUp">
                <h3 class="text-white mb-4">Discover Egypt with Confidence</h3>
                <div class="d-flex flex-wrap justify-content-center gap-3 mb-4">
                    <span class="why-tag"><i class="fa-solid fa-check"></i> Licensed & Trusted</span>
                    <span class="why-tag"><i class="fa-solid fa-check"></i> Experienced Team</span>
                    <span class="why-tag"><i class="fa-solid fa-check"></i> 24/7 Support</span>
                </div>
                <p class="text-white-50">
                    Whether you are looking for a cultural journey through the ancient temples, a relaxing holiday on the
                    Red Sea, or a luxury Nile cruise adventure, Best Choice Travel is committed to making your dream trip to
                    Egypt a reality.
                </p>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        :root {
            --primary-blue: #2b53a7;
            --bright-yellow: #f8e600;
            --deep-dark: #141b2d;
            --soft-gray: #f4f7fa;
        }

        /* Premium Banner */
        .about-banner-premium {
            height: 500px;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            display: flex;
            align-items: center;
            color: #fff;
        }

        .about-banner-premium .container {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to right, rgba(20, 27, 45, 0.72), rgba(43, 83, 167, 0.38));
        }

        .banner-content {
            position: relative;
            z-index: 2;
            max-width: 700px;
            margin: 0;
        }

        .banner-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 15px;
        }

        .banner-divider {
            width: 100px;
            height: 6px;
            background: var(--bright-yellow);
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .banner-subtitle {
            font-size: 1.25rem;
            opacity: 0.9;
        }

        /* Cards System */
        .about-bct-card {
            background: #fff;
            border-radius: 30px;
            padding: 45px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.04);
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
            transition: transform 0.3s ease;
        }

        .about-bct-card:hover {
            transform: translateY(-5px);
        }

        .about-intro-head {
            border-top: 4px solid var(--primary-blue);
            padding-bottom: 30px;
        }

        .about-intro-body {
            border: 1px solid rgba(43, 83, 167, 0.14);
            box-shadow: 0 16px 36px rgba(24, 39, 75, 0.07);
        }

        .about-intro-body .content-text {
            margin: 0;
        }

        .about-bct-eyebrow {
            color: var(--primary-blue);
            background: rgba(43, 83, 167, 0.1);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            display: inline-block;
            margin-bottom: 20px;
        }

        /* Credentials Style */
        .cred-item {
            background: var(--soft-gray);
            padding: 20px;
            border-radius: 20px;
            text-align: center;
            border: 1px solid transparent;
            transition: 0.3s;
        }

        .cred-item:hover {
            border-color: var(--primary-blue);
            background: #fff;
        }

        .cred-item i {
            font-size: 24px;
            color: var(--primary-blue);
            margin-bottom: 10px;
            display: block;
        }

        .cred-label {
            font-size: 11px;
            text-transform: uppercase;
            color: #777;
            display: block;
        }

        .cred-value {
            font-weight: 700;
            font-size: 14px;
            color: var(--deep-dark);
        }

        .license-text {
            color: #1f2937;
            font-size: 1.05rem;
            line-height: 1.75;
        }

        .license-bullets {
            margin: 0 0 10px 0;
            padding-left: 1.3rem;
        }

        .license-bullets li {
            color: #111827;
            font-size: 1.03rem;
            line-height: 1.7;
            margin-bottom: 4px;
        }

        /* Service Box */
        .service-box-premium {
            background: #fff;
            padding: 35px;
            border-radius: 25px;
            border: 1px solid #eee;
            transition: 0.4s;
        }

        .service-box-premium:hover {
            background: var(--primary-blue);
            border-color: var(--primary-blue);
        }

        .service-box-premium:hover * {
            color: #fff !important;
        }

        .s-icon {
            font-size: 40px;
            color: var(--primary-blue);
            margin-bottom: 20px;
        }

        /* Special Helpers */
        .icon-circle {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 25px;
            margin-bottom: 20px;
        }

        .icon-circle.primary {
            background: rgba(43, 83, 167, 0.1);
            color: var(--primary-blue);
        }

        .icon-circle.accent {
            background: rgba(248, 230, 0, 0.2);
            color: #b5a400;
        }

        .dark-card {
            background: var(--deep-dark);
            color: #fff;
            border: none;
        }

        .why-tag {
            background: rgba(255, 255, 255, 0.1);
            padding: 8px 20px;
            border-radius: 50px;
            font-size: 14px;
        }

        .why-tag i {
            color: var(--bright-yellow);
            margin-right: 8px;
        }

        .why-choose-section {
            border-top: 4px solid var(--primary-blue);
        }

        .why-choose-item {
            display: flex;
            gap: 14px;
            align-items: flex-start;
            background: #fff;
            border: 1px solid rgba(43, 83, 167, 0.16);
            border-radius: 14px;
            padding: 16px;
            height: 100%;
            transition: transform .2s ease, box-shadow .2s ease, border-color .2s ease;
        }

        .why-choose-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 24px rgba(43, 83, 167, 0.12);
            border-color: rgba(43, 83, 167, 0.3);
        }

        .why-choose-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(43, 83, 167, 0.1);
            color: var(--primary-blue);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-size: 15px;
            margin-top: 2px;
        }

        .why-choose-item h5 {
            margin-bottom: 6px;
            color: #0f1d39;
        }

        .why-choose-item p {
            margin: 0;
            color: #334155;
            line-height: 1.7;
        }

        /* Disable scroll-based animations on About page only */
        .about-main-wrapper .scroll-animate,
        .about-banner-premium .scroll-animate,
        .about-main-wrapper .scroll-animate.animate,
        .about-banner-premium .scroll-animate.animate {
            opacity: 1 !important;
            transform: none !important;
            animation: none !important;
            transition: none !important;
            filter: none !important;
        }

        @media (max-width: 768px) {
            .banner-title {
                font-size: 2.2rem;
            }

            .about-bct-card {
                padding: 25px;
            }

            .about-intro-head {
                padding-bottom: 22px;
            }
        }
    </style>
@endpush
