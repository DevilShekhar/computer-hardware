@extends('frontend.layouts.app')
@section('title','Our Products')
@section('content')

<div class="content-wraper pt-60 pb-60 pt-sm-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="shop-sidebar">
                    <div class="sidebar-categores-box mt-sm-30 mt-xs-30">
                        <div class="sidebar-title">
                            <h2>Brand</h2>
                        </div>
                        <div class="category-sub-menu">
                            <ul>
                                @foreach($allProducts->pluck('productBrand')->filter()->unique('id') as $brand)
                                    <li>
                                        <a href="javascript:void(0)" class="filter-brand" data-id="{{ $brand->id }}">{{ $brand->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-categores-box mt-30">
                        <div class="sidebar-title">
                            <h2>Category</h2>
                        </div>
                        <div class="category-sub-menu">
                            <ul>
                                @foreach($allProducts->pluck('category')->filter()->unique('id') as $category)
                                    <li class="has-sub">
                                        <a href="javascript:void(0)" class="filter-category" data-id="{{ $category->id }}">{{ $category->name }}</a>
                                        <ul>
                                            @foreach($allProducts->where('category_id',$category->id)->pluck('subCategory')->filter()->unique('id') as $subCategory)
                                                <li>
                                                    <a href="javascript:void(0)" class="filter-sub-category" data-id="{{ $subCategory->id }}">{{ $subCategory->name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="sidebar-categores-box mt-30">
                        <div class="sidebar-title">
                            <h2>Filter</h2>
                        </div>
                        <button type="button" class="btn-clear-all" id="clearFilters">Clear all</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                
                <div class="shop-top-bar">
                    <div class="shop-bar-inner">
                        <div class="product-view-mode">
                            <ul class="nav shop-item-filter-list" role="tablist">
                                <li class="active" role="presentation">
                                    <a aria-selected="true" class="active show" data-toggle="tab" role="tab" href="#grid-view">
                                        <i class="fa fa-th"></i>
                                    </a>
                                </li>
                                <li role="presentation">
                                    <a data-toggle="tab" role="tab" href="#list-view">
                                        <i class="fa fa-th-list"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="toolbar-amount">
                            <span id="productCount">Showing {{ $products->count() }} Products</span>
                        </div>
                    </div>
                    <div class="product-select-box">
                        <div class="product-short">
                            <p>Sort By:</p>
                            <select id="productSort" class="form-control">
                                <option value="latest">Latest</option>
                                <option value="name-asc">Name (A - Z)</option>
                                <option value="name-desc">Name (Z - A)</option>
                                <option value="price-asc">Price (Low &gt; High)</option>
                                <option value="price-desc">Price (High &gt; Low)</option>
                            </select>
                        </div>
                    </div>
                </div>
                
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row" id="productGrid">
                                    @forelse($products as $product)
                                        @php
                                            $primaryImage=$product->images->where('is_primary',true)->first()??$product->images->first();
                                            $hasDiscount=$product->sale_price&&$product->price>$product->sale_price;
                                            $discountPercentage=$hasDiscount?round((($product->price-$product->sale_price)/$product->price)*100):null;
                                        @endphp
                                        <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                            <div class="single-product-wrap">
                                                <div class="product-image">
                                                    <a href="{{ route('product.details',['slug'=>$product->slug]) }}">
                                                        @if($primaryImage&&$primaryImage->image)
                                                            <img src="{{ asset('storage/'.$primaryImage->image) }}" alt="{{ $product->name }}">
                                                        @else
                                                            <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                                        @endif
                                                    </a>
                                                    @if($hasDiscount)
                                                        <span class="sticker">-{{ $discountPercentage }}%</span>
                                                    @endif
                                                </div>
                                                <div class="product_desc">
                                                    <div class="product_desc_info">
                                                        <div class="product-review">
                                                            @if($product->productBrand)
                                                                <h5 class="manufacturer">
                                                                    <a href="#">{{ $product->productBrand->name }}</a>
                                                                </h5>
                                                            @endif
                                                            <div class="rating-box">
                                                                <ul class="rating">
                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                    <li><i class="fa fa-star-o"></i></li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        <h4>
                                                            <a class="product_name" href="{{ route('product.details',['slug'=>$product->slug]) }}">{{ $product->name }}</a>
                                                        </h4>
                                                        <div class="price-box">
                                                            @if($hasDiscount)
                                                                <span class="new-price new-price-2">₹{{ number_format($product->sale_price,2) }}</span>
                                                                <span class="old-price">₹{{ number_format($product->price,2) }}</span>
                                                            @else
                                                                <span class="new-price">₹{{ number_format($product->price,2) }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="add-actions">
                                                        <ul class="add-actions-link">
                                                            <li class="add-cart active">
                                                                <a href="{{ url('/cart/add/'.$product->id) }}">Add to cart</a>
                                                            </li>
                                                            <li>
                                                                <a class="links-details" href="#">
                                                                    <i class="fa fa-heart-o"></i>
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="quick-view" href="{{ route('product.details',['slug'=>$product->slug]) }}">
                                                                    <i class="fa fa-eye"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="col-lg-12">
                                            <div class="text-center py-5">
                                                <h4>No products available.</h4>
                                            </div>
                                        </div>
                                    @endforelse
                                </div>
                            </div>
                        </div>
                        <div id="list-view" class="tab-pane fade product-list-view" role="tabpanel">
                            <div id="productList">
                                @forelse($products as $product)
                                    @php
                                        $primaryImage=$product->images->where('is_primary',true)->first()??$product->images->first();
                                        $hasDiscount=$product->sale_price&&$product->price>$product->sale_price;
                                    @endphp
                                    <div class="row product-layout-list mb-30">
                                        <div class="col-lg-3 col-md-5">
                                            <div class="product-image">
                                                <a href="{{ route('product.details',['slug'=>$product->slug]) }}">
                                                    @if($primaryImage&&$primaryImage->image)
                                                        <img src="{{ asset('storage/'.$primaryImage->image) }}" alt="{{ $product->name }}">
                                                    @else
                                                        <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                                    @endif
                                                </a>
                                            </div>
                                        </div>
                                        <div class="col-lg-5 col-md-7">
                                            <div class="product_desc">
                                                <div class="product_desc_info">
                                                    <div class="product-review">
                                                        @if($product->productBrand)
                                                            <h5 class="manufacturer">
                                                                <a href="#">{{ $product->productBrand->name }}</a>
                                                            </h5>
                                                        @endif
                                                        <div class="rating-box">
                                                            <ul class="rating">
                                                                <li><i class="fa fa-star-o"></i></li>
                                                                <li><i class="fa fa-star-o"></i></li>
                                                                <li><i class="fa fa-star-o"></i></li>
                                                                <li><i class="fa fa-star-o"></i></li>
                                                                <li><i class="fa fa-star-o"></i></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    <h4>
                                                        <a class="product_name" href="{{ route('product.details',['slug'=>$product->slug]) }}">{{ $product->name }}</a>
                                                    </h4>
                                                    <div class="price-box">
                                                        @if($hasDiscount)
                                                            <span class="new-price new-price-2">₹{{ number_format($product->sale_price,2) }}</span>
                                                            <span class="old-price">₹{{ number_format($product->price,2) }}</span>
                                                        @else
                                                            <span class="new-price">₹{{ number_format($product->price,2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4">
                                            <div class="shop-add-action mb-xs-30">
                                                <ul class="add-actions-link">
                                                    <li class="add-cart">
                                                        <a href="{{ url('/cart/add/'.$product->id) }}">Add to cart</a>
                                                    </li>
                                                    <li class="wishlist">
                                                        <a href="#">
                                                            <i class="fa fa-heart-o"></i>Add to wishlist
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="quick-view" href="{{ route('product.details',['slug'=>$product->slug]) }}">
                                                            <i class="fa fa-eye"></i>View product
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <h4>No products available.</h4>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
                <div id="productLoader" style="display:none;text-align:center;padding:40px;">
                    <i class="fa fa-spinner fa-spin fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
document.addEventListener('DOMContentLoaded',function(){
    let currentFilter={
        brand:'',
        category:'',
        sub_category:'',
        sort:'latest'
    };


const productGrid=document.getElementById('productGrid');
const productList=document.getElementById('productList');
const productCount=document.getElementById('productCount');
const productLoader=document.getElementById('productLoader');
const productSort=document.getElementById('productSort');

function escapeHtml(value){
    const div=document.createElement('div');
    div.textContent=value??'';
    return div.innerHTML;
}

function formatPrice(value){
    return Number(value??0).toLocaleString('en-IN',{
        minimumFractionDigits:2,
        maximumFractionDigits:2
    });
}

function priceHtml(product){
    if(product.has_discount){
        return '<span class="new-price new-price-2">₹'+formatPrice(product.sale_price)+'</span><span class="old-price">₹'+formatPrice(product.price)+'</span>';
    }
    return '<span class="new-price">₹'+formatPrice(product.price)+'</span>';
}

function gridProduct(product){
    let sticker='';
    if(product.discount_percentage>0){
        sticker='<span class="sticker">-'+product.discount_percentage+'%</span>';
    }

    return '<div class="col-lg-4 col-md-4 col-sm-6 mt-40">'+
        '<div class="single-product-wrap">'+
            '<div class="product-image">'+
                '<a href="'+product.detail_url+'"><img src="'+product.image+'" alt="'+escapeHtml(product.name)+'"></a>'+
                sticker+
            '</div>'+
            '<div class="product_desc">'+
                '<div class="product_desc_info">'+
                    '<div class="product-review">'+
                        '<h5 class="manufacturer"><a href="#">'+escapeHtml(product.brand)+'</a></h5>'+
                        '<div class="rating-box">'+
                            '<ul class="rating">'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                            '</ul>'+
                        '</div>'+
                    '</div>'+
                    '<h4><a class="product_name" href="'+product.detail_url+'">'+escapeHtml(product.name)+'</a></h4>'+
                    '<div class="price-box">'+priceHtml(product)+'</div>'+
                '</div>'+
                '<div class="add-actions">'+
                    '<ul class="add-actions-link">'+
                        '<li class="add-cart active"><a href="'+product.cart_url+'">Add to cart</a></li>'+
                        '<li><a class="links-details" href="#"><i class="fa fa-heart-o"></i></a></li>'+
                        '<li><a class="quick-view" href="'+product.detail_url+'"><i class="fa fa-eye"></i></a></li>'+
                    '</ul>'+
                '</div>'+
            '</div>'+
        '</div>'+
    '</div>';
}

function listProduct(product){
    return '<div class="row product-layout-list mb-30">'+
        '<div class="col-lg-3 col-md-5">'+
            '<div class="product-image">'+
                '<a href="'+product.detail_url+'"><img src="'+product.image+'" alt="'+escapeHtml(product.name)+'"></a>'+
            '</div>'+
        '</div>'+
        '<div class="col-lg-5 col-md-7">'+
            '<div class="product_desc">'+
                '<div class="product_desc_info">'+
                    '<div class="product-review">'+
                        '<h5 class="manufacturer"><a href="#">'+escapeHtml(product.brand)+'</a></h5>'+
                        '<div class="rating-box">'+
                            '<ul class="rating">'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                                '<li><i class="fa fa-star-o"></i></li>'+
                            '</ul>'+
                        '</div>'+
                    '</div>'+
                    '<h4><a class="product_name" href="'+product.detail_url+'">'+escapeHtml(product.name)+'</a></h4>'+
                    '<div class="price-box">'+priceHtml(product)+'</div>'+
                '</div>'+
            '</div>'+
        '</div>'+
        '<div class="col-lg-4">'+
            '<div class="shop-add-action mb-xs-30">'+
                '<ul class="add-actions-link">'+
                    '<li class="add-cart"><a href="'+product.cart_url+'">Add to cart</a></li>'+
                    '<li class="wishlist"><a href="#"><i class="fa fa-heart-o"></i>Add to wishlist</a></li>'+
                    '<li><a class="quick-view" href="'+product.detail_url+'"><i class="fa fa-eye"></i>View product</a></li>'+
                '</ul>'+
            '</div>'+
        '</div>'+
    '</div>';
}

function loadProducts(){
    productLoader.style.display='block';
    productGrid.style.opacity='0.5';

    const params=new URLSearchParams();

    if(currentFilter.brand){
        params.set('brand',currentFilter.brand);
    }

    if(currentFilter.category){
        params.set('category',currentFilter.category);
    }

    if(currentFilter.sub_category){
        params.set('sub_category',currentFilter.sub_category);
    }

    params.set('sort',currentFilter.sort);

    fetch("{{ route('our-products') }}?"+params.toString(),{
        method:'GET',
        headers:{
            'X-Requested-With':'XMLHttpRequest',
            'Accept':'application/json'
        }
    })
    .then(function(response){
        if(!response.ok){
            throw new Error('HTTP '+response.status);
        }
        return response.json();
    })
    .then(function(response){
        let gridHtml='';
        let listHtml='';

        if(response.products&&response.products.length){
            response.products.forEach(function(product){
                gridHtml+=gridProduct(product);
                listHtml+=listProduct(product);
            });
        }else{
            gridHtml='<div class="col-lg-12"><div class="text-center py-5"><h4>No products available.</h4></div></div>';
            listHtml='<div class="text-center py-5"><h4>No products available.</h4></div>';
        }

        productGrid.innerHTML=gridHtml;

        if(productList){
            productList.innerHTML=listHtml;
        }

        productCount.textContent='Showing '+(response.count??0)+' Products';

        productLoader.style.display='none';
        productGrid.style.opacity='1';
    })
    .catch(function(error){
        console.error('Product filter error:',error);
        productLoader.style.display='none';
        productGrid.style.opacity='1';
    });
}

document.addEventListener('click',function(e){
    const brand=e.target.closest('.filter-brand');

    if(brand){
        e.preventDefault();
        currentFilter.brand=brand.dataset.id;
        currentFilter.category='';
        currentFilter.sub_category='';
        loadProducts();
        return;
    }

    const category=e.target.closest('.filter-category');

    if(category){
        e.preventDefault();
        currentFilter.brand='';
        currentFilter.category=category.dataset.id;
        currentFilter.sub_category='';
        loadProducts();
        return;
    }

    const subCategory=e.target.closest('.filter-sub-category');

    if(subCategory){
        e.preventDefault();
        currentFilter.brand='';
        currentFilter.category='';
        currentFilter.sub_category=subCategory.dataset.id;
        loadProducts();
        return;
    }
});

if(productSort){
    productSort.addEventListener('change',function(){
        currentFilter.sort=this.value;
        loadProducts();
    });
}

const clearFilters=document.getElementById('clearFilters');

if(clearFilters){
    clearFilters.addEventListener('click',function(e){
        e.preventDefault();

        currentFilter={
            brand:'',
            category:'',
            sub_category:'',
            sort:'latest'
        };

        productSort.value='latest';

        loadProducts();
    });
}


}); </script>
@endsection
