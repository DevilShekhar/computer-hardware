<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;

class OurProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['productBrand', 'category', 'subCategory', 'images'])->where('status', 1)->where('is_discounted', 0)->latest('id')->get();
        $discountedProducts = Product::with(['productBrand', 'category', 'subCategory', 'images'])->where('status', 1)->where('is_discounted', 1)->latest('id')->get();

        return view('frontend.our-products.index', compact('products', 'discountedProducts'));
    }
    public function discountedProducts()
    {
        $products = Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
        ])
            ->where('status', 1)
            ->where('is_discounted', 1)
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->latest('id')
            ->get();

        return view('frontend.our-products.discounted-products', compact('products'));
    }

    public function show($slug)
    {
        $product = Product::with(['productBrand', 'category', 'subCategory', 'images', 'specifications'])
            ->where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        return view('frontend.our-products.details', compact('product'));
    }
}