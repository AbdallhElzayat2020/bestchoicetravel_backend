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

        // Special handling for about_why: build JSON content from cards[]
        if ($siteSection->key === 'about_why') {
            $cards = $request->input('cards', []);
            if (is_array($cards)) {
                $cards = array_values(array_filter($cards, function ($card) {
                    return ! empty($card['title']) || ! empty($card['text']);
                }));
                $data['content'] = $cards ? json_encode($cards) : null;
            }
        }

        $siteSection->update($data);

        return redirect()->route('admin.site-sections.index')
            ->with('success', 'Section updated successfully.');
    }
}
