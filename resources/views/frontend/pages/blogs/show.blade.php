@extends('frontend.layouts.master')
@php
    $metaTitle = $blog->meta_title ?? $blog->title;
    $metaImage = $blog->cover_image ? asset('uploads/blogs/' . $blog->cover_image) : null;
    $coverSrc = $blog->cover_image
        ? asset('uploads/blogs/' . $blog->cover_image)
        : asset('assets/frontend/assets/images/blogs/01.png');
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

                <article class="blog-details-hero-card scroll-animate" data-animation="fadeInUp" data-delay="50">
                    <div class="blog-details-hero-image">
                        <img src="{{ $coverSrc }}" alt="{{ $blog->title }}">
                    </div>
                    <div class="blog-details-hero-body">
                        <div class="blog-card-meta blog-card-meta--hero">
                            @if ($blog->category)
                                <span><i class="fa-solid fa-tag"></i> {{ $blog->category }}</span>
                            @endif
                            @if ($blog->published_at)
                                <span><i class="fa-regular fa-calendar"></i>
                                    {{ $blog->published_at->format('M d, Y') }}</span>
                            @endif
                        </div>
                        <h1 class="blog-details-title">{{ $blog->title }}</h1>
                        @if ($blog->short_description)
                            <p class="blog-details-intro">{{ $blog->short_description }}</p>
                        @endif
                    </div>
                </article>
            </div>
        </section>

        <!-- Blog content + sidebar -->
        <section class="blog-details-main section-padding">
            <div class="container">
                <div class="blog-details-layout">
                    <article class="blog-details-content scroll-animate" data-animation="fadeInUp" data-delay="0">
                        @if ($blog->description)
                            {!! $blog->description !!}
                        @else
                            <p>No content available.</p>
                        @endif
                    </article>

                    <aside class="blogs-sidebar blog-details-sidebar">

                        {{-- Search --}}
                        <div class="blog-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="0">
                            <h3 class="blog-sidebar-title">
                                <i class="fa-solid fa-magnifying-glass me-2" style="color:var(--brand-blue);font-size:14px;"></i>
                                Search
                            </h3>
                            <form action="{{ route('blogs.index') }}" method="GET">
                                <div class="bds-search-box">
                                    <input type="text" name="q" placeholder="Search articles…" aria-label="Search blog">
                                    <button type="submit" aria-label="Search">
                                        <i class="fa-solid fa-arrow-right"></i>
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{-- Recent Articles --}}
                        @if ($relatedBlogs->isNotEmpty())
                            <div class="blog-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="50">
                                <h3 class="blog-sidebar-title">
                                    <i class="fa-solid fa-newspaper me-2" style="color:var(--brand-blue);font-size:14px;"></i>
                                    Recent Articles
                                </h3>
                                <ul class="bds-recent-list">
                                    @foreach ($relatedBlogs as $related)
                                        @php
                                            $thumb = $related->cover_image
                                                ? asset('uploads/blogs/' . $related->cover_image)
                                                : asset('assets/frontend/assets/images/blogs/01.png');
                                        @endphp
                                        <li class="bds-recent-item">
                                            <a href="{{ route('blogs.show', $related->slug) }}" class="bds-recent-link">
                                                <div class="bds-recent-thumb">
                                                    <img src="{{ $thumb }}" alt="{{ $related->title }}">
                                                </div>
                                                <div class="bds-recent-info">
                                                    <span class="bds-recent-title">{{ $related->title }}</span>
                                                    @if ($related->published_at)
                                                        <span class="bds-recent-date">
                                                            <i class="fa-regular fa-calendar"></i>
                                                            {{ $related->published_at->format('M d, Y') }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Back to Blog --}}
                        <div class="bds-back-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                            <a href="{{ route('blogs.index') }}" class="bds-back-btn">
                                <i class="fa-solid fa-arrow-left"></i>
                                Back to Blog
                            </a>
                        </div>

                    </aside>
                </div>
            </div>
        </section>
    </main>
@endsection

@push('css')
<style>
    /* Search box */
    .bds-search-box {
        display: flex;
        align-items: center;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
        transition: border-color .2s;
    }
    .bds-search-box:focus-within {
        border-color: var(--brand-blue);
    }
    .bds-search-box input {
        flex: 1;
        border: none;
        background: transparent;
        padding: 10px 14px;
        font-size: 14px;
        color: var(--text-dark);
        outline: none;
    }
    .bds-search-box input::placeholder { color: #a0aec0; }
    .bds-search-box button {
        border: none;
        background: var(--brand-blue);
        color: #fff;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 14px;
        cursor: pointer;
        transition: background .2s;
        flex-shrink: 0;
    }
    .bds-search-box button:hover { background: var(--brand-blue-dark); }

    /* Recent Articles list */
    .bds-recent-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 0;
    }
    .bds-recent-item + .bds-recent-item {
        border-top: 1px solid #f1f5f9;
        padding-top: 12px;
        margin-top: 12px;
    }
    .bds-recent-link {
        display: flex;
        gap: 12px;
        text-decoration: none;
        align-items: flex-start;
    }
    .bds-recent-thumb {
        width: 64px;
        height: 54px;
        border-radius: 10px;
        overflow: hidden;
        flex-shrink: 0;
    }
    .bds-recent-thumb img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: transform .35s ease;
    }
    .bds-recent-link:hover .bds-recent-thumb img {
        transform: scale(1.08);
    }
    .bds-recent-info {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }
    .bds-recent-title {
        font-size: 13.5px;
        font-weight: 600;
        color: var(--text-dark);
        line-height: 1.45;
        transition: color .2s;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .bds-recent-link:hover .bds-recent-title { color: var(--brand-blue); }
    .bds-recent-date {
        font-size: 12px;
        color: #94a3b8;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* Back to Blog */
    .bds-back-card {
        text-align: center;
    }
    .bds-back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 14px;
        font-weight: 600;
        color: var(--brand-blue);
        text-decoration: none;
        background: #fff;
        border: 1.5px solid rgba(43,83,167,0.2);
        border-radius: 12px;
        padding: 10px 20px;
        width: 100%;
        justify-content: center;
        transition: all .2s;
    }
    .bds-back-btn:hover {
        background: var(--brand-blue);
        border-color: var(--brand-blue);
        color: #fff;
    }
</style>
@endpush
