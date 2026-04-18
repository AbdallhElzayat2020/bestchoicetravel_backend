<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseCatalogCategory;
use App\Models\CruiseCatalogProgram;
use App\Models\CruiseCatalogVessel;
use App\Models\CruiseCatalogVesselImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CruiseCatalogVesselController extends Controller
{
    public function index(Request $request)
    {
        $query = CruiseCatalogVessel::with('category')->orderBy('sort_order')->latest();

        if ($request->filled('cruise_catalog_category_id')) {
            $query->where('cruise_catalog_category_id', $request->cruise_catalog_category_id);
        }

        $vessels = $query->paginate(20)->withQueryString();
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('dashboard.cruise-catalog.vessels.index', compact('vessels', 'categories'));
    }

    public function create()
    {
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();
        $programs = CruiseCatalogProgram::with('category')->orderBy('title')->get();

        return view('dashboard.cruise-catalog.vessels.create', compact('categories', 'programs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cruise_catalog_category_id' => 'required|exists:cruise_catalog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_vessels,slug',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'price_tier_1' => 'required|numeric|min:0',
            'price_tier_2' => 'nullable|numeric|min:0',
            'price_tier_3' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:cruise_catalog_programs,id',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        // DB columns are non-null decimals; normalize empty inputs to 0.00
        $validated['price_tier_1'] = (float) $validated['price_tier_1'];
        $validated['price_tier_2'] = $request->filled('price_tier_2') ? (float) $validated['price_tier_2'] : 0;
        $validated['price_tier_3'] = $request->filled('price_tier_3') ? (float) $validated['price_tier_3'] : 0;

        $programIds = $request->input('program_ids', []);
        $this->assertProgramsBelongToCategory($programIds, (int) $validated['cruise_catalog_category_id']);

        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $validated['cover_image'] = $file->storeAs('', time().'_'.uniqid().'_cover.'.$file->getClientOriginalExtension(), 'cruise_catalog');
        }

        $galleryFiles = $request->file('gallery', []);

        DB::transaction(function () use ($validated, $programIds, $galleryFiles) {
            $vessel = CruiseCatalogVessel::create($validated);
            if ($programIds) {
                $vessel->programs()->sync($programIds);
            }
            foreach ($galleryFiles as $i => $image) {
                if (! $image) {
                    continue;
                }
                $path = $image->storeAs('', time().'_'.uniqid().'_g.'.$image->getClientOriginalExtension(), 'cruise_catalog');
                CruiseCatalogVesselImage::create([
                    'cruise_catalog_vessel_id' => $vessel->id,
                    'image_path' => $path,
                    'alt' => null,
                    'sort_order' => $i,
                ]);
            }
        });

        return redirect()->route('admin.cruise-catalog.vessels.index')
            ->with('success', 'Cruise vessel created.');
    }

    public function edit(CruiseCatalogVessel $vessel)
    {
        $vessel->load(['images', 'programs']);
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();
        $programs = CruiseCatalogProgram::with('category')->orderBy('title')->get();

        return view('dashboard.cruise-catalog.vessels.edit', compact('vessel', 'categories', 'programs'));
    }

    public function update(Request $request, CruiseCatalogVessel $vessel)
    {
        $validated = $request->validate([
            'cruise_catalog_category_id' => 'required|exists:cruise_catalog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_vessels,slug,'.$vessel->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'price_tier_1' => 'required|numeric|min:0',
            'price_tier_2' => 'nullable|numeric|min:0',
            'price_tier_3' => 'nullable|numeric|min:0',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'program_ids' => 'nullable|array',
            'program_ids.*' => 'exists:cruise_catalog_programs,id',
            'gallery' => 'nullable|array',
            'gallery.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        if (! empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $validated['price_tier_1'] = (float) $validated['price_tier_1'];
        $validated['price_tier_2'] = $request->filled('price_tier_2') ? (float) $validated['price_tier_2'] : 0;
        $validated['price_tier_3'] = $request->filled('price_tier_3') ? (float) $validated['price_tier_3'] : 0;

        $programIds = $request->input('program_ids', []);
        $this->assertProgramsBelongToCategory($programIds, (int) $validated['cruise_catalog_category_id']);

        if ($request->hasFile('cover_image')) {
            if ($vessel->cover_image) {
                Storage::disk('cruise_catalog')->delete($vessel->cover_image);
            }
            $file = $request->file('cover_image');
            $validated['cover_image'] = $file->storeAs('', time().'_'.uniqid().'_cover.'.$file->getClientOriginalExtension(), 'cruise_catalog');
        }

        $galleryFiles = $request->file('gallery', []);

        DB::transaction(function () use ($vessel, $validated, $programIds, $galleryFiles) {
            $vessel->update($validated);
            $vessel->programs()->sync($programIds);

            foreach ($galleryFiles as $i => $image) {
                if (! $image) {
                    continue;
                }
                $path = $image->storeAs('', time().'_'.uniqid().'_g.'.$image->getClientOriginalExtension(), 'cruise_catalog');
                CruiseCatalogVesselImage::create([
                    'cruise_catalog_vessel_id' => $vessel->id,
                    'image_path' => $path,
                    'alt' => null,
                    'sort_order' => ($vessel->images()->max('sort_order') ?? -1) + 1 + $i,
                ]);
            }
        });

        return redirect()->route('admin.cruise-catalog.vessels.index')
            ->with('success', 'Cruise vessel updated.');
    }

    public function destroy(CruiseCatalogVessel $vessel)
    {
        foreach ($vessel->images as $img) {
            if ($img->image_path) {
                Storage::disk('cruise_catalog')->delete($img->image_path);
            }
        }
        if ($vessel->cover_image) {
            Storage::disk('cruise_catalog')->delete($vessel->cover_image);
        }
        $vessel->delete();

        return redirect()->route('admin.cruise-catalog.vessels.index')
            ->with('success', 'Cruise vessel deleted.');
    }

    public function destroyCover(CruiseCatalogVessel $vessel)
    {
        if ($vessel->cover_image) {
            Storage::disk('cruise_catalog')->delete($vessel->cover_image);
            $vessel->update(['cover_image' => null]);
        }

        return redirect()->route('admin.cruise-catalog.vessels.edit', $vessel)
            ->with('success', 'Cover image removed.');
    }

    public function destroyGalleryImage(CruiseCatalogVessel $vessel, int $vesselImage)
    {
        $image = CruiseCatalogVesselImage::query()
            ->where('cruise_catalog_vessel_id', $vessel->id)
            ->whereKey($vesselImage)
            ->firstOrFail();

        if ($image->image_path) {
            Storage::disk('cruise_catalog')->delete($image->image_path);
        }
        $image->delete();

        return redirect()->route('admin.cruise-catalog.vessels.edit', $vessel)
            ->with('success', 'Gallery image removed.');
    }

    /**
     * @param  array<int|string>  $programIds
     */
    private function assertProgramsBelongToCategory(array $programIds, int $categoryId): void
    {
        if ($programIds === []) {
            return;
        }

        $invalid = CruiseCatalogProgram::whereIn('id', $programIds)
            ->where('cruise_catalog_category_id', '!=', $categoryId)
            ->exists();

        if ($invalid) {
            throw ValidationException::withMessages([
                'program_ids' => ['All selected programs must belong to the same category as the vessel.'],
            ]);
        }
    }
}
