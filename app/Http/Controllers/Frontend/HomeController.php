<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\PromotionalBanner;

class HomeController extends Controller
{
    public function index()
    {
        // Active Promotional Banners
        $promotionalBanners = PromotionalBanner::where('status', 1)->latest('id')->get();
        // Active Products
        $products = Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
        ])->where('status', 1)->latest('id')->get();
        return view('frontend.home.index', compact('promotionalBanners','products'));
    }
}