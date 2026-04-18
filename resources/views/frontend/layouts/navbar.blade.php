<nav class="navbar navbar-expand-lg bg-body-tertiary shadow-sm fixed-top main-navbar">
    <div class="container px-lg-1">
        <a class="navbar-brand logo d-flex align-items-center gap-2" href="{{ route('home') }}">
            <img src="{{ asset('assets/frontend/images/logo_main.png') }}" alt="Logo" class="brand-logo-img"
                height="70">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar"
            aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            @php
                $isHome = request()->routeIs('home');
                $isBlog = request()->routeIs('blogs.*');
                $isAbout = request()->routeIs('about-us');
                $isContact = request()->routeIs('contact-us');
            @endphp
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link {{ $isHome ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                </li>

                <!-- 2- Cruises (dynamic main groups + experiences) -->
                @if (isset($sharedCruiseGroupsWithExperiences) && count($sharedCruiseGroupsWithExperiences) > 0)
                    @foreach ($sharedCruiseGroupsWithExperiences as $groupData)
                        @php
                            /** @var \App\Models\CruiseGroup $group */
                            $group = $groupData['group'];
                            $experiences = $groupData['experiences'];
                            $hasExperiences = $experiences->count() > 0;
                            $isCruiseGroup = request()->is($group->slug) || request()->is($group->slug . '/*');
                        @endphp

                        @if ($hasExperiences)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle {{ $isCruiseGroup ? 'active' : '' }}"
                                    href="{{ url($group->slug) }}" id="navCruiseGroup-{{ $group->id }}"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ $group->name }}
                                </a>

                                <ul class="dropdown-menu" aria-labelledby="navCruiseGroup-{{ $group->id }}">
                                    @foreach ($experiences as $experience)
                                        <li>
                                            <a class="dropdown-item"
                                                href="{{ url($group->slug . '/' . $experience->slug) }}">
                                                {{ $experience->title }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </li>
                        @else
                            {{-- Group without experiences yet: simple link, no empty dropdown --}}
                            <li class="nav-item">
                                <a class="nav-link {{ $isCruiseGroup ? 'active' : '' }}"
                                    href="{{ url($group->slug) }}">
                                    {{ $group->name }}
                                </a>
                            </li>
                        @endif
                    @endforeach

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navCruiseMenu" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $mainCruisesMenuName ?? 'Nile River Cruises' }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navCruiseMenu">
                            @forelse (($sharedCruiseCatalogCategories ?? collect()) as $catalogCategory)
                                <li>
                                    <a class="dropdown-item fw-semibold"
                                        href="{{ route('cruise-catalog.category', $catalogCategory->slug) }}">
                                        {{ $catalogCategory->name }}
                                    </a>
                                </li>
                            @empty
                                <li>
                                    <span class="dropdown-item-text text-muted">No cruise categories yet</span>
                                </li>
                            @endforelse
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a class="nav-link {{ $isBlog ? 'active' : '' }}" href="{{ route('blogs.index') }}">Blog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $isAbout ? 'active' : '' }}" href="{{ route('about-us') }}">About Us</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ $isContact ? 'active' : '' }}" href="{{ route('contact-us') }}">Contact</a>
                </li>

                <li class="nav-item mt-3 mt-lg-0">
                    <a class="btn btn-primary px-4" href="#packages">Trip Planner</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
