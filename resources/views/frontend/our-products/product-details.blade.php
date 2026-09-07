@extends('frontend.layouts.app')

@section('title', 'Our Brand')

@section('content')

<!-- Begin Li's Content Wraper Area -->
<div class="content-wraper pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <!-- shop-products-wrapper start -->
                <div class="shop-products-wrapper">
                    <div class="tab-content">
                        {{-- GRID VIEW - Active by default --}}
                        <div id="grid-view" class="tab-pane fade active show" role="tabpanel">
                            <div class="product-area shop-product-area">
                                <div class="row">
                                    @if($products->count())
                                        @foreach($products as $product)
                                            @php
                                                $primaryImage = $product->images->where('is_primary', true)->first();
                                                if (!$primaryImage) {
                                                    $primaryImage = $product->images->first();
                                                }
                                                $hasDiscount = $product->price > 0 && $product->sale_price && $product->sale_price < $product->price;
                                                $discountPercentage = $hasDiscount ? round((($product->price - $product->sale_price) / $product->price) * 100) : 0;
                                            @endphp

                                            {{-- GRID PRODUCT CARD - 3 columns --}}
                                            <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                                <div class="single-product-wrap">
                                                    <div class="product-image">
                                                        <a href="{{ route('product.details', $product->slug) }}">
                                                            @if($primaryImage && $primaryImage->image)
                                                                <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                                                     alt="{{ $product->name }}"
                                                                     width="280"
                                                                     height="280">
                                                            @else
                                                                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                                                                     alt="{{ $product->name }}"
                                                                     width="280"
                                                                     height="280">
                                                            @endif
                                                        </a>
                                                        @if($product->is_new ?? false)
                                                            <span class="sticker">New</span>
                                                        @endif
                                                        @if($hasDiscount)
                                                            <span class="sticker">-{{ $discountPercentage }}%</span>
                                                        @endif
                                                    </div>
                                                    <div class="product_desc">
                                                        <div class="product_desc_info">
                                                            <div class="product-review">
                                                                <h5 class="manufacturer">
                                                                    <a href="#">{{ $product->productBrand->name ?? 'Graphic Corner' }}</a>
                                                                </h5>
                                                                <div class="rating-box">
                                                                    <ul class="rating">
                                                                        @for($i = 1; $i <= 5; $i++)
                                                                            <li class="{{ $i <= ($product->rating ?? 0) ? '' : 'no-star' }}">
                                                                                <i class="fa fa-star-o"></i>
                                                                            </li>
                                                                        @endfor
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <h4>
                                                                <a class="product_name" href="{{ route('product.details', $product->slug) }}">
                                                                    {{ Str::limit($product->name, 30) }}
                                                                </a>
                                                            </h4>
                                                            <div class="price-box">
                                                                @if($hasDiscount)
                                                                    <span class="new-price new-price-2">₹{{ number_format($product->sale_price, 2) }}</span>
                                                                    <span class="old-price">
                                                                        ₹{{ number_format($product->price, 2) }}
                                                                    </span>
                                                                @else
                                                                    <span class="old-price">₹{{ number_format($product->price, 2) }}</span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="add-actions">
                                                            <ul class="add-actions-link">
                                                                <li class="add-cart active" style="color">
                                                                    <a href="{{ url('/cart/add/' . $product->id) }}">Add to cart</a>
                                                                </li>
                                                                <li>
                                                                    <a class="quick-view"
                                                                        href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                                        <i class="fa fa-eye"></i>
                                                                    </a>
                                                                </li>
                                                                <li>
                                                                    <a class="links-details" href="#">
                                                                        <i class="fa fa-heart-o"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach

                                        {{-- Pagination --}}
                                        <div class="col-12">
                                            <div class="paginatoin-area">
                                                <div class="row">
                                                    <div class="col-lg-6 col-md-6">
                                                        <p>Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} item(s)</p>
                                                    </div>
                                                    <div class="col-lg-6 col-md-6">
                                                        {{ $products->links('pagination::bootstrap-4') }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <div class="col-12">
                                            <p class="text-muted">No products found for this brand.</p>
                                        </div>
                                    @endif
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
