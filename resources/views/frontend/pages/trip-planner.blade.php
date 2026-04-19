@extends('frontend.layouts.master')

@section('meta_title', 'Trip Planner | Plan your Egypt journey')

@section('content')
    <section class="trip-planner-hero">
        <div class="trip-planner-hero-overlay"></div>
        <div class="trip-planner-hero-bg" style="background-image: url('{{ asset('assets/frontend/images/Luxor.webp') }}');">
        </div>
        <div class="container">
            <div class="trip-planner-hero-inner">
                <h1 class="trip-planner-hero-title scroll-animate" data-animation="fadeInUp" data-delay="50">
                    <span class="highlight">Trip Planner</span>
                </h1>
                <p class="trip-planner-hero-subtitle scroll-animate" data-animation="fadeInUp" data-delay="100">
                    Tell us who is travelling and when — our team will tailor an itinerary to match your dates and style.
                </p>
            </div>
        </div>
    </section>

    <section class="trip-planner-section section-padding">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="trip-planner-card card border-0 shadow-sm scroll-animate" data-animation="fadeInUp"
                        data-delay="150">
                        <div class="card-body p-4 p-md-5">
                            @if (session('success'))
                                <div class="alert alert-success" role="alert">{{ session('success') }}</div>
                            @endif

                            <form action="{{ route('trip-planner.store') }}" method="POST" id="tripPlannerForm" novalidate>
                                @csrf

                                <div class="row g-3 mb-3">
                                    <div class="col-md-12">
                                        <label for="full_name" class="form-label fw-semibold">Full name <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="full_name" id="full_name"
                                            class="form-control @error('full_name') is-invalid @enderror"
                                            value="{{ old('full_name') }}" required autocomplete="name">
                                        @error('full_name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="nationality" class="form-label fw-semibold">Nationality <span
                                                class="text-danger">*</span></label>
                                        <input type="text" name="nationality" id="nationality"
                                            class="form-control @error('nationality') is-invalid @enderror"
                                            value="{{ old('nationality') }}" required autocomplete="country-name">
                                        @error('nationality')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label fw-semibold">Phone</label>
                                        <input type="tel" name="phone" id="phone"
                                            class="form-control @error('phone') is-invalid @enderror"
                                            value="{{ old('phone') }}" required autocomplete="tel">
                                        @error('phone')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <label for="email" class="form-label fw-semibold">Email <span
                                                class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email"
                                            class="form-control @error('email') is-invalid @enderror"
                                            value="{{ old('email') }}" required autocomplete="email">
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <p class="fw-semibold mb-2">Number of travellers</p>
                                <div class="trip-planner-counters row g-3 mb-4">
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted mb-2 d-block">Adults (+12 years)</label>
                                        <div class="counter-field">
                                            <button type="button" class="counter-btn" data-step="-1" data-target="adults"
                                                aria-label="Decrease adults">−</button>
                                            <input type="number" name="adults" id="adults"
                                                class="counter-value @error('adults') is-invalid @enderror"
                                                value="{{ old('adults', 1) }}" min="1" max="50" readonly>
                                            <button type="button" class="counter-btn" data-step="1" data-target="adults"
                                                aria-label="Increase adults">+</button>
                                        </div>
                                        @error('adults')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted mb-2 d-block">Children (2 to 11)</label>
                                        <div class="counter-field">
                                            <button type="button" class="counter-btn" data-step="-1"
                                                data-target="children" aria-label="Decrease children">−</button>
                                            <input type="number" name="children" id="children"
                                                class="counter-value @error('children') is-invalid @enderror"
                                                value="{{ old('children', 0) }}" min="0" max="50" readonly>
                                            <button type="button" class="counter-btn" data-step="1"
                                                data-target="children" aria-label="Increase children">+</button>
                                        </div>
                                        @error('children')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label small text-muted mb-2 d-block">Infants (0 to 2)</label>
                                        <div class="counter-field">
                                            <button type="button" class="counter-btn" data-step="-1"
                                                data-target="infants" aria-label="Decrease infants">−</button>
                                            <input type="number" name="infants" id="infants"
                                                class="counter-value @error('infants') is-invalid @enderror"
                                                value="{{ old('infants', 0) }}" min="0" max="50" readonly>
                                            <button type="button" class="counter-btn" data-step="1"
                                                data-target="infants" aria-label="Increase infants">+</button>
                                        </div>
                                        @error('infants')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row g-3 mb-3">
                                    <div class="col-md-6">
                                        <label for="arrival_date" class="form-label fw-semibold">Arrival date</label>
                                        <input type="date" name="arrival_date" id="arrival_date"
                                            class="form-control @error('arrival_date') is-invalid @enderror"
                                            value="{{ old('arrival_date') }}">
                                        @error('arrival_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="departure_date" class="form-label fw-semibold">Departure date</label>
                                        <input type="date" name="departure_date" id="departure_date"
                                            class="form-control @error('departure_date') is-invalid @enderror"
                                            value="{{ old('departure_date') }}">
                                        @error('departure_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label for="message" class="form-label fw-semibold">Message <span
                                            class="text-danger">*</span></label>
                                    <textarea name="message" id="message" rows="5" class="form-control @error('message') is-invalid @enderror"
                                        required placeholder="Please share your travel plans, preferences, and any specific requests.">{{ old('message') }}</textarea>
                                    @error('message')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                @if (!empty($recaptchaSiteKey))
                                    <div class="mb-3">
                                        <div class="g-recaptcha" data-sitekey="{{ $recaptchaSiteKey }}"></div>
                                        @error('g-recaptcha-response')
                                            <div class="text-danger small mt-1">{{ $message }}</div>
                                        @enderror
                                    </div>
                                @endif

                                <button type="submit" class="btn btn-primary btn-lg px-5">
                                    Submit request
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    @if (!empty($recaptchaSiteKey))
        <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    @endif
    <script>
        document.querySelectorAll('.counter-btn').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var targetId = btn.getAttribute('data-target');
                var step = parseInt(btn.getAttribute('data-step'), 10);
                var input = document.getElementById(targetId);
                if (!input) return;
                var min = parseInt(input.getAttribute('min'), 10);
                var max = parseInt(input.getAttribute('max'), 10);
                var v = parseInt(input.value, 10) || 0;
                v += step;
                if (v < min) v = min;
                if (v > max) v = max;
                input.value = v;
            });
        });
    </script>
@endpush
