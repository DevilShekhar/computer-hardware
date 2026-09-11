<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Metaverse Info - Dashboard </title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/css/app.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/summernote/summernote-bs4.css') }}">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">
    <!-- Custom style CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bundles/datatables/datatables.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/css/select-2.css') }}">

    <link rel='shortcut icon' type='image/x-icon' href="{{ asset('assets/img/favicon.png') }}" />
    <style>
        .select2-container {
            width: 100% !important
        }

        .select2-container .select2-selection--single {
            height: 42px;
            border: 1px solid #e4e6fc;
            border-radius: 4px
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 40px;
            padding-left: 12px;
            color: #495057;
            font-size: 14px
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 8px
        }

        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: #6777ef;
            box-shadow: 0 0 0 2px rgba(103, 119, 239, .1)
        }

        .select2-dropdown {
            border: 1px solid #e4e6fc;
            border-radius: 4px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, .08)
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #e4e6fc;
            border-radius: 4px;
            padding: 7px 10px
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px;
            font-size: 14px
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background: #6777ef
        }
        .sidebar-brand a img {
            height: 90px;
        }
    </style>
</head>

<body>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        <li>
                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        data-width="200">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                            <span class="badge headerBadge1">
                                6 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
											text-white"> <img alt="image" src="assets/img/users/user-1.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">John
                                            Deo</span>
                                        <span class="time messege-text">Please check your mail !!</span>
                                        <span class="time">2 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Request for leave
                                            application</span>
                                        <span class="time">5 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="assets/img/users/user-5.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                                            Ryan</span> <span class="time messege-text">Your payment invoice is
                                            generated.</span> <span class="time">12 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="assets/img/users/user-4.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                                            Smith</span> <span class="time messege-text">hii John, I have upload
                                            doc
                                            related to task.</span> <span class="time">30
                                            Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="assets/img/users/user-3.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                                            Joshi</span> <span class="time messege-text">Please do as specify.
                                            Let me
                                            know if you have any query.</span> <span class="time">1
                                            Days Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="assets/img/users/user-2.png" class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Client Requirements</span>
                                        <span class="time">2 Days Ago</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                                        class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                                    </span> <span class="dropdown-item-desc"> Template update is
                                        available now! <span class="time">2 Min
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="far
												fa-user"></i>
                                    </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                                            Sugiharto</b> are now friends <span class="time">10 Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-success text-white"> <i class="fas
												fa-check"></i>
                                    </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                                        moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                                            Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-danger text-white"> <i
                                            class="fas fa-exclamation-triangle"></i>
                                    </span> <span class="dropdown-item-desc"> Low disk space. Let's
                                        clean it! <span class="time">17 Hours Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="fas
												fa-bell"></i>
                                    </span> <span class="dropdown-item-desc"> Welcome to Otika
                                        template! <span class="time">Yesterday</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            @if(auth()->user()->profile)
                                <img alt="image" src="{{ asset('storage/' . auth()->user()->profile) }}"
                                    class="user-img-radious-style">
                            @else
                                <img alt="image" src="{{ asset('assets/img/user.png') }}" class="user-img-radious-style">
                            @endif
                            <span class="d-sm-none d-lg-inline-block"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">
                            <div class="dropdown-title">
                                Hello {{ auth()->user()->name }}
                            </div>
                            <a href="{{ route('profile') }}" class="dropdown-item has-icon">
                                <i class="far fa-user"></i> Profile
                            </a>
                            <a href="{{ route('password.index') }}" class="dropdown-item has-icon">
                                <i class="fas fa-key"></i> Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <a href="{{ route('logout') }}" class="dropdown-item has-icon text-danger"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="{{ route('dashboard') }}"> <img alt="image" src="{{ asset('assets/img/logo.png') }}" />
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>

                        <li class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                            <a href="{{ route('dashboard') }}" class="nav-link">
                                <i data-feather="monitor"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        @can('user-manage')
                        <li class="dropdown {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="users"></i>
                                <span>Users</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('admin.users.index') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.users.index') }}">
                                        User Listing
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.users.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('admin.users.create') }}">
                                        Add User
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('roles-manage')
                        <li class="dropdown {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="shield"></i>
                                <span>Roles</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('admin.roles.index') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.index') }}">
                                        Role Listing
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('admin.roles.create') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('roles.create') }}">
                                        Add Role
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('order-management')
                        <li class="dropdown {{ request()->routeIs('customer-orders.*') ? 'active' : '' }}">
                            <a href="#" class="menu-toggle nav-link has-dropdown">
                                <i data-feather="shopping-bag"></i>
                                <span>Order Management</span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="{{ request()->routeIs('customer-orders.index', 'customer-orders.show') ? 'active' : '' }}">
                                    <a class="nav-link" href="{{ route('customer-orders.index') }}">
                                        All Orders
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 0 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 0]) }}">
                                        Pending
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 1 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 1]) }}">
                                        Confirmed
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 2 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 2]) }}">
                                        Processing
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 3 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 3]) }}">
                                        Shipped
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 4 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 4]) }}">
                                        Delivered
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 5 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 5]) }}">
                                        Cancelled
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 6 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 6]) }}">
                                        Failed
                                    </a>
                                </li>
                                <li class="{{ request()->routeIs('customer-orders.index') && request('status') == 7 ? 'active' : '' }}">
                                    <a class="nav-link"
                                    href="{{ route('customer-orders.index', ['status' => 7]) }}">
                                        Refunded
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @endcan
                        @can('my-order-manage')
                        <li class="{{ request()->routeIs('my-orders*') ? 'active' : '' }}">
                            <a href="{{ route('my-orders') }}" class="nav-link">
                                <i data-feather="shopping-bag"></i>
                                <span>My Orders</span>
                            </a>
                        </li>
                        @endcan
                        @can('promotional-banner-manage')
                            <li class="{{ request()->routeIs('promotional-banners.*') ? 'active' : '' }}">
                                <a href="{{ route('promotional-banners.index') }}" class="nav-link">
                                    <i data-feather="image"></i>
                                    <span>Promotional Banners</span>
                                </a>
                            </li>
                        @endcan
                        @can('gst-manage')
                            <li class="{{ request()->routeIs('gsts.*') ? 'active' : '' }}">
                                <a href="{{ route('gsts.index') }}" class="nav-link">
                                    <i data-feather="percent"></i>
                                    <span>GST</span>
                                </a>
                            </li>
                        @endcan
                        @can('product-manage')
                            <li class="dropdown {{ request()->routeIs('product-brands.*', 'categories.*', 'sub-categories.*', 'products.*') ? 'active' : '' }}">
                                <a href="#" class="menu-toggle nav-link has-dropdown">
                                    <i data-feather="package"></i>
                                    <span>Products</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('product-brand-manage')
                                        <li class="{{ request()->routeIs('product-brands.*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('product-brands.index') }}">
                                                Brands
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-category-manage')
                                        <li class="{{ request()->routeIs('categories.*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('categories.index') }}">
                                                Categories
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-sub-category-manage')
                                        <li class="{{ request()->routeIs('sub-categories.*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('sub-categories.index') }}">
                                                Sub Categories
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-manage')
                                        <li class="{{ request()->routeIs('products.index', 'products.create', 'products.edit', 'products.show') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('products.index') }}">
                                                Products
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-manage')
                                        <li class="{{ request()->routeIs('products.stock') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('products.stock') }}">
                                                Stock Management
                                            </a>
                                        </li>
                                    @endcan
                                    @can('product-inventory-history-manage')
                                        <li class="{{ request()->routeIs('products.inventory-history', 'products.inventory-history.data') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('products.inventory-history') }}">
                                                Inventory History
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('pc-builder-manage')
                            <li class="{{ request()->routeIs('builder-types.*', 'builder-products.*') ? 'active' : '' }}">
                                <a href="#" class="menu-toggle nav-link has-dropdown">
                                    <i data-feather="cpu"></i>
                                    <span>PC Builder</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('pc-builder-type-manage')
                                        <li class="{{ request()->routeIs('builder-types.*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('builder-types.index') }}">
                                                PC Builder Type
                                            </a>
                                        </li>
                                    @endcan
                                    @can('pc-builder-product-manage')
                                        <li class="{{ request()->routeIs('builder-products.*') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('builder-products.index') }}">
                                                PC Builder Product
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('product-review-manage')
                        <li class="{{ request()->routeIs('product-review.*') ? 'active' : '' }}">
                            <a href="{{ route('product-review.index') }}" class="nav-link">
                                <i data-feather="star"></i>
                                <span>Product Reviews</span>
                            </a>
                        </li>
                        @endcan
                        @can('coupon-manage')
                            <li class="dropdown">
                                <a href="#" class="menu-toggle nav-link has-dropdown">
                                    <i data-feather="tag"></i>
                                    <span>Coupons</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('coupon-index')
                                        <li class="{{ request()->routeIs('coupons.index') ? 'active' : '' }}">
                                            <a class="nav-link" href="{{ route('coupons.index') }}">
                                                Coupon List
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endcan
                        @can('contact-manage')
                        <li class="{{ request()->routeIs('admin.contact-submissions.*') ? 'active' : '' }}">
                            <a href="{{ route('admin.contact-submissions.index') }}" class="nav-link">
                                <i data-feather="mail"></i>
                                <span>Contact Submissions</span>
                            </a>
                        </li>
                        @endcan
                        @can('address-manage')
                        <li class="{{ request()->routeIs('addresses.*') ? 'active' : '' }}">
                            <a href="{{ route('addresses.index') }}" class="nav-link">
                                <i data-feather="settings"></i>
                                <span>Address Setting</span>
                            </a>
                        </li>
                        @endcan
                        <li class="{{ request()->routeIs('checkout.index.*') ? 'active' : '' }}">
                            <a href="{{ route('checkout.index') }}" class="nav-link">
                                <i data-feather="shopping-cart"></i>
                                <span>Go To Checkout</span>
                            </a>
                        </li>
                        <li class="{{ request()->routeIs('checkout.index.*') ? 'active' : '' }}">
                            <a href="/" class="nav-link">
                                <i data-feather="shopping-cart"></i>
                                <span>Explore More</span>
                            </a>
                        </li>
                    </ul>
                </aside>
            </div>
            <!-- Main Content -->
            <main class="main-content">
                @yield('content')
            </main>
            <footer class="main-footer">
                <div class="footer-left">
                    <a href="templateshub.net">Templateshub</a></a>
                    <div class="footer-right">
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('assets/js/app.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/summernote/summernote-bs4.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/bundles/sweetalert/sweetalert-11.js') }}"></script>

    @stack('scripts')

</body>

</html>
