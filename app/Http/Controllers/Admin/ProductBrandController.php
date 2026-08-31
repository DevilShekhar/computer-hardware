<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductBrandController extends Controller
{
    public function index()
    {
        $productBrands = ProductBrand::with(['createdBy', 'updatedBy'])
            ->latest()
            ->get();

        return view('admin.product_brands.index', compact('productBrands'));
    }

    public function create()
    {
        return view('admin.product_brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_brand_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Product brand name is required.',
            'product_brand_image.image' => 'The product brand image must be an image.',
            'product_brand_image.mimes' => 'Product brand image must be JPG, JPEG, PNG or WEBP.',
            'product_brand_image.max' => 'Product brand image must not be larger than 2MB.',
        ]);

        $brandImage = null;

        if ($request->hasFile('product_brand_image')) {
            $brandImage = $request->file('product_brand_image')
                ->store('product_brands', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = ProductBrand::where('slug', $slug)->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        ProductBrand::create([
            'name' => $request->name,
            'slug' => $slug,
            'product_brand_image' => $brandImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('product-brands.index')
            ->with('success', 'Product brand created successfully.');
    }

    public function show(ProductBrand $productBrand)
    {
        $productBrand->load(['createdBy', 'updatedBy']);

        return view('admin.product_brands.show', compact('productBrand'));
    }

    public function edit(ProductBrand $productBrand)
    {
        return view('admin.product_brands.edit', compact('productBrand'));
    }

    public function update(Request $request, ProductBrand $productBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'product_brand_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Product brand name is required.',
            'status.required' => 'Status is required.',
            'product_brand_image.image' => 'The product brand image must be an image.',
            'product_brand_image.mimes' => 'Product brand image must be JPG, JPEG, PNG or WEBP.',
            'product_brand_image.max' => 'Product brand image must not be larger than 2MB.',
        ]);

        $brandImage = $productBrand->product_brand_image;

        if ($request->hasFile('product_brand_image')) {
            if ($brandImage && Storage::disk('public')->exists($brandImage)) {
                Storage::disk('public')->delete($brandImage);
            }

            $brandImage = $request->file('product_brand_image')
                ->store('product_brands', 'public');
        }

        $slug = Str::slug($request->name);

        $existingSlug = ProductBrand::where('slug', $slug)
            ->where('id', '!=', $productBrand->id)
            ->exists();

        if ($existingSlug) {
            $slug .= '-' . time();
        }

        $productBrand->update([
            'name' => $request->name,
            'slug' => $slug,
            'product_brand_image' => $brandImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('product-brands.index')
            ->with('success', 'Product brand updated successfully.');
    }

    public function destroy(ProductBrand $productBrand)
    {
        $productBrand->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('product-brands.index')
            ->with('success', 'Product brand deactivated successfully.');
    }
}