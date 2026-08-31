<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductBrand;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with([
            'productBrand',
            'category',
            'createdBy',
            'updatedBy'
        ])->latest()->get();

        return view('admin.sub_categories.index', compact('subCategories'));
    }

    public function create()
    {
        $productBrands = ProductBrand::where('status', 1)
            ->latest()
            ->get();

        $categories = Category::where('status', 1)
            ->latest()
            ->get();

        return view('admin.sub_categories.create', compact(
            'productBrands',
            'categories'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'product_brand_id.required' => 'Product brand is required.',
            'product_brand_id.exists' => 'Selected product brand does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $categoryExists = Category::where('id', $request->category_id)
            ->where('product_brand_id', $request->product_brand_id)
            ->exists();

        if (!$categoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'category_id' => 'Selected category does not belong to the selected product brand.'
                ]);
        }

        $subCategoryImage = null;

        if ($request->hasFile('sub_cat_image')) {
            $subCategoryImage = $request->file('sub_cat_image')
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
            'product_brand_id' => $request->product_brand_id,
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

        return redirect()
            ->route('sub-categories.index')
            ->with('success', 'Sub category created successfully.');
    }

    public function show(SubCategory $subCategory)
    {
        $subCategory->load([
            'productBrand',
            'category',
            'createdBy',
            'updatedBy'
        ]);

        return view('admin.sub_categories.show', compact('subCategory'));
    }

    public function edit(SubCategory $subCategory)
    {
        $productBrands = ProductBrand::where('status', 1)
            ->orWhere('id', $subCategory->product_brand_id)
            ->latest()
            ->get();

        $categories = Category::where('product_brand_id', $subCategory->product_brand_id)
            ->where(function ($query) use ($subCategory) {
                $query->where('status', 1)
                    ->orWhere('id', $subCategory->category_id);
            })
            ->latest()
            ->get();

        return view(
            'admin.sub_categories.edit',
            compact(
                'subCategory',
                'productBrands',
                'categories'
            )
        );
    }

    public function update(Request $request, SubCategory $subCategory)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'sub_cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'product_brand_id.required' => 'Product brand is required.',
            'product_brand_id.exists' => 'Selected product brand does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'name.required' => 'Sub category name is required.',
            'status.required' => 'Status is required.',
            'sub_cat_image.image' => 'The sub category image must be an image.',
            'sub_cat_image.mimes' => 'Sub category image must be JPG, JPEG, PNG or WEBP.',
            'sub_cat_image.max' => 'Sub category image must not be larger than 2MB.',
        ]);

        $categoryExists = Category::where('id', $request->category_id)
            ->where('product_brand_id', $request->product_brand_id)
            ->exists();

        if (!$categoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'category_id' => 'Selected category does not belong to the selected product brand.'
                ]);
        }

        $subCategoryImage = $subCategory->sub_cat_image;

        if ($request->hasFile('sub_cat_image')) {
            if ($subCategoryImage && Storage::disk('public')->exists($subCategoryImage)) {
                Storage::disk('public')->delete($subCategoryImage);
            }

            $subCategoryImage = $request->file('sub_cat_image')
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
            'product_brand_id' => $request->product_brand_id,
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

    public function getCategoriesByBrand($brand)
    {
        $categories = Category::where('product_brand_id', $brand)
            ->where('status', 1)
            ->latest()
            ->get(['id', 'name']);

        return response()->json($categories);
    }
}