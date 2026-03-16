<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::with('states')->orderBy('sort_order')->paginate(15);
        return view('dashboard.countries.index', compact('countries'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.countries.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name',
            'slug' => 'nullable|string|max:255|unique:countries,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'code' => 'nullable|string|max:3|unique:countries,code',
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('flag')) {
            $flag = $request->file('flag');
            $flagName = time() . '_' . uniqid() . '.' . $flag->getClientOriginalExtension();
            $validated['flag'] = $flag->storeAs('', $flagName, 'countries');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            // Ensure slug is properly formatted
            $validated['slug'] = Str::slug($validated['slug']);
        }

        Country::create($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $country = Country::with('states')->findOrFail($id);
        return view('dashboard.countries.show', compact('country'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $country = Country::findOrFail($id);
        return view('dashboard.countries.edit', compact('country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $country = Country::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:countries,name,' . $id,
            'slug' => 'nullable|string|max:255|unique:countries,slug,' . $id . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
            'code' => 'nullable|string|max:3|unique:countries,code,' . $id,
            'flag' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('flag')) {
            if ($country->flag) {
                Storage::disk('countries')->delete(basename($country->flag));
            }
            $flag = $request->file('flag');
            $flagName = time() . '_' . uniqid() . '.' . $flag->getClientOriginalExtension();
            $validated['flag'] = $flag->storeAs('', $flagName, 'countries');
        }

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['name']);
        } else {
            // Ensure slug is properly formatted
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $country->update($validated);

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::findOrFail($id);

        if ($country->flag) {
            Storage::disk('countries')->delete(basename($country->flag));
        }

        $country->delete();

        return redirect()->route('admin.countries.index')
            ->with('success', 'Country deleted successfully');
    }
}
