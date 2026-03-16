<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BlogCategoryController extends Controller
{
    public function index()
    {
        $categories = BlogCategory::orderBy('sort_order')
            ->orderBy('name')
            ->paginate(15);

        return view('dashboard.blog-categories.index', compact('categories'));
    }

    public function create()
    {
        return view('dashboard.blog-categories.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:blog_categories,name',
                'slug' => 'nullable|string|max:255|unique:blog_categories,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            BlogCategory::create($validated);

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Blog category created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating blog category: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while creating the blog category. Please try again.')
                ->withInput();
        }
    }

    public function edit(string $id)
    {
        $category = BlogCategory::findOrFail($id);

        return view('dashboard.blog-categories.edit', compact('category'));
    }

    public function update(Request $request, string $id)
    {
        try {
            $category = BlogCategory::findOrFail($id);

            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:blog_categories,name,' . $id,
                'slug' => 'nullable|string|max:255|unique:blog_categories,slug,' . $id . '|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'status' => 'required|in:active,inactive',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            $category->update($validated);

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Blog category updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating blog category: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while updating the blog category. Please try again.')
                ->withInput();
        }
    }

    public function destroy(string $id)
    {
        try {
            $category = BlogCategory::findOrFail($id);
            $category->delete();

            return redirect()->route('admin.blog-categories.index')
                ->with('success', 'Blog category deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting blog category: ' . $e->getMessage());

            return redirect()->back()
                ->with('error', 'An error occurred while deleting the blog category. Please try again.');
        }
    }
}

