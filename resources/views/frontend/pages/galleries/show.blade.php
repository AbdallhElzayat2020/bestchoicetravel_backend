@extends('frontend.layouts.master')
@php
    $metaTitle = $gallery->title . ' - Gallery';
    $metaDescription = $gallery->description ? \Illuminate\Support\Str::limit(strip_tags($gallery->description), 160) : 'Explore our gallery of amazing travel destinations and experiences.';
    $metaImage = $gallery->cover_image ? asset('uploads/galleries/' . $gallery->cover_image) : null;
@endphp
@section('meta_title', $metaTitle)
@if($metaDescription)
@section('meta_description', $metaDescription)
@endif
@if($metaImage)
@section('meta_image', $metaImage)
@endif

@section('content')
    <section class="py-10 lg:py-12 border border-t-light-grey border-r-0 border-b-0 border-l-0">
        <div class="container">
            <nav class="font-medium text-grey" aria-label="Breadcrumb">
                <ul class="flex flex-wrap items-center gap-1 mb-2">
                    <li><a href="{{ route('home') }}" class="transition duration-200 hover:text-green-zomp">Home</a></li>
                    <span class="mx-1">/</span>
                    <li><a href="{{ route('galleries.index') }}"
                            class="transition duration-200 hover:text-green-zomp">Galleries</a></li>
                    <span class="mx-1">/</span>
                    <li><span class="text-dark-grey">{{ $gallery->title }}</span></li>
                </ul>
            </nav>
            <h1 class="text-black text-[40px] font-bold leading-[1.1em] mb-2">{{ $gallery->title }}</h1>
            @if($gallery->published_at)
                <p class="text-dark-grey">Published: {{ $gallery->published_at->format('M d, Y') }}</p>
            @endif
        </div>
    </section>

    <section class="mb-[60px] md:mb-24">
        <div class="container">

            @php
                $cover = $gallery->cover_image
                    ? asset('uploads/galleries/' . $gallery->cover_image)
                    : asset('assets/frontend/assets/images/gallery-placeholder.png');
            @endphp

            <div class="rounded-2xl overflow-hidden mb-6">
                <img src="{{ $cover }}" alt="{{ $gallery->title }}" class="w-full h-auto object-cover">
            </div>

            @if($gallery->description)
                <div class="prose max-w-none text-dark-grey">
                    {!! $gallery->description!!}
                </div>
            @endif
        </div>
    </section>
@endsection
