@extends('frontend.layouts.app')
@section('title', 'Our Products')
@section('content')
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>

                <li class="active">
                    Our Products
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="shop-product-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2>
                        <span>Our Products</span>
                    </h2>
                </div>
                <div class="row">
                    @forelse($products as $product)
                        @php
                            $primaryImage = $product->images
                                ->where('is_primary', true)
                                ->first();
                            if (!$primaryImage) {
                                $primaryImage = $product->images->first();
                            }
                        @endphp
                        <div class="col-lg-3 col-md-4 col-sm-6 mb-30">
                            <div class="single-product-wrap">
                                <div class="product-image">
                                    <a href="{{ route('product.details', $product->slug) }}">
                                        @if($primaryImage && $primaryImage->image)
                                            <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $product->name }}">
                                        @else
                                            <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                        @endif
                                    </a>
                                    @if($product->is_discounted)
                                        <span class="sticker">Sale</span>
                                    @else
                                        <span class="sticker">New</span>
                                    @endif
                                </div>
                                <div class="product_desc">
                                    <div class="product_desc_info">
                                        <div class="product-review">
                                            @if($product->productBrand)
                                                <h5 class="manufacturer">
                                                    <a href="#">
                                                        {{ $product->productBrand->name }}
                                                    </a>
                                                </h5>
                                            @endif
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
                                            <a class="product_name" href="{{ route('product.details', $product->slug) }}">
                                                {{ $product->name }}
                                            </a>
                                        </h4>
                                        <div class="price-box">
                                            @if($product->sale_price)
                                                <span class="new-price new-price-2">
                                                    ₹{{ number_format($product->sale_price, 2) }}
                                                </span>
                                                <span class="old-price">
                                                    ₹{{ number_format($product->price, 2) }}
                                                </span>
                                                @if($product->price > 0)
                                                    @php
                                                        $discountPercentage =
                                                            (($product->price - $product->sale_price)
                                                            / $product->price) * 100;
                                                    @endphp
                                                    <span class="discount-percentage">
                                                        -{{ round($discountPercentage) }}%
                                                    </span>
                                                @endif
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
                                                <a class="links-details" href="#">
                                                    <i class="fa fa-heart-o"></i>
                                                </a>
                                            </li>
                                            <li>
                                                <a class="quick-view" href="{{ route('product.details', $product->slug) }}">
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
                                <h4>
                                    No products available.
                                </h4>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
@endsection