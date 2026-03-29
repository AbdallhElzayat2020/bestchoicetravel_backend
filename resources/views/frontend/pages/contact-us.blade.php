@php
    $metaTitle = $page && $page->meta_title ? $page->meta_title : 'Contact Us';
    $metaDescription = $page ? $page->meta_description ?? null : null;
    $metaAuthor = $page ? $page->meta_author ?? null : null;
    $metaKeywords = $page ? $page->meta_keywords ?? null : null;
@endphp
@section('meta_title', $metaTitle)
@if ($metaDescription)
@section('meta_description', $metaDescription)
@endif
@if ($metaAuthor)
@section('meta_author', $metaAuthor)
@endif
@if ($metaKeywords)
@section('meta_keywords', $metaKeywords)
@endif
@extends('frontend.layouts.master')

@section('content')
    <!-- Contact Hero Banner -->
    <section class="contact-hero">
        <div class="contact-hero-overlay"></div>
        <div class="contact-hero-bg" style="background-image: url('{{ asset('assets/frontend/images/Luxor.webp') }}');">
        </div>
        <div class="container">
            <div class="contact-hero-inner">

                <h1 class="contact-hero-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                    <span class="highlight">GET IN TOUCH</span>
                </h1>
                <p class="contact-hero-subtitle scroll-animate" data-animation="fadeInUp" data-delay="100">
                    Our travel experts are ready to craft your perfect journey. Reach out and we'll respond within 24
                    hours.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact CTA / Info Only -->
    <section class="contact-main section-padding">
        <div class="container">
            <div class="contact-main-grid">
                {{-- Contact info cards first (full width of container) --}}
                <div class="contact-info-sidebar">
                    <div class="contact-info-card scroll-animate" data-animation="fadeInUp" data-delay="100">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>
                        <h3>Visit Our Office</h3>
                        <p>Cairo, Egypt</p>
                        <a href="https://maps.google.com" target="_blank" rel="noopener" class="contact-info-link">
                            Get Directions <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="contact-info-card scroll-animate" data-animation="fadeInUp" data-delay="150">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>
                        <h3>Call Us</h3>
                        <p>+20 123 456 7890</p>
                        <a href="tel:+201234567890" class="contact-info-link">
                            Call Now <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>

                    <div class="contact-info-card scroll-animate" data-animation="fadeInUp" data-delay="200">
                        <div class="contact-info-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>
                        <h3>Email Us</h3>
                        <p>info@travelegypt.com</p>
                        <a href="mailto:info@travelegypt.com" class="contact-info-link">
                            Send Email <i class="fa-solid fa-arrow-right"></i>
                        </a>
                    </div>
                </div>

                {{-- CTA box under contact cards --}}
                <div class="contact-cta-card scroll-animate mt-4" data-animation="fadeInUp" data-delay="50">
                    <h2 class="contact-cta-title">Ready to Start Your Journey?</h2>
                    <p class="contact-cta-subtitle">
                        Talk directly with our Egypt travel specialists on WhatsApp or by phone and we’ll help you plan the perfect trip.
                    </p>

                    <div class="contact-cta-stats">
                        <div class="contact-cta-stat">
                            <div class="contact-cta-number">15+</div>
                            <div class="contact-cta-label">Years Experience</div>
                        </div>
                        <div class="contact-cta-stat">
                            <div class="contact-cta-number">1975+</div>
                            <div class="contact-cta-label">Happy Travelers</div>
                        </div>
                        <div class="contact-cta-stat">
                            <div class="contact-cta-number">50+</div>
                            <div class="contact-cta-label">Tailor‑Made Trips</div>
                        </div>
                        <div class="contact-cta-stat">
                            <div class="contact-cta-number">24/7</div>
                            <div class="contact-cta-label">Guest Support</div>
                        </div>
                    </div>

                    <hr class="contact-cta-divider">

                    <p class="contact-cta-question">Ready to Start Your Journey?</p>

                    <div class="contact-cta-actions">
                        <a href="https://wa.me/201234567890" target="_blank" rel="noopener"
                            class="contact-cta-btn contact-cta-btn--primary">
                            <i class="fa-brands fa-whatsapp"></i>
                            WhatsApp Now
                        </a>
                        <a href="tel:+201234567890" class="contact-cta-btn contact-cta-btn--outline">
                            <i class="fa-solid fa-phone"></i>
                            Call Directly
                        </a>
                    </div>

                    <div class="contact-cta-footer">
                        <div class="contact-cta-footer-item">
                            <i class="fa-solid fa-location-dot me-1"></i>
                            Cairo, Egypt
                        </div>
                        <div class="contact-cta-footer-item">
                            <i class="fa-solid fa-envelope me-1"></i>
                            info@travelegypt.com
                        </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @if(!empty($recaptchaSiteKey))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
@endpush
