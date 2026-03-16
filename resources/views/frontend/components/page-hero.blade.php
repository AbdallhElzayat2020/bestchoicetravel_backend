@php
    $title = $title ?? ($pageTitle ?? 'Travel Egypt');
    $subtitle = $subtitle ?? ($pageSubtitle ?? null);
    $ctaText = $ctaText ?? 'Contact our team';
    $background = $background ?? null;
@endphp

<section class="page-hero position-relative">
    @if($background)
        <div class="page-hero-bg">
            <img src="{{ $background }}" alt="{{ $title }}" />
            <div class="page-hero-overlay"></div>
        </div>
    @endif

    <div class="container">
        <div class="page-hero-inner">
            <h1 class="page-hero-title">
                {{ $title }}
            </h1>
            @if($subtitle)
                <p class="page-hero-subtitle">
                    {{ $subtitle }}
                </p>
            @endif
            <a href="{{ route('contact-us') }}" class="btn btn-primary page-hero-cta">
                {{ $ctaText }}
            </a>
        </div>
    </div>
</section>

