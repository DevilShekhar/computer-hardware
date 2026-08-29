<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderBrand;
use App\Models\BuilderCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuilderCategoryController extends Controller
{
    public function index()
    {
        $builderCategories = BuilderCategory::with('brand')->latest()->get();
        return view('admin.builder_categories.index', compact('builderCategories'));
    }

    public function create()
    {
        $builderBrands = BuilderBrand::where('status', 1)->latest()->get();
        return view('admin.builder_categories.create', compact('builderBrands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'brand_id' => 'required|exists:builder_brands,id',
            'name' => 'required|string|max:255',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'name.required' => 'Category name is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);
        $categoryImage = null;
        if ($request->hasFile('cat_image')) {
            $categoryImage = $request->file('cat_image')->store('builder_categories', 'public');
        }
        $slug = Str::slug($request->name);
        $existingSlug = BuilderCategory::where('brand_id', $request->brand_id)->where('slug', $slug)->exists();
        if ($existingSlug) {
            $slug .= '-' . time();
        }
        BuilderCategory::create([
            'brand_id' => $request->brand_id,
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
        return redirect()->route('builder-categories.index')->with('success', 'PC Builder category created successfully.');
    }

    public function show(BuilderCategory $builderCategory)
    {
        $builderCategory->load('brand');
        return view('admin.builder_categories.show', compact('builderCategory'));
    }

    public function edit(BuilderCategory $builderCategory)
    {
        $builderBrands = BuilderBrand::where('status', 1)->orWhere('id', $builderCategory->brand_id)->latest()->get();
        return view('admin.builder_categories.edit', compact('builderCategory', 'builderBrands'));
    }

    public function update(Request $request, BuilderCategory $builderCategory)
    {
        $request->validate([
            'brand_id' => 'required|exists:builder_brands,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'name.required' => 'Category name is required.',
            'status.required' => 'Status is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);

        $categoryImage = $builderCategory->cat_image;
        if ($request->hasFile('cat_image')) {
            if ($categoryImage && Storage::disk('public')->exists($categoryImage)) {
                Storage::disk('public')->delete($categoryImage);
            }
            $categoryImage = $request->file('cat_image')->store('builder_categories', 'public');
        }
        $slug = Str::slug($request->name);
        $existingSlug = BuilderCategory::where('brand_id', $request->brand_id)
            ->where('slug', $slug)->where('id', '!=', $builderCategory->id)->exists();
        if ($existingSlug) {
            $slug .= '-' . time();
        }
        $builderCategory->update([
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('builder-categories.index')->with('success', 'PC Builder category updated successfully.');
    }

    public function destroy(BuilderCategory $builderCategory)
    {
        $builderCategory->update(['status' => 0,'updated_by' => Auth::id(),]);
        return redirect()->route('builder-categories.index')->with('success', 'PC Builder category deactivated successfully.');
    }
}
