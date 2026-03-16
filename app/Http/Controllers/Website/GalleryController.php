<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::active()
            ->published()
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.pages.galleries.index', compact('galleries'));
    }

    public function show(string $slug)
    {
        $gallery = Gallery::active()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('frontend.pages.galleries.show', compact('gallery'));
    }
}
