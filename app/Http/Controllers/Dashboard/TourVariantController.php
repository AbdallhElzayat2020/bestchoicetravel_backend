<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\TourVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class TourVariantController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $variants = TourVariant::orderBy('sort_order')
            ->latest()
            ->paginate(15);
        return view('dashboard.tour-variants.index', compact('variants'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.tour-variants.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'additional_duration' => 'nullable|integer|min:0',
                'additional_duration_type' => 'nullable|in:hours,days',
                'additional_price' => 'nullable|numeric|min:0',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $validated['image'] = $image->storeAs('', $imageName, 'tour_variants');
            }

            // Set defaults
            $validated['additional_duration'] = $validated['additional_duration'] ?? 0;
            $validated['additional_duration_type'] = $validated['additional_duration_type'] ?? 'days';
            $validated['additional_price'] = $validated['additional_price'] ?? 0;
            $validated['sort_order'] = $validated['sort_order'] ?? 0;

            // Create variant
            TourVariant::create($validated);

            return redirect()->route('admin.tour-variants.index')
                ->with('success', 'Tour variant created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating tour variant: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while creating the tour variant. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $variant = TourVariant::findOrFail($id);
        return view('dashboard.tour-variants.show', compact('variant'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $variant = TourVariant::findOrFail($id);
        return view('dashboard.tour-variants.edit', compact('variant'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $variant = TourVariant::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'additional_duration' => 'nullable|integer|min:0',
                'additional_duration_type' => 'nullable|in:hours,days',
                'additional_price' => 'nullable|numeric|min:0',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle image upload
            if ($request->hasFile('image')) {
                // Delete old image if exists
                if ($variant->image) {
                    Storage::disk('tour_variants')->delete($variant->image);
                }

                $image = $request->file('image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $validated['image'] = $image->storeAs('', $imageName, 'tour_variants');
            } else {
                // Keep existing image if no new image uploaded
                $validated['image'] = $variant->image;
            }

            // Set defaults
            $validated['additional_duration'] = $validated['additional_duration'] ?? 0;
            $validated['additional_duration_type'] = $validated['additional_duration_type'] ?? 'days';
            $validated['additional_price'] = $validated['additional_price'] ?? 0;
            $validated['sort_order'] = $validated['sort_order'] ?? 0;

            // Update variant
            $variant->update($validated);

            return redirect()->route('admin.tour-variants.index')
                ->with('success', 'Tour variant updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating tour variant: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating the tour variant. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $variant = TourVariant::findOrFail($id);

            // Delete image if exists
            if ($variant->image) {
                Storage::disk('tour_variants')->delete($variant->image);
            }

            $variant->delete();

            return redirect()->route('admin.tour-variants.index')
                ->with('success', 'Tour variant deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting tour variant: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the tour variant. Please try again.');
        }
    }
}
