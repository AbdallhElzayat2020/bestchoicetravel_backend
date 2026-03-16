@extends('frontend.layouts.master')
@php
    $galleriesPage = \App\Models\Page::getBySlug('galleries');
    $metaTitle = $galleriesPage && $galleriesPage->meta_title ? $galleriesPage->meta_title : 'Galleries';
@endphp
@section('meta_title', $metaTitle)
@if($galleriesPage && $galleriesPage->meta_description)
@section('meta_description', $galleriesPage->meta_description)
@endif
@if($galleriesPage && $galleriesPage->meta_author)
@section('meta_author', $galleriesPage->meta_author)
@endif
@if($galleriesPage && $galleriesPage->meta_keywords)
@section('meta_keywords', $galleriesPage->meta_keywords)
@endif

@section('content')
    <section class="py-10 lg:py-12 border border-t-light-grey border-r-0 border-b-0 border-l-0">
        <div class="container">
            <nav class="font-medium text-grey" aria-label="Breadcrumb">
                <ul class="flex flex-wrap items-center gap-1 mb-2">
                    <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                    <span class="mx-1">/</span>
                    <li><span class="text-dark-grey">Galleries</span></li>
                </ul>
            </nav>
            <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">{{ $metaTitle }}</h1>
        </div>
    </section>

    <section class="mb-[60px] md:mb-24">
        <div class="container">

            @if($galleries->count())
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 md:gap-6">
                    @foreach($galleries as $gallery)
                        @php
                            $cover = $gallery->cover_image
                                ? asset('uploads/galleries/' . $gallery->cover_image)
                                : asset('assets/frontend/assets/images/gallery-placeholder.png');
                        @endphp
                        <article class="group bg-white overflow-hidden rounded-2xl shadow-sm border border-light-grey">
                            <div class="overflow-hidden rounded-t-2xl">
                                <a href="{{ route('galleries.show', $gallery->slug) }}">
                                    <img src="{{ $cover }}" alt="{{ $gallery->title }}"
                                        class="w-full h-56 object-cover transition duration-300 group-hover:scale-105">
                                </a>
                            </div>
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-black mb-2 line-clamp-2 group-hover:text-green-zomp transition">
                                    <a href="{{ route('galleries.show', $gallery->slug) }}">{{ $gallery->title }}</a>
                                </h3>
                                @if($gallery->description)
                                    <p class="text-dark-grey text-sm line-clamp-2">{{ strip_tags($gallery->description) }}</p>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($galleries->hasPages())
                    <nav class="flex items-center justify-center gap-2 mt-10 sm:mt-16" aria-label="Pagination">
                        {{-- Previous Page Link --}}
                        @if ($galleries->onFirstPage())
                            <span
                                class="group border border-grey text-grey w-12 h-12 py-3 rounded-full flex items-center justify-center opacity-50 cursor-not-allowed">
                                <span class="iconify text-dark-grey" data-icon="proicons:chevron-left" data-width="24"
                                    data-height="24"></span>
                            </span>
                        @else
                            <a href="{{ $galleries->previousPageUrl() }}"
                                class="group border border-grey text-grey w-12 h-12 py-3 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">
                                <span class="iconify text-dark-grey group-hover:!text-white" data-icon="proicons:chevron-left"
                                    data-width="24" data-height="24"></span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $currentPage = $galleries->currentPage();
                            $lastPage = $galleries->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                        @endphp

                        {{-- First Page --}}
                        @if ($startPage > 1)
                            <a href="{{ $galleries->url(1) }}"
                                class="border border-transparent text-dark-grey font-bold text-base w-12 h-12 py-3 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">1</a>
                            @if ($startPage > 2)
                                <span
                                    class="text-dark-grey font-bold text-base py-3 w-12 h-12 rounded-full flex items-center justify-center">...</span>
                            @endif
                        @endif

                        {{-- Page Range --}}
                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <span
                                    class="font-bold text-base bg-green-zomp text-white w-12 h-12 py-3 rounded-full flex items-center justify-center">{{ $page }}</span>
                            @else
                                <a href="{{ $galleries->url($page) }}"
                                    class="border border-transparent text-dark-grey font-bold text-base w-12 h-12 py-3 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Last Page --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span
                                    class="text-dark-grey font-bold text-base py-3 w-12 h-12 rounded-full flex items-center justify-center">...</span>
                            @endif
                            <a href="{{ $galleries->url($lastPage) }}"
                                class="border border-transparent text-dark-grey font-bold text-base w-12 h-12 py-3 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $lastPage }}</a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($galleries->hasMorePages())
                            <a href="{{ $galleries->nextPageUrl() }}"
                                class="group border border-grey text-grey w-12 h-12 py-3 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">
                                <span class="iconify text-dark-grey group-hover:!text-white" data-icon="proicons:chevron-right"
                                    data-width="24" data-height="24"></span>
                            </a>
                        @else
                            <span
                                class="group border border-grey text-grey w-12 h-12 py-3 rounded-full flex items-center justify-center opacity-50 cursor-not-allowed">
                                <span class="iconify text-dark-grey" data-icon="proicons:chevron-right" data-width="24"
                                    data-height="24"></span>
                            </span>
                        @endif
                    </nav>
                @endif
            @else
                <div class="p-6 text-center text-dark-grey bg-white rounded-2xl border border-light-grey">
                    No galleries available yet.
                </div>
            @endif
        </div>
    </section>
@endsection
