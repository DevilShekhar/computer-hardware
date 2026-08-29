<?php

namespace App\Http\Controllers;
use App\Models\BuilderBrand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BuilderBrandController extends Controller
{
    public function index()
    {
        $builderBrands = BuilderBrand::latest()->get();
        return view('admin.builder_brands.index', compact('builderBrands'));
    }

    public function create()
    {
        return view('admin.builder_brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:builder_brands,name',
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists.',
            'brand_image.image' => 'The brand image must be an image.',
            'brand_image.mimes' => 'Brand image must be JPG, JPEG, PNG or WEBP.',
            'brand_image.max' => 'Brand image must not be larger than 2MB.',
        ]);
        $brandImage = null;
        if ($request->hasFile('brand_image')) {
            $brandImage = $request->file('brand_image')->store('builder_brands', 'public');
        }
        BuilderBrand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand_image' => $brandImage,
            'status' => 1,
            'created_by' => Auth::id(),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);

        return redirect()->route('builder-brands.index')->with('success', 'Builder brand created successfully.');
    }

    public function show(BuilderBrand $builderBrand)
    {
        return view('admin.builder_brands.show', compact('builderBrand'));
    }

    public function edit(BuilderBrand $builderBrand)
    {
        return view('admin.builder_brands.edit', compact('builderBrand'));
    }

    public function update(Request $request, BuilderBrand $builderBrand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:builder_brands,name,' . $builderBrand->id,
            'status' => 'required|boolean',
            'brand_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_keyword' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ], [
            'name.required' => 'Brand name is required.',
            'name.unique' => 'This brand already exists.',
            'status.required' => 'Status is required.',
            'brand_image.image' => 'The brand image must be an image.',
            'brand_image.mimes' => 'Brand image must be JPG, JPEG, PNG or WEBP.',
            'brand_image.max' => 'Brand image must not be larger than 2MB.',
        ]);
        $brandImage = $builderBrand->brand_image;
        if ($request->hasFile('brand_image')) {
            if ($brandImage && Storage::disk('public')->exists($brandImage)) {
                Storage::disk('public')->delete($brandImage);
            }
            $brandImage = $request->file('brand_image')->store('builder_brands', 'public');
        }
        $builderBrand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'brand_image' => $brandImage,
            'status' => $request->status,
            'updated_by' => Auth::id(),
            'meta_title' => $request->meta_title,
            'meta_keyword' => $request->meta_keyword,
            'meta_description' => $request->meta_description,
        ]);
        return redirect()->route('builder-brands.index')->with('success', 'Builder brand updated successfully.');
    }

    public function destroy(BuilderBrand $builderBrand)
    {
        $builderBrand->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('builder-brands.index')->with('success', 'Builder brand deactivated successfully.');
    }

    public function activate(BuilderBrand $builderBrand)
    {
        $builderBrand->update([
            'status' => 1,
            'updated_by' => Auth::id(),
        ]);
        return redirect()->route('builder-brands.index')->with('success', 'Builder brand activated successfully.');
    }
}