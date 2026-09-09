@extends('frontend.layouts.app')
@section('title', $meta_title)
@section('meta_keyword', $meta_keyword)
@section('meta_description', $meta_description)
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2>{{ $subCategory->name }}</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li>
                                <a href="{{ route('our-sub-category') }}">
                                    Our Sub Categories
                                </a>
                            </li>
                            <li class="active">{{ $subCategory->name }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
        <div class="container">
            <div class="row">
                @forelse($products as $product)
                    @php
                        $primaryImage = $product->images->where('is_primary', true)->first();
                        if (!$primaryImage) {
                            $primaryImage = $product->images->first();
                        }
                    @endphp
                    <div class="col-lg-3 col-md-6 col-sm-6 mb-30">
                        <div class="single-product-wrap">
                            <div class="product-image">
                                <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                    @if($primaryImage && $primaryImage->image)
                                        <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $product->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                    @else
                                        <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                    @endif
                                </a>
                            </div>
                            <div class="product_desc">
                                <div class="product_desc_info">
                                    <div class="product-review">
                                        <h5 class="manufacturer">
                                            @if($product->productBrand)
                                                <a href="{{ route('our-brand.show', ['slug' => $product->productBrand->slug]) }}">
                                                    {{ $product->productBrand->name }}
                                                </a>
                                            @else
                                                <a href="#">Product</a>
                                            @endif
                                        </h5>
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
                                        <a class="product_name" href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                            {{ $product->name }}
                                        </a>
                                    </h4>
                                    <div class="price-box">
                                        @if($product->sale_price !== null && $product->sale_price < $product->price)
                                            <span class="new-price new-price-2">
                                                ₹{{ number_format($product->sale_price, 2) }}
                                            </span>
                                            <span class="old-price">
                                                ₹{{ number_format($product->price, 2) }}
                                            </span>
                                        @else
                                            <span class="new-price">
                                                ₹{{ number_format($product->price, 2) }}
                                            </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="add-actions">
                                    <ul class="add-actions-link">
                                        <li class="add-cart active cart-btn"
                                            data-product-id="{{ $product->id }}"
                                            data-product-name="{{ $product->name }}"
                                            data-product-slug="{{ $product->slug }}"
                                            data-product-price="{{ $product->sale_price ?? $product->price }}"
                                            data-product-image="{{ $primaryImage && $primaryImage->image ? asset('storage/' . $primaryImage->image) : asset('assets/frontend/assets/images/product/large-size/1.jpg') }}">
                                            <a href="javascript:void(0);">Add to cart</a>
                                        </li>
                                        <li>
                                            <a class="links-details wishlist-btn"
                                                href="javascript:void(0);"
                                                data-product-id="{{ $product->id }}"
                                                data-product-name="{{ $product->name }}"
                                                data-product-slug="{{ $product->slug }}"
                                                data-product-price="{{ $product->sale_price ?? $product->price }}"
                                                data-product-image="{{ $primaryImage && $primaryImage->image ? asset('storage/' . $primaryImage->image) : asset('assets/frontend/assets/images/product/large-size/1.jpg') }}">
                                                <i class="fa fa-heart-o"></i>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="quick-view" href="{{ route('product.details', ['slug' => $product->slug]) }}">
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
                        <div class="text-center pt-40 pb-60">
                            <h3>No Products Available</h3>
                            <p>There are currently no products available for this sub category.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
@endsection
