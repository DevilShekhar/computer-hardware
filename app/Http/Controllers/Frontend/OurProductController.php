<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class OurProductController extends Controller
{
    public function index(Request $request)
    {
        $products=Product::with(['productBrand','category','subCategory','images'])
            ->where('status',1)
            ->when($request->filled('brand'),function($query) use($request){
                $query->where('product_brand_id',$request->brand);
            })
            ->when($request->filled('category'),function($query) use($request){
                $query->where('category_id',$request->category);
            })
            ->when($request->filled('sub_category'),function($query) use($request){
                $query->where('sub_category_id',$request->sub_category);
            })
            ->when($request->filled('sort'),function($query) use($request){
                if($request->sort==='name-asc'){
                    $query->orderBy('name','asc');
                }elseif($request->sort==='name-desc'){
                    $query->orderBy('name','desc');
                }elseif($request->sort==='price-asc'){
                    $query->orderByRaw('CASE WHEN sale_price IS NOT NULL AND sale_price < price THEN sale_price ELSE price END ASC');
                }elseif($request->sort==='price-desc'){
                    $query->orderByRaw('CASE WHEN sale_price IS NOT NULL AND sale_price < price THEN sale_price ELSE price END DESC');
                }else{
                    $query->latest('id');
                }
            })
            ->when(!$request->filled('sort'),function($query){
                $query->latest('id');
            })
            ->get();

        if($request->ajax()){
            return response()->json([
                'products'=>$products->map(function($product){
                    $primaryImage=$product->images->where('is_primary',true)->first()??$product->images->first();

                    $hasDiscount=$product->sale_price&&$product->price>$product->sale_price;

                    $discountPercentage=$hasDiscount
                        ?round((($product->price-$product->sale_price)/$product->price)*100)
                        :null;

                    return [
                        'id'=>$product->id,
                        'name'=>$product->name,
                        'slug'=>$product->slug,
                        'price'=>$product->price,
                        'sale_price'=>$product->sale_price,
                        'has_discount'=>$hasDiscount,
                        'discount_percentage'=>$discountPercentage,
                        'brand'=>$product->productBrand?$product->productBrand->name:'',
                        'image'=>$primaryImage&&$primaryImage->image
                            ?asset('storage/'.$primaryImage->image)
                            :asset('assets/frontend/assets/images/product/large-size/1.jpg'),
                        'detail_url'=>route('product.details',['slug'=>$product->slug]),
                        'cart_url'=>url('/cart/add/'.$product->id)
                    ];
                }),
                'count'=>$products->count()
            ]);
        }

        $allProducts=Product::with(['productBrand','category','subCategory'])
            ->where('status',1)
            ->get();

        return view('frontend.our-products.index',compact('products','allProducts'));
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
        $product = Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
            'specifications',
            'reviews.user'
        ])->where('slug', $slug)->where('status', 1)->firstOrFail();

        // Related products: same category + same sub category
        $relatedProducts = Product::with(['productBrand','images'])
        ->where('status', 1)
        ->where('id', '!=', $product->id)
        ->where('category_id', $product->category_id)
        ->where('sub_category_id', $product->sub_category_id)
        ->latest()
        ->take(8)
        ->get();
        return view('frontend.our-products.details',compact('product', 'relatedProducts'));
    }
}