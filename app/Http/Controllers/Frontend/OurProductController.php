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
        $meta_title = 'Our Products | Buy Computer Hardware Online';
        $meta_keyword = 'computer products, computer hardware, computer parts, PC components, graphics cards, processors, RAM, SSD, motherboard';
        $meta_description = 'Explore our range of computer hardware, PC components and accessories including graphics cards, processors, RAM, SSDs, motherboards and more.';
        return view('frontend.our-products.index',compact('products','allProducts','meta_title','meta_keyword','meta_description'));
    }
    public function discountedProducts()
    {
        $products = Product::with(['productBrand','category','subCategory','images',])->where('status', 1)->where('is_discounted', 1)->whereNotNull('sale_price')->whereColumn('sale_price', '<', 'price')->latest('id')->get();
        $meta_title = 'Discounted Computer Products | Best Deals & Offers';
        $meta_keyword = 'discounted computer products, computer hardware deals, PC parts offers, graphics card deals, processor offers, computer accessories discounts';
        $meta_description = 'Shop discounted computer hardware, PC components and accessories at great prices. Find deals on graphics cards, processors, RAM, SSDs, motherboards and more.';
        return view('frontend.our-products.discounted-products', compact('products','meta_title','meta_keyword','meta_description'));
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
        $meta_title = $product->meta_title ?: $product->name . ' | Computer Hardware';
        $meta_keyword = $product->meta_keywords ?: $product->name . ', computer hardware, computer parts';
        $meta_description = $product->meta_description ?: 'Buy ' . $product->name . ' online. Explore product details, specifications, pricing and availability.';
        return view('frontend.our-products.details',compact('product', 'relatedProducts','meta_title','meta_keyword','meta_description'));
    }
    public function compare()
    {
        $meta_title = 'Compare Computer Products | Compare PC Components';
        $meta_keyword = 'compare products, computer product comparison, compare computer hardware, compare PC components, graphics card comparison, processor comparison';
        $meta_description = 'Compare two computer hardware products side by side. Check prices, specifications, features and other details to choose the right PC component for your needs.';
        return view('frontend.our-products.compare', compact('meta_title','meta_keyword','meta_description'));
    }

    public function compareProducts(Request $request)
    {
        $ids=$request->input('ids',[]);

        if(!is_array($ids)){
            $ids=[];
        }

        $ids=array_map('intval',$ids);

        $ids=array_values(array_unique(array_filter($ids,function($id){
            return $id>0;
        })));

        $ids=array_slice($ids,0,2);

        $products=Product::with([
            'productBrand',
            'category',
            'subCategory',
            'images',
            'specifications',
        ])
            ->where('status',1)
            ->whereIn('id',$ids)
            ->get();

        $products=$products
            ->sortBy(function($product) use($ids){
                $position=array_search((int)$product->id,$ids);
                return $position===false?999:$position;
            })
            ->values();

        return response()->json([
            'products'=>$products->map(function($product){
                $primaryImage=$product->images->where('is_primary',true)->first()??$product->images->first();

                $specifications=$product->specifications->map(function($specification){
                    $attributes=method_exists($specification,'getAttributes')
                        ?$specification->getAttributes()
                        :[];

                    $name=$specification->specification_name
                        ??$specification->name
                        ??$specification->specification
                        ??$specification->attribute
                        ??$specification->title
                        ??$specification->key
                        ??($attributes['specification_name']??null)
                        ??($attributes['name']??null)
                        ??($attributes['specification']??null)
                        ??($attributes['attribute']??null)
                        ??($attributes['title']??null)
                        ??($attributes['key']??null);

                    $value=$specification->specification_value
                        ??$specification->value
                        ??$specification->attribute_value
                        ??$specification->description
                        ??$specification->text
                        ??($attributes['specification_value']??null)
                        ??($attributes['value']??null)
                        ??($attributes['attribute_value']??null)
                        ??($attributes['description']??null)
                        ??($attributes['text']??null);

                    return [
                        'name'=>$name,
                        'value'=>$value,
                    ];
                })
                ->filter(function($specification){
                    return filled($specification['name']);
                })
                ->values();

                return [
                    'id'=>$product->id,
                    'name'=>$product->name,
                    'slug'=>$product->slug,
                    'price'=>$product->price!==null?(float)$product->price:0,
                    'sale_price'=>$product->sale_price!==null?(float)$product->sale_price:null,
                    'brand'=>$product->productBrand?$product->productBrand->name:'',
                    'category'=>$product->category?$product->category->name:'',
                    'sub_category'=>$product->subCategory?$product->subCategory->name:'',
                    'image'=>$primaryImage&&$primaryImage->image
                        ?asset('storage/'.$primaryImage->image)
                        :asset('assets/frontend/assets/images/product/large-size/1.jpg'),
                    'detail_url'=>route('product.details',['slug'=>$product->slug]),
                    'specifications'=>$specifications,
                    'short_description' => $product->short_description ?? '',
                ];
            })->values(),
        ]);
    }
}
