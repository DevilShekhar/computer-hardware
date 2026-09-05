<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BuilderProduct;
use App\Models\BuilderType;

class PcBuilderController extends Controller
{
    /**
     * PC Builder listing page.
     */
    public function index()
    {
        $builderTypes = BuilderType::query()
            ->where('status', true)
            ->orderBy('name', 'asc')
            ->get();

        return view(
            'frontend.pc-builder.index',
            compact('builderTypes')
        );
    }


    /**
     * PC Builder detail page.
     *
     * Relationship:
     *
     * PC Builder Type
     *       ↓
     *    Product
     *
     * Products are grouped on frontend using
     * the Product's own:
     *
     * Product Brand
     *      ↓
     *   Category
     *      ↓
     * Sub Category
     */
    public function show($slug)
    {
        /*
        |--------------------------------------------------------------------------
        | Get Builder Type
        |--------------------------------------------------------------------------
        */
        $builderType = BuilderType::query()
            ->where('slug', $slug)
            ->where('status', true)
            ->firstOrFail();


        /*
        |--------------------------------------------------------------------------
        | Get Products Assigned To This Builder Type
        |--------------------------------------------------------------------------
        */
        $builderProducts = BuilderProduct::query()
            ->with([
                'product.productBrand',
                'product.category',
                'product.subCategory',
                'product.images',
            ])
            ->where('builder_type_id', $builderType->id)
            ->where('status', true)
            ->whereHas('product', function ($query) {
                $query->where('status', true);
            })
            ->orderBy('sort_order', 'asc')
            ->latest('id')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Only Valid Products
        |--------------------------------------------------------------------------
        */
        $products = $builderProducts
            ->filter(function ($builderProduct) {

                return $builderProduct->product !== null;

            })
            ->map(function ($builderProduct) {

                return $builderProduct->product;

            })
            ->unique('id')
            ->values();


        /*
        |--------------------------------------------------------------------------
        | Group Products
        |--------------------------------------------------------------------------
        |
        | Brand
        |   ↓
        | Category
        |   ↓
        | Sub Category
        |   ↓
        | Products
        |
        */
        $groupedProducts = $products
            ->groupBy(function ($product) {

                return optional($product->productBrand)->id ?? 0;

            })
            ->map(function ($brandProducts) {

                return $brandProducts
                    ->groupBy(function ($product) {

                        return optional($product->category)->id ?? 0;

                    })
                    ->map(function ($categoryProducts) {

                        return $categoryProducts
                            ->groupBy(function ($product) {

                                return optional($product->subCategory)->id ?? 0;

                            });

                    });

            });


        /*
        |--------------------------------------------------------------------------
        | Brand List
        |--------------------------------------------------------------------------
        */
        $brands = $products
            ->map(function ($product) {

                return $product->productBrand;

            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();


        return view(
            'frontend.pc-builder.show',
            compact(
                'builderType',
                'builderProducts',
                'products',
                'groupedProducts',
                'brands'
            )
        );
    }
}
