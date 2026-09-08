<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PromotionalBanner;
use App\Models\ProductBrand;


class HomeController extends Controller
{
    public function index()
    {
        $promotionalBanners = PromotionalBanner::where('status', 1)->latest('id')->get();
        $productBrands = ProductBrand::where('status', 1)->latest('id')->get();
        $products = Product::with(['productBrand', 'category', 'subCategory', 'images'])->where('status', 1)->where('is_discounted', 0)->latest('id')->get();
        $discountedProducts = Product::with(['productBrand', 'category', 'subCategory', 'images'])->where('status', 1)->where('is_discounted', 1)->latest('id')->get();
        $meta_title = 'Computer Hardware - Buy Computer Parts & Accessories Online';
        $meta_keyword = 'computer hardware, computer parts, PC components, graphics cards, processors, RAM, SSD, motherboard, computer accessories';
        $meta_description = 'Shop the latest computer hardware, PC components and accessories including processors, graphics cards, RAM, SSDs, motherboards and more at the best prices.';
        return view('frontend.home.index', compact('promotionalBanners', 'products', 'discountedProducts','productBrands','meta_title','meta_keyword','meta_description'));
    }
}