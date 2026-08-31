<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['createdBy', 'updatedBy'])
            ->latest()
            ->get();

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Category name is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);

        $categoryImage = null;

        if ($request->hasFile('cat_image')) {
            $categoryImage = $request->file('cat_image')
                ->store('categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = Category::where('slug', $slug)->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        Category::create([
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $category->load(['createdBy', 'updatedBy']);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Category name is required.',
            'status.required' => 'Status is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);

        $categoryImage = $category->cat_image;

        if ($request->hasFile('cat_image')) {
            if ($categoryImage && Storage::disk('public')->exists($categoryImage)) {
                Storage::disk('public')->delete($categoryImage);
            }

            $categoryImage = $request->file('cat_image')
                ->store('categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = Category::where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        $category->update([
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deactivated successfully.');
    }
}