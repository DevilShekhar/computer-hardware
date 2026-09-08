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
        $builderTypes = BuilderType::query()->where('status', true)->orderBy('name', 'asc')->get();
        $meta_title = 'PC Builder | Build Your Custom PC Online'; 
        $meta_keyword = 'PC builder, custom PC builder, build a PC, gaming PC builder, custom computer builder, PC components'; 
        $meta_description = 'Build your custom PC online with our PC Builder. Choose compatible components including processors, graphics cards, motherboards, RAM, storage and other PC parts.';
        return view( 'frontend.pc-builder.index', compact( 'builderTypes', 'meta_title', 'meta_keyword', 'meta_description' ) );
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
        
        $builderType = BuilderType::query()->where('slug', $slug)->where('status', true)->firstOrFail();
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
        $products = $builderProducts
            ->filter(function ($builderProduct) {

                return $builderProduct->product !== null;

            })
            ->map(function ($builderProduct) {
                return $builderProduct->product;
            })
            ->unique('id')
            ->values();
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
        $brands = $products
            ->map(function ($product) {
                return $product->productBrand;
            })
            ->filter()
            ->unique('id')
            ->sortBy('name')
            ->values();
            $meta_title = $builderType->meta_title ?: $builderType->name . ' | PC Builder';
            $meta_keyword = $builderType->meta_keywords ?: $builderType->name . ', PC builder, custom PC, computer hardware, PC components';
            $meta_description = $builderType->meta_description ?: 'Build your ' . $builderType->name . ' with compatible computer components including processors, graphics cards, motherboards, RAM and storage.';
        return view('frontend.pc-builder.show',
            compact(
                'builderType',
                'builderProducts',
                'products',
                'groupedProducts',
                'brands',
                'meta_title',
                'meta_keyword',
                'meta_description'
            )
        );
    }
}
