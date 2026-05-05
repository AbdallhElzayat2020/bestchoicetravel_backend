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
        $aboutIntro = $aboutSections['about_intro'] ?? null;
        $aboutCredentials = $aboutSections['about_credentials'] ?? null;
        $aboutMission = $aboutSections['about_mission'] ?? null;
        $aboutVision = $aboutSections['about_vision'] ?? null;
        $aboutServices = $aboutSections['about_services'] ?? null;
        $aboutWhyChoose = $aboutSections['about_why_choose'] ?? null;
        $aboutCta = $aboutSections['about_cta'] ?? null;

        $aboutBannerImage = ($aboutBanner && $aboutBanner->image_path)
            ? asset($aboutBanner->image_path)
            : asset('assets/frontend/images/about.webp');

        $credentials = [];
        if ($aboutCredentials && $aboutCredentials->content) {
            $decoded = json_decode($aboutCredentials->content, true);
            if (is_array($decoded)) {
                $credentials = $decoded;
            }
        }
        $services = [];
        if ($aboutServices && $aboutServices->content) {
            $decoded = json_decode($aboutServices->content, true);
            if (is_array($decoded)) {
                $services = $decoded;
            }
        }
        $whyItems = [];
        if ($aboutWhyChoose && $aboutWhyChoose->content) {
            $decoded = json_decode($aboutWhyChoose->content, true);
            if (is_array($decoded)) {
                $whyItems = $decoded;
            }
        }
    @endphp

    <!-- Banner Section -->
    <section class="about-banner-premium" style="background-image: url('{{ $aboutBannerImage }}');">
        <div class="banner-overlay"></div>
        <div class="container">
            <div class="banner-content scroll-animate" data-animation="fadeInDown">
                <h1 class="banner-title">{!! $aboutBanner && $aboutBanner->title ? $aboutBanner->title : 'About Us' !!}</h1>
                <div class="banner-subtitle about-richtext">
                    {!! $aboutBanner && $aboutBanner->subtitle ? $aboutBanner->subtitle : 'Discover who we are and why travelers choose us' !!}
                </div>
            </div>
        </div>
    </section>

    <section class="about-main-wrapper section-padding">
        <div class="container">

            <div class="about-bct-card mb-5">
                <span class="about-bct-eyebrow">{!! $aboutIntro->title ?? 'About Best Choice Travel' !!}</span>
                <h2 class="main-heading mb-3">{!! $aboutIntro->subtitle ?? 'Your Trusted Travel Partner in Egypt' !!}</h2>
                <div class="content-text about-richtext mb-3">{!! $aboutIntro->description ?? '' !!}</div>
                @if(!empty($aboutIntro?->content))
                    <div class="content-text about-richtext mb-0">{!! $aboutIntro->content !!}</div>
                @endif
            </div>

            <div class="about-bct-card license-card mb-5">
                <span class="about-bct-eyebrow">{!! $aboutCredentials->subtitle ?? 'Official Credentials' !!}</span>
                <h3 class="mb-4">{!! $aboutCredentials->title ?? 'Licensed Travel Company - Category (A)' !!}</h3>
                <div class="license-text about-richtext mb-3">{!! $aboutCredentials->description ?? '' !!}</div>
                @if(count($credentials))
                    <ul class="license-bullets mb-3">
                        @foreach($credentials as $row)
                            <li>
                                <strong>{!! $row['label'] ?? '' !!}:</strong> <span class="about-richtext d-inline">{!! $row['value'] ?? '' !!}</span>
                            </li>
                        @endforeach
                    </ul>
                @endif
                <p class="license-text mb-0">
                    This license allows the company to provide a range of tourism services, including inbound tourism,
                    tour operations, transportation, and travel arrangements for international visitors.
                </p>
            </div>

            <div class="row g-4 mb-5">
                <div class="col-lg-6">
                    <div class="about-bct-card h-100">
                        <div class="icon-circle primary"><i class="fa-solid fa-bullseye"></i></div>
                        <h3>{!! $aboutMission->title ?? 'Our Mission' !!}</h3>
                        <div class="about-richtext mb-0">{!! $aboutMission->description ?? '' !!}</div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about-bct-card h-100">
                        <div class="icon-circle accent"><i class="fa-solid fa-eye"></i></div>
                        <h3>{!! $aboutVision->title ?? 'Our Vision' !!}</h3>
                        <div class="about-richtext mb-0">{!! $aboutVision->description ?? '' !!}</div>
                    </div>
                </div>
            </div>

            <div class="services-container mb-5">
                <div class="text-center mb-5">
                    <span class="about-bct-eyebrow">{!! $aboutServices->subtitle ?? 'Travel Solutions' !!}</span>
                    <h3 class="fw-bold">{!! $aboutServices->title ?? 'What We Offer' !!}</h3>
                    @if(!empty($aboutServices?->description))
                        <div class="text-muted mt-2 mb-0 about-richtext">{!! $aboutServices->description !!}</div>
                    @endif
                </div>
                <div class="row g-4">
                    @foreach ($services as $service)
                        <div class="col-md-6 col-lg-4">
                            <div class="service-box-premium h-100">
                                <div class="s-icon"><i class="fa-solid {{ $service['icon'] ?? 'fa-star' }}"></i></div>
                                <h5>{!! $service['title'] ?? '' !!}</h5>
                                <div class="about-richtext">{!! $service['text'] ?? '' !!}</div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="about-bct-card why-choose-section mt-4">
                <h3 class="mb-4">{!! $aboutWhyChoose->title ?? 'Why Choose Best Choice Travel' !!}</h3>
                <div class="row g-3">
                    @foreach($whyItems as $item)
                        <div class="col-md-6">
                            <div class="why-choose-item">
                                <div class="why-choose-icon"><i class="fa-solid {{ $item['icon'] ?? 'fa-check' }}"></i></div>
                                <div>
                                    <h5>{!! $item['title'] ?? '' !!}</h5>
                                    <div class="mb-0 about-richtext">{!! $item['text'] ?? '' !!}</div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="about-bct-card dark-card text-center mt-4">
                <h3 class="text-white mb-4">{!! $aboutCta->title ?? 'Discover Egypt with Confidence' !!}</h3>
                <div class="about-richtext text-white-50 dark-card-richtext">
                    {!! $aboutCta->description ?? '' !!}
                </div>
            </div>
        </div>
    </section>
@endsection

@push('css')
    <style>
        :root {
            --primary-blue: #2b53a7;
            --bright-yellow: #f8e600;
            --deep-dark: #2b53a7;
            --soft-gray: #f4f7fa;
        }

        /* Premium Banner */
        .about-banner-premium {
            height: 725px;
            min-height: 725px;
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            position: relative;
            display: flex;
            align-items: center;
            color: #fff;
            overflow: hidden;
        }

        .about-banner-premium .container {
            position: relative;
            z-index: 2;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .banner-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, rgba(12, 20, 34, 0.72) 0%, rgba(12, 20, 34, 0.55) 50%, rgba(12, 20, 34, 0.72) 100%);
        }

        .banner-content {
            position: relative;
            z-index: 2;
            max-width: 820px;
            margin: 0 auto;
            text-align: center;
        }

        .banner-title {
            font-size: clamp(2.2rem, 5vw, 3.6rem);
            font-weight: 800;
            line-height: 1.12;
            margin-bottom: 12px;
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.35);
        }

        .banner-subtitle {
            font-size: clamp(1rem, 2vw, 1.2rem);
            line-height: 1.55;
            color: rgba(255, 255, 255, 0.92);
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
            background: var(--primary-blue);
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

        /* Rich text from Summernote */
        .about-richtext {
            color: inherit;
            line-height: 1.8;
        }

        .about-richtext p {
            margin-bottom: .75rem;
        }

        .about-richtext strong,
        .about-richtext b {
            font-weight: 800;
            color: #0f1d39;
            font-size: 1.05em;
        }

        .about-richtext h1,
        .about-richtext h2,
        .about-richtext h3,
        .about-richtext h4 {
            line-height: 1.3;
            margin: .45rem 0 .6rem;
            color: #0f1d39;
        }

        .about-richtext h1 { font-size: 1.9rem; }
        .about-richtext h2 { font-size: 1.6rem; }
        .about-richtext h3 { font-size: 1.35rem; }
        .about-richtext h4 { font-size: 1.15rem; }

        .about-richtext ul,
        .about-richtext ol {
            padding-left: 1.2rem;
            margin-bottom: .75rem;
        }

        .about-richtext li {
            margin-bottom: .35rem;
        }

        .dark-card-richtext,
        .dark-card-richtext p,
        .dark-card-richtext li,
        .dark-card-richtext span {
            color: rgba(255, 255, 255, 0.82) !important;
        }

        /* keep About page static without scroll animation */
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
