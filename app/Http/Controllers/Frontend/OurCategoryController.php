<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class OurCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('productBrand')->where('status', 1)->latest()->get();
        return view('frontend.our-category.index', compact('categories'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('status', 1)->latest()->get();
        return view('frontend.our-category.show', compact('category', 'products'));
    }
}