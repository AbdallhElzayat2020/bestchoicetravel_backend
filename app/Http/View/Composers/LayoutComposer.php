<?php

namespace App\Http\View\Composers;

use App\Models\Announcement;
use App\Models\Category;
use App\Models\CruiseExperience;
use App\Models\Page;
use App\Models\Setting;
use App\Models\Tour;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class LayoutComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get all active categories once (used in navbar and footer)
        $categories = Category::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // Get all active cruise experiences once (used in navbar and footer)
        $cruiseExperiences = CruiseExperience::active()
            ->orderBy('sort_order')
            ->get();

        // Get active announcements (used in navbar)
        $announcements = Announcement::where('status', 'active')
            ->orderBy('sort_order')
            ->get();

        // Get static pages for footer (cached, single query)
        $staticPages = Cache::remember('static_pages', 3600, function () {
            return Page::whereIn('slug', ['terms-and-conditions', 'privacy-policy'])
                ->where('status', 'active')
                ->get()
                ->keyBy('slug');
        });

        $termsPage = $staticPages->get('terms-and-conditions');
        $privacyPage = $staticPages->get('privacy-policy');

        // Get all settings in one query (cached)
        $settings = Setting::getAll();

        // Get settings from cached array
        $dahbiaCruisesName = $settings['dahbia_cruises_name'] ?? 'Dahbia Cruises';
        $phone = $settings['phone'] ?? '+20 101 515 7744 / +20 101 515 7746';
        $email = $settings['email'] ?? 'info@grandnilecruises.com';
        $address = $settings['address'] ?? 'Sarayah Zayed 2 Building, Apartment 1,<br>8th District<br>Sheikh Zayed City - Giza';
        $navbarLogo = $settings['navbar_logo'] ?? null;
        $footerLogo = $settings['footer_logo'] ?? null;

        // Get tours for each category (unified queries for navbar dropdowns)
        $nileCruisesCategory = $categories->firstWhere('slug', 'nile-cruises');
        $dahbiaToursCategory = $categories->firstWhere('slug', 'dahbia-tours');
        $tourEgyptPackagesCategory = $categories->firstWhere('slug', 'tour-egypt-packages');

        // Get tours for Nile Cruises category
        $nileCruisesTours = $nileCruisesCategory
            ? Tour::active()
                ->where('category_id', $nileCruisesCategory->id)
                ->select('id', 'title', 'slug', 'category_id')
                ->orderBy('sort_order')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        // Get tours for Dahbia Tours category
        $dahbiaToursTours = $dahbiaToursCategory
            ? Tour::active()
                ->where('category_id', $dahbiaToursCategory->id)
                ->select('id', 'title', 'slug', 'category_id')
                ->orderBy('sort_order')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        // Get tours for Tour Egypt Packages category
        $tourEgyptPackagesTours = $tourEgyptPackagesCategory
            ? Tour::active()
                ->where('category_id', $tourEgyptPackagesCategory->id)
                ->select('id', 'title', 'slug', 'category_id')
                ->orderBy('sort_order')
                ->latest()
                ->take(10)
                ->get()
            : collect();

        // Share data with all views
        $view->with([
            'sharedCategories' => $categories,
            'sharedCruiseExperiences' => $cruiseExperiences,
            'sharedAnnouncements' => $announcements,
            'sharedTermsPage' => $termsPage,
            'sharedPrivacyPage' => $privacyPage,
            'sharedNileCruisesTours' => $nileCruisesTours,
            'sharedDahbiaToursTours' => $dahbiaToursTours,
            'sharedTourEgyptPackagesTours' => $tourEgyptPackagesTours,
            'dahbiaCruisesName' => $dahbiaCruisesName,
            'sitePhone' => $phone,
            'siteEmail' => $email,
            'siteAddress' => $address,
            'navbarLogo' => $navbarLogo,
            'footerLogo' => $footerLogo,
        ]);
    }
}
