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

    public function about()
    {
        $sections = SiteSection::where('key', 'like', 'about_%')
            ->orderBy('sort_order')
            ->orderBy('key')
            ->get();

        return view('dashboard.site-sections.index', [
            'sections' => $sections,
            'scope' => 'about',
        ]);
    }

    public function edit(SiteSection $siteSection)
    {
        return view('dashboard.site-sections.edit', compact('siteSection'));
    }

    public function update(Request $request, SiteSection $siteSection)
    {
        $rules = [
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'content' => ['nullable', 'string'],
            'button_text' => ['nullable', 'string', 'max:255'],
            'button_link' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,gif', 'max:5120'],
        ];

        if ($siteSection->key === 'home_hero') {
            $rules['vimeo_url'] = ['nullable', 'string', 'max:500'];
        }

        $data = $request->validate($rules);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('uploads/sections'), $fileName);
            $data['image_path'] = 'uploads/sections/'.$fileName;
        }

        // About credentials list (label + value)
        if ($siteSection->key === 'about_credentials') {
            $credentials = $request->input('credentials', []);
            if (is_array($credentials)) {
                $credentials = array_values(array_filter($credentials, function ($item) {
                    return ! empty($item['label']) || ! empty($item['value']);
                }));
                $data['content'] = $credentials ? json_encode($credentials) : null;
            }
        }

        // About repeated items (services / why choose)
        if (in_array($siteSection->key, ['about_services', 'about_why_choose'])) {
            $items = $request->input('items', []);
            if (is_array($items)) {
                $items = array_values(array_filter($items, function ($item) {
                    return ! empty($item['title']) || ! empty($item['text']);
                }));
                $data['content'] = $items ? json_encode($items) : null;
            }
        }

        $siteSection->update($data);

        return redirect()->route('admin.site-sections.index')
            ->with('success', 'Section updated successfully.');
    }
}
