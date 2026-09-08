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
        $meta_title = 'Our Sub Categories | Computer Hardware'; 
        $meta_keyword = 'computer sub categories, PC components, computer hardware, computer parts'; 
        $meta_description = 'Explore our computer hardware sub categories and find processors, graphics cards, RAM, SSDs, motherboards and other computer components.';
        return view('frontend.our-sub-category.index', compact('subCategories','meta_title', 'meta_keyword', 'meta_description'));
    }

    public function show($slug)
    {
        $subCategory = SubCategory::where('slug', $slug)->where('status', 1)->firstOrFail();
        $products = Product::with(['images','productBrand'])
            ->where('sub_category_id', $subCategory->id)
            ->where('status', 1)
            ->latest()
            ->get();
            $meta_title = $subCategory->meta_title ?: $subCategory->name . ' | Computer Hardware'; 
            $meta_keyword = $subCategory->meta_keywords ?: $subCategory->name . ', computer hardware, computer parts'; 
            $meta_description = $subCategory->meta_description ?: 'Explore ' . $subCategory->name . ' computer hardware, components and accessories.';
        return view('frontend.our-sub-category.show', compact('subCategory', 'products','meta_title', 'meta_keyword', 'meta_description'));
    }
}
