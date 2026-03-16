<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::orderBy('sort_order')
            ->latest()
            ->paginate(15);
        return view('dashboard.blogs.index', compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $blogCategories = BlogCategory::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('dashboard.blogs.create', compact('blogCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:blogs,title',
                'slug' => 'nullable|string|max:255|unique:blogs,slug|regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/',
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'author' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive',
                'show_on_homepage' => 'nullable|boolean',
                'published_at' => 'nullable|date',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $validated['cover_image'] = $image->storeAs('', $imageName, 'blogs');
            }

            // Generate slug if not provided
            if (empty($validated['slug'])) {
                $validated['slug'] = Str::slug($validated['title']);
            } else {
                // Ensure slug is properly formatted
                $validated['slug'] = Str::slug($validated['slug']);
            }

            // Handle boolean fields
            $validated['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

            // Create blog
            Blog::create($validated);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog created successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error creating blog: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while creating the blog. Please try again.')
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $blog = Blog::findOrFail($id);
        return view('dashboard.blogs.show', compact('blog'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $blog = Blog::findOrFail($id);
        $blogCategories = BlogCategory::orderBy('sort_order')
            ->orderBy('name')
            ->get();

        return view('dashboard.blogs.edit', compact('blog', 'blogCategories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            $validated = $request->validate([
                'title' => 'required|string|max:255|unique:blogs,title,' . $id,
                'short_description' => 'nullable|string',
                'description' => 'nullable|string',
                'category' => 'nullable|string|max:255',
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string',
                'meta_keywords' => 'nullable|string',
                'cover_image' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
                'author' => 'nullable|string|max:255',
                'status' => 'required|in:active,inactive',
                'show_on_homepage' => 'nullable|boolean',
                'published_at' => 'nullable|date',
                'sort_order' => 'nullable|integer|min:0',
            ]);

            // Handle cover image upload
            if ($request->hasFile('cover_image')) {
                // Delete old image if exists
                if ($blog->cover_image) {
                    Storage::disk('blogs')->delete($blog->cover_image);
                }

                $image = $request->file('cover_image');
                $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
                $validated['cover_image'] = $image->storeAs('', $imageName, 'blogs');
            } else {
                // Keep existing image if no new image uploaded
                $validated['cover_image'] = $blog->cover_image;
            }

            // Generate slug if title changed
            if ($blog->isDirty('title')) {
                $validated['slug'] = Str::slug($validated['title']);
            }

            // Handle boolean fields
            $validated['show_on_homepage'] = $request->has('show_on_homepage') ? true : false;

            // Update blog
            $blog->update($validated);

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog updated successfully.');
        } catch (ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput();
        } catch (\Exception $e) {
            Log::error('Error updating blog: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while updating the blog. Please try again.')
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $blog = Blog::findOrFail($id);

            // Delete cover image if exists
            if ($blog->cover_image) {
                Storage::disk('blogs')->delete($blog->cover_image);
            }

            $blog->delete();

            return redirect()->route('admin.blogs.index')
                ->with('success', 'Blog deleted successfully.');
        } catch (\Exception $e) {
            Log::error('Error deleting blog: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'An error occurred while deleting the blog. Please try again.');
        }
    }
}
