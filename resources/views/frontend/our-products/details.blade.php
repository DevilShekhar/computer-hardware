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
            <a class="popup-img venobox vbox-item"
               href="{{ asset('storage/' . $image->image) }}"
               data-gall="myGallery">
                <img src="{{ asset('storage/' . $image->image) }}"
                     alt="{{ $product->name }}">
            </a>

            @if($product->is_discounted && $product->price > 0 && $product->sale_price && $product->sale_price < $product->price)
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
    @empty
        <div class="lg-image" style="position: relative;">
            <a class="popup-img venobox vbox-item"
               href="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
               data-gall="myGallery">
                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                     alt="{{ $product->name }}">
            </a>

            @if($product->is_discounted && $product->price > 0 && $product->sale_price && $product->sale_price < $product->price)
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
                            <img src="{{ asset('assets/frontend/assets/images/product/small-size/1.jpg') }}"  alt="{{ $product->name }}">
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
                                        <i class="fa {{ $product->stock_quantity > 0 ? 'fa-check-circle' : 'fa-times-circle' }}"></i>
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
                                        <input class="cart-plus-minus-box" name="quantity" value="1" type="text" min="1" max="{{ $product->stock_quantity }}">
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
                            <a data-toggle="tab" href="#reviews">
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
                <div class="product-details-manufacturer">
                    @if($product->productBrand)
                    <p>
                        <span>Brand</span>
                        {{ $product->productBrand->name }}
                    </p>
                    @endif
                    @if($product->sku)
                    <p>
                        <span>Reference</span>
                        {{ $product->sku }}
                    </p>
                    @endif
                    @if($product->category)
                    <p>
                        <span>Category</span>
                        {{ $product->category->name }}
                    </p>
                    @endif
                    @if($product->subCategory)
                    <p>
                        <span>Sub Category</span>
                        {{ $product->subCategory->name }}
                    </p>
                    @endif
                    @if($product->price !== null)
                    <p>
                        <span>Price</span>
                        ₹{{ number_format($product->price, 2) }}
                    </p>
                    @endif
                    @if($product->sale_price !== null)
                    <p>
                        <span>Sale Price</span>
                        ₹{{ number_format($product->sale_price, 2) }}
                    </p>
                    @endif
                    @if($product->hsn)
                    <p>
                        <span>HSN</span>
                        {{ $product->hsn }}
                    </p>
                    @endif
                    @if($product->warranty_information)
                    <p>
                        <span>Warranty</span>
                        {{ $product->warranty_information }}
                    </p>
                    @endif
                </div>
            </div>
            <div id="specifications" class="tab-pane" role="tabpanel">
                <div class="product-details-manufacturer">
                    @forelse($product->specifications as $specification)
                    <p>
                        <span>
                            {{ $specification->specification_name }}
                        </span>
                        {{ $specification->specification_value }}
                    </p>
                    @empty
                    <p>
                        No specifications available.
                    </p>
                    @endforelse
                </div>
            </div>
            <div id="reviews" class="tab-pane" role="tabpanel">
                <div class="product-reviews">
                    <div class="product-details-comment-block">
                        <div class="comment-review">
                            <span>Grade</span>
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
                                <li class="no-star">
                                    <i class="fa fa-star-o"></i>
                                </li>
                                <li class="no-star">
                                    <i class="fa fa-star-o"></i>
                                </li>
                            </ul>
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
                            <p>
                                No reviews available.
                            </p>
                        </div>
                        <div class="review-btn">
                            <a class="review-links" href="#" data-toggle="modal" data-target="#mymodal">
                                Write Your Review!
                            </a>
                        </div>
                        <div class="modal fade modal-wrapper" id="mymodal">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3 class="review-page-title">
                                            Write Your Review
                                        </h3>
                                        <div class="modal-inner-area row">
                                            <div class="col-lg-6">
                                                <div class="li-review-product">
                                                    @php
                                                        $reviewImage = $product->images->first();
                                                    @endphp
                                                    @if($reviewImage)
                                                        <img src="{{ asset('storage/' . $reviewImage->image) }}"  alt="{{ $product->name }}">
                                                    @endif
                                                    <div class="li-review-product-desc">
                                                        <p class="li-product-name">
                                                            {{ $product->name }}
                                                        </p>
                                                        @if($product->short_description)
                                                        <p>
                                                            <span>
                                                                {{ $product->short_description }}
                                                            </span>
                                                        </p>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div class="li-review-content">
                                                    <div class="feedback-area">
                                                        <div class="feedback">
                                                            <h3 class="feedback-title">
                                                                Our Feedback
                                                            </h3>
                                                            <form action="#">
                                                                <p class="your-opinion">
                                                                    <label>
                                                                        Your Rating
                                                                    </label>
                                                                    <span>
                                                                        <select class="star-rating">
                                                                            <option value="1">1</option>
                                                                            <option value="2">2</option>
                                                                            <option value="3">3</option>
                                                                            <option value="4">4</option>
                                                                            <option value="5">5</option>
                                                                        </select>
                                                                    </span>
                                                                </p>
                                                                <p class="feedback-form">
                                                                    <label for="feedback">
                                                                        Your Review
                                                                    </label>
                                                                    <textarea id="feedback" name="comment" cols="45" rows="8" aria-required="true"></textarea>
                                                                </p>
                                                                <div class="feedback-input">
                                                                    <p class="feedback-form-author">
                                                                        <label for="author">
                                                                            Name
                                                                            <span class="required">
                                                                                *
                                                                            </span>
                                                                        </label>
                                                                        <input id="author" name="author" value="" size="30" aria-required="true" type="text">
                                                                    </p>
                                                                    <p class="feedback-form-author feedback-form-email">
                                                                        <label for="email"> Email <span class="required"> *</span></label>
                                                                        <input id="email" name="email" value="" size="30" aria-required="true" type="text">
                                                                        <span class="required"><sub>*</sub> Required fields</span>
                                                                    </p>
                                                                    <div class="feedback-btn pb-15">
                                                                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                                                                            Close
                                                                        </a>
                                                                        <a href="#">
                                                                            Submit
                                                                        </a>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection