<aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
    <div class="app-brand demo">
        <a href="{{ route(auth()->user()->isAdmin() || auth()->user()->hasPermission('dashboard.access') ? 'admin.dashboard' : 'home') }}"
            class="app-brand-link d-flex flex-column">
            <span class="fs-4 fw-bold">MRCO-Egypt</span>
            <span class="small">Travel Website System</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="ti menu-toggle-icon d-none d-xl-block ti-sm align-middle"></i>
            <i class="ti ti-x d-block d-xl-none ti-sm align-middle"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="menu-inner py-1">

        {{-- Dashboard Home --}}
        @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('dashboard.access'))
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.dashboard'], 'active') }}">
                <a href="{{ route('admin.dashboard') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-smart-home"></i>
                    <div data-i18n="Home">Dashboard</div>
                </a>
            </li>
        @endif

        {{-- Bookings --}}
        <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.bookings.*'], 'active') }}">
            <a href="{{ route('admin.bookings.index') }}" class="menu-link">
                <i class="menu-icon tf-icons ti ti-calendar-event"></i>
                <div data-i18n="Booked Tours">Bookings</div>
            </a>
        </li>

        {{-- Tours Management Section --}}
        @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('dashboard.access'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Tours Management</span>
            </li>

            {{-- Categories --}}

            @php
                $isCruiseGroupsActive = request()->routeIs('admin.cruise-groups.*');
                $currentCruiseGroupId = request()->get('cruise_group_id');
                $currentGroupKey = request()->get('group_key');
                $isCruiseExperiencesActive = request()->routeIs('admin.cruise-experiences.*');
                $isMainCategoriesActive = $isCruiseGroupsActive || $isCruiseExperiencesActive;

                // Determine current active group
                if ($currentCruiseGroupId) {
                    $currentGroup = isset($cruiseGroups)
                        ? $cruiseGroups->firstWhere('id', $currentCruiseGroupId)
                        : null;
                    $currentGroupKey = $currentGroup ? $currentGroup->group_key : null;
                } elseif ($currentGroupKey && isset($cruiseGroups)) {
                    $currentGroup = $cruiseGroups->firstWhere('group_key', $currentGroupKey);
                } else {
                    $currentGroup = isset($cruiseGroups) ? $cruiseGroups->first() : null;
                    $currentGroupKey = $currentGroup ? $currentGroup->group_key : null;
                }
            @endphp
            <li class="menu-item {{ $isMainCategoriesActive ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-ship"></i>
                    <div data-i18n="Main Categories">Main Categories</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ $isCruiseGroupsActive ? 'active' : '' }}">
                        <a href="{{ route('admin.cruise-groups.index') }}" class="menu-link">
                            <div data-i18n="Categories">Categories</div>
                        </a>
                    </li>
                    @if (isset($cruiseGroups) && $cruiseGroups->count() > 0)
                        <li class="menu-item {{ $isCruiseExperiencesActive ? 'active open' : '' }}">
                            <a href="javascript:void(0);" class="menu-link menu-toggle">
                                <div data-i18n="Sub Categories">Sub Categories</div>
                            </a>
                            <ul class="menu-sub">
                                @foreach ($cruiseGroups as $group)
                                    @php
                                        $isActive =
                                            $isCruiseExperiencesActive &&
                                            (($currentGroupKey && $currentGroupKey == $group->group_key) ||
                                                ($currentCruiseGroupId && $currentCruiseGroupId == $group->id));
                                    @endphp
                                    <li class="menu-item {{ $isActive ? 'active' : '' }}">
                                        <a href="{{ route('admin.cruise-experiences.index', ['cruise_group_id' => $group->id]) }}"
                                            class="menu-link">
                                            <div data-i18n="{{ $group->name }}">{{ $group->name }}</div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @endif
                </ul>
            </li>

            @php
                $isCruiseCatalogActive = request()->routeIs('admin.cruise-catalog.*');
            @endphp
            <li class="menu-item {{ $isCruiseCatalogActive ? 'active open' : '' }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-anchor"></i>
                    <div data-i18n="Cruise Catalog">Cruise Catalog</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ \App\Helpers\setSidebarActive(['admin.cruise-catalog.categories.*'], 'active') }}">
                        <a href="{{ route('admin.cruise-catalog.categories.index') }}" class="menu-link">
                            <div data-i18n="Catalog Categories">Categories</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \App\Helpers\setSidebarActive(['admin.cruise-catalog.programs.*'], 'active') }}">
                        <a href="{{ route('admin.cruise-catalog.programs.index') }}" class="menu-link">
                            <div data-i18n="Cruise Programs">Programs</div>
                        </a>
                    </li>
                    <li
                        class="menu-item {{ \App\Helpers\setSidebarActive(['admin.cruise-catalog.vessels.*'], 'active') }}">
                        <a href="{{ route('admin.cruise-catalog.vessels.index') }}" class="menu-link">
                            <div data-i18n="Cruise Vessels">Vessels</div>
                        </a>
                    </li>
                </ul>
            </li>

            <li
                class="menu-item {{ \App\Helpers\setSidebarActive(['admin.tours.*', 'admin.tour-variants.*'], 'active open') }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-plane"></i>
                    <div data-i18n="Tours">Tours</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.tours.*'], 'active') }}">
                        <a href="{{ route('admin.tours.index') }}" class="menu-link">
                            <div data-i18n="All Tours">All Tours</div>
                        </a>
                    </li>
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.tour-variants.*'], 'active') }}">
                        <a href="{{ route('admin.tour-variants.index') }}" class="menu-link">
                            <div data-i18n="Optional Excursions">
                                Optional Excursions
                            </div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Locations --}}
            <li
                class="menu-item {{ \App\Helpers\setSidebarActive(['admin.countries.*', 'admin.states.*'], 'active open') }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-map-pin"></i>
                    <div data-i18n="Locations">Locations</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.countries.*'], 'active') }}">
                        <a href="{{ route('admin.countries.index') }}" class="menu-link">
                            <div data-i18n="Countries">Countries</div>
                        </a>
                    </li>
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.states.*'], 'active') }}">
                        <a href="{{ route('admin.states.index') }}" class="menu-link">
                            <div data-i18n="States">States</div>
                        </a>
                    </li>
                </ul>
            </li>

        @endif




        {{-- Content Management Section --}}
        @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('dashboard.access'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Content Management</span>
            </li>

            {{-- TopNav Announcement --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.announcements.*'], 'active') }}">
                <a href="{{ route('admin.announcements.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-speakerphone"></i>
                    <div data-i18n="Live Highlights">Live Highlights</div>
                </a>
            </li>

            {{-- FAQs --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.faqs.*'], 'active') }}">
                <a href="{{ route('admin.faqs.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-help"></i>
                    <div data-i18n="FAQs">FAQs</div>
                </a>
            </li>


            {{-- Testimonials --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.testimonials.*'], 'active') }}">
                <a href="{{ route('admin.testimonials.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-message-circle"></i>
                    <div data-i18n="Testimonials">Testimonials</div>
                </a>
            </li>
            {{-- Sliders --}}
            {{-- <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.sliders.*'], 'active') }}">
                            <a href="{{ route('admin.sliders.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-slideshow"></i>
                                <div data-i18n="Sliders">Sliders</div>
                            </a>
                        </li> --}}

            {{-- Blogs --}}
            <li
                class="menu-item {{ \App\Helpers\setSidebarActive(['admin.blog-categories.*', 'admin.blogs.*'], 'active open') }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-news"></i>
                    <div data-i18n="Blogs">Blogs</div>
                </a>
                <ul class="menu-sub">
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.blog-categories.*'], 'active') }}">
                        <a href="{{ route('admin.blog-categories.index') }}" class="menu-link">
                            <div data-i18n="Blog Categories">Blog Categories</div>
                        </a>
                    </li>
                    <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.blogs.*'], 'active') }}">
                        <a href="{{ route('admin.blogs.index') }}" class="menu-link">
                            <div data-i18n="Blogs">Blogs</div>
                        </a>
                    </li>
                </ul>
            </li>

            {{-- Galleries --}}
            {{-- <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.galleries.*'], 'active') }}">
                            <a href="{{ route('admin.galleries.index') }}" class="menu-link">
                                <i class="menu-icon tf-icons ti ti-slideshow"></i>
                                <div data-i18n="Galleries">Galleries</div>
                            </a>
                        </li> --}}








            {{-- Pages SEO --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.pages.*'], 'active') }}">
                <a href="{{ route('admin.pages.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-file-text"></i>
                    <div data-i18n="Pages SEO">Pages SEO</div>
                </a>
            </li>

            {{-- Site Sections --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.site-sections.*'], 'active open') }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-layout-2"></i>
                    <div data-i18n="Home Sections">Home Sections</div>
                </a>
                <ul class="menu-sub">
                    <li
                        class="menu-item {{ \App\Helpers\setSidebarActive(['admin.site-sections.index'], 'active') }}">
                        <a href="{{ route('admin.site-sections.index') }}" class="menu-link">
                            <div data-i18n="All Sections">All Sections</div>
                        </a>
                    </li>
                    {{-- <li
                        class="menu-item {{ \App\Helpers\setSidebarActive(['admin.site-sections.about'], 'active') }}">
                        <a href="{{ route('admin.site-sections.about') }}" class="menu-link">
                            <div data-i18n="About Sections">About Page Sections</div>
                        </a>
                    </li> --}}
                </ul>
            </li>
        @endif

        {{-- Communications Section --}}
        @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('dashboard.access'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">Communications</span>
            </li>

            {{-- Contacts --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.contacts.*'], 'active') }}">
                <a href="{{ route('admin.contacts.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-mail"></i>
                    <div data-i18n="Contacts">Contact Messages</div>
                    {{-- @if (isset($unreadContactsCount) && $unreadContactsCount > 0)
                        <span class="badge rounded-pill bg-label-danger ms-auto">{{ $unreadContactsCount }}</span>
                    @elseif(isset($sidebarStats['contacts']))
                        <span
                            class="badge rounded-pill bg-label-primary ms-auto">{{ $sidebarStats['contacts'] }}</span>
                    @endif --}}
                </a>
            </li>

            {{-- Subscribers --}}
            <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.subscribers.*'], 'active') }}">
                <a href="{{ route('admin.subscribers.index') }}" class="menu-link">
                    <i class="ti ti-users ti-md"></i>
                    <div data-i18n="Subscribers">Newsletter Subscribers</div>
                </a>
            </li>
        @endif

        {{-- System Section --}}
        @if (auth()->user()->isAdmin() ||
                auth()->user()->hasPermission('users.manage') ||
                auth()->user()->hasPermission('roles.manage'))
            <li class="menu-header small text-uppercase">
                <span class="menu-header-text">System</span>
            </li>


            {{-- Users & Roles --}}
            <li
                class="menu-item {{ \App\Helpers\setSidebarActive(['admin.users.*', 'admin.roles.*'], 'active open') }}">
                <a href="javascript:void(0);" class="menu-link menu-toggle">
                    <i class="menu-icon tf-icons ti ti-shield-lock"></i>
                    <div data-i18n="Users & Roles">Users & Roles</div>
                </a>
                <ul class="menu-sub">
                    @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('users.manage'))
                        <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.users.*'], 'active') }}">
                            <a href="{{ route('admin.users.index') }}" class="menu-link">
                                <div data-i18n="Users">Users</div>
                            </a>
                        </li>
                    @endif

                    @if (auth()->user()->isAdmin() || auth()->user()->hasPermission('roles.manage'))
                        <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.roles.*'], 'active') }}">
                            <a href="{{ route('admin.roles.index') }}" class="menu-link">
                                <div data-i18n="Roles">Roles & Permissions</div>
                            </a>
                        </li>
                    @endif
                </ul>
            </li>
            {{-- Settings --}}
            {{-- <li class="menu-item {{ \App\Helpers\setSidebarActive(['admin.settings.*'], 'active') }}">
                <a href="{{ route('admin.settings.edit') }}" class="menu-link">
                    <i class="menu-icon tf-icons ti ti-settings"></i>
                    <div data-i18n="Settings">Settings</div>
                </a>
            </li> --}}
        @endif

    </ul>
</aside>
