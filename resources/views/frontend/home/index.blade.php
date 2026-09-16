@extends('frontend.layouts.app')
@section('title', $meta_title)
@section('meta_keyword', $meta_keyword)
@section('meta_description', $meta_description)
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
                        @if($banner->title)
                            <h2>{{ $banner->title }}</h2>
                        @endif
                        @if($banner->short_description)
                            <h5>{{ $banner->short_description }}</h5>
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
<section class="team-area pt-60 pt-sm-44">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="li-section-title capitalize mb-25">
                    <h2><span>Our Brands</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="product-active owl-carousel">
                @forelse($productBrands as $productBrand)
                    <div class="col-lg-12">
                        <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                            <div class="team-thumb">
                                <a href="{{ route('our-brand.show', ['slug' => $productBrand->slug]) }}">
                                    @if($productBrand->product_brand_image)
                                        <img src="{{ asset('storage/' . $productBrand->product_brand_image) }}" alt="{{ $productBrand->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                    @else
                                        <img src="{{ asset('images/no-image.png') }}" alt="{{ $productBrand->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                    @endif
                                </a>
                            </div>
                            <div class="team-content text-center">
                                <h3>
                                    <a href="{{ route('our-brand.show', ['slug' => $productBrand->slug]) }}">{{ $productBrand->name }}</a>
                                </h3>
                                <p>
                                    <a href="{{ route('our-brand.show', ['slug' => $productBrand->slug]) }}">View Products</a>
                                </p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p>No brands available.</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
<section class="pc-builder-banner">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 col-md-6">
                <div class="pc-builder-content">
                    <h1>
                        Build Your <span>Dream PC</span>
                    </h1>
                    <h4>
                        Performance. Reliability. Built for You.
                    </h4>
                    <div class="pc-builder-line"></div>
                    <p class="pc-builder-description">
                        Build your perfect PC with genuine components, expert
                        guidance, and unbeatable prices. Only at
                        <strong>METAVERSE INFO</strong>
                    </p>
                    <div class="pc-builder-button">
                        <a href="{{ url('/pc-builder') }}">
                            Click Here to Build Your PC
                        </a>
                    </div>
                    <div class="pc-builder-features">
                        <div class="pc-feature">
                            <div class="pc-feature-icon">
                                <i class="fa fa-shield"></i>
                            </div>
                            <div class="pc-feature-content">
                                <span>Free</span>
                                <strong>Delivery</strong>
                            </div>
                        </div>
                        <div class="pc-feature-divider"></div>
                        <div class="pc-feature">
                            <div class="pc-feature-icon">
                                <i class="fa fa-lightbulb-o"></i>
                            </div>
                            <div class="pc-feature-content">
                                <span>Secure</span>
                                <strong>Payments</strong>
                            </div>
                        </div>
                        <div class="pc-feature-divider"></div>
                        <div class="pc-feature">
                            <div class="pc-feature-icon">
                                <i class="fa fa-headphones"></i>
                            </div>
                            <div class="pc-feature-content">
                                <span>Expert</span>
                                <strong>Support</strong>
                            </div>
                        </div>
                        <div class="pc-feature-divider"></div>
                        <div class="pc-feature">
                            <div class="pc-feature-icon">
                                <i class="fa fa-thumbs-up"></i>
                            </div>
                            <div class="pc-feature-content">
                                <span>Trusted by</span>
                                <strong>Thousands</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6">
                <div class="pc-builder-image">
                    <img src="{{ asset('assets/frontend/assets/images/pc-builder/pc-builder.png') }}" alt="Build Your Dream PC">
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
<section class="why-buy-section">
    <div class="container">
        <div class="why-buy-heading text-center">
            <h2>Why Buy From METAVERSE INFO?</h2>
            <p>
                Your trusted destination for genuine PC products,
                custom builds and instant digital gift cards.
            </p>
        </div>
        <div class="row why-buy-row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h3>100% Genuine Products</h3>
                    <p>
                        Only authentic products guaranteed.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-truck"></i>
                    </div>
                    <h3>Free Shipping</h3>
                    <p>
                        Free shipping on all products across India.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-bolt"></i>
                    </div>
                    <h3>Instant Digital Delivery</h3>
                    <p>
                        Digital codes delivered instantly.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-file-text"></i>
                    </div>
                    <h3>GST Invoice</h3>
                    <p>
                        GST invoice is available with every order.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-credit-card"></i>
                    </div>
                    <h3>Secure Payments</h3>
                    <p>
                        Safe &amp; secure payment options.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-video-camera"></i>
                    </div>
                    <h3>Live Product Demo</h3>
                    <p>
                        Experience the product before you buy.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-dropbox"></i>
                    </div>
                    <h3>Secure Packaging</h3>
                    <p>
                        Video recorded before dispatch.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-buy-card">
                    <div class="why-buy-icon">
                        <i class="fa fa-undo"></i>
                    </div>
                    <h3>Easy Returns</h3>
                    <p>
                        Hassle-free returns on eligible products.
                    </p>
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
<section class="why-choose-section">
    <div class="container">
        <div class="why-choose-heading">
            <h2>Why Choose Us</h2>
        </div>
        <div class="row why-choose-row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <i class="fa fa-exchange"></i>
                    </div>
                    <h3>Fast Delivery</h3>
                    <p>
                        Quick and reliable shipping to your
                        doorstep within 3-5 business days.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <i class="fa fa-shield"></i>
                    </div>
                    <h3>Secure Payment</h3>
                    <p>
                        Your transactions are protected with
                        industry-leading security protocols.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <i class="fa fa-life-ring"></i>
                    </div>
                    <h3>24/7 Support</h3>
                    <p>
                        Our customer service team is always
                        here to help you with any questions.
                    </p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="why-choose-card">
                    <div class="why-choose-icon">
                        <i class="fa fa-certificate"></i>
                    </div>
                    <h3>100% New &amp; Genuine</h3>
                    <p>
                        All our products are 100% brand new
                        with official brand warranty.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End PC Builder Banner -->
<div class="counterup-area">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <!-- Begin Limupa Counter Area -->
                <div class="limupa-counter white-smoke-bg">
                    <div class="container">
                        <div class="counter-img">
                            <img src="{{ asset('assets/frontend/assets/images/about-us/icon/1.png')}}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-number">
                                <h3 class="counter">2169</h3>
                            </div>
                            <div class="counter-text">
                                <span>HAPPY CUSTOMERS</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/2.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">869</h3>
                        </div>
                        <div class="counter-text">
                            <span>AWARDS WINNED</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter white-smoke-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/3.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">689</h3>
                        </div>
                        <div class="counter-text">
                            <span>HOURS WORKED</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/4.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">2169</h3>
                        </div>
                        <div class="counter-text">
                            <span>COMPLETE PROJECTS</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
        </div>
    </div>
</div>
@endsection