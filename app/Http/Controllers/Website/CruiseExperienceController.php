<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CruiseExperience;

class CruiseExperienceController extends Controller
{
    /**
     * Show all cruise experiences for a group in grid layout.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        // Get slug from route (the first segment after /)
        $slug = $request->segment(1);

        // Get the cruise group by slug
        $cruiseGroup = \App\Models\CruiseGroup::where('slug', $slug)
            ->where('status', 'active')
            ->firstOrFail();

        // Get all active cruise experiences for this group with pagination
        $experiences = CruiseExperience::active()
            ->where('cruise_group_id', $cruiseGroup->id)
            ->with(['cruiseGroup'])
            ->orderBy('sort_order')
            ->latest()
            ->paginate(12);

        return view('frontend.pages.nile-cruises.index', compact('experiences', 'cruiseGroup'));
    }

    /**
     * Show a single cruise experience page.
     */
    public function show(\Illuminate\Http\Request $request, string $slug)
    {
        // Get group slug from route (the first segment after /)
        $groupSlug = $request->segment(1);

        // Get the cruise group by slug
        $cruiseGroup = \App\Models\CruiseGroup::where('slug', $groupSlug)
            ->where('status', 'active')
            ->firstOrFail();

        $experience = CruiseExperience::active()
            ->where('cruise_group_id', $cruiseGroup->id)
            ->with(['cruiseGroup', 'faqs'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Get only the selected related tours
        $relatedTours = $experience->tours()
            ->active()
            ->with(['category', 'country', 'state'])
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('frontend.pages.nile-cruises.show', compact('experience', 'relatedTours', 'cruiseGroup'));
    }
}
