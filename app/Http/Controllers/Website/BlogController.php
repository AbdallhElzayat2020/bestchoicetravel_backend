<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');
        $activeCategory = $request->query('category');

        $query = Blog::active()
            ->published();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        if ($activeCategory) {
            $query->where('category', $activeCategory);
        }

        $blogs = $query
            ->orderBy('sort_order')
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $usedCategoryNames = Blog::active()
            ->published()
            ->whereNotNull('category')
            ->where('category', '!=', '')
            ->distinct()
            ->pluck('category');

        $categories = BlogCategory::whereIn('name', $usedCategoryNames)
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('frontend.pages.blogs.index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'search' => $search,
            'activeCategory' => $activeCategory,
        ]);
    }

    public function show(string $slug)
    {
        $blog = Blog::active()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Get related blogs (same category or recent)
        $relatedBlogs = Blog::active()
            ->published()
            ->where('id', '!=', $blog->id)
            ->orderBy('published_at', 'desc')
            ->take(3)
            ->get();

        return view('frontend.pages.blogs.show', compact('blog', 'relatedBlogs'));
    }
}
