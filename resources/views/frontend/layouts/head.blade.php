<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- Favicon --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/frontend/images/logo.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/frontend/images/logo.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/frontend/css/styles.css') }}">
    <!-- GoogleFonts -->
    <link href="https://fonts.googleapis.com/css2?family=Urbanist:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Iconify -->
    <script src="https://code.iconify.design/3/3.1.1/iconify.min.js"></script>
    <!-- Font Awesome 4.7.0 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Swiper -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <!-- Masonry -->
    <script src="https://cdn.jsdelivr.net/npm/masonry-layout@4/dist/masonry.pkgd.min.js"></script>
    <!-- Fancybox -->
    <link href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <!-- NoUiSlider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.8.1/nouislider.min.css">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Moment.js -->
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <!-- Daterangepicker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    @php
        $currentUrl = url()->current();
    @endphp

    <title>@hasSection('meta_title')@yield('meta_title')@else Travel Website @endif</title>

    <!-- Primary Meta Tags -->
    <meta name="title" content="@hasSection('meta_title')@yield('meta_title')@else Travel Website @endif">
    <meta name="description"
        content="@hasSection('meta_description')@yield('meta_description')@else Discover amazing travel destinations and book your next adventure with us. @endif">
    @hasSection('meta_author')
        <meta name="author" content="@yield('meta_author')">
    @endif
    @hasSection('meta_keywords')
        <meta name="keywords" content="@yield('meta_keywords')">
    @endif
    <meta name="robots" content="index, follow">
    <meta name="language" content="English">
    <link rel="canonical" href="{{ $currentUrl }}">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ $currentUrl }}">
    <meta property="og:title" content="@hasSection('meta_title')@yield('meta_title')@else Travel Website @endif">
    <meta property="og:description"
        content="@hasSection('meta_description')@yield('meta_description')@else Discover amazing travel destinations and book your next adventure with us. @endif">
    <meta property="og:image"
        content="@hasSection('meta_image')@yield('meta_image')@else {{ asset('assets/frontend/images/logo.png') }} @endif">
    <meta property="og:site_name" content="{{ config('app.name', 'Travel Website') }}">

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:url" content="{{ $currentUrl }}">
    <meta name="twitter:title" content="@hasSection('meta_title')@yield('meta_title')@else Travel Website @endif">
    <meta name="twitter:description"
        content="@hasSection('meta_description')@yield('meta_description')@else Discover amazing travel destinations and book your next adventure with us. @endif">
    <meta name="twitter:image"
        content="@hasSection('meta_image')@yield('meta_image')@else {{ asset('assets/frontend/images/logo.png') }} @endif">
    <style>
        #announcement-bar {
            position: relative;
            z-index: 50;
        }

        .announcement-scroll {
            display: inline-block;
            animation: scroll-horizontal 80s linear infinite;
            will-change: transform;
        }

        @keyframes scroll-horizontal {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        .announcement-scroll:hover {
            animation-play-state: paused;
        }

        /* Accommodation row hover styles */
        .accommodation-row:hover {
            background-color: #00AF87 !important;
        }

        .accommodation-row:hover .accommodation-name,
        .accommodation-row:hover .accommodation-price,
        .accommodation-row:hover .accommodation-desc {
            color: white !important;
        }

        .accommodation-row.bg-green-zomp .accommodation-name,
        .accommodation-row.bg-green-zomp .accommodation-price,
        .accommodation-row.bg-green-zomp .accommodation-desc {
            color: white !important;
        }

        /* Navbar dropdown items (applied to all dropdown <li>) */
        .nav-dropdown li a {
            display: block;
            padding: 0.85rem 1.5rem;
            background-color: #ffffff;
            text-align: center;
            transition: background-color 0.2s ease, color 0.2s ease;
        }

        .nav-dropdown li a:hover {
            background-color: #f2f4f4;
            color: #8b7138;
        }

        /* Width for all navbar dropdown menus */
        .nav-menu.nav-dropdown.divide-y.divide-light-grey {
            width: 230px;
        }

        /* Floating Action Buttons */
        .floating-whatsapp-btn {
            position: fixed;
            bottom: 24px;
            right: 24px;
            width: 56px;
            height: 56px;
            background-color: #25D366;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .floating-whatsapp-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background-color: #20ba5a;
        }

        .floating-whatsapp-btn .whatsapp-icon {
            color: white;
            font-size: 28px;
        }

        .floating-whatsapp-btn .notification-dot {
            position: absolute;
            top: -2px;
            right: -2px;
            width: 16px;
            height: 16px;
            background-color: #ff0000;
            border-radius: 50%;
            border: 2px solid white;
            animation: pulse 2s infinite;
        }


        .floating-scroll-top-btn {
            position: fixed;
            bottom: 90px;
            right: 24px;
            width: 56px;
            height: 56px;
            background-color: #4F5E71;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            z-index: 9999;
            transition: all 0.3s ease;
            text-decoration: none;
            opacity: 0;
            visibility: hidden;
            cursor: pointer;
        }

        .floating-scroll-top-btn.show {
            opacity: 1;
            visibility: visible;
        }

        .floating-scroll-top-btn:hover {
            transform: scale(1.1);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
            background-color: #3d4a5a;
        }

        .floating-scroll-top-btn .scroll-top-icon {
            color: white;
            font-size: 24px;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.5;
            }
        }

        /* Hero Slider Text Color Override */
        .hero-swiper .swiper-slide h1,
        .hero-swiper .swiper-slide h1 * {
            color: #8b7138 !important;
        }

        .hero-swiper .swiper-slide p,
        .hero-swiper .swiper-slide p * {
            color: #8b7138 !important;
        }

        @media (max-width: 768px) {

            .floating-whatsapp-btn,
            .floating-scroll-top-btn {
                width: 48px;
                height: 48px;
            }

            .floating-whatsapp-btn {
                bottom: 16px;
            }

            .floating-scroll-top-btn {
                bottom: 72px;
                right: 16px;
            }

            .floating-whatsapp-btn {
                right: 16px;
            }

            .floating-whatsapp-btn .whatsapp-icon,
            .floating-scroll-top-btn .scroll-top-icon {
                font-size: 24px;
            }

            .floating-whatsapp-btn .notification-dot {
                width: 12px;
                height: 12px;
            }
        }
    </style>
    @stack('css')
</head>
