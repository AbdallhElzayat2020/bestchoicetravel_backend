<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\SiteSection;
use Illuminate\Http\Request;

class SiteSectionController extends Controller
{
    public function index()
    {
        $sections = SiteSection::orderBy('sort_order')->orderBy('key')->get();

        return view('dashboard.site-sections.index', compact('sections'));
    }

    public function edit(SiteSection $siteSection)
    {
        return view('dashboard.site-sections.edit', compact('siteSection'));
    }

    public function update(Request $request, SiteSection $siteSection)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('uploads/sections'), $fileName);
            $data['image_path'] = 'uploads/sections/' . $fileName;
        }

        $siteSection->update($data);

        return redirect()->route('admin.site-sections.index')
            ->with('success', 'Section updated successfully.');
    }
}

