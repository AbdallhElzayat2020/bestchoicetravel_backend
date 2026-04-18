<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseCatalogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CruiseCatalogCategoryController extends Controller
{
    public function index()
    {
        $categories = CruiseCatalogCategory::orderBy('sort_order')->latest()->paginate(20);

        return view('dashboard.cruise-catalog.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.cruise-catalog.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        CruiseCatalogCategory::create($validated);

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category created.');
    }

    public function edit(CruiseCatalogCategory $cruise_catalog_category)
    {
        return view('dashboard.cruise-catalog.categories.edit', ['category' => $cruise_catalog_category]);
    }

    public function update(Request $request, CruiseCatalogCategory $cruise_catalog_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_categories,slug,'.$cruise_catalog_category->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $cruise_catalog_category->update($validated);

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category updated.');
    }

    public function destroy(CruiseCatalogCategory $cruise_catalog_category)
    {
        if ($cruise_catalog_category->programs()->exists() || $cruise_catalog_category->vessels()->exists()) {
            return back()->with('error', 'Cannot delete: remove programs and vessels under this category first.');
        }

        $cruise_catalog_category->delete();

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category deleted.');
    }
}
