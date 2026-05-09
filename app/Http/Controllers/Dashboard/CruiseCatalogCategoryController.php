<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseCatalogCategory;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
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
        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard.cruise-catalog.categories.create', compact('faqs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_categories,slug',
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'faq_ids' => 'nullable|array',
            'faq_ids.*' => 'exists:faqs,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('banner_image')) {
            $file = $request->file('banner_image');
            $validated['banner_image'] = $file->storeAs(
                '',
                time().'_'.uniqid().'_cat_banner.'.$file->getClientOriginalExtension(),
                'cruise_catalog'
            );
        } else {
            unset($validated['banner_image']);
        }

        $faqIds = $validated['faq_ids'] ?? [];
        unset($validated['faq_ids']);

        $category = CruiseCatalogCategory::create($validated);
        $this->syncFaqs($category, $faqIds);

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category created.');
    }

    public function edit(CruiseCatalogCategory $cruise_catalog_category)
    {
        $faqs = Faq::active()
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
        $selectedFaqIds = $cruise_catalog_category->faqs()->pluck('faqs.id')->toArray();

        return view('dashboard.cruise-catalog.categories.edit', [
            'category' => $cruise_catalog_category,
            'faqs' => $faqs,
            'selectedFaqIds' => $selectedFaqIds,
        ]);
    }

    public function update(Request $request, CruiseCatalogCategory $cruise_catalog_category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'h1_title' => 'nullable|string|max:255',
            'h2_title' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_categories,slug,'.$cruise_catalog_category->id,
            'description' => 'nullable|string',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'faq_ids' => 'nullable|array',
            'faq_ids.*' => 'exists:faqs,id',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        if ($request->hasFile('banner_image')) {
            $old = $cruise_catalog_category->banner_image;
            if ($old && Storage::disk('cruise_catalog')->exists($old)) {
                Storage::disk('cruise_catalog')->delete($old);
            }
            $file = $request->file('banner_image');
            $validated['banner_image'] = $file->storeAs(
                '',
                time().'_'.uniqid().'_cat_banner.'.$file->getClientOriginalExtension(),
                'cruise_catalog'
            );
        } else {
            unset($validated['banner_image']);
        }

        $faqIds = $validated['faq_ids'] ?? [];
        unset($validated['faq_ids']);

        $cruise_catalog_category->update($validated);
        $this->syncFaqs($cruise_catalog_category, $faqIds);

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category updated.');
    }

    public function destroy(CruiseCatalogCategory $cruise_catalog_category)
    {
        if ($cruise_catalog_category->programs()->exists() || $cruise_catalog_category->vessels()->exists()) {
            return back()->with('error', 'Cannot delete: remove programs and vessels under this category first.');
        }

        if ($cruise_catalog_category->banner_image && Storage::disk('cruise_catalog')->exists($cruise_catalog_category->banner_image)) {
            Storage::disk('cruise_catalog')->delete($cruise_catalog_category->banner_image);
        }

        $cruise_catalog_category->delete();

        return redirect()->route('admin.cruise-catalog.categories.index')
            ->with('success', 'Cruise category deleted.');
    }

    private function syncFaqs(CruiseCatalogCategory $category, array $faqIds): void
    {
        if (empty($faqIds)) {
            $category->faqs()->sync([]);
            return;
        }

        $syncData = [];
        foreach (array_values($faqIds) as $index => $faqId) {
            $syncData[$faqId] = ['sort_order' => $index];
        }

        $category->faqs()->sync($syncData);
    }
}
