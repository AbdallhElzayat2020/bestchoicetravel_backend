<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Faq;

class PageController extends Controller
{
    public function about()
    {
        $page = Page::getBySlug('about-us') ?? new Page([
            'slug' => 'about-us',
            'name' => 'About Us',
            'meta_title' => 'About Us',
        ]);

        return view('frontend.pages.about', compact('page'));
    }

    public function faqs()
    {
        $page = Page::getBySlug('faqs');
        $faqs = Faq::where('status', 'active')
            ->orderBy('sort_order')
            ->orderBy('created_at', 'asc')
            ->get();

        return view('frontend.pages.faqs', compact('faqs', 'page'));
    }

    /**
     * Display Terms and Conditions page
     */
    public function termsAndConditions()
    {
        $page = Page::where('slug', 'terms-and-conditions')
            ->where('status', 'active')
            ->firstOrFail();

        return view('frontend.pages.page', compact('page'));
    }

    /**
     * Display Privacy Policy page
     */
    public function privacyPolicy()
    {
        $page = Page::where('slug', 'privacy-policy')
            ->where('status', 'active')
            ->firstOrFail();

        return view('frontend.pages.page', compact('page'));
    }

    /**
     * Display a dynamic page by slug
     */
    public function show(string $slug)
    {
        $page = Page::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        return view('frontend.pages.page', compact('page'));
    }
}
