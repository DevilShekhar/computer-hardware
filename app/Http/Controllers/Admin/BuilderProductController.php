<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\BuilderBrand;
use App\Models\BuilderCategory;
use App\Models\BuilderProduct;
use App\Models\BuilderSubCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BuilderProductController extends Controller
{
    /**
     * Display builder products.
     */
    public function index(Request $request)
    {
        $query = BuilderProduct::with([
            'product',
            'builderBrand',
            'builderCategory',
            'builderSubCategory',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('sku', 'like', '%' . $search . '%');
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $builderProducts = $query
            ->orderBy('sort_order')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view('admin.builder-products.index',compact('builderProducts'));
    }

    /**
     * Show create form.
     */
    public function create()
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        $builderBrands = BuilderBrand::where('status', true)
            ->orderBy('name')
            ->get();

        $builderCategories = BuilderCategory::where('status', true)
            ->orderBy('name')
            ->get();

        $builderSubCategories = BuilderSubCategory::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder-products.create',
            compact(
                'products',
                'builderBrands',
                'builderCategories',
                'builderSubCategories'
            )
        );
    }

    /**
     * Store builder product.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
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
                'nullable',
                'boolean',
            ],
        ]);

        // Check duplicate
        $exists = BuilderProduct::where(
            'product_id',
            $validated['product_id']
        )
            ->where(
                'builder_sub_category_id',
                $validated['builder_sub_category_id']
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'This product is already added to this builder sub category.');
        }

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        $validated['status'] =
            $request->boolean('status');

        $validated['created_by'] =
            Auth::id();

        $validated['updated_by'] =
            Auth::id();

        BuilderProduct::create($validated);

        return redirect()
            ->route('builder-products.index')
            ->with(
                'success',
                'Builder product added successfully.'
            );
    }

    /**
     * Show builder product.
     */
    public function show(BuilderProduct $builderProduct)
    {
        $builderProduct->load([
            'product',
            'builderBrand',
            'builderCategory',
            'builderSubCategory',
        ]);

        return view(
            'admin.builder-products.show',
            compact('builderProduct')
        );
    }

    /**
     * Show edit form.
     */
    public function edit(BuilderProduct $builderProduct)
    {
        $products = Product::where('status', true)
            ->orderBy('name')
            ->get();

        $builderBrands = BuilderBrand::where('status', true)
            ->orderBy('name')
            ->get();

        $builderCategories = BuilderCategory::where('status', true)
            ->orderBy('name')
            ->get();

        $builderSubCategories = BuilderSubCategory::where('status', true)
            ->orderBy('name')
            ->get();

        return view(
            'admin.builder-products.edit',
            compact(
                'builderProduct',
                'products',
                'builderBrands',
                'builderCategories',
                'builderSubCategories'
            )
        );
    }

    /**
     * Update builder product.
     */
    public function update(Request $request, BuilderProduct $builderProduct) {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
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
                'nullable',
                'boolean',
            ],
        ]);

        // Check duplicate excluding current record
        $exists = BuilderProduct::where(
            'product_id',
            $validated['product_id']
        )
            ->where(
                'builder_sub_category_id',
                $validated['builder_sub_category_id']
            )
            ->where(
                'id',
                '!=',
                $builderProduct->id
            )
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with(
                    'error',
                    'This product is already added to this builder sub category.'
                );
        }

        $validated['sort_order'] =
            $validated['sort_order'] ?? 0;

        $validated['status'] =
            $request->boolean('status');

        $validated['updated_by'] =
            Auth::id();

        $builderProduct->update($validated);

        return redirect()
            ->route('builder-products.index')
            ->with(
                'success',
                'Builder product updated successfully.'
            );
    }

    /**
     * Delete builder product.
     */
    public function destroy(BuilderProduct $builderProduct)
    {
        $builderProduct->update([
            'status' => 0,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('builder-products.index')
            ->with(
                'success',
                'Builder product deactivated successfully.'
            );
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