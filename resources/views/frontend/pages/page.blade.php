@extends('frontend.layouts.master')

@php
    $metaTitle = $page->meta_title ?? $page->name;
    $metaDescription = $page->meta_description ?? null;
    $metaAuthor = $page->meta_author ?? null;
    $metaKeywords = $page->meta_keywords ?? null;

    $bannerSrc = $page->banner_image
        ? asset('uploads/pages/' . $page->banner_image)
        : asset('assets/frontend/assets/images/destination-banner.png');

    $policyLinks = [
        ['label' => 'Terms & Conditions', 'route' => 'terms-and-conditions'],
        ['label' => 'Payment Policy', 'route' => 'payment-policy'],
        ['label' => 'Privacy Policy', 'route' => 'privacy-policy'],
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
    <main>

        {{-- ─── Hero Banner ─────────────────────────────────────────────── --}}
        <section class="policy-hero">
            <div class="policy-hero-overlay"></div>
            <div class="policy-hero-bg" style="background-image: url('{{ $bannerSrc }}');"></div>
            <div class="container">
                <div class="policy-hero-inner scroll-animate" data-animation="fadeInUp">
                    <h1 class="policy-hero-title">{{ $page->name }}</h1>
                    @if ($metaDescription)
                        <p class="policy-hero-subtitle">
                            {{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 160) }}
                        </p>
                    @endif
                </div>
            </div>
        </section>

        {{-- ─── Main Content ─────────────────────────────────────────────── --}}
        <section class="policy-body section-padding">
            <div class="container">

                <article class="policy-content-wrap scroll-animate" data-animation="fadeInUp" data-delay="50">
                    <div class="policy-content-card">
                        <div class="policy-content-header">
                            <h2 class="policy-content-title">{{ $page->name }}</h2>
                            <span class="policy-last-updated">
                                <i class="fa-regular fa-calendar me-1"></i>
                                Last updated: {{ $page->updated_at->format('F d, Y') }}
                            </span>
                        </div>
                        <div class="policy-divider"></div>
                        <div class="summernote-content policy-prose">
                            @if ($page->content)
                                {!! $page->content !!}
                            @else
                                <p class="text-muted">Content coming soon.</p>
                            @endif
                        </div>
                    </div>
                </article>

            </div>
        </section>

    </main>
@endsection

@push('css')
    <style>
        /* ─── Hero ───────────────────────────────────────────────────────── */
        .policy-hero {
            position: relative;
            min-height: 80vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        .policy-hero-bg {
            position: absolute;
            inset: 0;
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .policy-hero-overlay {
            position: absolute;
            inset: 0;
            background: #000;
            opacity: 0.5;
            z-index: 1;
        }

        .policy-hero .container {
            position: relative;
            z-index: 2;
        }

        .policy-hero-inner {
            text-align: center;
            max-width: 720px;
            margin: 0 auto;
            color: #fff;
        }

        .policy-hero-title {
            font-family: "Cairo", sans-serif;
            font-size: 48px;
            font-weight: 700;
            color: #ffffff;
            margin-bottom: 12px;
            letter-spacing: -0.02em;
        }

        .policy-hero-subtitle {
            font-size: 17px;
            color: rgba(255, 255, 255, 0.9);
            line-height: 1.7;
            margin: 0;
            max-width: 600px;
        }

        @media (max-width: 992px) {
            .policy-hero-title {
                font-size: 36px;
            }
        }

        @media (max-width: 768px) {
            .policy-hero {
                min-height: 36vh;
            }

            .policy-hero-title {
                font-size: 28px;
            }

            .policy-hero-subtitle {
                font-size: 15px;
            }
        }

        /* ─── Content Card ───────────────────────────────────────────────── */
        .policy-content-card {
            background: #fff;
            border-radius: 20px;
            padding: 40px 44px;
            box-shadow: 0 4px 32px rgba(43, 83, 167, 0.07);
            border: 1px solid rgba(43, 83, 167, 0.06);
            margin-bottom: 28px;
        }

        @media (max-width: 600px) {
            .policy-content-card {
                padding: 24px 20px;
            }
        }

        .policy-content-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 16px;
        }

        .policy-content-title {
            font-size: 26px;
            font-weight: 800;
            color: var(--brand-blue);
            margin: 0;
        }

        .policy-last-updated {
            font-size: 12px;
            color: #999;
            white-space: nowrap;
            margin-top: 6px;
        }

        .policy-divider {
            height: 3px;
            background: linear-gradient(90deg, var(--brand-blue) 0%, var(--brand-blue-light) 100%);
            border-radius: 99px;
            margin-bottom: 28px;
            width: 60px;
        }

        /* ─── Prose ──────────────────────────────────────────────────────── */
        .policy-prose {
            color: #4a5568;
            line-height: 1.8;
            font-size: 15.5px;
        }

        .policy-prose h2 {
            font-size: 1.5rem;
            font-weight: 800;
            color: var(--brand-blue);
            margin: 1.8em 0 0.6em;
        }

        .policy-prose h3 {
            font-size: 1.15rem;
            font-weight: 700;
            color: #1a202c;
            margin: 1.6em 0 0.5em;
        }

        .policy-prose h4 {
            font-size: 1rem;
            font-weight: 700;
            color: #1a202c;
            margin: 1.4em 0 0.4em;
        }

        .policy-prose p {
            margin-bottom: 1em;
        }

        .policy-prose ul,
        .policy-prose ol {
            padding-left: 1.8em;
            margin: 1em 0;
        }

        .policy-prose li {
            margin-bottom: 0.5em;
        }

        .policy-prose strong,
        .policy-prose b {
            font-weight: 700;
            color: #1a202c;
        }

        .policy-prose a {
            color: var(--brand-blue);
            text-decoration: none;
            border-bottom: 1px solid rgba(43, 83, 167, 0.3);
            transition: border-color .2s;
        }

        .policy-prose a:hover {
            border-color: var(--brand-blue);
        }

        .policy-prose blockquote {
            border-left: 4px solid var(--brand-blue);
            padding: 12px 20px;
            margin: 1.5em 0;
            font-style: italic;
            color: #718096;
            background: rgba(43, 83, 167, 0.04);
            border-radius: 0 8px 8px 0;
        }

        .policy-prose hr {
            border: none;
            border-top: 1px solid #e2e8f0;
            margin: 2em 0;
        }

        .policy-prose table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5em 0;
            font-size: 14px;
        }

        .policy-prose table th,
        .policy-prose table td {
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            text-align: left;
        }

        .policy-prose table th {
            background: rgba(43, 83, 167, 0.06);
            font-weight: 700;
            color: var(--brand-blue);
        }

        .policy-prose table tr:nth-child(even) td {
            background: #f9fafb;
        }

        .policy-prose img {
            max-width: 100%;
            border-radius: 10px;
            margin: 1.5em 0;
        }

        .policy-prose code {
            background: #f7fafc;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 0.9em;
            color: #e53e3e;
        }

        /* ─── Related ────────────────────────────────────────────────────── */
        .policy-related-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--brand-blue);
            margin-bottom: 14px;
        }

        .policy-related-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
        }

        .policy-related-card {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1 1 220px;
            background: #fff;
            border: 1.5px solid rgba(43, 83, 167, 0.12);
            border-radius: 12px;
            padding: 14px 18px;
            color: var(--brand-blue);
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            transition: all .2s;
        }

        .policy-related-card:hover {
            background: var(--brand-blue);
            border-color: var(--brand-blue);
            color: #fff;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(43, 83, 167, 0.2);
        }
    </style>
@endpush
