@extends('frontend.layouts.master')

@php
    $metaTitle = data_get($page, 'meta_title') ?: 'FAQs';
@endphp

@section('meta_title', $metaTitle)
@if (data_get($page, 'meta_description'))
    @section('meta_description', data_get($page, 'meta_description'))
@endif
@if (data_get($page, 'meta_author'))
    @section('meta_author', data_get($page, 'meta_author'))
@endif
@if (data_get($page, 'meta_keywords'))
    @section('meta_keywords', data_get($page, 'meta_keywords'))
@endif

@section('content')
    <main class="faqs-page">
        <!-- Hero Section -->
        <section class="faqs-hero section-padding">
            <div class="container">
                <div class="faqs-hero-inner">
                    <div class="section-label scroll-animate" data-animation="fadeInUp">
                        <span>FREQUENTLY ASKED QUESTIONS</span>
                    </div>
                    <h1 class="faqs-hero-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                        Answers to <span class="highlight">Popular Questions</span>
                    </h1>
                    <p class="faqs-hero-subtitle scroll-animate" data-animation="fadeInUp" data-delay="100">
                        Find quick answers about bookings, payments, visas, Nile cruises and more. If you still need
                        help, our team is one message away.
                    </p>
                </div>
            </div>
        </section>

        <!-- FAQs List -->
        <section class="faqs-main faq-section section-padding">
            <div class="container">
                <div class="faqs-layout">
                    <div class="faqs-list">
                        @forelse($faqs as $index => $faq)
                            <div class="faq-item scroll-animate" data-animation="fadeInUp" data-delay="{{ $index * 40 }}">
                                <button class="faq-question" type="button">
                                    <div class="faq-question-left">
                                        <span class="faq-number">{{ $index + 1 }}</span>
                                    </div>
                                    <div class="faq-question-body">
                                        <span>{{ $faq->question }}</span>
                                    </div>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </button>
                                <div class="faq-answer">
                                    <div class="faq-answer-card">
                                        <p>{!! nl2br(e($faq->answer)) !!}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <p class="no-faqs-message">
                                There are no FAQs available at the moment. Please check back later or contact us
                                directly with your question.
                            </p>
                        @endforelse
                    </div>

                    <aside class="faqs-sidebar">
                        <div class="faq-sidebar-card scroll-animate" data-animation="fadeInUp" data-delay="0">
                            <h3 class="faq-sidebar-title">Still have a question?</h3>
                            <p class="faq-sidebar-text">
                                If you can’t find the answer you’re looking for, please contact our travel experts.
                                We usually reply within 24 hours.
                            </p>
                            <a href="{{ route('contact-us') }}" class="faq-sidebar-cta">
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
