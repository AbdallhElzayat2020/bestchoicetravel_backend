<?php

namespace App\Providers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\CruiseCatalogCategory;
use App\Models\CruiseExperience;
use App\Models\CruiseGroup;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class SharedDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register shared data as singleton to ensure it's loaded only once
        $this->app->singleton('shared.data', function ($app) {
            return $this->loadSharedData();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Share data with all frontend views using view composer
        view()->composer(['frontend.*', 'frontend.layouts.*', 'frontend.pages.*'], function ($view) {
            $sharedData = app('shared.data');

            $view->with([
                'sharedCategories' => $sharedData['categories'],
                'sharedCruiseExperiences' => $sharedData['cruiseExperiences'],
                'sharedCruiseGroups' => $sharedData['cruiseGroups'],
                'sharedCruiseGroupsWithExperiences' => $sharedData['cruiseGroupsWithExperiences'],
                'sharedCruiseCatalogCategories' => $sharedData['cruiseCatalogCategories'],
                'sharedAnnouncements' => $sharedData['announcements'],
                'sharedAnnouncementBar' => $sharedData['sharedAnnouncementBar'],
                'announcementBarEnabled' => $sharedData['announcementBarEnabled'],
                'sharedTermsPage' => $sharedData['termsPage'],
                'sharedPrivacyPage' => $sharedData['privacyPage'],
                'mainCruisesMenuName' => $sharedData['mainCruisesMenuName'],
                'sitePhone' => $sharedData['phone'],
                'siteEmail' => $sharedData['email'],
                'siteAddress' => $sharedData['address'],
                'navbarLogo' => $sharedData['navbarLogo'],
                'footerLogo' => $sharedData['footerLogo'],
            ]);
        });
    }

    /**
     * Load all shared data once
     */
    protected function loadSharedData(): array
    {
        // Get all active categories once (used in navbar and footer)
        $categories = Category::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // Get all active cruise groups (cached)
        $cruiseGroups = Cache::remember('cruise_groups_frontend', 3600, function () {
            return CruiseGroup::active()
                ->with(['cruiseExperiences' => function ($query) {
                    $query->active()->orderBy('sort_order');
                }])
                ->orderBy('sort_order')
                ->get();
        });

        // Get all active cruise experiences once (used in navbar and footer) with eager loading
        $cruiseExperiences = CruiseExperience::active()
            ->with('images', 'cruiseGroup')
            ->orderBy('sort_order')
            ->get();

        // Group cruise experiences by cruise_group_id from already loaded data (no extra queries)
        $cruiseGroupsWithExperiences = [];
        foreach ($cruiseGroups as $group) {
            $cruiseGroupsWithExperiences[$group->id] = [
                'group' => $group,
                'experiences' => $cruiseExperiences->where('cruise_group_id', $group->id)->values(),
            ];
        }

        // Cruise catalog categories from dashboard (used in navbar dropdown)
        $cruiseCatalogCategories = CruiseCatalogCategory::active()
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        // Active announcements (list) + single row for top bar (dynamic from DB)
        $announcements = Announcement::active()
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
        $sharedAnnouncementBar = $announcements->first();

        // Get static pages for footer (cached, single query)
        $staticPages = Cache::remember('static_pages', 3600, function () {
            return Page::whereIn('slug', ['terms-and-conditions', 'privacy-policy'])
                ->where('status', 'active')
                ->get()
                ->keyBy('slug');
        });

        $termsPage = $staticPages->get('terms-and-conditions');
        $privacyPage = $staticPages->get('privacy-policy');

        // Get all settings in one query (cached) - only once
        $settings = Setting::getAll();

        // Get settings from cached array
        $mainCruisesMenuName = $settings['main_cruises_menu_name'] ?? 'Dahabiya & Cruises';

        // Get settings from cached array
        $phone = $settings['phone'] ?? '+20 101 515 7744 / +20 101 515 7746';
        $email = $settings['email'] ?? 'info@grandnilecruises.com';
        $address = $settings['address'] ?? 'Sarayah Zayed 2 Building, Apartment 1,<br>8th District<br>Sheikh Zayed City - Giza';
        $navbarLogo = $settings['navbar_logo'] ?? null;
        $footerLogo = $settings['footer_logo'] ?? null;

        $announcementBarEnabled = ($settings['announcement_bar_enabled'] ?? '0') === '1';

        return [
            'categories' => $categories,
            'cruiseExperiences' => $cruiseExperiences,
            'cruiseGroups' => $cruiseGroups,
            'cruiseGroupsWithExperiences' => $cruiseGroupsWithExperiences,
            'cruiseCatalogCategories' => $cruiseCatalogCategories,
            'announcements' => $announcements,
            'sharedAnnouncementBar' => $sharedAnnouncementBar,
            'termsPage' => $termsPage,
            'privacyPage' => $privacyPage,
            'mainCruisesMenuName' => $mainCruisesMenuName,
            'phone' => $phone,
            'email' => $email,
            'address' => $address,
            'navbarLogo' => $navbarLogo,
            'footerLogo' => $footerLogo,
            'announcementBarEnabled' => $announcementBarEnabled,
        ];
    }
}
