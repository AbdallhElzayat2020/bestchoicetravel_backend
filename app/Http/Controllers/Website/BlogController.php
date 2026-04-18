<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $search = $this->sanitizeBlogSearch($request->query('q'));

        // Canonical param is category_name=… (value is the category slug). Legacy category_slug → redirect.
        if ($request->filled('category_slug') && !$request->filled('category_name')) {
            return redirect()->route('blogs.index', $this->blogIndexQueryParams(
                $search,
                (string) $request->query('category_slug'),
                $request
            ));
        }

        $slugParam = $request->query('category_name');
        $nameParam = $request->query('category');

        // SEO: redirect ?category=Full%20Name → ?category_name=slug (one canonical shape)
        if ($nameParam !== null && $slugParam === null) {
            $resolved = BlogCategory::active()->where('name', $nameParam)->first();
            if ($resolved) {
                return redirect()->route('blogs.index', $this->blogIndexQueryParams($search, $resolved->slug, $request));
            }
        }

        $activeCategoryName = null;
        $activeCategorySlug = null;

        if ($slugParam) {
            $cat = BlogCategory::active()->where('slug', $slugParam)->first();
            if ($cat) {
                $activeCategoryName = $cat->name;
                $activeCategorySlug = $cat->slug;
            }
        }

        // Drop empty / meaningless q (e.g. # only) from URL
        if ($request->has('q') && $search === null) {
            return redirect()->route('blogs.index', $this->blogIndexQueryParams(null, $activeCategorySlug, $request));
        }

        $query = Blog::active()
            ->published();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('short_description', 'like', '%' . $search . '%');
            });
        }

        if ($activeCategoryName) {
            $query->where('category', $activeCategoryName);
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

        $blogsPage = \App\Models\Page::getBySlug('blogs');
        $baseTitle = $blogsPage && $blogsPage->meta_title ? $blogsPage->meta_title : 'Blog';
        $baseDescription = $blogsPage && $blogsPage->meta_description
            ? $blogsPage->meta_description
            : 'Travel stories, guides and tips for your Egypt journey.';

        if ($search) {
            $blogMetaTitle = 'Search: "' . Str::limit($search, 55) . '" | ' . $baseTitle;
            $blogMetaDescription = 'Search results for "' . Str::limit($search, 120) . '" on our travel blog — articles about Egypt tours, Nile cruises and destinations.';
        } elseif ($activeCategoryName) {
            $blogMetaTitle = $activeCategoryName . ' | ' . $baseTitle;
            $blogMetaDescription = 'Read articles about ' . $activeCategoryName . ' — travel inspiration and practical tips for Egypt.';
        } else {
            $blogMetaTitle = $baseTitle;
            $blogMetaDescription = $baseDescription;
        }

        $blogCanonicalUrl = route('blogs.index', $this->canonicalBlogParams($search, $activeCategorySlug, $request));

        // Internal search result pages: avoid duplicate thin URLs in Google
        $blogRobots = $search ? 'noindex, follow' : 'index, follow';

        return view('frontend.pages.blogs.index', [
            'blogs' => $blogs,
            'categories' => $categories,
            'search' => $search,
            'activeCategory' => $activeCategoryName,
            'activeCategorySlug' => $activeCategorySlug,
            'blogMetaTitle' => $blogMetaTitle,
            'blogMetaDescription' => $blogMetaDescription,
            'blogCanonicalUrl' => $blogCanonicalUrl,
            'blogRobots' => $blogRobots,
            'hasActiveFilters' => (bool) $search || (bool) $activeCategorySlug,
        ]);
    }

    /**
     * Strip noise (e.g. lone #), trim, limit length for LIKE queries.
     */
    private function sanitizeBlogSearch(?string $raw): ?string
    {
        if ($raw === null || $raw === '') {
            return null;
        }

        $s = trim($raw);
        $s = ltrim($s, '#');
        $s = trim($s);

        if ($s === '') {
            return null;
        }

        return Str::limit($s, 200);
    }

    /**
     * Query string for redirects (drops empty keys, normalizes page).
     *
     * @return array<string, mixed>
     */
    private function blogIndexQueryParams(?string $search, ?string $categorySlug, Request $request): array
    {
        $params = array_filter([
            'category_name' => $categorySlug,
            'q' => $search,
        ], fn($v) => $v !== null && $v !== '');

        $page = (int) $request->query('page', 1);
        if ($page > 1) {
            $params['page'] = $page;
        }

        return $params;
    }

    /**
     * Canonical URL params (same as visible filters, includes page when paginated).
     *
     * @return array<string, mixed>
     */
    private function canonicalBlogParams(?string $search, ?string $categorySlug, Request $request): array
    {
        return $this->blogIndexQueryParams($search, $categorySlug, $request);
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
