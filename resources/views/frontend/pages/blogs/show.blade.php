@extends('frontend.layouts.master')
@php
$metaTitle = $blog->meta_title ?? $blog->title;
$metaImage = $blog->cover_image ? asset('uploads/blogs/' . $blog->cover_image) : null;
@endphp
@section('meta_title', $metaTitle)
@if ($blog->meta_description)
@section('meta_description', $blog->meta_description)
@endif
@if ($blog->author)
@section('meta_author', $blog->author)
@endif
@if ($blog->meta_keywords)
@section('meta_keywords', $blog->meta_keywords)
@endif
@if ($metaImage)
@section('meta_image', $metaImage)
@endif

@section('content')
    <!-- Blog details hero -->
    <main class="blog-details-page">
        <section class="blog-details-hero section-padding">
            <div class="container">
                <div class="blog-details-breadcrumb scroll-animate" data-animation="fadeInUp">
                    <a href="index.html#home">Home</a>
                    <span>/</span>
                    <a href="blogs.html">Blog</a>
                    <span>/</span>
                    <span>How to Choose the Perfect Nile Cruise Itinerary</span>
                </div>

                <article class="blog-details-hero-card scroll-animate" data-animation="fadeInUp" data-delay="50">
                    <div class="blog-details-hero-image">
                        <img src="assets/images/desert-safar.jpg" alt="Nile Cruise Itinerary Guide">
                    </div>
                    <div class="blog-details-hero-body">
                        <div class="blog-card-meta blog-card-meta--hero">
                            <span><i class="fa-regular fa-calendar"></i> Mar 10, 2026</span>
                            <span><i class="fa-solid fa-tag"></i> Nile Cruises</span>
                            <span><i class="fa-regular fa-user"></i> Travel Egypt Team</span>
                        </div>
                        <h1 class="blog-details-title">
                            How to Choose the Perfect Nile Cruise Itinerary
                        </h1>
                    </div>
                </article>
            </div>
        </section>

        <!-- Blog content + sidebar -->
        <section class="blog-details-main section-padding">
            <div class="container">
                <div class="blog-details-layout">
                    <article class="blog-details-content scroll-animate" data-animation="fadeInUp" data-delay="0">
                        <h2>3, 4 or 7 Nights – What’s the Difference?</h2>
                        <p>
                            Most Nile cruises sail between Luxor and Aswan, with stops at temples such as Kom Ombo,
                            Edfu and Philae. The main difference is how much time you have on board and how relaxed
                            the pace feels.
                        </p>
                        <p>
                            A <strong>3‑night cruise</strong> typically focuses on the key highlights and is perfect if
                            you’re combining the Nile with Cairo and the Red Sea. A <strong>4‑night cruise</strong>
                            adds more time on the sun deck and slower sailing hours. A <strong>7‑night cruise</strong>
                            is ideal if you want a floating hotel experience with more time to unwind between tours.
                        </p>

                        <h3>When Is the Best Time to Cruise the Nile?</h3>
                        <p>
                            The most comfortable months are from <strong>October to April</strong> when daytime
                            temperatures are mild and evenings are cool. Summer sailings are still possible but expect
                            higher heat in the middle of the day and plan temple visits very early or late.
                        </p>

                        <blockquote class="blog-quote">
                            <p>
                                “Our favourite itineraries start in Luxor and finish in Aswan, giving you golden‑hour
                                views of the river and time to explore Nubian culture at the end of your journey.”
                            </p>
                        </blockquote>

                        <h3>What to Look For in a Cruise Ship</h3>
                        <ul>
                            <li><strong>Cabin size &amp; windows:</strong> look for full‑length windows or a balcony
                                for the best Nile views.</li>
                            <li><strong>Included sightseeing:</strong> check which temples and sites are covered in the
                                program.</li>
                            <li><strong>On‑board dining:</strong> ask about set menus vs. buffets and dietary options.
                            </li>
                            <li><strong>Group size:</strong> smaller groups usually mean more personalised guiding and
                                easier logistics.</li>
                        </ul>

                        <p>
                            At Travel Egypt Tours, we work only with vetted 5★ and boutique ships, and we match each
                            guest with the sailing that fits their travel style, budget and pace.
                        </p>
                    </article>

                    <aside class="blogs-sidebar blog-details-sidebar">
                        <div class="blog-sidebar-card blog-sidebar-search scroll-animate" data-animation="fadeInUp"
                            data-delay="0">
                            <h3 class="blog-sidebar-title">Search</h3>
                            <div class="blog-search-box">
                                <input type="text" placeholder="Search articles..." aria-label="Search blog">
                                <button type="button" aria-label="Search">
                                    <i class="fa-solid fa-magnifying-glass"></i>
                                </button>
                            </div>
                        </div>

                        <div class="blog-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="50">
                            <h3 class="blog-sidebar-title">Recent Articles</h3>
                            <ul class="blog-recent-list">
                                <li>
                                    <a href="blog-details.html">
                                        5 Essential Tips Before Your First Trip to Luxor
                                    </a>
                                </li>
                                <li>
                                    <a href="blog-details.html">
                                        Red Sea Snorkeling: Best Spots for First‑Time Visitors
                                    </a>
                                </li>
                                <li>
                                    <a href="blog-details.html">
                                        What to Pack for an Egypt Tour in Winter
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>
@endsection
