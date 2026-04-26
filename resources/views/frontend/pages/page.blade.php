@extends('frontend.layouts.master')

@php
    $metaTitle = $page->meta_title ?? $page->name;
    $metaDescription = $page->meta_description ?? null;
    $metaAuthor = $page->meta_author ?? null;
    $metaKeywords = $page->meta_keywords ?? null;

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
            <div class="container">
                <div class="policy-hero-inner scroll-animate" data-animation="fadeInUp">

                    <h1 class="policy-hero-title">{{ $page->name }}</h1>
                    @if ($metaDescription)
                        <p class="policy-hero-subtitle">
                            {{ \Illuminate\Support\Str::limit(strip_tags($metaDescription), 160) }}</p>
                    @endif
                </div>
            </div>
        </section>

        {{-- ─── Main Content ─────────────────────────────────────────────── --}}
        <section class="policy-body section-padding">
            <div class="container">
                <div class="policy-layout">

                    {{-- Sidebar --}}
                    <aside class="policy-sidebar scroll-animate" data-animation="fadeInLeft" data-delay="50">
                        <div class="policy-sidebar-card">
                            <h3 class="policy-sidebar-title">
                                <i class="fa-solid fa-scale-balanced me-2"></i>Legal Pages
                            </h3>
                            <ul class="policy-sidebar-links">
                                @foreach ($policyLinks as $link)
                                    @php
                                        $isActive = request()->routeIs($link['route']);
                                    @endphp
                                    <li>
                                        <a href="{{ route($link['route']) }}"
                                            class="policy-sidebar-link {{ $isActive ? 'active' : '' }}">
                                            <i class="fa-solid fa-chevron-right"></i>
                                            {{ $link['label'] }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="policy-sidebar-help scroll-animate" data-animation="fadeInLeft" data-delay="100">
                            <div class="policy-help-icon">
                                <i class="fa-solid fa-headset"></i>
                            </div>
                            <h4>Need Help?</h4>
                            <p>Our team is available 24/7 to answer your questions.</p>
                            <a href="{{ route('contact-us') }}" class="policy-help-btn">
                                <i class="fa-solid fa-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </aside>

                    {{-- Content --}}
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

                        {{-- Related Policy Links --}}
                        <div class="policy-related">
                            <h4 class="policy-related-title">Related Legal Pages</h4>
                            <div class="policy-related-grid">
                                @foreach ($policyLinks as $link)
                                    @if (!request()->routeIs($link['route']))
                                        <a href="{{ route($link['route']) }}" class="policy-related-card">
                                            <i class="fa-solid fa-file-lines"></i>
                                            <span>{{ $link['label'] }}</span>
                                            <i class="fa-solid fa-arrow-right ms-auto"></i>
                                        </a>
                                    @endif
                                @endforeach
                            </div>
                        </div>
                    </article>

                </div>
            </div>
        </section>

    </main>
@endsection

@push('css')
    <style>
        /* ─── Hero ───────────────────────────────────────────────────────── */
        .policy-hero {
            position: relative;
            min-height: 300px;
            display: flex;
            align-items: center;
            background: url('{{ asset('assets/images/Nile-Cruise.webp') }}') center/cover no-repeat;
            padding: 200px 0 120px;
        }

        .policy-hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, rgba(43, 83, 167, 0.85) 0%, rgba(33, 64, 130, 0.75) 100%);
        }

        .policy-hero-inner {
            position: relative;
            z-index: 1;
            color: #fff;
        }

        .policy-breadcrumb {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            margin-bottom: 14px;
            opacity: 0.85;
        }

        .policy-breadcrumb a {
            color: #fff;
            text-decoration: none;
            transition: opacity .2s;
        }

        .policy-breadcrumb a:hover {
            opacity: 0.7;
        }

        .policy-breadcrumb i {
            font-size: 10px;
        }

        .policy-hero-title {
            font-size: clamp(2rem, 4vw, 3rem);
            font-weight: 800;
            margin-bottom: 12px;
            line-height: 1.2;
        }

        .policy-hero-subtitle {
            font-size: 16px;
            opacity: 0.88;
            max-width: 600px;
            line-height: 1.6;
        }

        /* ─── Layout ─────────────────────────────────────────────────────── */
        .policy-layout {
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 32px;
            align-items: start;
        }

        @media (max-width: 900px) {
            .policy-layout {
                grid-template-columns: 1fr;
            }

            .policy-sidebar {
                order: 2;
            }

            .policy-content-wrap {
                order: 1;
            }
        }

        /* ─── Sidebar ────────────────────────────────────────────────────── */
        .policy-sidebar {
            display: flex;
            flex-direction: column;
            gap: 24px;
            position: sticky;
            top: 100px;
        }

        .policy-sidebar-card {
            background: #fff;
            border-radius: 16px;
            padding: 28px 24px;
            box-shadow: 0 4px 24px rgba(43, 83, 167, 0.08);
            border: 1px solid rgba(43, 83, 167, 0.07);
        }

        .policy-sidebar-title {
            font-size: 15px;
            font-weight: 700;
            color: var(--brand-blue);
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 2px solid rgba(43, 83, 167, 0.1);
        }

        .policy-sidebar-links {
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .policy-sidebar-links li+li {
            margin-top: 6px;
        }

        .policy-sidebar-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            border-radius: 10px;
            color: #555;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
        }

        .policy-sidebar-link i {
            font-size: 10px;
            opacity: 0.5;
            transition: all .2s;
        }

        .policy-sidebar-link:hover,
        .policy-sidebar-link.active {
            background: rgba(43, 83, 167, 0.07);
            color: var(--brand-blue);
        }

        .policy-sidebar-link.active {
            font-weight: 700;
            background: rgba(43, 83, 167, 0.1);
        }

        .policy-sidebar-link:hover i,
        .policy-sidebar-link.active i {
            opacity: 1;
            transform: translateX(3px);
        }

        /* ─── Sidebar Help ───────────────────────────────────────────────── */
        .policy-sidebar-help {
            background: linear-gradient(135deg, var(--brand-blue) 0%, var(--brand-blue-dark) 100%);
            border-radius: 16px;
            padding: 28px 24px;
            text-align: center;
            color: #fff;
        }

        .policy-help-icon {
            width: 52px;
            height: 52px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 14px;
            font-size: 22px;
        }

        .policy-sidebar-help h4 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .policy-sidebar-help p {
            font-size: 13px;
            opacity: 0.85;
            margin-bottom: 16px;
            line-height: 1.5;
        }

        .policy-help-btn {
            display: inline-flex;
            align-items: center;
            background: #fff;
            color: var(--brand-blue);
            border-radius: 999px;
            padding: 9px 20px;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
            transition: all .2s;
        }

        .policy-help-btn:hover {
            background: rgba(255, 255, 255, 0.9);
            color: var(--brand-blue-dark);
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
