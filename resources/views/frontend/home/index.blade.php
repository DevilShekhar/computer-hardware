@extends('frontend.layouts.app')
@section('title', 'Home')
@section('content')
<!-- Start Hero Area -->
<div class="slider-with-banner full-screen-slider">
    <div class="slider-area">
        <div class="slider-active owl-carousel">
            @forelse($promotionalBanners as $banner)

                <div class="single-slide align-center-left animation-style-01"
                    style="background-image: url('{{ asset('storage/' . $banner->image) }}');">

                    <div class="slider-progress"></div>

                    <div class="slider-content">
                        @if($banner->short_description)
                            <h5>{{ $banner->short_description }}</h5>
                        @endif

                        @if($banner->title)
                            <h2>{{ $banner->title }}</h2>
                        @endif

                        @if($banner->button_text)
                            <div class="default-btn slide-btn">
                                <a class="links" href="{{ $banner->button_url ?: '#' }}">
                                    {{ $banner->button_text }}
                                </a>
                            </div>
                        @endif
                    </div>

                </div>

            @empty

                <div class="single-slide align-center-left animation-style-01">
                    <div class="slider-progress"></div>

                    <div class="slider-content">
                        <h5>Welcome to Our Store</h5>
                        <h2>Discover Our Latest Products</h2>

                        <div class="default-btn slide-btn">
                            <a class="links" href="{{ url('/shop') }}">
                                Shopping Now
                            </a>
                        </div>
                    </div>
                </div>

            @endforelse
        </div>
    </div>
</div>
<div class="li-static-banner li-static-banner-4 text-center pt-20">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="single-banner pb-sm-30 pb-xs-30">
                    <a href="#">
                        <img src="{{ asset('assets/frontend/assets/images/banner/2_3.jpg') }}" alt="Li's Static Banner">
                    </a>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="single-banner">
                    <a href="#">
                        <img src="{{ asset('assets/frontend/assets/images/banner/2_4.jpg') }}" alt="Li's Static Banner">
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2><span>Our Products</span></h2>
                </div>
                <div class="row">
                    <div class="product-active owl-carousel">
                        @forelse($products as $product)
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first();
                                if (!$primaryImage) {
                                    $primaryImage = $product->images->first();
                                }
                            @endphp
                            <div class="col-lg-12">
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                            @if($primaryImage && $primaryImage->image)
                                                <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $product->name }}">
                                            @else
                                                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                            @endif
                                        </a>
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    @if($product->productBrand)
                                                        <a href="#">
                                                            {{ $product->productBrand->name }}
                                                        </a>
                                                    @else
                                                        <a href="#">
                                                            Product
                                                        </a>
                                                    @endif
                                                </h5>
                                                <div class="rating-box">
                                                    <ul class="rating">
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <h4>
                                                <a  class="product_name" href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h4>
                                            <div class="price-box">
                                                @if( $product->sale_price !== null &&  $product->sale_price < $product->price)
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
                                                <li class="add-cart active">
                                                    <a href="{{ url('/cart/add/' . $product->id) }}">
                                                        Add to cart
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="links-details"  href="#">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="quick-view"  href="{{ route('product.details', ['slug' => $product->slug]) }}"                                     >
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
                                <div class="text-center">
                                    <p>No products available.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2><span>Discounted Products</span></h2>
                </div>
                <div class="row">
                    <div class="product-active owl-carousel">
                        @forelse($discountedProducts as $product)
                            @php
                                $primaryImage = $product->images->where('is_primary', true)->first();
                                if (!$primaryImage) {   
                                    $primaryImage = $product->images->first();
                                }
                                $discountPercentage = 0;
                                if ( $product->price > 0 &&  $product->sale_price &&  $product->sale_price < $product->price) {
                                    $discountPercentage = round(
                                    (($product->price - $product->sale_price) / $product->price) * 100
                                );}
                            @endphp
                            <div class="col-lg-12">
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                            @if($primaryImage && $primaryImage->image)
                                            <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $product->name }}">
                                            @else
                                            <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                            @endif
                                        </a>
                                        @if($discountPercentage > 0)
                                        <span class="sticker">
                                            -{{ $discountPercentage }}%
                                        </span>
                                        @endif
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    @if($product->productBrand)
                                                    <a href="#">
                                                        {{ $product->productBrand->name }}
                                                    </a>
                                                    @else
                                                    <a href="#">
                                                        Product
                                                    </a>
                                                    @endif
                                                </h5>
                                                <div class="rating-box">
                                                    <ul class="rating">
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                        <li>
                                                            <i class="fa fa-star-o"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <h4>
                                                <a class="product_name" href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                    {{ $product->name }}
                                                </a>
                                            </h4>
                                            <div class="price-box">
                                                <span class="new-price new-price-2 sale-price">
                                                    ₹{{ number_format($product->sale_price, 2) }}
                                                </span>
                                                <span class="old-price original-price">
                                                    ₹{{ number_format($product->price, 2) }}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active">
                                                    <a href="{{ url('/cart/add/' . $product->id) }}">
                                                        Add to cart
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="links-details" href="#">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="quick-view"  href="{{ route('product.details', ['slug' => $product->slug]) }}">
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
                                <div class="text-center">
                                    <p>No discounted products available.</p>
                                </div>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<div class="li-static-home">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-static-home-image"></div>
                <div class="li-static-home-content">
                    <p>Sale Offer<span>-20% Off</span>This Week</p>
                    <h2>Featured Product</h2>
                    <h2>Sanai Accessories 2018</h2>
                    <p class="schedule">
                        Starting at
                        <span> $1209.00</span>
                    </p>
                    <div class="default-btn">
                        <a href="shop-left-sidebar.html" class="links">Shopping Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="group-featured-product pt-60 pb-40 pb-xs-25">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="featured-product">
                    <div class="li-section-title">
                        <h2>
                            <span>Chamcham</span>
                        </h2>
                    </div>
                    <div class="featured-product-active-2 owl-carousel">
                        <div class="featured-product-bundle">
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/1.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/2.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/3.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="featured-product pt-sm-10 pt-xs-25">
                    <div class="li-section-title">
                        <h2>
                            <span>Meito</span>
                        </h2>
                    </div>
                    <div class="featured-product-active-2 owl-carousel">
                        <div class="featured-product-bundle">
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/4.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/5.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/6.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="featured-product pt-sm-10 pt-xs-25">
                    <div class="li-section-title">
                        <h2>
                            <span>Sanai</span>
                        </h2>
                    </div>
                    <div class="featured-product-active-2 owl-carousel">
                        <div class="featured-product-bundle">
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/6.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/4.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="group-featured-pro-wrapper">
                                    <div class="product-img">
                                        <a href="product-details.html">
                                            <img
                                                src="{{ asset('assets/frontend/assets/images/featured-product/2.jpg') }}">
                                        </a>
                                    </div>
                                    <div class="featured-pro-content">
                                        <div class="product-review">
                                            <h5 class="manufacturer">
                                                <a href="product-details.html">Studio Design</a>
                                            </h5>
                                        </div>
                                        <div class="rating-box">
                                            <ul class="rating">
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                                <li class="no-star"><i class="fa fa-star-o"></i></li>
                                            </ul>
                                        </div>
                                        <h4><a class="featured-product-name" href="single-product.html">Mug Today is a
                                                good day</a></h4>
                                        <div class="featured-price-box">
                                            <span class="new-price">$71.80</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection