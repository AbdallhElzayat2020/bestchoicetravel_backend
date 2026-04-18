<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\CruiseCatalogCategory;
use App\Models\CruiseCatalogProgram;
use App\Models\CruiseCatalogProgramDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CruiseCatalogProgramController extends Controller
{
    public function index(Request $request)
    {
        $query = CruiseCatalogProgram::with('category')->orderBy('sort_order')->latest();

        if ($request->filled('cruise_catalog_category_id')) {
            $query->where('cruise_catalog_category_id', $request->cruise_catalog_category_id);
        }

        $programs = $query->paginate(20)->withQueryString();
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('dashboard.cruise-catalog.programs.index', compact('programs', 'categories'));
    }

    public function create()
    {
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('dashboard.cruise-catalog.programs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'cruise_catalog_category_id' => 'required|exists:cruise_catalog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_programs,slug',
            'short_description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'days' => 'required|array|min:1',
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.day_title' => 'required|string|max:255',
            'days.*.day_status' => 'required|in:draft,active,inactive',
            'days.*.details' => 'nullable|string',
        ]);

        if (empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['title']);
        } else {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $days = $validated['days'];
        unset($validated['days']);

        DB::transaction(function () use ($validated, $days) {
            $program = CruiseCatalogProgram::create($validated);
            foreach ($days as $i => $row) {
                CruiseCatalogProgramDay::create([
                    'cruise_catalog_program_id' => $program->id,
                    'day_number' => (int) $row['day_number'],
                    'day_title' => $row['day_title'],
                    'day_status' => $row['day_status'],
                    'details' => $row['details'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        });

        return redirect()->route('admin.cruise-catalog.programs.index')
            ->with('success', 'Cruise program created.');
    }

    public function edit(CruiseCatalogProgram $program)
    {
        $program->load('days');
        $categories = CruiseCatalogCategory::orderBy('sort_order')->orderBy('name')->get();

        return view('dashboard.cruise-catalog.programs.edit', compact('program', 'categories'));
    }

    public function update(Request $request, CruiseCatalogProgram $program)
    {
        $validated = $request->validate([
            'cruise_catalog_category_id' => 'required|exists:cruise_catalog_categories,id',
            'title' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:cruise_catalog_programs,slug,'.$program->id,
            'short_description' => 'nullable|string',
            'duration_days' => 'required|integer|min:1|max:365',
            'status' => 'required|in:active,inactive',
            'sort_order' => 'nullable|integer|min:0',
            'days' => 'required|array|min:1',
            'days.*.day_number' => 'required|integer|min:1',
            'days.*.day_title' => 'required|string|max:255',
            'days.*.day_status' => 'required|in:draft,active,inactive',
            'days.*.details' => 'nullable|string',
        ]);

        if (! empty($validated['slug'])) {
            $validated['slug'] = Str::slug($validated['slug']);
        }

        $days = $validated['days'];
        unset($validated['days']);

        DB::transaction(function () use ($program, $validated, $days) {
            $program->update($validated);
            $program->days()->delete();
            foreach ($days as $i => $row) {
                CruiseCatalogProgramDay::create([
                    'cruise_catalog_program_id' => $program->id,
                    'day_number' => (int) $row['day_number'],
                    'day_title' => $row['day_title'],
                    'day_status' => $row['day_status'],
                    'details' => $row['details'] ?? null,
                    'sort_order' => $i,
                ]);
            }
        });

        return redirect()->route('admin.cruise-catalog.programs.index')
            ->with('success', 'Cruise program updated.');
    }

    public function destroy(CruiseCatalogProgram $program)
    {
        $program->delete();

        return redirect()->route('admin.cruise-catalog.programs.index')
            ->with('success', 'Cruise program deleted.');
    }
}
