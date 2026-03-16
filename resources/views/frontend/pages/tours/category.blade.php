@extends('frontend.layouts.master')

@php
    $metaTitle = $category->meta_title ?? ($category->name);
    $metaDescription = $category->description
        ? \Illuminate\Support\Str::limit(strip_tags($category->description), 160)
        : ('Discover our ' . $category->name . ' tours and packages.');
@endphp

@section('meta_title', $metaTitle)
@section('meta_description', $metaDescription)

@section('content')
    @php
        // Get grid columns class
        $gridCols = match ($category->grid_columns ?? '4') {
            '2' => 'lg:grid-cols-2',
            '3' => 'lg:grid-cols-3',
            '4' => 'lg:grid-cols-4',
            default => 'lg:grid-cols-4'
        };

        // Header styles
        $headerBg = $category->header_background_color ?? null;
        $headerText = $category->header_text_color ?? null;
        $headerStyle = '';
        if ($headerBg) {
            $headerStyle .= 'background-color: ' . $headerBg . ';';
        }
        if ($headerText) {
            $headerStyle .= 'color: ' . $headerText . ';';
        }
    @endphp

    @if($category->custom_css)
        <style>
            {!! $category->custom_css !!}
        </style>
    @endif

    <section class="py-10 lg:py-12 border border-t-light-grey border-r-0 border-b-0 border-l-0">
        <div class="container">
            @if($category->show_breadcrumb ?? true)
                <nav class="font-medium text-grey" aria-label="Breadcrumb">
                    <ul class="flex flex-wrap items-center gap-1 mb-2">
                        <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                        <span class="mx-1">/</span>
                        <li><span class="text-dark-grey">{{ $category->name }}</span></li>
                    </ul>
                </nav>
            @endif
            <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">{{ $category->name }}</h1>
            @if(($category->show_description ?? true) && $category->description)
                <div class="text-dark-grey max-w-2xl prose prose-sm">
                    {!! $category->description !!}
                </div>
            @endif
        </div>
    </section>

    <section class="mb-[60px] md:mb-24">
        <div class="container">
            @if($tours->count())
                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 {{ $gridCols }}">
                    @foreach($tours as $tour)
                        @php
                            $coverImage = $tour->cover_image
                                ? asset('uploads/tours/' . $tour->cover_image)
                                : asset('assets/frontend/assets/images/blogs/01.png');

                            $isOnSale = $tour->has_offer && $tour->isOfferActive();
                            $currentPrice =
                                $isOnSale && $tour->price_after_discount ? $tour->price_after_discount : $tour->price;
                            $oldPrice = $isOnSale && $tour->price_before_discount ? $tour->price_before_discount : null;

                            // Location
                            $locationParts = [];
                            if ($tour->category) {
                                $locationParts[] = $tour->category->name;
                            }
                            if ($tour->country) {
                                $locationParts[] = $tour->country->name;
                            }
                            $location = implode(', ', $locationParts);

                            // Duration - Always display as days, use DB value only
                            $durationValue = (int) ($tour->duration ?? 0);
                            $durationText = $durationValue . ' ' . ($durationValue == 1 ? 'day' : 'days');
                        @endphp
                        <article class="relative overflow-hidden transition duration-200">
                            <div class="bg-white border rounded-2xl border-light-grey">
                                <div class="relative overflow-hidden rounded-t-2xl">
                                    <a href="{{ route('tours.show', $tour->slug) }}">
                                        <img src="{{ $coverImage }}" alt="{{ $tour->title }}"
                                            class="object-cover w-full h-auto transition duration-300 hover:scale-105">
                                        @if ($isOnSale)
                                            <span
                                                class="absolute top-4 right-4 bg-[#F51D35] rounded py-1 px-2 text-white text-sm font-semibold">On
                                                Sale</span>
                                        @endif
                                    </a>
                                </div>
                                <div class="p-4">
                                    <div class="flex items-center gap-2 mb-2">
                                        <span class="iconify" data-icon="ep:location" data-width="14" data-height="14"></span>
                                        <span class="text-sm text-dark-grey">{{ $location ?: 'Location' }}</span>
                                    </div>

                                    <h4
                                        class="mb-2 text-base font-bold text-black transition duration-200 line-clamp-2 hover:text-green-zomp">
                                        <a href="{{ route('tours.show', $tour->slug) }}">{{ $tour->title }}</a>
                                    </h4>

                                    <div class="flex items-center mb-2 text-orange-yellow">
                                        <span class="iconify" data-icon="mdi:star"></span>
                                        <span class="iconify" data-icon="mdi:star">
                                        </span>
                                        <span class="iconify" data-icon="mdi:star"></span>
                                        <span class="iconify" data-icon="mdi:star"></span>
                                        <span class="iconify" data-icon="mdi:star"></span>
                                    </div>

                                    @if ($tour->duration)
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="iconify" data-icon="mdi:clock-outline" data-width="14" data-height="14"></span>
                                            <span class="text-sm text-dark-grey">{{ $durationText }}</span>
                                        </div>
                                    @endif

                                    <div class="h-px my-4 border-t border-light-grey"></div>

                                    @if ($oldPrice)
                                        <div class="mb-1 text-sm font-bold line-through text-grey">
                                            ${{ number_format($oldPrice, 0) }}</div>
                                    @endif

                                    <div class="flex items-center justify-between gap-2">
                                        @if ($currentPrice !== null)
                                            <span class="flex items-center gap-1">
                                                <span class="text-sm text-dark-grey">From</span>
                                                <span class="text-base font-bold text-green-zomp">
                                                    ${{ number_format($currentPrice, 0) }}
                                                </span>
                                            </span>
                                        @endif
                                        <a href="{{ route('tours.show', $tour->slug) }}"
                                            class="inline-flex items-center gap-1 text-sm font-semibold text-green-zomp transition duration-200 hover:text-green-zomp-hover">
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                @if($tours->hasPages())
                    <nav class="flex items-center justify-center gap-2 mt-10 sm:mt-14" aria-label="Pagination">
                        {{-- Previous Page Link --}}
                        @if ($tours->onFirstPage())
                            <span
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center opacity-50 cursor-not-allowed">
                                <span class="iconify text-dark-grey" data-icon="proicons:chevron-left" data-width="20"
                                    data-height="20"></span>
                            </span>
                        @else
                            <a href="{{ $tours->previousPageUrl() }}"
                                class="group border border-grey text-grey w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">
                                <span class="iconify text-dark-grey group-hover:!text-white" data-icon="proicons:chevron-left"
                                    data-width="20" data-height="20"></span>
                            </a>
                        @endif

                        {{-- Pagination Elements --}}
                        @php
                            $currentPage = $tours->currentPage();
                            $lastPage = $tours->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                        @endphp

                        {{-- First Page --}}
                        @if ($startPage > 1)
                            <a href="{{ $tours->url(1) }}"
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
                                <a href="{{ $tours->url($page) }}"
                                    class="border border-transparent text-dark-grey font-bold text-sm w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $page }}</a>
                            @endif
                        @endfor

                        {{-- Last Page --}}
                        @if ($endPage < $lastPage)
                            @if ($endPage < $lastPage - 1)
                                <span
                                    class="text-dark-grey font-bold text-sm py-2 w-10 h-10 rounded-full flex items-center justify-center">...</span>
                            @endif
                            <a href="{{ $tours->url($lastPage) }}"
                                class="border border-transparent text-dark-grey font-bold text-sm w-10 h-10 py-2 rounded-full flex items-center justify-center transition duration-200 hover:!border-green-zomp hover:!bg-green-zomp hover:!text-white">{{ $lastPage }}</a>
                        @endif

                        {{-- Next Page Link --}}
                        @if ($tours->hasMorePages())
                            <a href="{{ $tours->nextPageUrl() }}"
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
                    No tours are available in this category at the moment.
                </div>
            @endif
        </div>
    </section>
@endsection
