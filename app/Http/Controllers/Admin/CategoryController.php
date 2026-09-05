<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\ProductBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['productBrand','createdBy','updatedBy'])->latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        $productBrands = ProductBrand::where('status', 1)->latest()->get();
        return view('admin.categories.create', compact('productBrands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'name' => 'required|string|max:255',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'product_brand_id.required' => 'Product brand is required.',
            'product_brand_id.exists' => 'Selected product brand does not exist.',
            'name.required' => 'Category name is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);
        $slug = Str::slug($request->name);
        $existingCategory = Category::where(
            'product_brand_id',
            $request->product_brand_id
        )
        ->where('slug', $slug)
        ->exists();
        if ($existingCategory) {
            return back()->withInput()->withErrors([
                'name' => 'This category already exists under the selected brand.'
            ]);
        }
        $categoryImage = null;
        if ($request->hasFile('cat_image')) {
            $categoryImage = $request->file('cat_image')->store('categories', 'public');
        }
        Category::create([
            'product_brand_id' => $request->product_brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
        ]);
        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }
    public function show(Category $category)
    {
        $category->load(['productBrand','createdBy','updatedBy']);
        return view('admin.categories.show', compact('category'));
    }
    public function edit(Category $category)
    {
        $productBrands = ProductBrand::where('status', 1)->orWhere('id', $category->product_brand_id)->latest()->get();
        return view('admin.categories.edit',compact('category', 'productBrands'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'name' => 'required|string|max:255',
            'status' => 'required|boolean',
            'cat_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'product_brand_id.required' => 'Product brand is required.',
            'product_brand_id.exists' => 'Selected product brand does not exist.',
            'name.required' => 'Category name is required.',
            'status.required' => 'Status is required.',
            'cat_image.image' => 'The category image must be an image.',
            'cat_image.mimes' => 'Category image must be JPG, JPEG, PNG or WEBP.',
            'cat_image.max' => 'Category image must not be larger than 2MB.',
        ]);
        $slug = Str::slug($request->name);
        $existingCategory = Category::where(
            'product_brand_id',
            $request->product_brand_id
        )
            ->where('slug', $slug)
            ->where('id', '!=', $category->id)
            ->exists();
        if ($existingCategory) {
            return back()->withInput()->withErrors(['name' => 'This category already exists under the selected brand.']);
        }
        $categoryImage = $category->cat_image;
        if ($request->hasFile('cat_image')) {
            if (
                $categoryImage &&
                Storage::disk('public')->exists($categoryImage)
            ) {
                Storage::disk('public')->delete($categoryImage);
            }
            $categoryImage = $request->file('cat_image')->store('categories', 'public');
        }
        $category->update([
            'product_brand_id' => $request->product_brand_id,
            'name' => $request->name,
            'slug' => $slug,
            'cat_image' => $categoryImage,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }
    public function destroy(Category $category)
    {
        $category->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('categories.index')->with('success', 'Category deactivated successfully.');
    }
}