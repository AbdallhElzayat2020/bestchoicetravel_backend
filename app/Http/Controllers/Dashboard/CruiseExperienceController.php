<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseExperience;
use App\Models\CruiseExperienceFaq;
use App\Models\CruiseGroup;
use App\Models\Faq;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CruiseExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Support both cruise_group_id and group_key for backward compatibility
        $cruiseGroupId = $request->get('cruise_group_id');
        $groupKey = $request->get('group_key');

        $query = CruiseExperience::with('tours', 'cruiseGroup');

        if ($cruiseGroupId) {
            $query->where('cruise_group_id', $cruiseGroupId);
            $cruiseGroup = \App\Models\CruiseGroup::find($cruiseGroupId);
            $groupKey = $cruiseGroup ? $cruiseGroup->group_key : null;
        } elseif ($groupKey) {
            $query->byGroup($groupKey);
            // Get cruise_group_id from group_key
            $cruiseGroup = \App\Models\CruiseGroup::where('group_key', $groupKey)->first();
            $cruiseGroupId = $cruiseGroup ? $cruiseGroup->id : null;
        } else {
            // Default to first active group
            $firstGroup = \App\Models\CruiseGroup::active()->orderBy('sort_order')->first();
            if ($firstGroup) {
                $query->where('cruise_group_id', $firstGroup->id);
                $groupKey = $firstGroup->group_key;
                $cruiseGroupId = $firstGroup->id;
            } else {
                $query->byGroup('dahabiya');
                $groupKey = 'dahabiya';
                $cruiseGroupId = null;
            }
        }

        $experiences = $query->orderBy('sort_order')
            ->latest()
            ->paginate(15)
            ->appends($request->query());

        return view('dashboard.cruise-experiences.index', compact('experiences', 'groupKey', 'cruiseGroupId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $cruiseGroups = CruiseGroup::active()->orderBy('sort_order')->get();
        $tours = Tour::active()
            ->orderBy('title')
            ->get();

        $faqs = Faq::active()->orderBy('sort_order')->orderBy('created_at', 'desc')->get();

        return view('dashboard.cruise-experiences.create', compact('tours', 'cruiseGroups', 'faqs'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'cruise_group_id' => 'required|exists:cruise_groups,id',
                'title' => 'required|string|max:255|unique:cruise_experiences,title',
                'slug' => 'nullable|string|max:255|unique:cruise_experiences,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'short_description' => 'nullable|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
                'tour_ids' => 'nullable|array',
                'tour_ids.*' => 'exists:tours,id',
                'faq_ids' => 'nullable|array',
                'faq_ids.*' => 'exists:faqs,id',
            ]);

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            } else {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            // Get group_key from cruise_group
            $cruiseGroup = CruiseGroup::findOrFail($validated['cruise_group_id']);
            $validated['group_key'] = $cruiseGroup->group_key;

            $experience = CruiseExperience::create($validated);

            // Handle banner image upload
            if ($request->hasFile('banner_image')) {
                $banner = $request->file('banner_image');
                $bannerName = time().'_'.uniqid().'_banner.'.$banner->getClientOriginalExtension();
                $path = $banner->storeAs('', $bannerName, 'cruise_experiences');
                $experience->update(['banner_image' => $path]);
            }

            // Sync related tours
            if ($request->filled('tour_ids')) {
                $experience->tours()->sync($request->tour_ids);
            }

            // Attach selected global FAQs (optional)
            if ($request->filled('faq_ids')) {
                $faqIds = $request->faq_ids;
                $faqs = Faq::whereIn('id', $faqIds)->get()->keyBy('id');

                foreach ($faqIds as $index => $faqId) {
                    $faq = $faqs->get($faqId);
                    if (! $faq) {
                        continue;
                    }

                    CruiseExperienceFaq::create([
                        'cruise_experience_id' => $experience->id,
                        'faq_id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'status' => 'active',
                        'sort_order' => $index,
                    ]);
                }
            }

            return redirect()->route('admin.cruise-experiences.index')
                ->with('success', 'Cruise experience created successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating cruise experience: '.$e->getMessage());

            return back()
                ->with('error', 'An error occurred while creating the cruise experience. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $experience = CruiseExperience::with('tours')->findOrFail($id);

        return view('dashboard.cruise-experiences.show', compact('experience'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, string $id)
    {
        $experience = CruiseExperience::with('tours', 'cruiseGroup', 'faqs')->findOrFail($id);
        $cruiseGroups = CruiseGroup::active()->orderBy('sort_order')->get();
        $tours = Tour::active()->orderBy('title')->get();
        $selectedTourIds = $experience->tours->pluck('id')->toArray();
        $faqs = Faq::active()->orderBy('sort_order')->orderBy('created_at', 'desc')->get();
        $selectedFaqIds = $experience->faqs->pluck('faq_id')->filter()->toArray();

        return view('dashboard.cruise-experiences.edit', compact('experience', 'tours', 'selectedTourIds', 'cruiseGroups', 'faqs', 'selectedFaqIds'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $experience = CruiseExperience::findOrFail($id);

            $validated = $request->validate([
                'cruise_group_id' => 'required|exists:cruise_groups,id',
                'title' => 'required|string|max:255|unique:cruise_experiences,title,'.$id,
                'slug' => 'nullable|string|max:255|unique:cruise_experiences,slug,'.$id.'|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'short_description' => 'nullable|string',
                'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'description' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
                'tour_ids' => 'nullable|array',
                'tour_ids.*' => 'exists:tours,id',
                'faq_ids' => 'nullable|array',
                'faq_ids.*' => 'exists:faqs,id',
            ]);

            // Generate slug if provided, otherwise keep existing
            if (! empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['slug']);
            }

            // Get group_key from cruise_group
            $cruiseGroup = CruiseGroup::findOrFail($validated['cruise_group_id']);
            $validated['group_key'] = $cruiseGroup->group_key;

            $experience->update($validated);

            // Handle banner image upload / replacement
            if ($request->hasFile('banner_image')) {
                // Delete old banner if exists
                if ($experience->banner_image) {
                    Storage::disk('cruise_experiences')->delete($experience->banner_image);
                }

                $banner = $request->file('banner_image');
                $bannerName = time().'_'.uniqid().'_banner.'.$banner->getClientOriginalExtension();
                $path = $banner->storeAs('', $bannerName, 'cruise_experiences');
                $experience->update(['banner_image' => $path]);
            }

            // Sync related tours
            if ($request->filled('tour_ids')) {
                $experience->tours()->sync($request->tour_ids);
            } else {
                $experience->tours()->detach();
            }

            // Replace related FAQs with selected global ones
            $experience->faqs()->delete();
            if ($request->filled('faq_ids')) {
                $faqIds = $request->faq_ids;
                $faqs = Faq::whereIn('id', $faqIds)->get()->keyBy('id');

                foreach ($faqIds as $index => $faqId) {
                    $faq = $faqs->get($faqId);
                    if (! $faq) {
                        continue;
                    }

                    CruiseExperienceFaq::create([
                        'cruise_experience_id' => $experience->id,
                        'faq_id' => $faq->id,
                        'question' => $faq->question,
                        'answer' => $faq->answer,
                        'status' => 'active',
                        'sort_order' => $index,
                    ]);
                }
            }

            return redirect()->route('admin.cruise-experiences.index')
                ->with('success', 'Cruise experience updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating cruise experience: '.$e->getMessage());

            return back()
                ->with('error', 'An error occurred while updating the cruise experience. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $experience = CruiseExperience::with('images')->findOrFail($id);

            // Delete images from disk
            foreach ($experience->images as $image) {
                if ($image->image) {
                    Storage::disk('cruise_experiences')->delete($image->image);
                }
            }

            $experience->delete();

            return redirect()->route('admin.cruise-experiences.index')
                ->with('success', 'Cruise experience deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting cruise experience: '.$e->getMessage());

            return back()
                ->with('error', 'An error occurred while deleting the cruise experience. Please try again.');
        }
    }
}
