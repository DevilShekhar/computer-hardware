<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderBrand;
use App\Models\BuilderCategory;
use App\Models\BuilderSubCategory;
use App\Models\BuilderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuilderSubCategoryController extends Controller
{
    public function index()
    {
        $builderSubCategories = BuilderSubCategory::with(['builderType', 'brand', 'category'])->latest()->get();

        return view('admin.builder_sub_categories.index', compact('builderSubCategories'));
    }

    public function create()
    {
        $builderTypes = BuilderType::where('status', 1)->latest()->get();
        $builderBrands = BuilderBrand::where('status', 1)->latest()->get();
        $builderCategories = BuilderCategory::where('status', 1)->latest()->get();

        return view('admin.builder_sub_categories.create', compact('builderTypes', 'builderBrands', 'builderCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'builder_type_id' => 'required|exists:builder_types,id',
            'brand_id' => 'required|exists:builder_brands,id',
            'category_id' => 'required|exists:builder_categories,id',
            'name' => 'required|string|max:255',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $brandExists = BuilderBrand::where('id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->exists();

        if (!$brandExists) {
            return back()->withInput()->withErrors([
                'brand_id' => 'Selected brand does not belong to the selected builder type.'
            ]);
        }

        $categoryExists = BuilderCategory::where('id', $request->category_id)
            ->where('brand_id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->where('status', 1)
            ->exists();

        if (!$categoryExists) {
            return back()->withInput()->withErrors([
                'category_id' => 'Selected category does not belong to the selected builder type and brand.'
            ]);
        }

        $subCategoryImage = null;

        if ($request->hasFile('sub_cat_image')) {
            $subCategoryImage = $request->file('sub_cat_image')->store('builder_sub_categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = BuilderSubCategory::where('builder_type_id', $request->builder_type_id)
            ->where('brand_id', $request->brand_id)
            ->where('category_id', $request->category_id)
            ->where('slug', $slug)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        BuilderSubCategory::create([
            'builder_type_id' => $request->builder_type_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sub_cat_image' => $subCategoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('builder-sub-categories.index')->with('success', 'PC Builder sub category created successfully.');
    }

    public function show(BuilderSubCategory $builderSubCategory)
    {
        $builderSubCategory->load(['builderType', 'brand', 'category', 'createdBy', 'updatedBy']);

        return view('admin.builder_sub_categories.show', compact('builderSubCategory'));
    }

    public function edit(BuilderSubCategory $builderSubCategory)
    {
        $builderTypes = BuilderType::where('status', 1)
            ->orWhere('id', $builderSubCategory->builder_type_id)
            ->latest()
            ->get();

        $builderBrands = BuilderBrand::where('builder_type_id', $builderSubCategory->builder_type_id)
            ->where(function ($query) use ($builderSubCategory) {
                $query->where('status', 1)
                    ->orWhere('id', $builderSubCategory->brand_id);
            })
            ->latest()
            ->get();

        $builderCategories = BuilderCategory::where('builder_type_id', $builderSubCategory->builder_type_id)
            ->where('brand_id', $builderSubCategory->brand_id)
            ->where(function ($query) use ($builderSubCategory) {
                $query->where('status', 1)
                    ->orWhere('id', $builderSubCategory->category_id);
            })
            ->latest()
            ->get();

        return view('admin.builder_sub_categories.edit', compact('builderSubCategory', 'builderTypes', 'builderBrands', 'builderCategories'));
    }

    public function update(Request $request, BuilderSubCategory $builderSubCategory)
    {
        $request->validate([
            'builder_type_id' => 'required|exists:builder_types,id',
            'brand_id' => 'required|exists:builder_brands,id',
            'category_id' => 'required|exists:builder_categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'status.required' => 'Status is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $brandExists = BuilderBrand::where('id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->exists();

        if (!$brandExists) {
            return back()->withInput()->withErrors([
                'brand_id' => 'Selected brand does not belong to the selected builder type.'
            ]);
        }

        $categoryExists = BuilderCategory::where('id', $request->category_id)
            ->where('brand_id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->exists();

        if (!$categoryExists) {
            return back()->withInput()->withErrors([
                'category_id' => 'Selected category does not belong to the selected builder type and brand.'
            ]);
        }

        $subCategoryImage = $builderSubCategory->sub_cat_image;

        if ($request->hasFile('sub_cat_image')) {
            if ($subCategoryImage && Storage::disk('public')->exists($subCategoryImage)) {
                Storage::disk('public')->delete($subCategoryImage);
            }

            $subCategoryImage = $request->file('sub_cat_image')->store('builder_sub_categories', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = BuilderSubCategory::where('builder_type_id', $request->builder_type_id)
            ->where('brand_id', $request->brand_id)
            ->where('category_id', $request->category_id)
            ->where('slug', $slug)
            ->where('id', '!=', $builderSubCategory->id)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        $builderSubCategory->update([
            'builder_type_id' => $request->builder_type_id,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sub_cat_image' => $subCategoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('builder-sub-categories.index')->with('success', 'PC Builder sub category updated successfully.');
    }

    public function destroy(BuilderSubCategory $builderSubCategory)
    {
        $builderSubCategory->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()->route('builder-sub-categories.index')->with('success', 'PC Builder sub category deactivated successfully.');
    }

    public function getByBrand($brand)
    {
        $builderCategories = BuilderCategory::where('brand_id', $brand)
            ->where('status', 1)
            ->latest()
            ->get(['id', 'name']);

        return response()->json($builderCategories);
    }
    public function getBrandsByType($builderType)
    {
        $builderBrands = BuilderBrand::where('builder_type_id', $builderType)
            ->where('status', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($builderBrands);
    }
}