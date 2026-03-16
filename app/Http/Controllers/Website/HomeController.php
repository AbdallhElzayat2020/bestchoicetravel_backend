<?php

namespace App\Http\Controllers\Website;

use App\Models\Blog;
use App\Models\Tour;
use App\Models\Slider;
use App\Models\Subscriber;
use App\Models\Faq;
use App\Models\Gallery;
use App\Models\SiteSection;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sliders = Slider::active()
            ->orderBy('sort_order')
            ->get();

        // Get cruise experiences from shared data (already loaded by SharedDataServiceProvider)
        // Get latest 2 added
        $sharedCruiseExperiences = app('shared.data')['cruiseExperiences'];
        $cruiseExperiences = $sharedCruiseExperiences
            ->sortByDesc('created_at')
            ->take(2)
            ->values();

        $blogs = Blog::active()
            ->published()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(6)
            ->get();

        $homeGalleries = Gallery::active()
            ->published()
            ->homepage()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->take(9)
            ->get();

        $activeTours = Tour::active()
            ->homepage()
            ->select(
                'id',
                'title',
                'slug',
                'category_id',
                'sub_category_id',
                'country_id',
                'state_id',
                'cover_image',
                'price',
                'has_offer',
                'price_before_discount',
                'price_after_discount',
                'offer_start_date',
                'offer_end_date',
                'duration',
                'sort_order',
                'created_at'
            )
            ->with([
                'category:id,name,slug',
                'subCategory:id,name,slug',
                'country:id,name',
                'state:id,name'
            ])
            ->orderBy('sort_order')
            ->latest()
            ->take(8)
            ->get();

        $homeFaqs = Faq::active()
            ->where('show_on_homepage', true)
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        $siteSections = SiteSection::active()
            ->whereIn('key', [
                'home_hero',
                'home_cruises',
                'home_day_tours',
                'home_desert',
                'home_egypt_jordan',
                'home_redsea',
            ])
            ->get()
            ->keyBy('key');

        return view('frontend.pages.home', compact(
            'sliders',
            'cruiseExperiences',
            'blogs',
            'homeGalleries',
            'activeTours',
            'homeFaqs',
            'siteSections'
        ));
    }

    /**
     * Handle newsletter subscription.
     */
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|max:255',
            'name' => 'nullable|string|max:255',
        ]);

        $existing = Subscriber::where('email', $data['email'])->first();

        if ($existing) {
            $existing->update([
                'name' => $data['name'] ?? $existing->name,
                'is_active' => true,
                'subscribed_at' => now(),
                'unsubscribed_at' => null,
            ]);
        } else {
            Subscriber::create([
                'email' => $data['email'],
                'name' => $data['name'] ?? null,
                'is_active' => true,
                'subscribed_at' => now(),
            ]);
        }

        return redirect()->back()->with('success', 'Subscribed successfully!');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
