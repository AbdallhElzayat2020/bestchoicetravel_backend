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
                    <a href="https://www.facebook.com/bctegypt" target="_blank"
                        class="social-link"aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>
                    <a href="https://www.instagram.com/bct.egypt/" target="_blank"
                        class="social-link"aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
                    </a>
                </div>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">Tours</h3>
                @php
                    $footerTourCategories = collect($sharedCategories ?? [])->filter(function ($category) {
                        return !in_array($category->slug, ['destinations', 'nile-cruises'], true);
                    });
                @endphp
                <ul class="footer-links">
                    @forelse ($footerTourCategories as $tourCategory)
                        <li>
                            <a href="{{ route('tours.category', $tourCategory->slug) }}">{{ $tourCategory->name }}</a>
                        </li>
                    @empty
                        <li><a href="{{ route('home') }}#packages">Packages</a></li>
                    @endforelse
                </ul>
            </div>
            <div class="footer-section">
                <h3 class="footer-title">{{ $mainCruisesMenuName ?? 'Nile Cruises' }}</h3>
                @php
                    $footerNileCategories = $sharedCruiseCatalogCategories ?? collect();
                @endphp
                <ul class="footer-links footer-links--nile">
                    @forelse ($footerNileCategories as $catalogCategory)
                        <li>
                            <a
                                href="{{ route('cruise-catalog.category', $catalogCategory->slug) }}">{{ $catalogCategory->name }}</a>
                        </li>
                    @empty
                        <li><a href="{{ route('home') }}#packages">Packages</a></li>
                    @endforelse
                </ul>
            </div>
            <div class="footer-section">
                @php
                    $footerDestinationsGroupData = collect($sharedCruiseGroupsWithExperiences ?? [])->first(
                        function ($groupData) {
                            $group = $groupData['group'] ?? null;
                            if (!$group) {
                                return false;
                            }

                            return strcasecmp((string) $group->name, 'Destinations') === 0
                                || strcasecmp((string) $group->slug, 'destinations') === 0
                                || strcasecmp((string) ($group->group_key ?? ''), 'destinations') === 0;
                        },
                    );
                    $footerDestinationsGroup = $footerDestinationsGroupData['group'] ?? null;
                    $footerDestinations = collect($footerDestinationsGroupData['experiences'] ?? []);
                @endphp
                <h3 class="footer-title">{{ $footerDestinationsGroup->name ?? 'Destinations' }}</h3>
                <ul class="footer-links">
                    @forelse ($footerDestinations as $destination)
                        <li>
                            <a href="{{ url(($footerDestinationsGroup->slug ?? 'destinations') . '/' . $destination->slug) }}">
                                {{ $destination->title }}
                            </a>
                        </li>
                    @empty
                        <li><a href="{{ route('home') }}#packages">Packages</a></li>
                    @endforelse
                </ul>
            </div>

        </div>
        <div class="footer-bottom">
            <p>&copy; 2026 <a href="https://bestchoice.travel" class="text-warning text-decoration-none" target="_blank"
                    rel="noopener noreferrer">Best Choice Travel</a>. All rights
                reserved.
            </p>
            <p>Proudly Crafted in Egypt with Love ❤️</p>
            <p class="mt-2 mb-0 small text-white-50 text-start">
                Best Choice Travel (BCT), a licensed Destination Management Company (DMC) in Egypt, provides travel
                services worldwide. All content on this website is protected by copyright and may not be reproduced
                without permission. Bookings are subject to our Terms, Conditions, and applicable travel regulations.
            </p>

        </div>
    </div>
</footer>
