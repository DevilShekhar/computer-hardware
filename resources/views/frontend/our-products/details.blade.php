@extends('frontend.layouts.app')
@section('title', $product->name)
@section('content')
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li>
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li>
                    <a href="{{ route('our-products') }}">Our Products</a>
                </li>
                <li class="active">
                    {{ $product->name }}
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="content-wraper">
    <div class="container">
        <div class="row single-product-area">
            <div class="col-lg-5 col-md-6">
                <div class="product-details-left">
                    <div class="product-details-images slider-navigation-1">
                        @forelse($product->images as $image)
                        <div class="lg-image" style="position: relative;">
                            <a class="popup-img venobox vbox-item" href="{{ asset('storage/' . $image->image) }}"
                                data-gall="myGallery">
                                <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}">
                            </a>
                            @if($product->is_discounted && $product->price > 0 && $product->sale_price &&
                            $product->sale_price < $product->price)
                                @php
                                $discountPercentage = (($product->price - $product->sale_price) / $product->price) *
                                100;
                                @endphp
                                <span class="product-discount-badge">
                                    <span class="discount-percentage">
                                        {{ round($discountPercentage) }}%
                                    </span>
                                </span>
                                @endif
                        </div>
                        @empty
                        <div class="lg-image" style="position: relative;">
                            <a class="popup-img venobox vbox-item"  href="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"  data-gall="myGallery">
                                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                            </a>
                            @if($product->is_discounted && $product->price > 0 && $product->sale_price &&  $product->sale_price < $product->price)
                                @php
                                $discountPercentage = (($product->price - $product->sale_price) / $product->price) * 100;
                                @endphp
                                <span class="product-discount-badge">
                                    <span class="discount-percentage">
                                        {{ round($discountPercentage) }}%
                                    </span>
                                </span>
                                @endif
                        </div>
                        @endforelse
                    </div>
                    <div class="product-details-thumbs slider-thumbs-1">
                        @forelse($product->images as $image)
                        <div class="sm-image">
                            <img src="{{ asset('storage/' . $image->image) }}" alt="{{ $product->name }}">
                        </div>
                        @empty
                        <div class="sm-image">
                            <img src="{{ asset('assets/frontend/assets/images/product/small-size/1.jpg') }}" alt="{{ $product->name }}">
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
            <div class="col-lg-7 col-md-6">
                <div class="product-details-view-content pt-60">
                    <div class="product-info">
                        @if($product->productBrand)
                        <span class="product-details-ref">
                            {{ $product->productBrand->name }}
                        </span>
                        @endif
                        <h2>
                            {{ $product->name }}
                        </h2>
                        @if($product->sku)
                        <span class="product-details-ref">
                            Reference: {{ $product->sku }}
                        </span>
                        @endif
                        <div class="rating-box pt-20">
                            <ul class="rating rating-with-review-item">
                                <li>
                                    <i class="fa fa-star-o"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star-o"></i>
                                </li>
                                <li>
                                    <i class="fa fa-star-o"></i>
                                </li>
                                <li class="no-star">
                                    <i class="fa fa-star-o"></i>
                                </li>
                                <li class="no-star">
                                    <i class="fa fa-star-o"></i>
                                </li>
                            </ul>
                        </div>
                        <div class="price-box pt-20">
                            @if($product->sale_price)
                            <span class="new-price new-price-2 sale-price">
                                ₹{{ number_format($product->sale_price, 2) }}
                            </span>
                            <span class="old-price original-price">
                                ₹{{ number_format($product->price, 2) }}
                            </span>
                            @if($product->price > 0)
                            @php
                            $discountPercentage = (($product->price - $product->sale_price) / $product->price) * 100;
                            @endphp
                            <span class="discount-percentage">
                                -{{ round($discountPercentage) }}%
                            </span>
                            @endif
                            @else
                            <span class="new-price new-price-2">
                                ₹{{ number_format($product->price, 2) }}
                            </span>
                            @endif
                        </div>
                        @if($product->short_description)
                        <div class="product-desc">
                            <p>
                                <span>
                                    {{ $product->short_description }}
                                </span>
                            </p>
                        </div>
                        @endif
                        <div class="product-details-meta">
                            <div class="product-meta-header">
                                <h4>Product Information</h4>
                            </div>
                            <div class="product-meta-grid">
                                @if($product->category)
                                <div class="product-meta-item">
                                    <span class="meta-label">Category</span>
                                    <span class="meta-value">
                                        {{ $product->category->name }}
                                    </span>
                                </div>
                                @endif
                                @if($product->subCategory)
                                <div class="product-meta-item">
                                    <span class="meta-label">Sub Category</span>
                                    <span class="meta-value">
                                        {{ $product->subCategory->name }}
                                    </span>
                                </div>
                                @endif
                                <div class="product-meta-item">
                                    <span class="meta-label">Availability</span>
                                    <span class="meta-value availability-value {{ $product->stock_quantity > 0 ? 'in-stock' : 'out-stock' }}">
                                        <i
                                            class="fa {{ $product->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
                                        {{ $product->stock_quantity > 0 ? 'In Stock' : 'Out of Stock' }}
                                    </span>
                                </div>
                                @if($product->hsn)
                                <div class="product-meta-item">
                                    <span class="meta-label">HSN Code</span>
                                    <span class="meta-value">
                                        {{ $product->hsn }}
                                    </span>
                                </div>
                                @endif
                                @if(!is_null($product->warranty_information))
                                <div class="product-meta-item product-meta-full">
                                    <span class="meta-label">Warranty</span>
                                    <span class="meta-value">
                                        {{ $product->warranty_information }}
                                    </span>
                                </div>
                                @endif
                                @if($product->sku)
                                <div class="product-meta-item product-meta-full">
                                    <span class="meta-label">SKU</span>
                                    <span class="meta-value">
                                        {{ $product->sku }}
                                    </span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="single-add-to-cart">
                            <form action="{{ url('/cart/add/' . $product->id) }}" method="POST" class="cart-quantity">
                                @csrf
                                <div class="quantity">
                                    <label>Quantity</label>
                                    <div class="cart-plus-minus">
                                        <input class="cart-plus-minus-box" name="quantity" value="1" type="text" min="1"
                                            max="{{ $product->stock_quantity }}">
                                        <div class="dec qtybutton">
                                            <i class="fa fa-angle-down"></i>
                                        </div>
                                        <div class="inc qtybutton">
                                            <i class="fa fa-angle-up"></i>
                                        </div>
                                    </div>
                                </div>
                                <button class="add-to-cart" type="submit" @if($product->stock_quantity <= 0) disabled
                                        @endif>
                                        @if($product->stock_quantity > 0)
                                        Add to cart
                                        @else
                                        Out of stock
                                        @endif
                                </button>
                            </form>
                        </div>
                        <div class="product-additional-info pt-25">
                            <a class="wishlist-btn" href="#">
                                <i class="fa fa-heart-o"></i>
                                Add to wishlist
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="product-area pt-35">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-product-tab">
                    <ul class="nav li-product-menu">
                        <li>
                            <a class="active" data-toggle="tab" href="#description">
                                <span>Description</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#product-details">
                                <span>Product Details</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#specifications">
                                <span>Specifications</span>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#reviews" id="reviews-tab">
                                <span>Reviews</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="tab-content">
            <div id="description" class="tab-pane active show" role="tabpanel">
                <div class="product-description">
                    @if($product->description)
                    {!! $product->description !!}
                    @else
                    <span>
                        No description available.
                    </span>
                    @endif
                </div>
            </div>
            <div id="product-details" class="tab-pane" role="tabpanel">
                <div class="product-details-card">
                    <div class="product-details-layout">
                        <div class="product-details-left">
                            <div class="product-details-image">
                                @php
                                $primaryImage = $product->images->where('is_primary', true)->first();
                                if (!$primaryImage) {
                                $primaryImage = $product->images->first();
                                }
                                @endphp
                                @if($primaryImage && $primaryImage->image)
                                <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $product->name }}">
                                @else
                                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}" alt="{{ $product->name }}">
                                @endif
                            </div>
                            @if($product->price !== null)
                            <div class="product-price-card">
                                <div class="product-price-item">
                                    <span class="price-icon">
                                        <i class="fa fa-tag"></i>
                                    </span>
                                    <div>
                                        <span class="price-label">PRICE</span>
                                        <strong>
                                            ₹{{ number_format($product->price, 2) }}
                                        </strong>
                                    </div>
                                </div>
                                @if($product->sale_price !== null && $product->sale_price > 0 && $product->sale_price <
                                    $product->price)
                                    <div class="product-sale-price-item">
                                        <span class="price-icon">
                                            <i class="fa fa-tag"></i>
                                        </span>
                                        <div>
                                            <span class="price-label">SALE PRICE</span>
                                            <strong>
                                                ₹{{ number_format($product->sale_price, 2) }}
                                            </strong>
                                        </div>
                                    </div>
                                    @endif
                            </div>
                            @endif
                        </div>
                        <div class="product-details-right">
                            @if($product->productBrand)
                            <div class="product-detail-row">
                                <div class="product-detail-icon">
                                    <i class="fa fa-tag"></i>
                                </div>
                                <div class="product-detail-label">
                                    Brand
                                </div>
                                <div class="product-detail-colon">
                                    :
                                </div>
                                <div class="product-detail-value">
                                    {{ $product->productBrand->name }}
                                </div>
                            </div>
                            @endif
                            @if($product->sku)
                            <div class="product-detail-row">
                                <div class="product-detail-icon">
                                    <i class="fa fa-barcode"></i>
                                </div>
                                <div class="product-detail-label">
                                    Reference
                                </div>
                                <div class="product-detail-colon">
                                    :
                                </div>
                                <div class="product-detail-value">
                                    {{ $product->sku }}
                                </div>
                            </div>
                            @endif
                            @if($product->category)
                            <div class="product-detail-row">
                                <div class="product-detail-icon">
                                    <i class="fa fa-th-large"></i>
                                </div>
                                <div class="product-detail-label">
                                    Category
                                </div>
                                <div class="product-detail-colon">
                                    :
                                </div>
                                <div class="product-detail-value">
                                    {{ $product->category->name }}
                                </div>
                            </div>
                            @endif
                            @if($product->subCategory)
                            <div class="product-detail-row">
                                <div class="product-detail-icon">
                                    <i class="fa fa-th-list"></i>
                                </div>
                                <div class="product-detail-label">
                                    Sub Category
                                </div>
                                <div class="product-detail-colon">
                                    :
                                </div>
                                <div class="product-detail-value">
                                    {{ $product->subCategory->name }}
                                </div>
                            </div>
                            @endif
                            @if($product->price !== null)
                            <div class="product-detail-row">
                                <div class="product-detail-icon">
                                    <i class="fa fa-inr"></i>
                                </div>
                                <div class="product-detail-label">
                                    Price
                                </div>
                                <div class="product-detail-colon">
                                    :
                                </div>
                                <div class="product-detail-value">
                                    ₹{{ number_format($product->price, 2) }}
                                </div>
                            </div>
                            @endif
                            @if($product->sale_price !== null && $product->sale_price > 0 && $product->sale_price <
                                $product->price)
                                <div class="product-detail-row sale-row">
                                    <div class="product-detail-icon">
                                        <i class="fa fa-inr"></i>
                                    </div>
                                    <div class="product-detail-label">
                                        Sale Price
                                    </div>
                                    <div class="product-detail-colon">
                                        :
                                    </div>
                                    <div class="product-detail-value">
                                        ₹{{ number_format($product->sale_price, 2) }}
                                    </div>
                                </div>
                                @endif
                                @if($product->hsn)
                                <div class="product-detail-row">
                                    <div class="product-detail-icon">
                                        <i class="fa fa-file-text-o"></i>
                                    </div>
                                    <div class="product-detail-label">
                                        HSN
                                    </div>
                                    <div class="product-detail-colon">
                                        :
                                    </div>
                                    <div class="product-detail-value">
                                        {{ $product->hsn }}
                                    </div>
                                </div>
                                @endif
                                @if($product->warranty_information)
                                <div class="product-detail-row">
                                    <div class="product-detail-icon">
                                        <i class="fa fa-shield"></i>
                                    </div>
                                    <div class="product-detail-label">
                                        Warranty
                                    </div>
                                    <div class="product-detail-colon">
                                        :
                                    </div>
                                    <div class="product-detail-value">
                                        {{ $product->warranty_information }}
                                    </div>
                                </div>
                                @endif
                        </div>
                    </div>
                </div>
            </div>
            <div id="specifications" class="tab-pane" role="tabpanel">
                <div class="product-details-card">
                    <div class="product-details-right">@forelse($product->specifications as $specification)<div
                            class="product-detail-row">
                            <div class="product-detail-icon"><i class="fa fa-cog"></i></div>
                            <div class="product-detail-label">{{ $specification->specification_name }}</div>
                            <div class="product-detail-colon">:</div>
                            <div class="product-detail-value">{{ $specification->specification_value }}</div>
                        </div>@empty<p>No specifications available.</p>@endforelse</div>
                </div>
            </div>
            <div id="reviews" class="tab-pane" role="tabpanel">
                <div class="product-reviews">
                    <div class="product-details-comment-block">
                        @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                        @endif
                        @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                        @endif
                        @php
                            $reviewCount = $product->reviews->count();
                            $averageRating = $reviewCount > 0 ? round($product->reviews->avg('rating'), 1) : 0;
                        @endphp
                        <div class="comment-review">
                            <span>Grade</span>
                            <ul class="rating">
                                @for($i = 1; $i <= 5; $i++)
                                <li>
                                    <i class="fa {{ $i <= round($averageRating) ? 'fa-star' : 'fa-star-o' }}"></i>
                                </li>
                                @endfor
                            </ul>
                            @if($reviewCount > 0)
                            <span>{{ $averageRating }}/5 ({{ $reviewCount }} {{ $reviewCount == 1 ? 'Review' : 'Reviews' }})</span>
                            @else
                            <span>No reviews yet</span>
                            @endif
                        </div>
                        <div class="comment-author-infos pt-25">
                            <span>
                                {{ $product->name }}
                            </span>
                        </div>
                        <div class="comment-details">
                            <h4 class="title-block">
                                Customer Reviews
                            </h4>
                            @forelse($product->reviews->sortByDesc('created_at') as $review)
                            <div class="customer-review-item">
                                <div class="customer-review-header">
                                    <strong>{{ $review->user->name }}</strong>
                                    <span>
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fa {{ $i <= $review->rating ? 'fa-star' : 'fa-star-o' }}"></i>
                                        @endfor
                                    </span>
                                </div>
                                <p>
                                    {{ $review->comment }}
                                </p>
                                <small>
                                    {{ $review->created_at->format('d M Y') }}
                                </small>
                            </div>
                            @empty
                            <p>
                                No reviews available.
                            </p>
                            @endforelse
                        </div>
                        <div class="review-btn">
                            @auth
                                @php
                                    $userReview = $product->reviews->where('user_id', auth()->id())->first();
                                @endphp
                                @if($userReview)
                                <p>You have already reviewed this product.</p>
                                @else
                                <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">
                                    Write Your Review!
                                </a>
                                @endif
                            @else
                                <a class="review-links" href="{{ route('login.for.review', ['slug' => $product->slug]) }}">
                                    Login to Write a Review
                                </a>
                            @endauth
                        </div>
                        @auth
                        @php
                            $userReview = $product->reviews->where('user_id', auth()->id())->first();
                        @endphp

                        @if(!$userReview)
                        <div class="modal fade modal-wrapper" id="mymodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3 class="review-page-title">
                                            Write Your Review
                                        </h3>
                                        <div class="modal-inner-area row">
                                            <div class="col-lg-12">
                                                <div class="li-review-content">
                                                    <div class="feedback-area">
                                                        <div class="feedback">
                                                            <h3 class="feedback-title">
                                                                Our Feedback
                                                            </h3>
                                                            <form action="{{ route('reviews.store') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                                                <p class="your-opinion">
                                                                    <label>
                                                                        Your Rating
                                                                    </label>
                                                                    <span>
                                                                        <select class="star-rating" name="rating" required>
                                                                            <option value="5">5</option>
                                                                            <option value="4">4</option>
                                                                            <option value="3">3</option>
                                                                            <option value="2">2</option>
                                                                            <option value="1">1</option>
                                                                        </select>
                                                                    </span>
                                                                </p>
                                                                <p class="feedback-form">
                                                                    <label for="feedback">
                                                                        Your Review
                                                                    </label>
                                                                    <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true" required></textarea>
                                                                </p>
                                                                <div class="feedback-input">
                                                                    <p class="feedback-form-author">
                                                                        <label>
                                                                            Name
                                                                        </label>
                                                                        <input value="{{ auth()->user()->name }}" size="30" type="text" readonly>
                                                                    </p>
                                                                    <p class="feedback-form-author feedback-form-email">
                                                                        <label>
                                                                            Email
                                                                        </label>
                                                                        <input value="{{ auth()->user()->email }}" size="30" type="email" readonly>
                                                                    </p>
                                                                    <div class="feedback-btn pb-15">
                                                                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            Close
                                                                        </a>
                                                                        <button type="submit" class="li-btn-3 review-links">
                                                                            Submit
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@if($relatedProducts->count() > 0)
<section class="product-area li-laptop-product pt-60 pb-45 pt-sm-50 pt-xs-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="li-section-title">
                    <h2><span>Related Products</span></h2>
                </div>
                <div class="row">
                    <div class="product-active owl-carousel">
                        @foreach($relatedProducts as $relatedProduct)
                        @php
                        $primaryImage = $relatedProduct->images->where('is_primary', true)->first();
                        if (!$primaryImage) {
                        $primaryImage = $relatedProduct->images->first();
                        }
                        $hasDiscount = $relatedProduct->price > 0 && $relatedProduct->sale_price !== null &&
                        $relatedProduct->sale_price > 0 && $relatedProduct->sale_price < $relatedProduct->price;
                            $discountPercentage = 0;
                            if ($hasDiscount) {
                            $discountPercentage = round(
                            (($relatedProduct->price - $relatedProduct->sale_price)
                            / $relatedProduct->price) * 100
                            );
                            }
                            @endphp
                            <div class="col-lg-12">
                                <div class="single-product-wrap">
                                    <div class="product-image">
                                        <a href="{{ route('product.details', ['slug' => $relatedProduct->slug]) }}">
                                            @if($primaryImage && $primaryImage->image)
                                            <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                                alt="{{ $relatedProduct->name }}">
                                            @else
                                            <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                                                alt="{{ $relatedProduct->name }}">
                                            @endif
                                        </a>
                                        @if($hasDiscount && $discountPercentage > 0)
                                        <span class="sticker">
                                            -{{ $discountPercentage }}%
                                        </span>
                                        @endif
                                    </div>
                                    <div class="product_desc">
                                        <div class="product_desc_info">
                                            <div class="product-review">
                                                <h5 class="manufacturer">
                                                    @if($relatedProduct->productBrand)
                                                    <a href="#">
                                                        {{ $relatedProduct->productBrand->name }}
                                                    </a>
                                                    @else
                                                    <a href="#">
                                                        Product
                                                    </a>
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
                                                <a class="product_name"
                                                    href="{{ route('product.details', ['slug' => $relatedProduct->slug]) }}">
                                                    {{ $relatedProduct->name }}
                                                </a>
                                            </h4>
                                            <div class="price-box">
                                                @if($hasDiscount)
                                                <span class="new-price new-price-2 sale-price">
                                                    ₹{{ number_format($relatedProduct->sale_price, 2) }}
                                                </span>
                                                <span class="old-price original-price">
                                                    ₹{{ number_format($relatedProduct->price, 2) }}
                                                </span>
                                                @else
                                                <span class="new-price">
                                                    ₹{{ number_format($relatedProduct->price, 2) }}
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="add-actions">
                                            <ul class="add-actions-link">
                                                <li class="add-cart active">
                                                    <a href="{{ url('/cart/add/' . $relatedProduct->id) }}">
                                                        Add to cart
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="links-details" href="#">
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="quick-view"
                                                        href="{{ route('product.details', ['slug' => $relatedProduct->slug]) }}">
                                                        <i class="fa fa-eye"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@if(request()->get('review') == 1)
<script>
document.addEventListener('DOMContentLoaded',function(){
    $('#reviews-tab').tab('show');
    setTimeout(function(){
        document.getElementById('reviews').scrollIntoView({
            behavior:'smooth',
            block:'start'
        });
    },300);
});
</script>
@endif
@else
@endif
@endsection