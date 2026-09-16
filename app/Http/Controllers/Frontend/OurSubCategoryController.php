<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class OurSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with(['category', 'productBrand'])->where('status', 1)->latest()->paginate(8);
        $meta_title = 'Our Sub Categories | Computer Hardware';
        $meta_keyword = 'computer sub categories, PC components, computer hardware, computer parts';
        $meta_description = 'Explore our computer hardware sub categories and find processors, graphics cards, RAM, SSDs, motherboards and other computer components.';
        return view('frontend.our-sub-category.index', compact('subCategories','meta_title', 'meta_keyword', 'meta_description'));
    }

    public function show(Request $request, $slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->where('status', 1)->firstOrFail();

        $products = Product::with(['images', 'productBrand'])
            ->where('sub_category_id', $subCategory->id)
            ->where('status', 1)
            ->latest()
            ->paginate(9)
            ->appends($request->query());

        if ($request->ajax()) {
            return response()->json([
                'products' => $products->map(function ($product) {
                    $primaryImage = $product->images->where('is_primary', true)->first()
                        ?? $product->images->first();

                    $hasDiscount = $product->sale_price !== null
                        && $product->sale_price < $product->price;

                    return [
                        'id'                  => $product->id,
                        'name'                => $product->name,
                        'slug'                => $product->slug,
                        'price'               => $product->price,
                        'sale_price'          => $product->sale_price,
                        'has_discount'        => $hasDiscount,
                        'discount_percentage' => $hasDiscount
                            ? round((($product->price - $product->sale_price) / $product->price) * 100)
                            : null,
                        'brand_name'          => $product->productBrand?->name,
                        'brand_slug'          => $product->productBrand?->slug,
                        'image'               => $primaryImage && $primaryImage->image
                            ? asset('storage/' . $primaryImage->image)
                            : asset('assets/frontend/assets/images/product/large-size/1.jpg'),
                        'detail_url'          => route('product.details', ['slug' => $product->slug]),
                    ];
                }),
                'count'        => $products->count(),
                'total'        => $products->total(),
                'current_page' => $products->currentPage(),
                'last_page'    => $products->lastPage(),
            ]);
        }

        $meta_title = $subCategory->meta_title ?: $subCategory->name . ' | Computer Hardware';
        $meta_keyword = $subCategory->meta_keywords ?: $subCategory->name . ', computer hardware, computer parts';
        $meta_description = $subCategory->meta_description ?: 'Explore ' . $subCategory->name . ' computer hardware, components and accessories.';
        return view('frontend.our-sub-category.show', compact('subCategory', 'products', 'meta_title', 'meta_keyword', 'meta_description'));
    }
}
