<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    {{-- Favicon (same as navbar logo) --}}
    <link rel="icon" type="image/png" href="{{ asset('assets/frontend/images/logo_main.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/frontend/images/logo_main.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/frontend/images/logo_main.png') }}">

    @php
        $defaultTitle = 'Travel Egypt - Discover Ancient Wonders';
        $defaultDescription = 'Tailor-made tours across Egypt: Nile cruises, Cairo, Luxor, Aswan and Red Sea escapes.';
        $defaultImage = asset('assets/frontend/assets/images/logo_white.webp');

        $pageTitle = trim($__env->yieldContent('meta_title')) ?: $defaultTitle;
        $pageDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
        $pageAuthor = trim($__env->yieldContent('meta_author'));
        $pageKeywords = trim($__env->yieldContent('meta_keywords'));
        $pageImage = trim($__env->yieldContent('meta_image')) ?: $defaultImage;
    @endphp

    <title>{{ $pageTitle }}</title>
    <meta name="description" content="{{ $pageDescription }}">
    @if($pageAuthor)
        <meta name="author" content="{{ $pageAuthor }}">
    @endif
    @if($pageKeywords)
        <meta name="keywords" content="{{ $pageKeywords }}">
    @endif

    {{-- Open Graph / social sharing --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="{{ $pageTitle }}">
    <meta property="og:description" content="{{ $pageDescription }}">
    <meta property="og:image" content="{{ $pageImage }}">
    <meta property="og:url" content="{{ url()->current() }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $pageTitle }}">
    <meta name="twitter:description" content="{{ $pageDescription }}">
    <meta name="twitter:image" content="{{ $pageImage }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/styles.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Anta&family=Cairo:wght@200..1000&family=Noto+Serif:ital,wght@0,100..900;1,100..900&family=Playfair+Display:ital,wght@0,400..900;1,400..900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
        integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">

    @stack('head_extra')
    @stack('css')
</head>

@php
    $showAnnouncementBar =
        !empty($announcementBarEnabled ?? false) &&
        isset($sharedAnnouncementBar) &&
        $sharedAnnouncementBar;
@endphp

<body @class(['has-announcement-bar' => $showAnnouncementBar])>
    <!-- Scroll progress bar -->
    <div class="scroll-progress">
        <div class="scroll-progress-bar" id="scrollProgressBar"></div>
    </div>
    <!-- Navigation Bar -->

    <!-- Floating actions (WhatsApp + Scroll to top) -->
    <div class="floating-actions">
        <a href="https://wa.me/201234567890" target="_blank" rel="noopener" class="floating-btn floating-btn--whatsapp"
            id="whatsappBtn" aria-label="Chat on WhatsApp">
            <i class="fa-brands fa-whatsapp"></i>
        </a>
        <button type="button" class="floating-btn floating-btn--scrolltop" id="scrollTopBtn" aria-label="Scroll to top">
            <i class="fa-solid fa-arrow-up"></i>
        </button>
    </div>



    @if ($showAnnouncementBar)
        @include('frontend.layouts.announcement-bar')
    @endif

    <!-- Bootstrap Navbar -->
    @include('frontend.layouts.navbar')

    @yield('content')

    <!-- Footer -->
    @include('frontend.layouts.footer')

    @include('frontend.layouts.scripts')
</body>

</html>
