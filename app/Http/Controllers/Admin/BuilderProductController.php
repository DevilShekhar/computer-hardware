<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BuilderBrand;
use App\Models\BuilderCategory;
use App\Models\BuilderProduct;
use App\Models\BuilderSubCategory;
use App\Models\BuilderType;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BuilderProductController extends Controller
{
    public function index(Request $request)
    {
        $query = BuilderProduct::with([
            'product',
            'builderType',
            'builderBrand',
            'builderCategory',
            'builderSubCategory',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $builderProducts = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.builder-products.index', compact('builderProducts'));
    }

    public function create()
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        $builderTypes = BuilderType::where('status', true)
            ->orderBy('name')
            ->get();

        $builderBrands = collect();
        $builderCategories = collect();
        $builderSubCategories = collect();

        return view(
            'admin.builder-products.create',
            compact(
                'products',
                'builderTypes',
                'builderBrands',
                'builderCategories',
                'builderSubCategories'
            )
        );
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],
            'builder_type_id' => [
                'required',
                'exists:builder_types,id',
            ],
            'builder_brand_id' => [
                'required',
                'exists:builder_brands,id',
            ],
            'builder_category_id' => [
                'required',
                'exists:builder_categories,id',
            ],
            'builder_sub_category_id' => [
                'required',
                'exists:builder_sub_categories,id',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
        ], [
            'product_id.required' => 'Product is required.',
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'builder_brand_id.required' => 'Builder brand is required.',
            'builder_brand_id.exists' => 'Selected builder brand does not exist.',
            'builder_category_id.required' => 'Builder category is required.',
            'builder_category_id.exists' => 'Selected builder category does not exist.',
            'builder_sub_category_id.required' => 'Builder sub category is required.',
            'builder_sub_category_id.exists' => 'Selected builder sub category does not exist.',
        ]);

        $brandExists = BuilderBrand::where('id', $validated['builder_brand_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->exists();

        if (!$brandExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_brand_id' => 'Selected brand does not belong to the selected builder type.',
                ]);
        }

        $categoryExists = BuilderCategory::where('id', $validated['builder_category_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->where('brand_id', $validated['builder_brand_id'])
            ->exists();

        if (!$categoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_category_id' => 'Selected category does not belong to the selected builder type and brand.',
                ]);
        }

        $subCategoryExists = BuilderSubCategory::where('id', $validated['builder_sub_category_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->where('brand_id', $validated['builder_brand_id'])
            ->where('category_id', $validated['builder_category_id'])
            ->exists();

        if (!$subCategoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_sub_category_id' => 'Selected sub category does not belong to the selected builder type, brand and category.',
                ]);
        }

        $exists = BuilderProduct::where('builder_type_id', $validated['builder_type_id'])
            ->where('product_id', $validated['product_id'])
            ->where('builder_sub_category_id', $validated['builder_sub_category_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'product_id' => 'This product is already added to this builder type and sub category.',
                ]);
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status'] = 1;
        $validated['created_by'] = Auth::id();
        $validated['updated_by'] = Auth::id();

        BuilderProduct::create($validated);

        return redirect()
            ->route('builder-products.index')
            ->with('success', 'Builder product added successfully.');
    }

    public function show(BuilderProduct $builderProduct)
    {
        $builderProduct->load([
            'product',
            'builderType',
            'builderBrand',
            'builderCategory',
            'builderSubCategory',
            'createdBy',
            'updatedBy',
        ]);

        return view(
            'admin.builder-products.show',
            compact('builderProduct')
        );
    }

    public function edit(BuilderProduct $builderProduct)
    {
        $products = Product::where('status', true)
            ->orWhere('id', $builderProduct->product_id)
            ->orderBy('name')
            ->get();

        $builderTypes = BuilderType::where('status', true)
            ->orWhere('id', $builderProduct->builder_type_id)
            ->orderBy('name')
            ->get();

        $builderBrands = BuilderBrand::where('builder_type_id', $builderProduct->builder_type_id)
            ->where(function ($query) use ($builderProduct) {
                $query->where('status', true)
                    ->orWhere('id', $builderProduct->builder_brand_id);
            })
            ->orderBy('name')
            ->get();

        $builderCategories = BuilderCategory::where('builder_type_id', $builderProduct->builder_type_id)
            ->where('brand_id', $builderProduct->builder_brand_id)
            ->where(function ($query) use ($builderProduct) {
                $query->where('status', true)
                    ->orWhere('id', $builderProduct->builder_category_id);
            })
            ->orderBy('name')
            ->get();

        $builderSubCategories = BuilderSubCategory::where('builder_type_id', $builderProduct->builder_type_id)
            ->where('brand_id', $builderProduct->builder_brand_id)
            ->where('category_id', $builderProduct->builder_category_id)
            ->where(function ($query) use ($builderProduct) {
                $query->where('status', true)
                    ->orWhere('id', $builderProduct->builder_sub_category_id);
            })
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder-products.edit',
            compact(
                'builderProduct',
                'products',
                'builderTypes',
                'builderBrands',
                'builderCategories',
                'builderSubCategories'
            )
        );
    }

    public function update(Request $request, BuilderProduct $builderProduct)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],
            'builder_type_id' => [
                'required',
                'exists:builder_types,id',
            ],
            'builder_brand_id' => [
                'required',
                'exists:builder_brands,id',
            ],
            'builder_category_id' => [
                'required',
                'exists:builder_categories,id',
            ],
            'builder_sub_category_id' => [
                'required',
                'exists:builder_sub_categories,id',
            ],
            'sort_order' => [
                'nullable',
                'integer',
                'min:0',
            ],
            'status' => [
                'required',
                'boolean',
            ],
        ], [
            'product_id.required' => 'Product is required.',
            'builder_type_id.required' => 'Builder type is required.',
            'builder_type_id.exists' => 'Selected builder type does not exist.',
            'builder_brand_id.required' => 'Builder brand is required.',
            'builder_brand_id.exists' => 'Selected builder brand does not exist.',
            'builder_category_id.required' => 'Builder category is required.',
            'builder_category_id.exists' => 'Selected builder category does not exist.',
            'builder_sub_category_id.required' => 'Builder sub category is required.',
            'builder_sub_category_id.exists' => 'Selected builder sub category does not exist.',
            'status.required' => 'Status is required.',
        ]);

        $brandExists = BuilderBrand::where('id', $validated['builder_brand_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->exists();

        if (!$brandExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_brand_id' => 'Selected brand does not belong to the selected builder type.',
                ]);
        }

        $categoryExists = BuilderCategory::where('id', $validated['builder_category_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->where('brand_id', $validated['builder_brand_id'])
            ->exists();

        if (!$categoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_category_id' => 'Selected category does not belong to the selected builder type and brand.',
                ]);
        }

        $subCategoryExists = BuilderSubCategory::where('id', $validated['builder_sub_category_id'])
            ->where('builder_type_id', $validated['builder_type_id'])
            ->where('brand_id', $validated['builder_brand_id'])
            ->where('category_id', $validated['builder_category_id'])
            ->exists();

        if (!$subCategoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'builder_sub_category_id' => 'Selected sub category does not belong to the selected builder type, brand and category.',
                ]);
        }

        $exists = BuilderProduct::where('builder_type_id', $validated['builder_type_id'])
            ->where('product_id', $validated['product_id'])
            ->where('builder_sub_category_id', $validated['builder_sub_category_id'])
            ->where('id', '!=', $builderProduct->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->withErrors([
                    'product_id' => 'This product is already added to this builder type and sub category.',
                ]);
        }

        $validated['sort_order'] = $validated['sort_order'] ?? 0;
        $validated['status'] = $request->boolean('status');
        $validated['updated_by'] = Auth::id();

        $builderProduct->update($validated);

        return redirect()
            ->route('builder-products.index')
            ->with('success', 'Builder product updated successfully.');
    }

    public function destroy(BuilderProduct $builderProduct)
    {
        $builderProduct->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-products.index')
            ->with('success', 'Builder product deactivated successfully.');
    }

    public function getBrands($type)
    {
        $brands = BuilderBrand::where('builder_type_id', $type)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($brands);
    }

    public function getCategories($brand)
    {
        $categories = BuilderCategory::where('brand_id', $brand)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    public function getSubCategories($category)
    {
        $subCategories = BuilderSubCategory::where('category_id', $category)
            ->where('status', true)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($subCategories);
    }
}