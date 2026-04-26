<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pages = Page::orderBy('sort_order')->orderBy('name')->get();
        return view('dashboard.pages.index', compact('pages'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Page $page)
    {
        return view('dashboard.pages.edit', compact('page'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Page $page)
    {
        // Check if this is a content-editable page
        $editablePages = ['terms-and-conditions', 'privacy-policy', 'payment-policy'];
        $isEditable = in_array($page->slug, $editablePages);

        if ($isEditable) {
            // Allow content and SEO fields to be updated
            $validated = $request->validate([
                'content' => 'nullable|string',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_author' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string|max:500',
            ]);
        } else {
            // For static pages, only allow SEO fields to be updated
            $validated = $request->validate([
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_author' => 'nullable|string|max:255',
                'meta_keywords' => 'nullable|string|max:500',
            ]);
        }

        $page->update($validated);

        $message = $isEditable ? 'Page updated successfully' : 'Page SEO updated successfully';
        return redirect()->route('admin.pages.index')
            ->with('success', $message);
    }
}
