@extends('frontend.layouts.master')
@php
    $blogsPage = \App\Models\Page::getBySlug('blogs');
@endphp
@section('meta_title', $blogMetaTitle ?? ($blogsPage && $blogsPage->meta_title ? $blogsPage->meta_title : 'Blogs'))
@php
    $__blogDesc = $blogMetaDescription ?? ($blogsPage && $blogsPage->meta_description ? $blogsPage->meta_description : '');
@endphp
@if ($__blogDesc !== '')
    @section('meta_description', $__blogDesc)
@endif
@if ($blogsPage && $blogsPage->meta_author)
    @section('meta_author', $blogsPage->meta_author)
@endif
@if ($blogsPage && $blogsPage->meta_keywords)
    @section('meta_keywords', $blogsPage->meta_keywords)
@endif

@push('head_extra')
    @if (!empty($blogCanonicalUrl))
        <link rel="canonical" href="{{ $blogCanonicalUrl }}">
    @endif
    @if (!empty($blogRobots))
        <meta name="robots" content="{{ $blogRobots }}">
    @endif
@endpush

@section('content')
    <!-- Blog Listing Page -->
    <main class="blogs-page">
        <!-- Hero / intro -->
        <section class="blogs-hero section-padding">
            <div class="container">
                <div class="blogs-hero-inner">
                    <div class="section-label scroll-animate" data-animation="fadeInUp">
                        <span class="star-icon">✦</span>
                        <span>TRAVEL EGYPT BLOG</span>
                        <span class="star-icon">✦</span>
                    </div>
                    <h1 class="blogs-hero-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                        Stories, Guides &amp; <span class="highlight">Travel Tips</span>
                    </h1>
                    <p class="blogs-hero-subtitle scroll-animate" data-animation="fadeInUp" data-delay="100">
                        Inspiration and practical advice to help you plan your next journey across Egypt –
                        from Cairo and the Nile to the Red Sea and beyond.
                    </p>
                </div>
            </div>
        </section>

        <!-- Blog list + sidebar -->
        <section class="blogs-main section-padding">
            <div class="container">
                <div class="blogs-layout">
                    <!-- Left: blog cards -->
                    <div class="blogs-list">
                        @forelse ($blogs as $index => $blog)
                            <article class="blog-card scroll-animate" data-animation="fadeInUp"
                                data-delay="{{ $index * 50 }}"
                                onclick="window.location='{{ route('blogs.show', $blog->slug) }}'"
                                onkeydown="if(event.key === 'Enter' || event.key === ' ') { event.preventDefault(); window.location='{{ route('blogs.show', $blog->slug) }}'; }"
                                role="link" tabindex="0" aria-label="Open article: {{ $blog->title }}">
                                <div class="blog-card-image">
                                    @php
                                        $cover = $blog->cover_image
                                            ? asset('uploads/blogs/' . $blog->cover_image)
                                            : asset('assets/frontend/assets/images/blogs/01.png');
                                    @endphp
                                    <img src="{{ $cover }}" alt="{{ $blog->title }}">
                                </div>
                                <div class="blog-card-body">
                                    <div class="blog-card-meta">
                                        <span>
                                            <i class="fa-regular fa-calendar"></i>
                                            {{ optional($blog->published_at)->format('M d, Y') }}
                                        </span>
                                        @if ($blog->category)
                                            <span>
                                                <i class="fa-solid fa-tag"></i>
                                                {{ $blog->category }}
                                            </span>
                                        @endif
                                        @if ($blog->author)
                                            <span>
                                                <i class="fa-regular fa-user"></i>
                                                {{ $blog->author }}
                                            </span>
                                        @endif
                                    </div>
                                    <h2 class="blog-card-title">
                                        <a href="{{ route('blogs.show', $blog->slug) }}">
                                            {{ $blog->title }}
                                        </a>
                                    </h2>
                                    @if ($blog->short_description)
                                        <p class="blog-card-excerpt">
                                            {{ Str::limit(strip_tags($blog->short_description), 180) }}
                                        </p>
                                    @endif
                                    <a href="{{ route('blogs.show', $blog->slug) }}" class="blog-card-btn">
                                        Read More
                                        <i class="fa-solid fa-arrow-right-long"></i>
                                    </a>
                                </div>
                            </article>
                        @empty
                            <p class="no-blogs-message">
                                No blog articles found. Try adjusting your search or filters.
                            </p>
                        @endforelse

                        @if ($blogs->hasPages())
                            <div class="blogs-pagination">
                                {{ $blogs->links() }}
                            </div>
                        @endif
                    </div>

                    <!-- Right: sidebar -->
                    <aside class="blogs-sidebar">
                        <div class="blog-sidebar-card blog-sidebar-search scroll-animate" data-animation="fadeInUp"
                            data-delay="0">
                            <h3 class="blog-sidebar-title">Search</h3>
                            <form class="blog-search-box" method="GET" action="{{ route('blogs.index') }}"
                                role="search">
                                <input type="search" name="q" value="{{ $search ?? '' }}"
                                    placeholder="Search articles..." aria-label="Search blog" autocomplete="off"
                                    maxlength="200" inputmode="search">
                                @if ($activeCategorySlug ?? null)
                                    <input type="hidden" name="category_name" value="{{ $activeCategorySlug }}">
                                @endif
                                <span class="blog-search-actions">
                                    <button type="submit" class="blog-search-submit" aria-label="Search">
                                        <i class="fa-solid fa-magnifying-glass"></i>
                                    </button>
                                </span>
                            </form>
                            @if (!empty($hasActiveFilters))
                                <a href="{{ route('blogs.index') }}" class="blog-search-clear">
                                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                                    Clear search &amp; filters
                                </a>
                            @endif
                        </div>

                        <div class="blog-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="50">
                            <h3 class="blog-sidebar-title">Categories</h3>
                            <ul class="blog-category-list">
                                @php
                                    $currentSearch = $search ?? '';
                                    $currentSlug = $activeCategorySlug ?? null;
                                @endphp
                                <li class="{{ $currentSlug ? '' : 'active' }}">
                                    <a href="{{ route('blogs.index', array_filter(['q' => $currentSearch])) }}">
                                        <span class="dot"></span>
                                        All Articles
                                    </a>
                                </li>
                                @foreach ($categories ?? [] as $category)
                                    @php
                                        $isActive = $currentSlug === $category->slug;
                                    @endphp
                                    <li class="{{ $isActive ? 'active' : '' }}">
                                        <a
                                            href="{{ route('blogs.index', array_filter(['category_name' => $category->slug, 'q' => $currentSearch])) }}">
                                            <span class="dot"></span>
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <div class="blog-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                            <h3 class="blog-sidebar-title">Need Help?</h3>
                            <p class="blog-sidebar-text">
                                Not sure which itinerary fits you best? Our travel designers can
                                recommend the perfect tour based on your dates and interests.
                            </p>
                            <a href="{{ route('contact-us') }}" class="blog-sidebar-cta">
                                Contact our team
                                <i class="fa-solid fa-arrow-right-long"></i>
                            </a>
                        </div>
                    </aside>
                </div>
            </div>
        </section>
    </main>
@endsection
