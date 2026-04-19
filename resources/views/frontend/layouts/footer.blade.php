<footer class="footer">
    <div class="container">
        <div class="footer-content">
            <div class="footer-section">
                <div class="footer-logo">
                    <img src="{{ asset('assets/frontend/images/logo_wh.png') }}" alt="Travel Egypt"
                        class="footer-logo-img">
                </div>
                <p class="footer-description">
                    We offer you the best travel experiences in Egypt with trips designed to discover the wonders of
                    ancient and modern Egypt.
                </p>
                <div class="social-links">
                    <a href="#" class="social-link" aria-label="Facebook"><i
                            class="fa-brands fa-facebook-f"></i></a>
                    <a href="#" class="social-link" aria-label="Instagram"><i
                            class="fa-brands fa-instagram"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Tours</h3>
                @php
                    $footerExcludedGroupSlugs = ['egypt-day-tours'];
                    $footerCruiseRows = collect($sharedCruiseGroupsWithExperiences ?? [])
                        ->sortBy(fn($d) => $d['group']->sort_order)
                        ->filter(fn($d) => !in_array($d['group']->slug, $footerExcludedGroupSlugs, true))
                        ->flatMap(function ($d) {
                            $group = $d['group'];

                            return $d['experiences']->map(
                                fn($experience) => ['group' => $group, 'experience' => $experience],
                            );
                        });
                @endphp
                <ul class="footer-links">
                    @forelse ($footerCruiseRows as $row)
                        <li>
                            <a
                                href="{{ url($row['group']->slug . '/' . $row['experience']->slug) }}">{{ $row['experience']->title }}</a>
                        </li>
                    @empty
                        <li><a href="{{ route('home') }}#packages">Packages</a></li>
                    @endforelse
                </ul>

                @php
                    $footerNileCategories = $sharedCruiseCatalogCategories ?? collect();
                @endphp
                @if ($footerNileCategories->count())
                    <ul class="footer-links footer-links--nile">
                        @foreach ($footerNileCategories as $catalogCategory)
                            <li>
                                <a
                                    href="{{ route('cruise-catalog.category', $catalogCategory->slug) }}">{{ $catalogCategory->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Company</h3>
                <ul class="footer-links">
                    <li><a href="{{ route('blogs.index') }}">Blogs</a></li>
                    <li><a href="{{ route('about-us') }}">About Us</a></li>
                    <li><a href="{{ route('contact-us') }}">Contact</a></li>
                    <li><a href="{{ route('faqs') }}">FAQs</a></li>
                    <li><a href="#">Terms & Conditions</a></li>
                    <li><a href="#">Payment Policy</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Locations</h3>
                <ul class="footer-contact">
                    <li>
                        <span class="contact-icon"><i class="fa-solid fa-location-dot"></i></span>
                        <span>Cairo, Egypt</span>
                    </li>
                    <li>
                        <span class="contact-icon"><i class="fa-solid fa-phone"></i></span>
                        <span>+20 123 456 7890</span>
                    </li>
                    <li>
                        <span class="contact-icon"><i class="fa-solid fa-envelope"></i></span>
                        <span>info@travelegypt.com</span>
                    </li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 <a href="https://bestchoice.travel" class="text-warning text-decoration-none" target="_blank"
                    rel="noopener noreferrer">Best Choice Travel</a>. All rights
                reserved.
            </p>
        </div>
    </div>
</footer>
