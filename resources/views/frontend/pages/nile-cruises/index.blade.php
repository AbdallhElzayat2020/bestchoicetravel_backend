@extends('frontend.layouts.master')

@php
    $metaTitle = $cruiseGroup->meta_title ?? ($cruiseGroup->name . ' - ' . config('app.name', 'Travel Website'));
    $metaDescription = $cruiseGroup->meta_description ?? ('Discover our curated ' . $cruiseGroup->name . ' programs and experiences, with handpicked related tours for each cruise.');
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
    <section class="py-10 lg:py-12 border border-t-light-grey border-r-0 border-b-0 border-l-0">
        <div class="container">
            <nav class="font-medium text-grey" aria-label="Breadcrumb">
                <ul class="flex flex-wrap items-center gap-1 mb-2">
                    <li>
                        <a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a>
                    </li>
                    <span class="mx-1">/</span>
                    <li><span class="text-dark-grey">{{ $cruiseGroup->name }}</span></li>
                </ul>
            </nav>
            <h1 class="text-black text-[32px] md:text-[40px] font-bold leading-[1.1em] mb-2">{{ $cruiseGroup->name }}</h1>
            @if($cruiseGroup->description)
                <div class="text-dark-grey max-w-2xl prose prose-sm">
                    {!! $cruiseGroup->description !!}
                </div>
            @endif
        </div>
    </section>

    <section class="mb-[60px] md:mb-24">
        <div class="container">
            @if($experiences->count())
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
                    @foreach($experiences as $experience)
                        @php
                            $coverImage = $experience->banner_image
                                ? asset('uploads/cruise-experiences/' . $experience->banner_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');

                            $shortDescription = $experience->short_description
                                ? \Illuminate\Support\Str::limit(strip_tags($experience->short_description), 100)
                                : null;

                            // Generate URL using cruise group slug
                            $cruiseUrl = '/' . $cruiseGroup->slug . '/' . $experience->slug;
                        @endphp
                        <article class="relative overflow-hidden transition duration-200">
                            <div class="bg-white border rounded-2xl border-light-grey">
                                <div class="relative overflow-hidden rounded-t-2xl">
                                    <a href="{{ $cruiseUrl }}">
                                        <img src="{{ $coverImage }}" alt="{{ $experience->title }}"
                                            class="object-cover w-full h-auto transition duration-300 hover:scale-105">
                                    </a>
                                </div>
                                <div class="p-4">
                                    <h4
                                        class="mb-2 text-base font-bold text-black transition duration-200 line-clamp-2 hover:text-green-zomp">
                                        <a href="{{ $cruiseUrl }}">{{ $experience->title }}</a>
                                    </h4>

                                    @if($shortDescription)
                                        <p class="text-sm text-dark-grey mb-3 line-clamp-2">
                                            {{ $shortDescription }}
                                        </p>
                                    @endif

                                    <div class="h-px my-4 border-t border-light-grey"></div>

                                    <div class="flex items-center justify-between gap-2">
                                        <a href="{{ $cruiseUrl }}"
                                            class="inline-flex items-center gap-1 text-sm font-semibold text-green-zomp transition duration-200 hover:text-green-zomp-hover">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($experiences->hasPages())
                    <nav class="flex items-center justify-center gap-2 mt-10 sm:mt-14" aria-label="Pagination">
                        {{-- Previous Page Link --}}
                        @if ($experiences->onFirstPage())
                            <span
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center opacity-50 cursor-not-allowed">
                                <span class="iconify text-dark-grey" data-icon="proicons:chevron-left" data-width="20"
                                    data-height="20"></span>
                            </span>
                        @else
                            <a href="{{ $experiences->previousPageUrl() }}"
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">
                                <span class="iconify text-dark-grey group-hover:!text-white" data-icon="proicons:chevron-left"
                                    data-width="20" data-height="20"></span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $currentPage = $experiences->currentPage();
                            $lastPage = $experiences->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                        @endphp

                        {{-- First Page --}}
                        @if ($startPage > 1)
                            <a href="{{ $experiences->url(1) }}"
                                class="border border-transparent text-dark-grey font-bold text-sm w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">1</a>
                            @if ($startPage > 2)
                                <span
                                    class="text-dark-grey font-bold text-sm py-2 w-10 h-10 rounded-full flex items-center justify-center">...</span>
                            @endif
                        @endif

                        {{-- Page Range --}}
                        @for ($page = $startPage; $page <= $endPage; $page++)
                            @if ($page == $currentPage)
                                <span
                                    class="font-bold text-sm bg-green-zomp text-white w-10 h-10 py-2 rounded-full flex items-center justify-center">{{ $page }}</span>
                            @else
                                <a href="{{ $experiences->url($page) }}"
                                    class="border border-transparent text-dark-grey font-bold text-sm w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Last Page --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span
                                    class="text-dark-grey font-bold text-sm py-2 w-10 h-10 rounded-full flex items-center justify-center">...</span>
                            @endif
                            <a href="{{ $experiences->url($lastPage) }}"
                                class="border border-transparent text-dark-grey font-bold text-sm w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $lastPage }}</a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($experiences->hasMorePages())
                            <a href="{{ $experiences->nextPageUrl() }}"
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">
                                <span class="iconify text-dark-grey group-hover:!text-white" data-icon="proicons:chevron-right"
                                    data-width="20" data-height="20"></span>
                            </a>
                        @else
                            <span
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center opacity-50 cursor-not-allowed">
                                <span class="iconify text-dark-grey" data-icon="proicons:chevron-right" data-width="20"
                                    data-height="20"></span>
                            </span>
                        @endif
                    </nav>
                @endif
            @else
                <div class="p-6 text-center text-dark-grey bg-white rounded-2xl border border-light-grey">
                    No cruise experiences are available in this group at the moment.
                </div>
            @endif
        </div>
    </section>
@endsection
