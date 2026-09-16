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
            <div class="row" id="subCategoryProductGrid">
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

            <div class="row">
                <div class="col-lg-12">
                    <div class="li-paginatoin-area text-center pt-25">
                        <ul class="li-pagination-box" id="subCategoryProductPagination"></ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const grid       = document.getElementById('subCategoryProductGrid');
    const pagination = document.getElementById('subCategoryProductPagination');
    const slug       = "{{ $subCategory->slug }}";

    if (!grid || !pagination) return;

    let currentPage = {{ $products->currentPage() }};

    function escapeHtml(value) {
        const div = document.createElement('div');
        div.textContent = value ?? '';
        return div.innerHTML;
    }

    function formatPrice(value) {
        return Number(value ?? 0).toLocaleString('en-IN', {
            minimumFractionDigits: 2,
            maximumFractionDigits: 2
        });
    }

    function priceHtml(product) {
        if (product.has_discount) {
            return '<span class="new-price new-price-2">₹' + formatPrice(product.sale_price) + '</span>' +
                   '<span class="old-price">₹' + formatPrice(product.price) + '</span>';
        }
        return '<span class="new-price">₹' + formatPrice(product.price) + '</span>';
    }

    function cardHtml(product) {
        const fallback = "{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}";
        const img      = product.image || fallback;

        const brandUrl = product.brand_slug
            ? "{{ url('/our-brand') }}/" + product.brand_slug
            : "javascript:void(0)";

        const brandBlock = product.brand_name
            ? '<h5 class="manufacturer">' +
                '<a href="' + brandUrl + '">' + escapeHtml(product.brand_name) + '</a>' +
              '</h5>'
            : '<h5 class="manufacturer"><a href="#">Product</a></h5>';

        return '<div class="col-lg-3 col-md-6 col-sm-6 mb-30">' +
            '<div class="single-product-wrap">' +
                '<div class="product-image">' +
                    '<a href="' + product.detail_url + '">' +
                        '<img src="' + img + '" alt="' + escapeHtml(product.name) + '" style="width: 100%; height: 220px; object-fit: contain;">' +
                    '</a>' +
                '</div>' +
                '<div class="product_desc">' +
                    '<div class="product_desc_info">' +
                        '<div class="product-review">' +
                            brandBlock +
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
                        '<div class="price-box">' + priceHtml(product) + '</div>' +
                    '</div>' +
                    '<div class="add-actions">' +
                        '<ul class="add-actions-link">' +
                            '<li class="add-cart active cart-btn" ' +
                                'data-product-id="' + product.id + '" ' +
                                'data-product-name="' + escapeHtml(product.name) + '" ' +
                                'data-product-slug="' + (product.slug || '') + '" ' +
                                'data-product-price="' + (product.sale_price || product.price || 0) + '" ' +
                                'data-product-image="' + img + '">' +
                                '<a href="javascript:void(0);">Add to cart</a>' +
                            '</li>' +
                            '<li>' +
                                '<a class="links-details wishlist-btn" href="javascript:void(0);" ' +
                                    'data-product-id="' + product.id + '" ' +
                                    'data-product-name="' + escapeHtml(product.name) + '" ' +
                                    'data-product-slug="' + (product.slug || '') + '" ' +
                                    'data-product-price="' + (product.sale_price || product.price || 0) + '" ' +
                                    'data-product-image="' + img + '">' +
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

    function renderPagination(meta) {
        const current = parseInt(meta.current_page, 10) || 1;
        const last    = parseInt(meta.last_page, 10) || 1;

        pagination.innerHTML = '';
        if (last <= 1) return;

        let html = '';

        if (current > 1) {
            html += '<li><a class="Previous" href="javascript:void(0)" data-page="' + (current - 1) + '">Previous</a></li>';
        } else {
            html += '<li class="disabled"><a class="Previous" href="javascript:void(0)">Previous</a></li>';
        }

        for (let p = 1; p <= last; p++) {
            html += '<li' + (p === current ? ' class="active"' : '') + '>' +
                    '<a href="javascript:void(0)" data-page="' + p + '">' + p + '</a>' +
                    '</li>';
        }

        if (current < last) {
            html += '<li><a class="Next" href="javascript:void(0)" data-page="' + (current + 1) + '">Next</a></li>';
        } else {
            html += '<li class="disabled"><a class="Next" href="javascript:void(0)">Next</a></li>';
        }

        pagination.innerHTML = html;

        pagination.querySelectorAll('a[data-page]').forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const page = parseInt(this.dataset.page, 10) || 1;
                if (page === currentPage) return;
                loadPage(page);
            });
        });
    }

    function loadPage(page) {
        grid.style.opacity = '0.5';

        fetch("{{ url('/our-sub-category') }}/" + slug + "?page=" + page, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            currentPage = page;

            let html = '';
            if (data.products && data.products.length) {
                data.products.forEach(function (p) { html += cardHtml(p); });
            } else {
                html = '<div class="col-lg-12"><div class="text-center pt-40 pb-60">' +
                       '<h3>No Products Available</h3>' +
                       '<p>There are currently no products available for this sub category.</p>' +
                       '</div></div>';
            }

            grid.innerHTML = html;
            grid.style.opacity = '1';

            renderPagination({
                current_page: data.current_page,
                last_page:    data.last_page
            });

            const y = grid.getBoundingClientRect().top + window.pageYOffset - 120;
            window.scrollTo({ top: y, behavior: 'smooth' });
        })
        .catch(function (err) {
            console.error('Sub-category products fetch error:', err);
            grid.style.opacity = '1';
        });
    }

    renderPagination({
        current_page: {{ $products->currentPage() }},
        last_page:    {{ $products->lastPage() }}
    });
});
</script>
@endsection
