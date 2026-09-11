@extends('admin.layouts.app')
@section('content')
    <section class="section">
        @can('my-order-index')
            <div class="row">
                {{-- Total Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">My Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $myOrderCount }}</h2>
                                                <p class="mb-0">Total Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Products">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Pending Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">Pending Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $pendingOrderCount }}</h2>
                                                <p class="mb-0">Pending Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Pending Orders">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Confirmed Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">Confirmed Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $confirmedOrderCount }}</h2>
                                                <p class="mb-0">Confirmed Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Confirmed Orders">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Shipped Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">Shipped Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $shippedOrderCount }}</h2>
                                                <p class="mb-0">Shipped Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Shipped Orders">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Delivered Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">Delivered Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $deliveredOrderCount }}</h2>
                                                <p class="mb-0">Delivered Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Delivered Orders">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                </div>

                {{-- Cancelled Orders --}}
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                    <a href="{{ route('my-orders') }}" class="text-decoration-none">
                        <div class="card dashboard-card">
                            <div class="card-statistic-4">
                                <div class="align-items-center justify-content-between">
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                            <div class="card-content">
                                                <h5 class="font-15">Cancelled Orders</h5>
                                                <h2 class="mb-3 font-18">{{ $cancelledOrderCount }}</h2>
                                                <p class="mb-0">Cancelled Orders</p>
                                            </div>
                                        </div>

                                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                            <div class="banner-img">
                                                <img src="{{ asset('assets/img/banner/1.png') }}" alt="Cancelled Orders">
                                            </div>
                                        </div>
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
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('products.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Products</h5>
                                            <h2 class="mb-3 font-18">{{ $productCount }}</h2>
                                            <p class="mb-0"> Products</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/1.png') }}" alt="Products">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-brand-count')
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('product-brands.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Brands</h5>
                                            <h2 class="mb-3 font-18">{{ $brandCount }}</h2>
                                            <p class="mb-0"> Brands</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/2.png') }}" alt="Brands">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-category-count')
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('categories.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Categories</h5>
                                            <h2 class="mb-3 font-18">{{ $categoryCount }}</h2>
                                            <p class="mb-0">Categories</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/3.png') }}" alt="Categories">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-sub-category-count')
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('sub-categories.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">SubCate</h5>
                                            <h2 class="mb-3 font-18">{{ $subCategoryCount }}</h2>
                                            <p class="mb-0">SubCategories</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/4.png') }}" alt="Sub Categories">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-user-count')
            <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('admin.users.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Users</h5>
                                            <h2 class="mb-3 font-18">{{ $userCount }}</h2>
                                            <p class="mb-0"> Users</p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/1.png') }}" alt="Users">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>
        <div class="row">
            @can('dashboard-review-count')
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('product-review.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Total Reviews</h5>

                                            <h2 class="mb-3 font-18">
                                                {{ $reviewCount }}
                                            </h2>

                                            <p class="mb-0">
                                                Total Reviews
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/3.png') }}"
                                                alt="Total Reviews">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-approved-review-count')      
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('product-review.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Approved Reviews</h5>

                                            <h2 class="mb-3 font-18">
                                                {{ $approvedReviewCount }}
                                            </h2>

                                            <p class="mb-0">
                                                Approved Reviews
                                            </p>
                                        </div>
                                    </div>

                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/4.png') }}"
                                                alt="Approved Reviews">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
        </div>
        <div class="row">
            @can('dashboard-active-coupon-count')
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('coupons.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Active Coupons</h5>
                                            <h2 class="mb-3 font-18">
                                                {{ $activeCouponCount }}
                                            </h2>
                                            <p class="mb-0">
                                                Active Coupons
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/3.png') }}"  alt="Active Coupons">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endcan
            @can('dashboard-expired-coupon-count')
            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 col-xs-12">
                <a href="{{ route('coupons.index') }}" class="text-decoration-none">
                    <div class="card dashboard-card">
                        <div class="card-statistic-4">
                            <div class="align-items-center justify-content-between">
                                <div class="row">
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                                        <div class="card-content">
                                            <h5 class="font-15">Expired Coupons</h5>
                                            <h2 class="mb-3 font-18">
                                                {{ $expiredCouponCount }}
                                            </h2>
                                            <p class="mb-0">
                                                Expired Coupons
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                                        <div class="banner-img">
                                            <img src="{{ asset('assets/img/banner/4.png') }}" alt="Expired Coupons">
                                        </div>
                                    </div>
                                </div>
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