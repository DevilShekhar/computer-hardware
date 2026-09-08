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
        $meta_title = 'Our Brands | Computer Hardware';
        $meta_keyword = 'computer hardware brands, PC brands, computer parts brands';
        $meta_description = 'Explore trusted computer hardware brands offering processors, graphics cards, motherboards, RAM, SSDs and other computer components.';
        return view('frontend.our-brand.index', compact('productBrands','meta_title','meta_keyword','meta_description'));
    }
    public function show($slug) 
    {   
        $productBrand = ProductBrand::where('slug', $slug) ->where('status', 1) ->firstOrFail(); 
        $products = Product::with(['category', 'subCategory']) ->where('product_brand_id', $productBrand->id) ->where('status', 1) ->latest() ->get();
        $meta_title = $productBrand->meta_title ?: $productBrand->name . ' | Computer Hardware';
        $meta_keyword = $productBrand->meta_keywords ?: $productBrand->name . ', computer hardware, computer parts';
        $meta_description = $productBrand->meta_description ?: 'Explore ' . $productBrand->name . ' computer hardware, components and accessories.';
        return view('frontend.our-brand.show', compact('productBrand', 'products','meta_title','meta_keyword','meta_description')); 
    }
}