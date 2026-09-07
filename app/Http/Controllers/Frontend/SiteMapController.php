<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BuilderType;
use App\Models\Product;
use App\Models\ProductBrand;

class SiteMapController extends Controller
{
    public function index()
    {
        $products = Product::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at']);

        $brands = ProductBrand::query()
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at']);

        $builderTypes = BuilderType::query()
            ->where('status', 1)
            ->whereNotNull('slug')
            ->where('slug', '!=', '')
            ->get(['slug', 'updated_at']);

        return response()
            ->view('frontend.sitemap', compact('products', 'brands', 'builderTypes'))
            ->header('Content-Type', 'application/xml; charset=UTF-8')
            ->header('Cache-Control', 'public, max-age=3600');
    }
}