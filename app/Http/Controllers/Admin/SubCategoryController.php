<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with('category')
            ->latest()
            ->get();

        return view('admin.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $categories = Category::where('status', 1)
            ->latest()
            ->get();

        return view('admin.sub_categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $categoryImage = null;

        if ($request->hasFile('sub_cat_image')) {
            $categoryImage = $request->file('sub_cat_image')
                ->store('sub_categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = SubCategory::where('category_id', $request->category_id)
            ->where('slug', $slug)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        SubCategory::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sub_cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('sub-categories.index')
            ->with('success', 'Sub category created successfully.');
    }

    public function show(SubCategory $subCategory)
    {
        $subCategory->load('category', 'createdBy', 'updatedBy');

        return view('admin.sub_categories.show', compact('subCategory'));
    }

    public function edit(SubCategory $subCategory)
    {
        $categories = Category::where('status', 1)
            ->orWhere('id', $subCategory->category_id)
            ->latest()
            ->get();

        return view(
            'admin.sub_categories.edit',
            compact('subCategory', 'categories')
        );
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'status.required' => 'Status is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $categoryImage = $subCategory->sub_cat_image;

        if ($request->hasFile('sub_cat_image')) {
            if ($categoryImage && Storage::disk('public')->exists($categoryImage)) {
                Storage::disk('public')->delete($categoryImage);
            }

            $categoryImage = $request->file('sub_cat_image')
                ->store('sub_categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = SubCategory::where('category_id', $request->category_id)
            ->where('slug', $slug)
            ->where('id', '!=', $subCategory->id)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        $subCategory->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sub_cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('sub-categories.index')
            ->with('success', 'Sub category updated successfully.');
    }

    public function destroy(SubCategory $subCategory)
    {
        $subCategory->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('sub-categories.index')
            ->with('success', 'Sub category deactivated successfully.');
    }
}