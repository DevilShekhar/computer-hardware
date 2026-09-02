<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryHistory;
use App\Models\Product;
use App\Models\ProductBrand;
use App\Models\ProductImage;
use App\Models\ProductSpecification;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
            'createdBy',
            'updatedBy',
        ])->latest()->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        $productBrands = ProductBrand::where('status', 1)->latest()->get();

        return view('admin.products.create', compact('productBrands'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock_quantity' => 'required|integer|min:0',
            'hsn' => 'nullable|string|max:255',
            'gst_rate' => 'nullable|numeric|min:0|max:100',
            'warranty_information' => 'nullable|string|max:255',
            'specification_name' => 'nullable|array',
            'specification_value' => 'nullable|array',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
            'is_discounted' => 'required|boolean',
        ], [
            'product_brand_id.required' => 'Product brand is required.',
            'product_brand_id.exists' => 'Selected product brand does not exist.',
            'category_id.required' => 'Category is required.',
            'category_id.exists' => 'Selected category does not exist.',
            'sub_category_id.required' => 'Sub category is required.',
            'sub_category_id.exists' => 'Selected sub category does not exist.',
            'name.required' => 'Product name is required.',
            'sku.required' => 'SKU is required.',
            'sku.unique' => 'This SKU already exists.',
            'price.required' => 'Price is required.',
            'sale_price.lte' => 'Sale price must be less than or equal to price.',
            'stock_quantity.required' => 'Stock quantity is required.',
        ]);

        $categoryExists = Category::where('id', $request->category_id)
            ->where('product_brand_id', $request->product_brand_id)
            ->exists();

        if (! $categoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'category_id' => 'Selected category does not belong to the selected product brand.',
                ]);
        }

        $subCategoryExists = SubCategory::where('id', $request->sub_category_id)
            ->where('category_id', $request->category_id)
            ->where('product_brand_id', $request->product_brand_id)
            ->exists();

        if (! $subCategoryExists) {
            return back()
                ->withInput()
                ->withErrors([
                    'sub_category_id' => 'Selected sub category does not belong to the selected category and product brand.',
                ]);
        }

        $slug = Str::slug($request->name);

        if (Product::where('slug', $slug)->exists()) {
            $slug .= '-'.time();
        }

        $product = Product::create([
            'product_brand_id' => $request->product_brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock_quantity' => $request->stock_quantity,
            'hsn' => $request->hsn,
            'gst_rate' => $request->gst_rate,
            'warranty_information' => $request->warranty_information,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => 1,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
            'is_discounted' => $request->is_discounted,
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $imagePath = $image->store('products', 'public');

                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'is_primary' => $index === 0,
                ]);
            }
        }

        if ($request->specification_name && $request->specification_value) {
            foreach ($request->specification_name as $key => $name) {
                $value = $request->specification_value[$key] ?? null;

                if (! empty($name) && ! empty($value)) {
                    ProductSpecification::create([
                        'product_id' => $product->id,
                        'specification_name' => $name,
                        'specification_value' => $value,
                    ]);
                }
            }
        }

        return redirect()
            ->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load([
            'productBrand',
            'category',
            'subCategory',
            'images',
            'specifications',
            'createdBy',
            'updatedBy',
        ]);

        return view('admin.products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $productBrands = ProductBrand::where('status', 1)
            ->orWhere('id', $product->product_brand_id)
            ->latest()
            ->get();

        $categories = Category::where('product_brand_id', $product->product_brand_id)
            ->where('status', 1)
            ->orWhere(function ($query) use ($product) {
                $query->where('id', $product->category_id);
            })
            ->latest()
            ->get();

        $subCategories = SubCategory::where('product_brand_id', $product->product_brand_id)
            ->where('category_id', $product->category_id)
            ->where('status', 1)
            ->orWhere(function ($query) use ($product) {
                $query->where('id', $product->sub_category_id);
            })
            ->latest()
            ->get();

        $product->load([
            'images',
            'specifications',
        ]);

        return view('admin.products.edit', compact(
            'product',
            'productBrands',
            'categories',
            'subCategories'
        ));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'product_brand_id' => 'required|exists:product_brands,id',
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'required|exists:sub_categories,id',
            'name' => 'required|string|max:255',
            'sku' => 'required|string|max:255|unique:products,sku,'.$product->id,
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lte:price',
            'stock_quantity' => 'required|integer|min:0',
            'hsn' => 'nullable|string|max:255',
            'gst_rate' => 'nullable|numeric|min:0|max:100',
            'warranty_information' => 'nullable|string|max:255',
            'status' => 'required|boolean',
            'is_discounted' => 'required|boolean',
            'specification_name' => 'nullable|array',
            'specification_name.*' => 'nullable|string|max:255',
            'specification_value' => 'nullable|array',
            'specification_value.*' => 'nullable|string|max:255',
            'meta_title' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
            'meta_description' => 'nullable|string',
        ]);
        $categoryExists = Category::where('id', $request->category_id)->where('product_brand_id', $request->product_brand_id)->exists();
        if (! $categoryExists) {
            return back()->withInput()->withErrors(['category_id' => 'Selected category does not belong to the selected product brand.']);
        }
        $subCategoryExists = SubCategory::where('id', $request->sub_category_id)->where('category_id', $request->category_id)->where('product_brand_id', $request->product_brand_id)->exists();
        if (! $subCategoryExists) {
            return back()->withInput()->withErrors([
                'sub_category_id' => 'Selected sub category does not belong to the selected category and product brand.',
            ]);
        }
        $slug = Str::slug($request->name);
        if (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
            $slug .= '-'.time();
        }
        $product->update([
            'product_brand_id' => $request->product_brand_id,
            'category_id' => $request->category_id,
            'sub_category_id' => $request->sub_category_id,
            'name' => $request->name,
            'slug' => $slug,
            'sku' => $request->sku,
            'short_description' => $request->short_description,
            'description' => $request->description,
            'price' => $request->price,
            'sale_price' => $request->sale_price,
            'stock_quantity' => $request->stock_quantity,
            'hsn' => $request->hsn,
            'gst_rate' => $request->gst_rate,
            'warranty_information' => $request->warranty_information,
            'meta_title' => $request->meta_title,
            'meta_keywords' => $request->meta_keywords,
            'meta_description' => $request->meta_description,
            'status' => $request->status,
            'updated_by' => Auth::id(),
            'is_discounted' => $request->is_discounted,
        ]);
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imagePath = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image' => $imagePath,
                    'is_primary' => false,
                ]);
            }
        }
        $product->specifications()->delete();
        $specificationNames = $request->input('specification_name', []);
        $specificationValues = $request->input('specification_value', []);
        foreach ($specificationNames as $key => $name) {
            $value = $specificationValues[$key] ?? null;
            if (! empty(trim($name ?? '')) && ! empty(trim($value ?? ''))) {
                ProductSpecification::create([
                    'product_id' => $product->id,
                    'specification_name' => trim($name),
                    'specification_value' => trim($value),
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->update(['status' => 0, 'updated_by' => Auth::id()]);

        return redirect()->route('products.index')->with('success', 'Product deactivated successfully.');
    }

    public function deleteImage(ProductImage $image)
    {
        if ($image->image && Storage::disk('public')->exists($image->image)) {
            Storage::disk('public')->delete($image->image);
        }
        $image->delete();

        return back()->with('success', 'Product image deleted successfully.');
    }

    public function getCategoriesByBrand($brand)
    {
        $categories = Category::where('product_brand_id', $brand)
            ->where('status', 1)
            ->latest()
            ->get(['id', 'name']);

        return response()->json($categories);
    }

    public function getSubCategoriesByCategory($category)
    {
        $subCategories = SubCategory::where('category_id', $category)
            ->where('status', 1)
            ->latest()
            ->get(['id', 'name']);

        return response()->json($subCategories);
    }

    public function addStock(Request $request, Product $product)
    {
        $request->validate([
            'stock_action' => 'required|in:add,update',
            'quantity' => 'required|integer|min:1',
            'reason' => 'nullable|string|max:255',
        ]);

        $previousStock = $product->stock_quantity;

        if ($request->stock_action === 'add') {

            $newStock = $previousStock + $request->quantity;
            $inventoryType = 'in';
            $historyType = 'add';

        } else {

            $newStock = $request->quantity;
            $inventoryType = 'out';
            $historyType = 'adjustment';
        }
        Inventory::create([
            'product_id' => $product->id,
            'type' => $inventoryType,
            'quantity' => $request->quantity,
            'previous_stock' => $previousStock,
            'new_stock' => $newStock,
            'reason' => $request->reason,
            'created_by' => Auth::id(),
        ]);
        InventoryHistory::create([
            'product_id' => $product->id,
            'previous_quantity' => $previousStock,
            'quantity_added' => $request->stock_action === 'add'
                ? $request->quantity
                : 0,
            'new_quantity' => $newStock,
            'type' => $historyType,
            'note' => $request->reason,
            'created_by' => Auth::id(),
        ]);
        $product->update([
            'stock_quantity' => $newStock,
            'updated_by' => Auth::id(),
        ]);

        return redirect()
            ->route('products.index')
            ->with('success', 'Product stock updated successfully.');
    }

    public function inventoryHistory(Request $request)
    {
        $products = Product::orderBy('name')->get();

        $selectedProduct = $request->get('product');

        return view('admin.products.inventory-history', compact(
            'products',
            'selectedProduct'
        ));
    }

    public function inventoryHistoryData(?Product $product = null)
    {
        $query = InventoryHistory::with(['product', 'createdBy'])
            ->latest();

        if ($product) {
            $query->where('product_id', $product->id);
        }

        $histories = $query->get();

        return response()->json([
            'product' => $product?->name,
            'sku' => $product?->sku,
            'current_stock' => $product?->stock_quantity,

            'history' => $histories->map(function ($item) {
                return [
                    'product' => $item->product->name ?? '-',
                    'sku' => $item->product->sku ?? '-',
                    'created_at' => $item->created_at
                        ? $item->created_at->format('d-m-Y h:i A')
                        : '-',
                    'type' => $item->type,
                    'quantity' => $item->quantity_added,
                    'previous_stock' => $item->previous_quantity,
                    'new_stock' => $item->new_quantity,
                    'reason' => $item->note ?? '-',
                    'created_by' => $item->createdBy->name ?? 'System',
                ];
            })->values(),
        ]);
    }

    public function stockProducts($type = 'available')
    {
        $query = Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
            'createdBy',
            'updatedBy',
        ]);

        switch ($type) {

            case 'available':
                // Stock greater than 10
                $query->where('stock_quantity', '>', 10);
                $title = 'Available Products';
                break;

            case 'low':
                // Stock between 1 and 10
                $query->whereBetween('stock_quantity', [1, 10]);
                $title = 'Low Stock Products';
                break;

            case 'out':
                // Stock is 0
                $query->where('stock_quantity', 0);
                $title = 'Out Of Stock Products';
                break;

            default:
                abort(404);
        }

        $products = $query->latest()->get();

        return view('admin.products.index', compact(
            'products',
            'type',
            'title'
        ));
    }
}
