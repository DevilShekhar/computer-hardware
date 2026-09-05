@extends('frontend.layouts.app')
@section('title', 'Our Products')
@section('content')
<style>
.product-filter-sidebar {
    background: #fff;
    border: 1px solid #e8e8e8;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 3px 15px rgba(0, 0, 0, 0.04);
}

.product-filter-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 18px 20px;
    background: #fff;
    border-bottom: 1px solid #ededed;
}

.product-filter-header-left {
    display: flex;
    align-items: center;
    gap: 10px;
}

.product-filter-header-icon {
    width: 34px;
    height: 34px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f5f5f5;
    border-radius: 6px;
    color: #222;
    font-size: 15px;
}

.product-filter-header h2 {
    margin: 0;
    color: #222;
    font-size: 17px;
    font-weight: 600;
    text-transform: none;
}

.product-filter-header small {
    display: block;
    margin-top: 2px;
    color: #999;
    font-size: 11px;
}

.product-filter-body {
    padding: 8px 0 0;
}

.product-filter-tree {
    margin: 0;
    padding: 0 14px 10px;
    list-style: none;
}

.product-filter-tree,
.product-filter-tree ul {
    list-style: none;
}

.product-filter-tree li {
    list-style: none;
    margin: 0;
    padding: 0;
}

.product-filter-tree .brand-item {
    margin-bottom: 2px;
}

.product-filter-tree .filter-brand,
.product-filter-tree .filter-category,
.product-filter-tree .filter-sub-category {
    position: relative;
    display: flex;
    align-items: center;
    width: 100%;
    text-decoration: none;
    cursor: pointer;
    transition: all 0.2s ease;
    border-radius: 6px;
}

.product-filter-tree .filter-brand {
    min-height: 43px;
    padding: 7px 10px;
    color: #555;
    font-size: 14px;
    font-weight: 500;
}

.product-filter-tree .filter-brand:hover {
    background: #f7f7f7;
    color: #111;
}

.product-filter-tree .filter-brand.active {
    background: #f3f7ff;
    color: #111;
    font-weight: 600;
}

.product-filter-tree .filter-category {
    min-height: 39px;
    padding: 6px 10px;
    color: #555;
    font-size: 13.5px;
    font-weight: 500;
}

.product-filter-tree .filter-category:hover {
    background: #f8f8f8;
    color: #111;
}

.product-filter-tree .filter-category.active {
    background: #f6f6f6;
    color: #111;
    font-weight: 600;
}

.product-filter-tree .filter-sub-category {
    min-height: 35px;
    padding: 5px 10px;
    color: #777;
    font-size: 13px;
    font-weight: 400;
}

.product-filter-tree .filter-sub-category:hover {
    background: #fafafa;
    color: #222;
}

.product-filter-tree .filter-sub-category.active {
    background: #f3f7ff;
    color: #111;
    font-weight: 600;
}

.tree-arrow {
    position: relative;
    width: 25px;
    min-width: 25px;
    height: 25px;
    margin-right: 2px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 5px;
    transition: all 0.2s ease;
}

.tree-arrow:before {
    content: '';
    width: 6px;
    height: 6px;
    border-right: 1.5px solid #777;
    border-bottom: 1.5px solid #777;
    transform: rotate(-45deg);
    transition: transform 0.2s ease;
}

.brand-item.is-open>.filter-brand .tree-arrow,
.category-item.is-open>.filter-category .tree-arrow {
    background: #eeeeee;
}

.brand-item.is-open>.filter-brand .tree-arrow:before,
.category-item.is-open>.filter-category .tree-arrow:before {
    transform: rotate(45deg);
}

.tree-arrow.empty:before {
    display: none;
}

.tree-arrow.empty {
    background: transparent;
}

.filter-label {
    flex: 1;
    min-width: 0;
    line-height: 20px;
}

.filter-count {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 24px;
    height: 21px;
    padding: 0 6px;
    margin-left: 8px;
    border-radius: 12px;
    background: #f2f2f2;
    color: #888;
    font-size: 10px;
    font-weight: 500;
    line-height: 21px;
}

.filter-brand.active .filter-count,
.filter-category.active .filter-count,
.filter-sub-category.active .filter-count {
    background: #e7edf8;
    color: #555;
}

.category-tree,
.sub-category-tree {
    display: none;
    margin: 2px 0 4px;
    padding: 0 0 0 18px;
    border-left: 1px solid #e6e6e6;
}

.brand-item.is-open>.category-tree {
    display: block;
}

.category-item.is-open>.sub-category-tree {
    display: block;
}

.category-item {
    margin-bottom: 1px;
}

.sub-category-item {
    margin-bottom: 1px;
}

.sub-category-tree .filter-sub-category:before {
    content: '';
    width: 6px;
    height: 6px;
    margin-right: 10px;
    border-radius: 50%;
    background: #c8c8c8;
    flex-shrink: 0;
}

.sub-category-tree .filter-sub-category:hover:before,
.sub-category-tree .filter-sub-category.active:before {
    background: #555;
}

.filter-clear-area {
    margin: 4px 14px 14px;
    padding-top: 13px;
    border-top: 1px solid #ededed;
}

.btn-clear-all {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    width: 100%;
    min-height: 38px;
    padding: 7px 12px;
    border: 1px solid #dedede;
    border-radius: 6px;
    background: #fff;
    color: #666;
    font-size: 12px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
}

.btn-clear-all:hover {
    border-color: #222;
    background: #222;
    color: #fff;
}

.btn-clear-all i {
    font-size: 11px;
}

.filter-selected-info {
    display: none;
    margin: 0 14px 12px;
    padding: 9px 11px;
    border-radius: 6px;
    background: #f7f7f7;
    color: #777;
    font-size: 11px;
}

.filter-selected-info.show {
    display: block;
}

.filter-selected-info strong {
    color: #222;
    font-weight: 600;
}

@media (max-width: 991px) {
    .product-filter-sidebar {
        margin-top: 30px;
    }
}

@media (max-width: 575px) {
    .product-filter-header {
        padding: 15px;
    }

    .product-filter-tree {
        padding-left: 10px;
        padding-right: 10px;
    }

    .filter-clear-area {
        margin-left: 10px;
        margin-right: 10px;
    }
}
</style>
@php
$filterBrands = $allProducts
->pluck('productBrand')
->filter()
->unique('id')
->values();
@endphp
<div class="content-wraper pt-60 pb-60 pt-sm-30">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 order-2 order-lg-1">
                <div class="shop-sidebar">
                    <div class="product-filter-sidebar">
                        <div class="product-filter-header">
                            <div class="product-filter-header-left">
                                <div class="product-filter-header-icon">
                                    <i class="fa fa-sliders"></i>
                                </div>
                                <div>
                                    <h2>Shop by Brand</h2>
                                    <small>Select category to filter</small>
                                </div>
                            </div>
                        </div>
                        <div class="product-filter-body">
                            <div class="filter-selected-info" id="filterSelectedInfo">
                                Selected:
                                <strong id="filterSelectedText"></strong>
                            </div>
                            <ul id="productFilterTree" class="product-filter-tree">
                                @foreach($filterBrands as $brand)
                                @php
                                $brandProducts = $allProducts->filter(function ($product) use ($brand) {
                                return $product->productBrand &&
                                $product->productBrand->id == $brand->id;
                                });
                                $brandCategories = $brandProducts
                                ->pluck('category')
                                ->filter()
                                ->unique('id')
                                ->values();
                                $brandProductCount = $brandProducts->count();
                                @endphp
                                <li class="brand-item" data-brand-id="{{ $brand->id }}">
                                    <a href="javascript:void(0)" class="filter-brand" data-id="{{ $brand->id }}"
                                        data-name="{{ $brand->name }}" aria-expanded="false">
                                        @if($brandCategories->count())
                                        <span class="tree-arrow"></span>
                                        @else
                                        <span class="tree-arrow empty"></span>
                                        @endif
                                        <span class="filter-label">
                                            {{ $brand->name }}
                                        </span>
                                        <span class="filter-count">
                                            {{ $brandProductCount }}
                                        </span>
                                    </a>
                                    @if($brandCategories->count())
                                    <ul class="category-tree">
                                        @foreach($brandCategories as $category)
                                        @php
                                        $categoryProducts = $brandProducts->filter(function ($product) use ($category) {
                                        return $product->category &&
                                        $product->category->id == $category->id;
                                        });
                                        $subCategories = $categoryProducts
                                        ->pluck('subCategory')
                                        ->filter()
                                        ->unique('id')
                                        ->values();
                                        $categoryProductCount = $categoryProducts->count();
                                        @endphp
                                        <li class="category-item" data-brand-id="{{ $brand->id }}"
                                            data-category-id="{{ $category->id }}">
                                            <a href="javascript:void(0)" class="filter-category"
                                                data-id="{{ $category->id }}" data-brand-id="{{ $brand->id }}"
                                                data-name="{{ $category->name }}" aria-expanded="false">
                                                @if($subCategories->count())
                                                <span class="tree-arrow"></span>
                                                @else
                                                <span class="tree-arrow empty"></span>
                                                @endif
                                                <span class="filter-label">
                                                    {{ $category->name }}
                                                </span>
                                                <span class="filter-count">
                                                    {{ $categoryProductCount }}
                                                </span>
                                            </a>
                                            @if($subCategories->count())
                                            <ul class="sub-category-tree">
                                                @foreach($subCategories as $subCategory)
                                                @php
                                                $subCategoryProductCount = $categoryProducts->filter(function ($product)
                                                use ($subCategory) {
                                                return $product->subCategory &&
                                                $product->subCategory->id == $subCategory->id;
                                                })->count();
                                                @endphp
                                                <li class="sub-category-item" data-brand-id="{{ $brand->id }}"
                                                    data-category-id="{{ $category->id }}"
                                                    data-sub-category-id="{{ $subCategory->id }}">
                                                    <a href="javascript:void(0)" class="filter-sub-category"
                                                        data-id="{{ $subCategory->id }}"
                                                        data-brand-id="{{ $brand->id }}"
                                                        data-category-id="{{ $category->id }}"
                                                        data-name="{{ $subCategory->name }}">
                                                        <span class="filter-label">
                                                            {{ $subCategory->name }}
                                                        </span>
                                                        <span class="filter-count">
                                                            {{ $subCategoryProductCount }}
                                                        </span>
                                                    </a>
                                                </li>
                                                @endforeach
                                            </ul>
                                            @endif
                                        </li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </li>
                                @endforeach
                            </ul>
                            <div class="filter-clear-area">
                                <button type="button" class="btn-clear-all" id="clearFilters">
                                    <i class="fa fa-refresh"></i>
                                    <span>Clear All Filters</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <div class="shop-top-bar">
                    <div class="shop-bar-inner">
                        <div class="product-view-mode">
                            <ul class="nav shop-item-filter-list" role="tablist">
                                <li class="active" role="presentation">
                                    <a aria-selected="true" class="active show" data-toggle="tab" role="tab"
                                        href="#grid-view">
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
                            <span id="productCount">
                                Showing {{ $products->count() }} Products
                            </span>
                        </div>
                    </div>
                    <div class="product-select-box">
                        <div class="product-short">
                            <p>Sort By:</p>
                            <select id="productSort" class="form-control">
                                <option value="latest">
                                    Latest
                                </option>
                                <option value="name-asc">
                                    Name (A - Z)
                                </option>
                                <option value="name-desc">
                                    Name (Z - A)
                                </option>
                                <option value="price-asc">
                                    Price (Low &gt; High)
                                </option>
                                <option value="price-desc">
                                    Price (High &gt; Low)
                                </option>
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
                                    $primaryImage = $product->images
                                    ->where('is_primary', true)
                                    ->first() ?? $product->images->first();
                                    $hasDiscount = $product->sale_price &&
                                    $product->price > $product->sale_price;
                                    $discountPercentage = $hasDiscount
                                    ? round((($product->price - $product->sale_price) / $product->price) * 100)
                                    : null;
                                    @endphp
                                    <div class="col-lg-4 col-md-4 col-sm-6 mt-40">
                                        <div class="single-product-wrap">
                                            <div class="product-image">
                                                <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                    @if($primaryImage && $primaryImage->image)
                                                    <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                                        alt="{{ $product->name }}">
                                                    @else
                                                    <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                                                        alt="{{ $product->name }}">
                                                    @endif
                                                </a>
                                                @if($hasDiscount)
                                                <span class="sticker">
                                                    -{{ $discountPercentage }}%
                                                </span>
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
                                                        <a class="product_name"
                                                            href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                            {{ $product->name }}
                                                        </a>
                                                    </h4>
                                                    <div class="price-box">
                                                        @if($hasDiscount)
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
                                                            <a href="javascript:void(0)" class="compare-product"
                                                                data-id="{{ $product->id }}" title="Compare Product">
                                                                <i class="fa fa-exchange"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="links-details" href="#">
                                                                <i class="fa fa-heart-o"></i>
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="quick-view"
                                                                href="{{ route('product.details', ['slug' => $product->slug]) }}">
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
                                            <h4>
                                                No products available.
                                            </h4>
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
                                $primaryImage = $product->images
                                ->where('is_primary', true)
                                ->first() ?? $product->images->first();
                                $hasDiscount = $product->sale_price &&
                                $product->price > $product->sale_price;
                                @endphp
                                <div class="row product-layout-list mb-30">
                                    <div class="col-lg-3 col-md-5">
                                        <div class="product-image">
                                            <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                @if($primaryImage && $primaryImage->image)
                                                <img src="{{ asset('storage/' . $primaryImage->image) }}"
                                                    alt="{{ $product->name }}">
                                                @else
                                                <img src="{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}"
                                                    alt="{{ $product->name }}">
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
                                                    <a class="product_name"
                                                        href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </h4>
                                                <div class="price-box">
                                                    @if($hasDiscount)
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
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="shop-add-action mb-xs-30">
                                            <ul class="add-actions-link">
                                                <li class="add-cart">
                                                    <a href="{{ url('/cart/add/' . $product->id) }}">
                                                        Add to cart
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="javascript:void(0)" class="compare-product"
                                                        data-id="{{ $product->id }}" title="Compare Product">
                                                        <i class="fa fa-exchange"></i>
                                                        Compare
                                                    </a>
                                                </li>
                                                <li class="wishlist">
                                                    <a href="#">
                                                        <i class="fa fa-heart-o"></i>
                                                        Add to wishlist
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="quick-view"
                                                        href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                        <i class="fa fa-eye"></i>
                                                        View product
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="text-center py-5">
                                    <h4>
                                        No products available.
                                    </h4>
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
document.addEventListener('DOMContentLoaded', function() {
    let currentFilter = {
        brand: '',
        category: '',
        sub_category: '',
        sort: 'latest'
    };
    const productGrid =
        document.getElementById('productGrid');
    const productList =
        document.getElementById('productList');
    const productCount =
       document.getElementById('productCount');
    const productLoader =
        document.getElementById('productLoader');
    const productSort =
        document.getElementById('productSort');
    const filterTree =
        document.getElementById('productFilterTree');
    const filterSelectedInfo =
        document.getElementById('filterSelectedInfo');
    const filterSelectedText =
        document.getElementById('filterSelectedText');
    function escapeHtml(value) {
        const div =
            document.createElement('div');
        div.textContent =
            value ?? '';
        return div.innerHTML;
    }
    function formatPrice(value) {
        return Number(value ?? 0).toLocaleString(
            'en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            }
        );
    }
    function priceHtml(product) {
        if (product.has_discount) {
            return '<span class="new-price new-price-2">₹' +
                formatPrice(product.sale_price) +
                '</span>' +
                '<span class="old-price">₹' +
                formatPrice(product.price) +
                '</span>';
        }
        return '<span class="new-price">₹' +
            formatPrice(product.price) +
            '</span>';
    }

    function gridProduct(product) {
        let sticker = '';
        if (product.discount_percentage > 0) {
            sticker =
                '<span class="sticker">-' +
                product.discount_percentage +
                '%</span>';
        }
        return '<div class="col-lg-4 col-md-4 col-sm-6 mt-40">' +
            '<div class="single-product-wrap">' +
            '<div class="product-image">' +
            '<a href="' + product.detail_url + '">' +
            '<img src="' + product.image + '" alt="' + escapeHtml(product.name) + '">' +
            '</a>' +
            sticker +
            '</div>' +
            '<div class="product_desc">' +
            '<div class="product_desc_info">' +
            '<div class="product-review">' +
            '<h5 class="manufacturer">' +
            '<a href="#">' +
            escapeHtml(product.brand) +
            '</a>' +
            '</h5>' +
            '<div class="rating-box">' +
            '<ul class="rating">' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '<h4>' +
            '<a class="product_name" href="' + product.detail_url + '">' +
            escapeHtml(product.name) +
            '</a>' +
            '</h4>' +
            '<div class="price-box">' +
            priceHtml(product) +
            '</div>' +
            '</div>' +
            '<div class="add-actions">' +
            '<ul class="add-actions-link">' +
            '<li class="add-cart active">' +
            '<a href="' + product.cart_url + '">' +
            'Add to cart' +
            '</a>' +
            '</li>' +
            '<li>' +
            '<a class="compare-product" ' + 'href="javascript:void(0)" ' + 'data-id="' + product.id + '">' +
            '<i class="fa fa-exchange"></i>' +
            '</a>' +
            '</li>' +
            '<li>' +
            '<a class="links-details" href="#">' +
            '<i class="fa fa-heart-o"></i>' +
            '</a>' +
            '</li>' +
            '<li>' +
            '<a class="quick-view" href="' + product.detail_url + '">' +
            '<i class="fa fa-eye"></i>' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>';
    }
    function listProduct(product) {
        return '<div class="row product-layout-list mb-30">' +
            '<div class="col-lg-3 col-md-5">' +
            '<div class="product-image">' +
            '<a href="' + product.detail_url + '">' +
            '<img src="' + product.image + '" alt="' + escapeHtml(product.name) + '">' +
            '</a>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-5 col-md-7">' +
            '<div class="product_desc">' +
            '<div class="product_desc_info">' +
            '<div class="product-review">' +
            '<h5 class="manufacturer">' +
            '<a href="#">' +
             escapeHtml(product.brand) +
            '</a>' +
            '</h5>' +
            '<div class="rating-box">' +
            '<ul class="rating">' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '<li><i class="fa fa-star-o"></i></li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '<h4>' +
            '<a class="product_name" href="' + product.detail_url + '">' +
            escapeHtml(product.name) +
            '</a>' +
            '</h4>' +
            '<div class="price-box">' +
            priceHtml(product) +
            '</div>' +
            '</div>' +
            '</div>' +
            '</div>' +
            '<div class="col-lg-4">' +
            '<div class="shop-add-action mb-xs-30">' +
            '<ul class="add-actions-link">' +
            '<li class="add-cart">' +
            '<a href="' + product.cart_url + '">' +
            'Add to cart' +
            '</a>' +
            '</li>' +
            '<li>' +
            '<a href="javascript:void(0)" ' + 'class="compare-product" ' + 'data-id="' + product.id + '" ' +
            'title="Compare Product">' +
            '<i class="fa fa-exchange"></i>' +
            ' Compare' +
            '</a>' +
            '</li>' +
            '<li class="wishlist">' +
            '<a href="#">' +
            '<i class="fa fa-heart-o"></i>' +
            'Add to wishlist' +
            '</a>' +
            '</li>' +
            '<li>' +
            '<a class="quick-view" href="' + product.detail_url + '">' +
            '<i class="fa fa-eye"></i>' +
            'View product' +
            '</a>' +
            '</li>' +
            '</ul>' +
            '</div>' +
            '</div>' +
            '</div>';
    }
    function updateSelectedInfo(name) {
        if (!filterSelectedInfo ||
            !filterSelectedText) {
            return;
        }
        if (name) {
            filterSelectedText.textContent = name;
            filterSelectedInfo.classList.add(
                'show'
            );
        } else {
            filterSelectedText.textContent =
                '';
            filterSelectedInfo.classList.remove(
                'show'
            );
        }
    }

    function closeOtherBrands(currentBrandItem) {
        if (!filterTree) {
            return;
        }
        filterTree
            .querySelectorAll('.brand-item')
            .forEach(function(brandItem) {
                if (
                    brandItem !==
                    currentBrandItem
                ) {
                    brandItem.classList.remove(
                        'is-open'
                    );
                    const brandLink =
                        brandItem.querySelector(
                            '.filter-brand'
                        );
                    if (brandLink) {
                        brandLink.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                    brandItem
                        .querySelectorAll(
                            '.category-item'
                        )
                        .forEach(function(
                            categoryItem
                        ) {
                            categoryItem.classList.remove(
                                'is-open'
                            );
                            const categoryLink =
                                categoryItem.querySelector(
                                    '.filter-category'
                                );
                            if (categoryLink) {
                                categoryLink.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );
                            }
                        });
                }
            });
    }

    function closeOtherCategories(
        currentCategoryItem
    ) {
        if (!currentCategoryItem) {
            return;
        }
        const parentBrand =
            currentCategoryItem.closest(
                '.brand-item'
            );
        if (!parentBrand) {
            return;
        }
        parentBrand
            .querySelectorAll(
                '.category-item'
            )
            .forEach(function(
                categoryItem
            ) {
                if (
                    categoryItem !==
                    currentCategoryItem
                ) {
                    categoryItem.classList.remove(
                        'is-open'
                    );
                    const categoryLink =
                        categoryItem.querySelector(
                            '.filter-category'
                        );
                    if (categoryLink) {
                        categoryLink.setAttribute(
                            'aria-expanded',
                            'false'
                        );
                    }
                }
            });
    }
    function clearActiveFilters() {
        if (!filterTree) {
            return;
        }
        filterTree
            .querySelectorAll(
                '.filter-brand, .filter-category, .filter-sub-category'
            )
            .forEach(function(item) {
                item.classList.remove(
                    'active'
                );
            });
    }

    function loadProducts() {
        productLoader.style.display =
            'block';
        productGrid.style.opacity =
            '0.5';
        const params =
            new URLSearchParams();
        if (currentFilter.brand) {
            params.set(
                'brand',
                currentFilter.brand
            );
        }
        if (currentFilter.category) {
            params.set(
                'category',
                currentFilter.category
            );
        }
        if (currentFilter.sub_category) {
            params.set(
                'sub_category',
                currentFilter.sub_category
            );
        }
        params.set(
            'sort',
            currentFilter.sort
        );
        fetch(
                "{{ route('our-products') }}?" +
                params.toString(), {
                    method: 'GET',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                }
            )
            .then(function(response) {
                if (!response.ok) {
                    throw new Error(
                        'HTTP ' +
                        response.status
                    );
                }
                return response.json();
            })
            .then(function(response) {
                let gridHtml = '';
                let listHtml = '';
                if (
                    response.products &&
                    response.products.length
                ) {
                    response.products.forEach(
                        function(product) {
                            gridHtml +=
                                gridProduct(product);

                            listHtml +=
                                listProduct(product);
                        }
                    );
                } else {
                    gridHtml =
                        '<div class="col-lg-12">' +
                        '<div class="text-center py-5">' +
                        '<h4>No products available.</h4>' +
                        '</div>' +
                        '</div>';
                    listHtml =
                        '<div class="text-center py-5">' +
                        '<h4>No products available.</h4>' +
                        '</div>';
                }
                productGrid.innerHTML =
                    gridHtml;
                if (productList) {
                    productList.innerHTML =
                        listHtml;
                }
                productCount.textContent =
                    'Showing ' +
                    (response.count ?? 0) +
                    ' Products';
                productLoader.style.display =
                    'none';
                productGrid.style.opacity =
                    '1';
            })
            .catch(function(error) {
                console.error(
                    'Product filter error:',
                    error
                );
                productLoader.style.display =
                    'none';
                productGrid.style.opacity =
                    '1';
            });
    }
    document.addEventListener(
        'click',
        function(e) {
            const compareButton =
                e.target.closest(
                    '.compare-product'
                );
            if (compareButton) {
                e.preventDefault();
                const productId =
                    Number(
                        compareButton.dataset.id
                    );
                if (!productId) {
                    console.error(
                        'Invalid product ID for comparison'
                    );
                    return;
                }
                let compareProducts = [];
                try {
                    compareProducts =
                        JSON.parse(
                            localStorage.getItem(
                                'compareProducts'
                            ) || '[]'
                        );

                } catch (error) {

                    console.error(
                        'Invalid compareProducts:',
                        error
                    );

                    compareProducts = [];

                }

                compareProducts =
                    compareProducts
                    .map(Number)
                    .filter(function(id) {

                        return id > 0;

                    });

                compareProducts = [
                    ...new Set(
                        compareProducts
                    )
                ];

                if (
                    compareProducts.includes(
                        productId
                    )
                ) {

                    window.location.href =
                        "{{ route('compare') }}";

                    return;
                }

                if (
                    compareProducts.length >= 2
                ) {

                    alert(
                        'You can compare only 2 products at a time.'
                    );

                    return;
                }

                compareProducts.push(
                    productId
                );

                localStorage.setItem(
                    'compareProducts',
                    JSON.stringify(
                        compareProducts
                    )
                );

                if (
                    compareProducts.length === 1
                ) {

                    alert(
                        'Product added for comparison. Please select one more product.'
                    );

                    return;
                }

                if (
                    compareProducts.length === 2
                ) {

                    window.location.href =
                        "{{ route('compare') }}";

                    return;
                }
            }

            const brand =
                e.target.closest(
                    '.filter-brand'
                );

            if (brand) {

                e.preventDefault();

                const brandItem =
                    brand.closest(
                        '.brand-item'
                    );

                const brandId =
                    brand.dataset.id;

                const brandName =
                    brand.dataset.name;

                if (
                    !brandItem ||
                    !brandId
                ) {
                    return;
                }

                const wasOpen =
                    brandItem.classList.contains(
                        'is-open'
                    );

                closeOtherBrands(
                    brandItem
                );

                clearActiveFilters();

                currentFilter.brand =
                    brandId;

                currentFilter.category =
                    '';

                currentFilter.sub_category =
                    '';

                brand.classList.add(
                    'active'
                );

                updateSelectedInfo(
                    brandName
                );

                if (wasOpen) {

                    brandItem.classList.remove(
                        'is-open'
                    );

                    brand.setAttribute(
                        'aria-expanded',
                        'false'
                    );

                } else {

                    brandItem.classList.add(
                        'is-open'
                    );

                    brand.setAttribute(
                        'aria-expanded',
                        'true'
                    );

                }

                loadProducts();

                return;
            }

            const category =
                e.target.closest(
                    '.filter-category'
                );

            if (category) {

                e.preventDefault();

                const categoryItem =
                    category.closest(
                        '.category-item'
                    );

                const brandId =
                    category.dataset.brandId;

                const categoryId =
                    category.dataset.id;

                const categoryName =
                    category.dataset.name;

                if (
                    !categoryItem ||
                    !brandId ||
                    !categoryId
                ) {
                    return;
                }

                closeOtherCategories(
                    categoryItem
                );

                clearActiveFilters();

                currentFilter.brand =
                    brandId;

                currentFilter.category =
                    categoryId;

                currentFilter.sub_category =
                    '';

                const parentBrandItem =
                    categoryItem.closest(
                        '.brand-item'
                    );

                if (parentBrandItem) {

                    parentBrandItem.classList.add(
                        'is-open'
                    );

                    const parentBrandLink =
                        parentBrandItem.querySelector(
                            '.filter-brand'
                        );

                    if (parentBrandLink) {

                        parentBrandLink.classList.add(
                            'active'
                        );

                        parentBrandLink.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }

                }

                category.classList.add(
                    'active'
                );

                updateSelectedInfo(
                    categoryName
                );

                const subCategoryTree =
                    categoryItem.querySelector(
                        '.sub-category-tree'
                    );

                if (subCategoryTree) {

                    const wasOpen =
                        categoryItem.classList.contains(
                            'is-open'
                        );

                    if (wasOpen) {

                        categoryItem.classList.remove(
                            'is-open'
                        );

                        category.setAttribute(
                            'aria-expanded',
                            'false'
                        );

                    } else {

                        categoryItem.classList.add(
                            'is-open'
                        );

                        category.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }

                }

                loadProducts();

                return;
            }

            const subCategory =
                e.target.closest(
                    '.filter-sub-category'
                );

            if (subCategory) {

                e.preventDefault();

                const subCategoryItem =
                    subCategory.closest(
                        '.sub-category-item'
                    );

                const brandId =
                    subCategory.dataset.brandId;

                const categoryId =
                    subCategory.dataset.categoryId;

                const subCategoryId =
                    subCategory.dataset.id;

                const subCategoryName =
                    subCategory.dataset.name;

                if (
                    !subCategoryItem ||
                    !brandId ||
                    !categoryId ||
                    !subCategoryId
                ) {
                    return;
                }

                clearActiveFilters();

                currentFilter.brand =
                    brandId;

                currentFilter.category =
                    categoryId;

                currentFilter.sub_category =
                    subCategoryId;

                const brandItem =
                    subCategoryItem.closest(
                        '.brand-item'
                    );

                if (brandItem) {

                    brandItem.classList.add(
                        'is-open'
                    );

                    const brandLink =
                        brandItem.querySelector(
                            '.filter-brand'
                        );

                    if (brandLink) {

                        brandLink.classList.add(
                            'active'
                        );

                        brandLink.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }

                }

                const categoryItem =
                    subCategoryItem.closest(
                        '.category-item'
                    );

                if (categoryItem) {

                    categoryItem.classList.add(
                        'is-open'
                    );

                    const categoryLink =
                        categoryItem.querySelector(
                            '.filter-category'
                        );

                    if (categoryLink) {

                        categoryLink.classList.add(
                            'active'
                        );

                        categoryLink.setAttribute(
                            'aria-expanded',
                            'true'
                        );

                    }

                }

                subCategory.classList.add(
                    'active'
                );

                updateSelectedInfo(
                    subCategoryName
                );

                loadProducts();

                return;
            }

        }
    );

    if (productSort) {

        productSort.addEventListener(
            'change',
            function() {

                currentFilter.sort =
                    this.value;

                loadProducts();

            }
        );

    }

    const clearFilters =
        document.getElementById(
            'clearFilters'
        );

    if (clearFilters) {

        clearFilters.addEventListener(
            'click',
            function(e) {

                e.preventDefault();

                currentFilter = {
                    brand: '',
                    category: '',
                    sub_category: '',
                    sort: 'latest'
                };

                if (productSort) {

                    productSort.value =
                        'latest';

                }

                if (filterTree) {

                    filterTree
                        .querySelectorAll(
                            '.brand-item'
                        )
                        .forEach(
                            function(brandItem) {

                                brandItem.classList.remove(
                                    'is-open'
                                );

                            }
                        );

                    filterTree
                        .querySelectorAll(
                            '.category-item'
                        )
                        .forEach(
                            function(categoryItem) {

                                categoryItem.classList.remove(
                                    'is-open'
                                );

                            }
                        );

                    filterTree
                        .querySelectorAll(
                            '.filter-brand, .filter-category, .filter-sub-category'
                        )
                        .forEach(
                            function(item) {

                                item.classList.remove(
                                    'active'
                                );

                                item.setAttribute(
                                    'aria-expanded',
                                    'false'
                                );

                            }
                        );

                }

                updateSelectedInfo('');

                loadProducts();

            }
        );

    }

});
</script>

@endsection