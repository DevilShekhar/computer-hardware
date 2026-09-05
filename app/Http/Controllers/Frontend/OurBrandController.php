<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\ProductBrand;
use App\Models\Product;

class OurBrandController extends Controller
{
    public function index()
    {
        $productBrands = ProductBrand::where('status', 1)->latest()->get();
        return view('frontend.our-brand.index', compact('productBrands'));
    }
    public function show($slug) 
    {   
        $productBrand = ProductBrand::where('slug', $slug) ->where('status', 1) ->firstOrFail(); 
        $products = Product::with(['category', 'subCategory']) ->where('product_brand_id', $productBrand->id) ->where('status', 1) ->latest() ->get(); 
        return view('frontend.our-brand.show', compact('productBrand', 'products')); 
    }
}