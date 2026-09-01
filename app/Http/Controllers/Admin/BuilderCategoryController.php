<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderBrand;
use App\Models\BuilderCategory;
use App\Models\BuilderType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuilderCategoryController extends Controller
{
    
    public function index()
    {
        $builderCategories = BuilderCategory::with(['builderType','brand',])->latest()->get();
        return view('admin.builder_categories.index', compact('builderCategories'));
    }
    public function create()
    {
        $builderTypes = BuilderType::where('status', 1)->orderBy('name')->get();
        $builderBrands = BuilderBrand::where('status', 1)->orderBy('name')->get();
        return view('admin.builder_categories.create',compact('builderTypes','builderBrands')
        );
    }
    public function store(Request $request)
    {
        $request->validate([
            'builder_type_id' => ['required', 'exists:builder_types,id'],
            'brand_id' => ['required', 'exists:builder_brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'cat_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
            ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'name.required' => 'Category name is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);

        $brandExists = BuilderBrand::where('id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->where('status', 1)
            ->exists();

        if (!$brandExists) {
            return back()->withInput()->withErrors(['brand_id' => 'Selected brand does not belong to the selected builder type.',]);
        }

        /*
        |--------------------------------------------------------------------------
        | Category Slug
        |--------------------------------------------------------------------------
        */

        $slug = Str::slug($request->name);

        $existingSlug = BuilderCategory::where('builder_type_id', $request->builder_type_id)
            ->where('brand_id', $request->brand_id)
            ->where('slug', $slug)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        /*
        |--------------------------------------------------------------------------
        | Upload Image
        |--------------------------------------------------------------------------
        */

        $categoryImage = null;

        if ($request->hasFile('cat_image')) {
            $categoryImage = $request->file('cat_image')->store('builder_categories', 'public');
        }

        /*
        |--------------------------------------------------------------------------
        | Create Category
        |--------------------------------------------------------------------------
        */

        BuilderCategory::create([
            'builder_type_id' => $request->builder_type_id,
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
        return redirect()->route('builder-categories.index') ->with('success', 'PC Builder category created successfully.');
    }

    /*
    |--------------------------------------------------------------------------
    | Show
    |--------------------------------------------------------------------------
    */

    public function show(BuilderCategory $builderCategory)
    {
        $builderCategory->load(['builderType','brand', ]);
        return view('admin.builder_categories.show',compact('builderCategory'));
    }

    /*
    |--------------------------------------------------------------------------
    | Edit
    |--------------------------------------------------------------------------
    */

    public function edit(BuilderCategory $builderCategory)
    {
        $builderTypes = BuilderType::where('status', 1)
            ->orWhere('id', $builderCategory->builder_type_id)
            ->orderBy('name')
            ->get();

        $builderBrands = BuilderBrand::where('status', 1)
            ->orWhere('id', $builderCategory->brand_id)
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder_categories.edit',
            compact(
                'builderCategory',
                'builderTypes',
                'builderBrands'
            )
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, BuilderCategory $builderCategory)
    {
        $request->validate([
            'builder_type_id' => ['required', 'exists:builder_types,id'],
            'brand_id' => ['required', 'exists:builder_brands,id'],
            'name' => ['required', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'cat_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'meta_title' => ['nullable', 'string'],
            'meta_keywords' => ['nullable', 'string'],
            'meta_description' => ['nullable', 'string'],
        ], [
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'brand_id.required' => 'Brand is required.',
            'brand_id.exists' => 'Selected brand does not exist.',
            'name.required' => 'Category name is required.',
            'status.required' => 'Status is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);

        $brandExists = BuilderBrand::where('id', $request->brand_id)
            ->where('builder_type_id', $request->builder_type_id)
            ->where('status', 1)
            ->exists();

        if (!$brandExists) {
            $brandExists = BuilderBrand::where('id', $request->brand_id)
                ->where('builder_type_id', $request->builder_type_id)
                ->exists();
        }

        if (!$brandExists) {
            return back()->withInput()->withErrors([
                'brand_id' => 'Selected brand does not belong to the selected builder type.',
            ]);
        }

        $slug = Str::slug($request->name);

        $existingSlug = BuilderCategory::where('builder_type_id', $request->builder_type_id)
            ->where('brand_id', $request->brand_id)
            ->where('slug', $slug)
            ->where('id', '!=', $builderCategory->id)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        $categoryImage = $builderCategory->cat_image;

        if ($request->hasFile('cat_image')) {
            if ($categoryImage && Storage::disk('public')->exists($categoryImage)) {
                Storage::disk('public')->delete($categoryImage);
            }

            $categoryImage = $request->file('cat_image')->store('builder_categories', 'public');
        }

        $builderCategory->update([
            'builder_type_id' => $request->builder_type_id,
            'brand_id' => $request->brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->boolean('status'),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-categories.index')
            ->with('success', 'PC Builder category updated successfully.');
    }
    /*
    |--------------------------------------------------------------------------
    | Destroy / Deactivate
    |--------------------------------------------------------------------------
    */

    public function destroy(BuilderCategory $builderCategory)
    {
        $builderCategory->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('builder-categories.index')->with('success','PC Builder category deactivated successfully.');
    }
}