@extends('admin.layouts.app')
@section('content')
    <section class="section">
        @can('my-order-index')
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-purple">
                                <i class="fas fa-cart-plus"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $myOrderCount }}
                                        </h3>
                                        <span class="text-muted">
                                            My Orders
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-orange">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $pendingOrderCount }}
                                        </h3>
                                        <span class="text-muted">Pending Orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-green">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $confirmedOrderCount }}
                                        </h3>
                                        <span class="text-muted">Confirmed Orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-cyan">
                                <i class="fas fa-truck"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $shippedOrderCount }}
                                        </h3>
                                        <span class="text-muted">Shipped Orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-purple">
                                <i class="fas fa-box-open"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $deliveredOrderCount }}
                                        </h3>
                                        <span class="text-muted">Delivered Orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 col-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card card-statistic-1">
                            <div class="card-icon l-bg-fail">
                                <i class="fas fa-ban"></i>
                            </div>
                            <div class="card-wrap">
                                <div class="padding-20">
                                    <div class="text-right">
                                        <h3 class="font-light mb-0">
                                            {{ $cancelledOrderCount }}
                                        </h3>
                                        <span class="text-muted">Cancelled Orders</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        @endcan
        <div class="row">
            @can('dashboard-product-count')
            {{-- Products --}}
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('products.index') }}" class="text-decoration-none">
                    <div class="card l-bg-green">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fa fa-award"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Products</h4>
                                <span>{{ $productCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-purple"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fa fa-box"></i>
                                        Products
                                    </span>
                                    <span class="text-nowrap">
                                        Total Products
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-brand-count')
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('product-brands.index') }}" class="text-decoration-none">
                    <div class="card l-bg-cyan">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Brands</h4>
                                <span>{{ $brandCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-orange"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-tags"></i>
                                        Brands
                                    </span>

                                    <span class="text-nowrap">
                                        Total Brands
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-category-count')
            {{-- Categories --}}
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                    <div class="card l-bg-purple">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-layer-group"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Categories</h4>
                                <span>{{ $categoryCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-cyan"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-layer-group"></i>
                                        Categories
                                    </span>
                                    <span class="text-nowrap">
                                        Total Categories
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-sub-category-count')
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('sub-categories.index') }}" class="text-decoration-none">
                    <div class="card l-bg-orange">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-sitemap"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Sub Categories</h4>
                                <span>{{ $subCategoryCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-green"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-sitemap"></i>
                                        Sub Categories
                                    </span>
                                    <span class="text-nowrap">
                                        Total Sub Categories
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-user-count')
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card" style="background: linear-gradient(135deg, #3949ab, #5c6bc0);">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Users</h4>
                                <span>{{ $userCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar"
                                        style="background: #ffffff;"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-users"></i>
                                        Users
                                    </span>
                                    <span class="text-nowrap">
                                        Total Users
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>
        <div class="row">
            @can('dashboard-review-count')
            <div class="col-xl-6 col-lg-6">
                <a href="{{ route('product-review.index') }}" class="text-decoration-none">
                    <div class="card l-bg-yellow">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-star"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Total Reviews</h4>
                                <span>{{ $reviewCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-orange"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-star"></i>
                                        Reviews
                                    </span>
                                    <span class="text-nowrap">
                                        Total Reviews
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-approved-review-count')
            {{-- Approved Reviews --}}
            <div class="col-xl-6 col-lg-6">
                <a href="{{ route('product-review.index') }}" class="text-decoration-none">
                    <div class="card l-bg-green">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Approved Reviews</h4>
                                <span>{{ $approvedReviewCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-cyan"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-check-circle"></i>
                                        Approved
                                    </span>
                                    <span class="text-nowrap">
                                        Total Approved Reviews
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>
        {{-- Order Status wise cards --}}
        @can('dashboard-order-count')
        <div class="mb-3">
            <div class="d-inline-flex align-items-center px-3 py-2 rounded"
                style="background: linear-gradient(135deg, #3949ab, #5c6bc0); color: #fff;">
                <i class="fas fa-shopping-bag mr-2"></i>
                <h5 class="mb-0 font-weight-bold">
                    Latest Customer Orders
                </h5>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 0]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Pending</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[0] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-orange text-white">
                                        <i class="fas fa-clock"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 10%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 1]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Confirmed</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[1] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-cyan text-white">
                                        <i class="fas fa-check"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 7.8%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 2]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Processing</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[2] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-green text-white">
                                        <i class="fas fa-cogs"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 15%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 3]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Shipped</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[3] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-purple text-white">
                                        <i class="fas fa-truck"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 5.4%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 4]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Delivered</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[4] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-teal text-white">
                                        <i class="fas fa-box-open"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 12%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 5]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Cancelled</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[5] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-pink text-white">
                                        <i class="fas fa-times-circle"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 3.2%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 6]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Failed</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[6] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-fail text-white">
                                        <i class="fas fa-exclamation-triangle"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 2.5%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-3 col-lg-6">
                <a href="{{ route('customer-orders.index', ['status' => 7]) }}" class="text-decoration-none">
                    <div class="card">
                        <div class="card-body card-type-3">
                            <div class="row">
                                <div class="col">
                                    <h6 class="text-muted mb-0">Refunded</h6>
                                    <span class="font-weight-bold mb-0">
                                        {{ $orderStatusCounts[7] ?? 0 }}
                                    </span>
                                </div>
                                <div class="col-auto">
                                    <div class="card-circle l-bg-red text-white">
                                        <i class="fas fa-undo-alt"></i>
                                    </div>
                                </div>
                            </div>
                            <p class="mt-3 mb-0 text-muted text-sm">
                                <span class="text-success mr-2">
                                    <i class="fa fa-arrow-up"></i> 4.6%
                                </span>
                                <span class="text-nowrap">Since last month</span>
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
        @endcan
       @can('best-seller-items')
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Best Selling Products</h4>
            <a href="{{ route('best-selling-products.index') }}" class="btn btn-primary">
                View All
            </a>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Product</th>
                                <th>SKU</th>
                                <th>Brand</th>
                                <th>Price</th>
                                <th>Total Sold</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bestSellingProducts as $index => $item)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        @if($item->product && $item->product->images->first())
                                            <img src="{{ asset('storage/' . $item->product->images->first()->image) }}"
                                                alt="{{ $item->product->name }}"
                                                width="45"
                                                height="45"
                                                class="rounded"
                                                style="object-fit:cover;">
                                        @else
                                            <img src="{{ asset('assets/img/default.png') }}"
                                                alt="image"
                                                width="45"
                                                height="45"
                                                class="rounded"
                                                style="object-fit:cover;">
                                        @endif
                                    </td>
                                    <td>
                                        {{ $item->product->name ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->product->sku ?? '-' }}
                                    </td>
                                    <td>
                                        {{ $item->product->productBrand->name ?? '-' }}
                                    </td>
                                    <td>
                                        ₹{{ number_format($item->product->sale_price ?? $item->product->price, 2) }}
                                    </td>
                                    <td>
                                        <strong>{{ $item->total_sold }}</strong>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center">
                                        No sales data available.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       @endcan
        <div class="row">
            @can('dashboard-active-coupon-count')
            <div class="col-xl-6 col-lg-6">
                <a href="{{ route('coupons.index') }}" class="text-decoration-none">
                    <div class="card l-bg-orange">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-tags"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Active Coupons</h4>
                                <span>{{ $activeCouponCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-purple"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-tag"></i>
                                        Coupons
                                    </span>
                                    <span class="text-nowrap">
                                        Total Active Coupons
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-expired-coupon-count')
            <div class="col-xl-6 col-lg-6">
                <a href="{{ route('coupons.index') }}" class="text-decoration-none">
                    <div class="card l-bg-red">
                        <div class="card-statistic-3">
                            <div class="card-icon card-icon-large">
                                <i class="fas fa-calendar-times"></i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title">Expired Coupons</h4>
                                <span>{{ $expiredCouponCount }}</span>
                                <div class="progress mt-1 mb-1" data-height="8">
                                    <div class="progress-bar l-bg-orange"
                                        role="progressbar"
                                        data-width="25%"
                                        aria-valuenow="25"
                                        aria-valuemin="0"
                                        aria-valuemax="100">
                                    </div>
                                </div>
                                <p class="mb-0 text-sm">
                                    <span class="mr-2">
                                        <i class="fas fa-calendar-times"></i>
                                        Coupons
                                    </span>
                                    <span class="text-nowrap">
                                        Total Expired Coupons
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>
         @can('dashboard-chart')
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card dashboard-chart-card">
                    <div class="card-header">
                        <h4>Order Status</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart4" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card dashboard-chart-card">
                    <div class="card-header">
                        <h4>Monthly Orders</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart3" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card dashboard-chart-card">
                    <div class="card-header">
                        <h4>Monthly Sales</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart2" class="dashboard-chart"></div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('dashboard-latest-order')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Latest Customer Orders</h4>
                        <div class="card-header-action">
                            <a href="{{ route('customer-orders.index') }}"
                            class="btn btn-primary">
                                View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Order Number</th>
                                        <th>Customer</th>
                                        <th>Total</th>
                                        <th>Payment</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($latestOrders as $order)
                                        @php
                                            $statusNames = [
                                                0 => 'Pending',
                                                1 => 'Confirmed',
                                                2 => 'Processing',
                                                3 => 'Shipped',
                                                4 => 'Delivered',
                                                5 => 'Cancelled',
                                                6 => 'Failed',
                                                7 => 'Refunded',
                                            ];
                                            $statusClasses = [
                                                0 => 'badge-warning',
                                                1 => 'badge-info',
                                                2 => 'badge-primary',
                                                3 => 'badge-primary',
                                                4 => 'badge-success',
                                                5 => 'badge-danger',
                                                6 => 'badge-danger',
                                                7 => 'badge-secondary',
                                            ];
                                        @endphp
                                        <tr>
                                            <td>
                                                {{ $loop->iteration }}
                                            </td>
                                            <td>
                                                <strong>
                                                    {{ $order->order_number }}
                                                </strong>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>
                                                        {{ $order->customer_name }}
                                                    </strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $order->email }}
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <strong>
                                                    ₹{{ number_format($order->total_amount, 2) }}
                                                </strong>
                                            </td>
                                            <td>
                                                @if($order->payment_status == 'paid')
                                                    <span class="badge badge-success">
                                                        Paid
                                                    </span>
                                                @elseif($order->payment_status == 'pending')
                                                    <span class="badge badge-warning">
                                                        Pending
                                                    </span>
                                                @elseif($order->payment_status == 'failed')
                                                    <span class="badge badge-danger">
                                                        Failed
                                                    </span>
                                                @else
                                                    <span class="badge badge-secondary">
                                                        {{ ucfirst($order->payment_status) }}
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="badge {{ $statusClasses[$order->status] ?? 'badge-secondary' }}">
                                                    {{ $statusNames[$order->status] ?? 'Unknown' }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $order->created_at->format('d M Y') }}
                                                <br>
                                                <small class="text-muted">
                                                    {{ $order->created_at->format('h:i A') }}
                                                </small>
                                            </td>
                                            <td>
                                                <a href="{{ route('customer-orders.show', $order->id) }}"
                                                class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center py-4">
                                                <i class="fas fa-shopping-cart fa-2x text-muted mb-2"></i>
                                                <p class="mb-0 text-muted">
                                                    No customer orders found.
                                                </p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endcan
        @can('dashboard-latest-review')
            <div class="row">
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Pending Product Reviews</h4>
                            <div class="card-header-action">
                                <a href="{{ route('product-review.index') }}" class="btn btn-primary">View All</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover mb-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Product</th>
                                            <th>Customer</th>
                                            <th>Rating</th>
                                            <th>Review</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($latestPendingReviews as $review)
                                            @php
                                                $primaryImage = $review->product?->images?->where('is_primary', true)->first();
                                                if (!$primaryImage) {
                                                    $primaryImage = $review->product?->images?->first();
                                                }
                                            @endphp
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        @if($primaryImage && $primaryImage->image)
                                                            <img src="{{ asset('storage/' . $primaryImage->image) }}" alt="{{ $review->product->name ?? 'Product' }}" width="45" height="45" class="rounded mr-2" style="object-fit: cover;">
                                                        @else
                                                            <img src="{{ asset('assets/img/default.png') }}" alt="Product Image" width="45" height="45" class="rounded mr-2" style="object-fit: cover;">
                                                        @endif
                                                        <span>{{ $review->product->name ?? '-' }}</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <strong>{{ $review->user->name ?? '-' }}</strong>
                                                    @if($review->user?->email)
                                                        <small class="d-block text-muted">{{ $review->user->email }}</small>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="text-warning">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            @if($i <= $review->rating)
                                                                <i class="fas fa-star"></i>
                                                            @else
                                                                <i class="far fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </td>
                                                <td>
                                                    <span title="{{ $review->comment }}">
                                                        {{ \Illuminate\Support\Str::limit($review->comment, 50) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <small>{{ $review->created_at?->format('d-m-Y') }}</small>
                                                    <span class="badge badge-warning d-block mt-1">Pending</span>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center py-4">No pending reviews.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <a href="{{ route('product-review.index') }}" class="card-footer card-link text-center small">View All Reviews</a>
                    </div>
                </div>
            </div>
        @endcan
    </section>
@endsection
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (typeof ApexCharts === 'undefined') {
        console.error('ApexCharts is not loaded.');
        return;
    }

    var monthlyOrders = @json($monthlyOrders);
    var monthlySales = @json($monthlySales);
    var orderStatus = @json($orderStatus);

    var monthNames = [
        'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
        'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
    ];

    var statusNames = {
        0: 'Pending',
        1: 'Confirmed',
        2: 'Processing',
        3: 'Shipped',
        4: 'Delivered',
        5: 'Cancelled',
        6: 'Failed',
        7: 'Refunded'
    };

    var statusOrder = [
        'Pending',
        'Confirmed',
        'Processing',
        'Shipped',
        'Delivered',
        'Cancelled',
        'Failed',
        'Refunded'
    ];

    var normalizedStatuses = {};

    orderStatus.forEach(function (item) {
        var statusValue = item.status;
        var statusName = null;

        if (statusValue !== null && statusValue !== undefined) {
            if (statusNames[statusValue] !== undefined) {
                statusName = statusNames[statusValue];
            } else {
                var textStatus = String(statusValue).trim().toLowerCase();

                var textStatusMap = {
                    'pending': 'Pending',
                    'confirm': 'Confirmed',
                    'confirmed': 'Confirmed',
                    'processing': 'Processing',
                    'shipped': 'Shipped',
                    'delivered': 'Delivered',
                    'cancel': 'Cancelled',
                    'cancelled': 'Cancelled',
                    'failed': 'Failed',
                    'refunded': 'Refunded',
                    'refund': 'Refunded'
                };

                if (textStatusMap[textStatus] !== undefined) {
                    statusName = textStatusMap[textStatus];
                }
            }
        }

        if (statusName) {
            if (!normalizedStatuses[statusName]) {
                normalizedStatuses[statusName] = 0;
            }

            normalizedStatuses[statusName] += parseInt(item.total) || 0;
        }
    });

    var statusLabels = [];
    var statusTotals = [];

    statusOrder.forEach(function (statusName) {
        if (normalizedStatuses[statusName] > 0) {
            statusLabels.push(statusName);
            statusTotals.push(normalizedStatuses[statusName]);
        }
    });

    var totalOrders = statusTotals.reduce(function (total, value) {
        return total + value;
    }, 0);

    var orderMonths = monthlyOrders.map(function (item) {
        return monthNames[parseInt(item.month) - 1];
    });

    var orderTotals = monthlyOrders.map(function (item) {
        return parseInt(item.total) || 0;
    });

    var salesMonths = monthlySales.map(function (item) {
        return monthNames[parseInt(item.month) - 1];
    });

    var salesTotals = monthlySales.map(function (item) {
        return parseFloat(item.total) || 0;
    });

    var chart4 = document.querySelector('#chart4');

    if (chart4 && statusTotals.length > 0) {
        new ApexCharts(chart4, {
            chart: {
                type: 'donut',
                toolbar: {
                    show: false
                }
            },
            series: statusTotals,
            labels: statusLabels,
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                fontWeight: 500,
                markers: {
                    width: 9,
                    height: 9,
                    radius: 50
                },
                itemMargin: {
                    horizontal: 7,
                    vertical: 5
                }
            },
            plotOptions: {
                pie: {
                    expandOnClick: true,
                    donut: {
                        size: '70%',
                        labels: {
                            show: true,
                            name: {
                                show: true,
                                fontSize: '13px',
                                fontWeight: 500
                            },
                            value: {
                                show: true,
                                fontSize: '22px',
                                fontWeight: 600,
                                offsetY: 5,
                                formatter: function (value) {
                                    return value;
                                }
                            },
                            total: {
                                show: true,
                                showAlways: true,
                                label: 'Total Orders',
                                fontSize: '13px',
                                fontWeight: 500,
                                formatter: function () {
                                    return totalOrders;
                                }
                            }
                        }
                    }
                }
            },
            dataLabels: {
                enabled: true,
                formatter: function (value) {
                    return value.toFixed(1) + '%';
                },
                style: {
                    fontSize: '12px',
                    fontWeight: 600
                },
                dropShadow: {
                    enabled: false
                }
            },
            stroke: {
                width: 2
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return value + ' Orders';
                    }
                }
            },
            responsive: [
                {
                    breakpoint: 1200,
                    options: {
                        chart: {
                            height: 320
                        },
                        legend: {
                            fontSize: '12px'
                        }
                    }
                },
                {
                    breakpoint: 576,
                    options: {
                        chart: {
                            height: 350
                        },
                        legend: {
                            fontSize: '12px',
                            itemMargin: {
                                horizontal: 5,
                                vertical: 4
                            }
                        }
                    }
                }
            ]
        }).render();
    }

    var chart3 = document.querySelector('#chart3');

    if (chart3) {
        new ApexCharts(chart3, {
            chart: {
                type: 'line',
                height: 330,
                toolbar: {
                    show: false
                },
                zoom: {
                    enabled: false
                }
            },
            series: [
                {
                    name: 'Orders',
                    data: orderTotals
                }
            ],
            xaxis: {
                categories: orderMonths,
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    formatter: function (value) {
                        return Math.round(value);
                    },
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            markers: {
                size: 4,
                strokeWidth: 2,
                hover: {
                    size: 7
                }
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#e9ecef',
                strokeDashArray: 4,
                padding: {
                    left: 10,
                    right: 10
                }
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (value) {
                        return value + ' Orders';
                    }
                }
            }
        }).render();
    }

    var chart2 = document.querySelector('#chart2');

    if (chart2) {
        new ApexCharts(chart2, {
            chart: {
                type: 'bar',
                height: 330,
                toolbar: {
                    show: false
                }
            },
            series: [
                {
                    name: 'Sales',
                    data: salesTotals
                }
            ],
            xaxis: {
                categories: salesMonths,
                axisBorder: {
                    show: true
                },
                axisTicks: {
                    show: false
                },
                labels: {
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            yaxis: {
                min: 0,
                forceNiceScale: true,
                labels: {
                    formatter: function (value) {
                        return '₹' + Math.round(value).toLocaleString('en-IN');
                    },
                    style: {
                        fontSize: '12px'
                    }
                }
            },
            plotOptions: {
                bar: {
                    borderRadius: 4,
                    columnWidth: '50%'
                }
            },
            dataLabels: {
                enabled: false
            },
            grid: {
                borderColor: '#e9ecef',
                strokeDashArray: 4,
                padding: {
                    left: 10,
                    right: 10
                }
            },
            tooltip: {
                y: {
                    formatter: function (value) {
                        return '₹' + value.toLocaleString('en-IN', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });
                    }
                }
            }
        }).render();
    }
});
</script>
@endpush
