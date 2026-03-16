<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Tour;
use App\Models\Category;
use App\Models\Faq;
use App\Models\Testimonial;

class TourController extends Controller
{
    /**
     * Display tours by category slug.
     */
    public function byCategory(string $slug)
    {
        $category = Category::active()->where('slug', $slug)->firstOrFail();

        $tours = Tour::active()
            ->where('category_id', $category->id)
            ->with(['category', 'subCategory', 'country', 'state'])
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('frontend.pages.tours.category', compact('category', 'tours'));
    }

    public function show(string $slug)
    {
        $tour = Tour::active()
            ->with([
                'category',
                'subCategory',
                'state',
                'country',
                'tourDays' => function ($query) {
                    $query->orderBy('day_number')->orderBy('sort_order');
                },
                'tourImages' => function ($query) {
                    $query->orderBy('sort_order');
                },
                'variants' => function ($query) {
                    $query->where('status', 'active')->orderBy('sort_order');
                },
                'seasonalPrices' => function ($query) {
                    $query->where('status', 'active')
                        ->with(['priceItems' => function ($q) {
                            $q->orderBy('sort_order');
                        }])
                        ->orderBy('sort_order');
                },
            ])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related tours (same category only) with eager loading
        // Laravel will optimize and reuse already loaded relations when IDs match
        $relatedTours = Tour::active()
            ->where('id', '!=', $tour->id)
            ->where('category_id', $tour->category_id)
            ->with(['category:id,name,slug', 'country:id,name,code', 'state:id,name,slug'])
            ->orderBy('sort_order')
            ->latest()
            ->take(8)
            ->get();

        // Get FAQs for the tour page
        $faqs = Faq::where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Get testimonials/reviews
        $testimonials = Testimonial::active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        // Calculate average rating
        $averageRating = $testimonials->count() > 0
            ? round($testimonials->avg('rating'), 1)
            : 0;

        $recaptchaSiteKey = config('services.recaptcha.site_key');

        return view('frontend.pages.tour-details', compact('tour', 'relatedTours', 'faqs', 'testimonials', 'averageRating', 'recaptchaSiteKey'));
    }
}
