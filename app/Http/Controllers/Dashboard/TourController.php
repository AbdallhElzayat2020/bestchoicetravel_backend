<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Country;
use App\Models\State;
use App\Models\SubCategory;
use App\Models\Tour;
use App\Models\TourDay;
use App\Models\TourImage;
use App\Models\TourVariant;
use App\Models\TourSeasonalPrice;
use App\Models\TourSeasonalPriceItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class TourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tours = Tour::with(['category', 'subCategory', 'country', 'state', 'tourDays'])
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);
        return view('dashboard.tours.index', compact('tours'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::active()->orderBy('name')->get();
        $countries = Country::active()->orderBy('name')->get();
        // Don't load sub categories and states initially - they will be loaded via AJAX
        $subCategories = collect();
        $states = collect();
        $availableVariants = TourVariant::active()->orderBy('sort_order')->get();
        return view('dashboard.tours.create', compact('categories', 'subCategories', 'countries', 'states', 'availableVariants'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'title' => 'required|string|max:255|unique:tours,title',
            'slug' => 'nullable|string|max:255|unique:tours,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:hours,days',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'show_on_homepage' => 'nullable|boolean',
            'price' => 'required|numeric|min:0',
            'has_offer' => 'nullable|boolean',
            'price_before_discount' => 'nullable|numeric|min:0|required_if:has_offer,1',
            'price_after_discount' => 'nullable|numeric|min:0|required_if:has_offer,1',
            'offer_start_date' => 'nullable|date|required_if:has_offer,1',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date|required_if:has_offer,1',
            'notes' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'tour_days' => 'nullable|array',
            'tour_days.*.day_number' => 'required|integer|min:1',
            'tour_days.*.day_title' => 'required|string|max:255',
            'tour_days.*.details' => 'nullable|string',
            'cover_image_alt' => 'nullable|string|max:255',
            'tour_images' => 'nullable|array',
            'tour_images.*.image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tour_images.*.alt' => 'nullable|string|max:255',
            'tour_images.*.sort_order' => 'nullable|integer|min:0',
            'tour_variants' => 'nullable|array',
            'tour_variants.*.title' => 'required|string|max:255',
            'tour_variants.*.description' => 'nullable|string',
            'tour_variants.*.additional_duration' => 'nullable|integer|min:0',
            'tour_variants.*.additional_duration_type' => 'nullable|in:hours,days',
            'tour_variants.*.additional_price' => 'nullable|numeric|min:0',
            'tour_variants.*.status' => 'nullable|in:active,inactive',
            'tour_variants.*.sort_order' => 'nullable|integer|min:0',
            'seasonal_prices' => 'nullable|array',
            'seasonal_prices.*.season_name' => 'required|string|max:255',
            'seasonal_prices.*.start_month' => 'required|integer|min:1|max:12',
            'seasonal_prices.*.end_month' => 'required|integer|min:1|max:12',
            'seasonal_prices.*.description' => 'nullable|string',
            'seasonal_prices.*.status' => 'nullable|in:active,inactive',
            'seasonal_prices.*.sort_order' => 'nullable|integer|min:0',
            'seasonal_prices.*.price_items' => 'nullable|array',
            'seasonal_prices.*.price_items.*.price_name' => 'required|string|max:255',
            'seasonal_prices.*.price_items.*.price_value' => 'required|numeric|min:0',
            'seasonal_prices.*.price_items.*.description' => 'nullable|string',
            'seasonal_prices.*.price_items.*.sort_order' => 'nullable|integer|min:0',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $validated['cover_image'] = $image->storeAs('', $imageName, 'tours');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle boolean fields
        $validated['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;
        $validated['has_offer'] = $request->has('has_offer') ? true : false;

        // Use database transaction
        DB::beginTransaction();
        try {
            // Create tour
            $tour = Tour::create($validated);

            // Handle tour days
            if ($request->has('tour_days') && is_array($request->tour_days)) {
                $dayIndex = 0;
                foreach ($request->tour_days as $index => $dayData) {
                    if (!empty($dayData['day_title'])) {
                        $sortOrder = isset($dayData['sort_order']) && is_numeric($dayData['sort_order'])
                            ? (int) $dayData['sort_order']
                            : $dayIndex;
                        $dayNumber = isset($dayData['day_number']) && is_numeric($dayData['day_number'])
                            ? (int) $dayData['day_number']
                            : ($dayIndex + 1);
                        TourDay::create([
                            'tour_id' => $tour->id,
                            'day_number' => $dayNumber,
                            'day_title' => $dayData['day_title'],
                            'details' => $dayData['details'] ?? null,
                            'sort_order' => $sortOrder,
                        ]);
                        $dayIndex++;
                    }
                }
            }

            // Handle tour images - fix the array structure
            if ($request->has('tour_images') && is_array($request->tour_images)) {
                foreach ($request->tour_images as $index => $imageData) {
                    // Check if it's a file upload
                    if ($request->hasFile("tour_images.{$index}.image")) {
                        $imageFile = $request->file("tour_images.{$index}.image");
                        if ($imageFile && $imageFile->isValid()) {
                            $imageName = time() . '_' . uniqid() . '_' . $index . '.' . $imageFile->getClientOriginalExtension();
                            $imagePath = $imageFile->storeAs('', $imageName, 'tours');

                            TourImage::create([
                                'tour_id' => $tour->id,
                                'image' => $imagePath,
                                'alt' => $imageData['alt'] ?? null,
                                'sort_order' => $imageData['sort_order'] ?? $index,
                            ]);
                        }
                    }
                }
            }

            // Handle tour variants (from available variants checkboxes)
            if ($request->has('selected_variants') && is_array($request->selected_variants)) {
                $tour->variants()->sync($request->selected_variants);
            } else {
                // If no variants selected, detach all
                $tour->variants()->detach();
            }

            // Handle seasonal prices
            if ($request->has('seasonal_prices') && is_array($request->seasonal_prices)) {
                foreach ($request->seasonal_prices as $index => $priceData) {
                    if (!empty($priceData['season_name'])) {
                        $seasonalPrice = TourSeasonalPrice::create([
                            'tour_id' => $tour->id,
                            'season_name' => $priceData['season_name'],
                            'start_month' => $priceData['start_month'],
                            'end_month' => $priceData['end_month'],
                            'description' => $priceData['description'] ?? null,
                            'status' => $priceData['status'] ?? 'active',
                            'sort_order' => $priceData['sort_order'] ?? $index,
                        ]);

                        // Handle price items for this seasonal price
                        if (isset($priceData['price_items']) && is_array($priceData['price_items'])) {
                            foreach ($priceData['price_items'] as $itemIndex => $itemData) {
                                if (!empty($itemData['price_name'])) {
                                    TourSeasonalPriceItem::create([
                                        'seasonal_price_id' => $seasonalPrice->id,
                                        'price_name' => $itemData['price_name'],
                                        'price_value' => $itemData['price_value'] ?? 0,
                                        'description' => $itemData['description'] ?? null,
                                        'sort_order' => $itemData['sort_order'] ?? $itemIndex,
                                    ]);
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.tours.index')
                ->with('success', 'Tour created successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            // Delete uploaded cover image if exists
            if (isset($validated['cover_image'])) {
                Storage::disk('tours')->delete(basename($validated['cover_image']));
            }

            return back()->withInput()
                ->with('error', 'Failed to create tour: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $tour = Tour::with([
            'category',
            'subCategory',
            'country',
            'state',
            'tourDays' => function ($query) {
                $query->orderBy('day_number')->orderBy('sort_order');
            },
            'tourImages' => function ($query) {
                $query->orderBy('sort_order');
            },
            'variants' => function ($query) {
                $query->orderBy('sort_order');
            },
            'seasonalPrices.priceItems' => function ($query) {
                $query->orderBy('sort_order');
            },
            'seasonalPrices' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->findOrFail($id);
        return view('dashboard.tours.show', compact('tour'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $tour = Tour::with([
            'tourDays' => function ($query) {
                $query->orderBy('day_number')->orderBy('sort_order');
            },
            'tourImages' => function ($query) {
                $query->orderBy('sort_order');
            },
            'variants' => function ($query) {
                $query->orderBy('sort_order');
            },
            'seasonalPrices' => function ($query) {
                $query->orderBy('sort_order');
            }
        ])->findOrFail($id);

        $categories = Category::active()->orderBy('name')->get();
        $subCategories = SubCategory::where('category_id', $tour->category_id)->active()->orderBy('name')->get();
        $countries = Country::active()->orderBy('name')->get();
        $states = State::where('country_id', $tour->country_id)->active()->orderBy('name')->get();
        $availableVariants = TourVariant::active()->orderBy('sort_order')->get();

        return view('dashboard.tours.edit', compact('tour', 'categories', 'subCategories', 'countries', 'states', 'availableVariants'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $tour = Tour::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:sub_categories,id',
            'country_id' => 'required|exists:countries,id',
            'state_id' => 'nullable|exists:states,id',
            'title' => 'required|string|max:255|unique:tours,title,' . $id,
            'slug' => 'nullable|string|max:255|unique:tours,slug,' . $id . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'duration' => 'required|integer|min:1',
            'duration_type' => 'required|in:hours,days',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'show_on_homepage' => 'nullable|boolean',
            'price' => 'required|numeric|min:0',
            'has_offer' => 'nullable|boolean',
            'price_before_discount' => 'nullable|numeric|min:0|required_if:has_offer,1',
            'price_after_discount' => 'nullable|numeric|min:0|required_if:has_offer,1',
            'offer_start_date' => 'nullable|date|required_if:has_offer,1',
            'offer_end_date' => 'nullable|date|after_or_equal:offer_start_date|required_if:has_offer,1',
            'notes' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'tour_days' => 'nullable|array',
            'tour_days.*.day_number' => 'required|integer|min:1',
            'tour_days.*.day_title' => 'required|string|max:255',
            'tour_days.*.details' => 'nullable|string',
            'deleted_days' => 'nullable|array',
            'deleted_days.*' => 'exists:tour_days,id',
            'tour_images' => 'nullable|array',
            'tour_images.*.image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
            'tour_images.*.alt' => 'nullable|string|max:255',
            'tour_images.*.sort_order' => 'nullable|integer|min:0',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'exists:tour_images,id',
            'tour_variants' => 'nullable|array',
            'tour_variants.*.title' => 'required|string|max:255',
            'tour_variants.*.description' => 'nullable|string',
            'tour_variants.*.additional_duration' => 'nullable|integer|min:0',
            'tour_variants.*.additional_duration_type' => 'nullable|in:hours,days',
            'tour_variants.*.additional_price' => 'nullable|numeric|min:0',
            'tour_variants.*.status' => 'nullable|in:active,inactive',
            'tour_variants.*.sort_order' => 'nullable|integer|min:0',
            'deleted_variants' => 'nullable|array',
            'deleted_variants.*' => 'exists:tour_variants,id',
            'seasonal_prices' => 'nullable|array',
            'seasonal_prices.*.season_name' => 'required|string|max:255',
            'seasonal_prices.*.start_month' => 'required|integer|min:1|max:12',
            'seasonal_prices.*.end_month' => 'required|integer|min:1|max:12',
            'seasonal_prices.*.description' => 'nullable|string',
            'seasonal_prices.*.status' => 'nullable|in:active,inactive',
            'seasonal_prices.*.sort_order' => 'nullable|integer|min:0',
            'seasonal_prices.*.price_items' => 'nullable|array',
            'seasonal_prices.*.price_items.*.price_name' => 'required|string|max:255',
            'seasonal_prices.*.price_items.*.price_value' => 'required|numeric|min:0',
            'seasonal_prices.*.price_items.*.description' => 'nullable|string',
            'seasonal_prices.*.price_items.*.sort_order' => 'nullable|integer|min:0',
            'deleted_seasonal_prices' => 'nullable|array',
            'deleted_seasonal_prices.*' => 'exists:tour_seasonal_prices,id',
            'deleted_seasonal_price_items' => 'nullable|array',
            'deleted_seasonal_price_items.*' => 'exists:tour_seasonal_price_items,id',
        ]);

        // Handle cover image upload
        if ($request->hasFile('cover_image')) {
            if ($tour->cover_image) {
                Storage::disk('tours')->delete(basename($tour->cover_image));
            }
            $image = $request->file('cover_image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $validated['cover_image'] = $image->storeAs('', $imageName, 'tours');
        }

        // Generate slug if not provided
        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        }

        // Handle boolean fields
        $validated['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;
        $validated['has_offer'] = $request->has('has_offer') ? true : false;

        // Use database transaction
        DB::beginTransaction();
        try {
            // Update tour
            $tour->update($validated);

            // Handle deleted days
            if ($request->has('deleted_days') && is_array($request->deleted_days)) {
                TourDay::whereIn('id', $request->deleted_days)->delete();
            }

            // Handle tour days update/create
            if ($request->has('tour_days') && is_array($request->tour_days)) {
                $dayIndex = 0;
                foreach ($request->tour_days as $index => $dayData) {
                    if (!empty($dayData['day_title'])) {
                        $sortOrder = isset($dayData['sort_order']) && is_numeric($dayData['sort_order'])
                            ? (int) $dayData['sort_order']
                            : $dayIndex;
                        $dayNumber = isset($dayData['day_number']) && is_numeric($dayData['day_number'])
                            ? (int) $dayData['day_number']
                            : ($dayIndex + 1);
                        if (isset($dayData['id']) && $dayData['id']) {
                            // Update existing day
                            $day = TourDay::find($dayData['id']);
                            if ($day && $day->tour_id == $tour->id) {
                                $day->update([
                                    'day_number' => $dayNumber,
                                    'day_title' => $dayData['day_title'],
                                    'details' => $dayData['details'] ?? null,
                                    'sort_order' => $sortOrder,
                                ]);
                            }
                        } else {
                            // Create new day
                            TourDay::create([
                                'tour_id' => $tour->id,
                                'day_number' => $dayNumber,
                                'day_title' => $dayData['day_title'],
                                'details' => $dayData['details'] ?? null,
                                'sort_order' => $sortOrder,
                            ]);
                        }
                        $dayIndex++;
                    }
                }
            }

            // Handle deleted images
            if ($request->has('deleted_images') && is_array($request->deleted_images)) {
                $deletedImages = TourImage::whereIn('id', $request->deleted_images)->get();
                foreach ($deletedImages as $image) {
                    if ($image->image) {
                        Storage::disk('tours')->delete(basename($image->image));
                    }
                }
                TourImage::whereIn('id', $request->deleted_images)->delete();
            }

            // Handle existing images update
            if ($request->has('tour_images') && is_array($request->tour_images)) {
                foreach ($request->tour_images as $imageId => $imageData) {
                    if (is_numeric($imageId)) {
                        // Existing image
                        $image = TourImage::find($imageId);
                        if ($image && $image->tour_id == $tour->id) {
                            // Update sort order and alt
                            $image->update([
                                'alt' => $imageData['alt'] ?? $image->alt,
                                'sort_order' => $imageData['sort_order'] ?? $image->sort_order,
                            ]);

                            // Update image if new file uploaded
                            if ($request->hasFile("tour_images.{$imageId}.image")) {
                                $newImage = $request->file("tour_images.{$imageId}.image");
                                if ($newImage && $newImage->isValid()) {
                                    // Delete old image
                                    if ($image->image) {
                                        Storage::disk('tours')->delete(basename($image->image));
                                    }
                                    // Upload new image
                                    $imageName = time() . '_' . uniqid() . '_' . $imageId . '.' . $newImage->getClientOriginalExtension();
                                    $imagePath = $newImage->storeAs('', $imageName, 'tours');
                                    $image->update(['image' => $imagePath]);
                                }
                            }
                        }
                    }
                }
            }

            // Handle new tour images
            if ($request->has('tour_images') && is_array($request->tour_images)) {
                foreach ($request->tour_images as $index => $imageData) {
                    // Check if it's a new image (starts with 'new-')
                    if (is_string($index) && strpos($index, 'new-') === 0) {
                        if ($request->hasFile("tour_images.{$index}.image")) {
                            $imageFile = $request->file("tour_images.{$index}.image");
                            if ($imageFile && $imageFile->isValid()) {
                                $imageName = time() . '_' . uniqid() . '_' . $index . '.' . $imageFile->getClientOriginalExtension();
                                $imagePath = $imageFile->storeAs('', $imageName, 'tours');

                                TourImage::create([
                                    'tour_id' => $tour->id,
                                    'image' => $imagePath,
                                    'alt' => $imageData['alt'] ?? null,
                                    'sort_order' => $imageData['sort_order'] ?? 0,
                                ]);
                            }
                        }
                    }
                }
            }

            // Handle tour variants (from available variants checkboxes)
            if ($request->has('selected_variants') && is_array($request->selected_variants)) {
                $tour->variants()->sync($request->selected_variants);
            } else {
                // If no variants selected, detach all
                $tour->variants()->detach();
            }

            // Handle deleted seasonal price items
            if ($request->has('deleted_seasonal_price_items') && is_array($request->deleted_seasonal_price_items)) {
                TourSeasonalPriceItem::whereIn('id', $request->deleted_seasonal_price_items)->delete();
            }

            // Handle deleted seasonal prices
            if ($request->has('deleted_seasonal_prices') && is_array($request->deleted_seasonal_prices)) {
                TourSeasonalPrice::whereIn('id', $request->deleted_seasonal_prices)->delete();
            }

            // Handle seasonal prices (update existing and create new)
            if ($request->has('seasonal_prices') && is_array($request->seasonal_prices)) {
                foreach ($request->seasonal_prices as $index => $priceData) {
                    if (!empty($priceData['season_name'])) {
                        $seasonalPrice = null;
                        // Check if it's an existing price (has id) or new one (starts with 'new-')
                        if (isset($priceData['id']) && is_numeric($priceData['id'])) {
                            // Update existing seasonal price
                            $seasonalPrice = TourSeasonalPrice::where('id', $priceData['id'])
                                ->where('tour_id', $tour->id)
                                ->first();
                            if ($seasonalPrice) {
                                $seasonalPrice->update([
                                    'season_name' => $priceData['season_name'],
                                    'start_month' => $priceData['start_month'],
                                    'end_month' => $priceData['end_month'],
                                    'description' => $priceData['description'] ?? null,
                                    'status' => $priceData['status'] ?? 'active',
                                    'sort_order' => $priceData['sort_order'] ?? $index,
                                ]);
                            }
                        } elseif (is_string($index) && strpos($index, 'new-') === 0) {
                            // Create new seasonal price
                            $seasonalPrice = TourSeasonalPrice::create([
                                'tour_id' => $tour->id,
                                'season_name' => $priceData['season_name'],
                                'start_month' => $priceData['start_month'],
                                'end_month' => $priceData['end_month'],
                                'description' => $priceData['description'] ?? null,
                                'status' => $priceData['status'] ?? 'active',
                                'sort_order' => $priceData['sort_order'] ?? $index,
                            ]);
                        }

                        // Handle price items for this seasonal price
                        if ($seasonalPrice && isset($priceData['price_items']) && is_array($priceData['price_items'])) {
                            foreach ($priceData['price_items'] as $itemIndex => $itemData) {
                                if (!empty($itemData['price_name'])) {
                                    // Check if it's an existing item (has id) or new one
                                    if (isset($itemData['id']) && is_numeric($itemData['id'])) {
                                        // Update existing price item
                                        TourSeasonalPriceItem::where('id', $itemData['id'])
                                            ->where('seasonal_price_id', $seasonalPrice->id)
                                            ->update([
                                                'price_name' => $itemData['price_name'],
                                                'price_value' => $itemData['price_value'] ?? 0,
                                                'description' => $itemData['description'] ?? null,
                                                'sort_order' => $itemData['sort_order'] ?? $itemIndex,
                                            ]);
                                    } elseif (is_string($itemIndex) && strpos($itemIndex, 'new-') === 0) {
                                        // Create new price item
                                        TourSeasonalPriceItem::create([
                                            'seasonal_price_id' => $seasonalPrice->id,
                                            'price_name' => $itemData['price_name'],
                                            'price_value' => $itemData['price_value'] ?? 0,
                                            'description' => $itemData['description'] ?? null,
                                            'sort_order' => $itemData['sort_order'] ?? $itemIndex,
                                        ]);
                                    }
                                }
                            }
                        }
                    }
                }
            }

            DB::commit();

            return redirect()->route('admin.tours.index')
                ->with('success', 'Tour updated successfully');
        } catch (ValidationException $e) {
            DB::rollBack();
            return back()->withInput()->withErrors($e->errors());
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Tour update failed: ' . $e->getMessage(), [
                'tour_id' => $id,
                'exception' => $e->getTraceAsString()
            ]);
            return back()->withInput()
                ->with('error', 'Failed to update tour: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $tour = Tour::with('tourImages')->findOrFail($id);

        if ($tour->cover_image) {
            Storage::disk('tours')->delete(basename($tour->cover_image));
        }

        // Delete tour images
        foreach ($tour->tourImages as $image) {
            if ($image->image) {
                Storage::disk('tours')->delete(basename($image->image));
            }
        }

        $tour->delete();

        return redirect()->route('admin.tours.index')
            ->with('success', 'Tour deleted successfully');
    }

    /**
     * Get states by country (AJAX)
     */
    public function getStatesByCountry(Request $request)
    {
        $countryId = $request->get('country_id') ?? $request->input('country_id');

        if (!$countryId) {
            return response()->json([]);
        }

        $states = State::where('country_id', $countryId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($states);
    }

    /**
     * Get subcategories by category (AJAX)
     */
    public function getSubCategoriesByCategory(Request $request)
    {
        $categoryId = $request->get('category_id') ?? $request->input('category_id');

        if (!$categoryId) {
            return response()->json([]);
        }

        $subCategories = SubCategory::where('category_id', $categoryId)
            ->active()
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subCategories);
    }
}
