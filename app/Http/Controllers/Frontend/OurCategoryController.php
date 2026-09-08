<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;

class OurCategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('productBrand')->where('status', 1)->latest()->paginate(8);
        $meta_title = 'Our Categories | Computer Hardware'; 
        $meta_keyword = 'computer categories, PC components, computer hardware categories, computer parts'; 
        $meta_description = 'Explore our computer hardware categories including processors, graphics cards, motherboards, RAM, SSDs and other computer components.';
        return view('frontend.our-category.index', compact('categories','meta_title', 'meta_keyword', 'meta_description'));
    }

    public function show($slug)
    {
        $category = Category::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::where('category_id', $category->id)->where('status', 1)->latest()->get();
        $meta_title = $category->meta_title ?: $category->name . ' | Computer Hardware'; 
        $meta_keyword = $category->meta_keywords ?: $category->name . ', computer hardware, computer parts'; 
        $meta_description = $category->meta_description ?: 'Explore ' . $category->name . ' computer hardware, components and accessories.';
        return view('frontend.our-category.show', compact('category', 'products','meta_title', 'meta_keyword', 'meta_description'));
    }
}