<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\SubCategory;

class OurSubCategoryController extends Controller
{
    public function index()
    {
        $subCategories = SubCategory::with(['category', 'productBrand'])->where('status', 1)->latest()->paginate(8);
        return view('frontend.our-sub-category.index', compact('subCategories'));
    }

    public function show($slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::with(['images','productBrand'])
            ->where('sub_category_id', $subCategory->id)
            ->where('status', 1)
            ->latest()
            ->get();
        return view('frontend.our-sub-category.show', compact('subCategory', 'products'));
    }
}