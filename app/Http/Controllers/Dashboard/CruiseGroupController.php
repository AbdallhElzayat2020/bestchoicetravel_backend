<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Str;

class CruiseGroupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $groups = CruiseGroup::withCount('cruiseExperiences')
            ->orderBy('sort_order')
            ->latest()
            ->paginate(15);

        return view('dashboard.cruise-groups.index', compact('groups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.cruise-groups.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_groups,slug',
            'group_key' => 'nullable|string|max:255|unique:cruise_groups,group_key',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Auto-generate group_key from slug if not provided
        if (empty($validated['group_key'])) {
            $validated['group_key'] = Str::slug($validated['slug']);
        }

        CruiseGroup::create($validated);

        Cache::forget('settings_all'); // Clear settings cache
        Cache::forget('static_pages'); // Clear static pages cache
        Cache::forget('cruise_groups_sidebar'); // Clear cruise groups cache
        Cache::forget('cruise_groups_frontend'); // Clear frontend cruise groups cache

        // Clear route cache to regenerate routes with new group
        Artisan::call('route:clear');
        Artisan::call('route:cache');

        return redirect()->route('admin.cruise-groups.index')
            ->with('success', 'Cruise group created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = CruiseGroup::with('cruiseExperiences')->findOrFail($id);
        return view('dashboard.cruise-groups.show', compact('group'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $group = CruiseGroup::findOrFail($id);
        return view('dashboard.cruise-groups.edit', compact('group'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $group = CruiseGroup::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_groups,slug,' . $id,
            'group_key' => 'nullable|string|max:255|unique:cruise_groups,group_key,' . $id,
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|in:active,inactive',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        }

        // Auto-generate group_key from slug if not provided
        if (empty($validated['group_key'])) {
            $validated['group_key'] = Str::slug($validated['slug']);
        }

        $group->update($validated);

        // Update group_key in related cruise experiences
        if ($group->wasChanged('group_key')) {
            $group->cruiseExperiences()->update(['group_key' => $validated['group_key']]);
        }

        Cache::forget('settings_all'); // Clear settings cache
        Cache::forget('static_pages'); // Clear static pages cache
        Cache::forget('cruise_groups_sidebar'); // Clear cruise groups cache
        Cache::forget('cruise_groups_frontend'); // Clear frontend cruise groups cache

        return redirect()->route('admin.cruise-groups.index')
            ->with('success', 'Cruise group updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = CruiseGroup::findOrFail($id);

        // Check if group has cruise experiences
        if ($group->cruiseExperiences()->count() > 0) {
            return redirect()->route('admin.cruise-groups.index')
                ->with('error', 'Cannot delete cruise group with existing cruise experiences.');
        }

        $group->delete();

        Cache::forget('settings_all'); // Clear settings cache
        Cache::forget('static_pages'); // Clear static pages cache
        Cache::forget('cruise_groups_sidebar'); // Clear cruise groups cache
        Cache::forget('cruise_groups_frontend'); // Clear frontend cruise groups cache

        return redirect()->route('admin.cruise-groups.index')
            ->with('success', 'Cruise group deleted successfully.');
    }
}
