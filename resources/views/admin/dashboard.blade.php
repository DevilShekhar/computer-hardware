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
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card ">
                    <div class="card-header">
                        <h4>Revenue chart</h4>
                        <div class="card-header-action">
                            <div class="dropdown">
                                <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle">Options</a>
                                <div class="dropdown-menu">
                                    <a href="#" class="dropdown-item has-icon"><i class="fas fa-eye"></i> View</a>
                                    <a href="#" class="dropdown-item has-icon"><i class="far fa-edit"></i> Edit</a>
                                    <div class="dropdown-divider"></div>
                                    <a href="#" class="dropdown-item has-icon text-danger"><i class="far fa-trash-alt"></i>Delete</a>
                                </div>
                            </div>
                            <a href="#" class="btn btn-primary">View All</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-9">
                                <div id="chart1"></div>
                                <div class="row mb-0">
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="list-inline text-center">
                                            <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"  class="col-green"></i>
                                                <h5 class="m-b-0">$675</h5>
                                                <p class="text-muted font-14 m-b-0">Weekly Earnings</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="list-inline text-center">
                                            <div class="list-inline-item p-r-30"><i data-feather="arrow-down-circle"
                                                    class="col-orange"></i>
                                                <h5 class="m-b-0">$1,587</h5>
                                                <p class="text-muted font-14 m-b-0">Monthly Earnings</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                                        <div class="list-inline text-center">
                                            <div class="list-inline-item p-r-30"><i data-feather="arrow-up-circle"
                                                    class="col-green"></i>
                                                <h5 class="mb-0 m-b-0">$45,965</h5>
                                                <p class="text-muted font-14 m-b-0">Yearly Earnings</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3">
                                <div class="row mt-5">
                                    <div class="col-7 col-xl-7 mb-3">Total customers</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">8,257</span>
                                        <sup class="col-green">+09%</sup>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total Income</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">$9,857</span>
                                        <sup class="text-danger">-18%</sup>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Project completed</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">28</span>
                                        <sup class="col-green">+16%</sup>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">Total expense</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">$6,287</span>
                                        <sup class="col-green">+09%</sup>
                                    </div>
                                    <div class="col-7 col-xl-7 mb-3">New Customers</div>
                                    <div class="col-5 col-xl-5 mb-3">
                                        <span class="text-big">684</span>
                                        <sup class="col-green">+22%</sup>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Chart</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart4" class="chartsh"></div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Chart</h4>
                    </div>
                    <div class="card-body">
                        <div class="summary">
                            <div class="summary-chart active" data-tab-group="summary-tab" id="summary-chart">
                                <div id="chart3" class="chartsh"></div>
                            </div>
                            <div data-tab-group="summary-tab" id="summary-text">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-12 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Chart</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart2" class="chartsh"></div>
                    </div>
                </div>
            </div>
        </div>
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
        <div class="row">
            <div class="col-md-6 col-lg-12 col-xl-6">
                <!-- Support tickets -->
                <div class="card">
                    <div class="card-header">
                        <h4>Support Ticket</h4>
                        <form class="card-header-form">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-1.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-success mb-1 float-right">Feature</div>
                                <span class="font-weight-bold">#89754</span>
                                <a href="javascript:void(0)">Please add advance table</a>
                                <p class="my-1">Hi, can you please add new table for advan...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">John
                                        Deo</span>
                                    &nbsp;&nbsp; - 1 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-2.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-warning mb-1 float-right">Bug</div>
                                <span class="font-weight-bold">#57854</span>
                                <a href="javascript:void(0)">Select item not working</a>
                                <p class="my-1">please check select item in advance form not work...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Sarah
                                        Smith</span>
                                    &nbsp;&nbsp; - 2 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-3.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-primary mb-1 float-right">Query</div>
                                <span class="font-weight-bold">#85784</span>
                                <a href="javascript:void(0)">Are you provide template in Angular?</a>
                                <p class="my-1">can you provide template in latest angular 8.</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Ashton
                                        Cox</span>
                                    &nbsp;&nbsp; -2 day ago</small>
                            </div>
                        </div>
                        <div class="support-ticket media pb-1 mb-3">
                            <img src="assets/img/users/user-6.png" class="user-img mr-2" alt="">
                            <div class="media-body ml-3">
                                <div class="badge badge-pill badge-info mb-1 float-right">Enhancement</div>
                                <span class="font-weight-bold">#25874</span>
                                <a href="javascript:void(0)">About template page load speed</a>
                                <p class="my-1">Hi, John, can you work on increase page speed of template...</p>
                                <small class="text-muted">Created by <span class="font-weight-bold font-13">Hasan
                                        Basri</span>
                                    &nbsp;&nbsp; -3 day ago</small>
                            </div>
                        </div>
                    </div>
                    <a href="javascript:void(0)" class="card-footer card-link text-center small ">View
                        All</a>
                </div>
                <!-- Support tickets -->
            </div>
            <div class="col-md-6 col-lg-12 col-xl-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Projects Payments</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Client Name</th>
                                        <th>Date</th>
                                        <th>Payment Method</th>
                                        <th>Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td>John Doe </td>
                                        <td>11-08-2018</td>
                                        <td>NEFT</td>
                                        <td>$258</td>
                                    </tr>
                                    <tr>
                                        <td>2</td>
                                        <td>Cara Stevens
                                        </td>
                                        <td>15-07-2018</td>
                                        <td>PayPal</td>
                                        <td>$125</td>
                                    </tr>
                                    <tr>
                                        <td>3</td>
                                        <td>
                                            Airi Satou
                                        </td>
                                        <td>25-08-2018</td>
                                        <td>RTGS</td>
                                        <td>$287</td>
                                    </tr>
                                    <tr>
                                        <td>4</td>
                                        <td>
                                            Angelica Ramos
                                        </td>
                                        <td>01-05-2018</td>
                                        <td>CASH</td>
                                        <td>$170</td>
                                    </tr>
                                    <tr>
                                        <td>5</td>
                                        <td>
                                            Ashton Cox
                                        </td>
                                        <td>18-04-2018</td>
                                        <td>NEFT</td>
                                        <td>$970</td>
                                    </tr>
                                    <tr>
                                        <td>6</td>
                                        <td>
                                            John Deo
                                        </td>
                                        <td>22-11-2018</td>
                                        <td>PayPal</td>
                                        <td>$854</td>
                                    </tr>
                                    <tr>
                                        <td>7</td>
                                        <td>
                                            Hasan Basri
                                        </td>
                                        <td>07-09-2018</td>
                                        <td>Cash</td>
                                        <td>$128</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection