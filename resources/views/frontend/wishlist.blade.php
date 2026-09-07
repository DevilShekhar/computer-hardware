@extends('frontend.layouts.app')

@section('content')
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li class="active">Wishlist</li>
            </ul>
        </div>
    </div>
</div>
<!-- Li's Breadcrumb Area End Here -->

<!--Wishlist Area Strat-->
<div class="wishlist-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div id="empty-wishlist" class="text-center" style="display: none;">
                    <h4>Your wishlist is empty.</h4>
                    <a href="{{ url('our-products') }}" class="li-button mt-20">Continue Shopping</a>
                </div>

                <div id="wishlist-items">
                    <!-- Items will be loaded here by JavaScript -->
                </div>
            </div>
        </div>
    </div>
</div>
<!--Wishlist Area End-->
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Load wishlist and cart on page load
    loadWishlist();
    loadMiniCart();

    function loadWishlist() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const container = document.getElementById('wishlist-items');
        const emptyMsg = document.getElementById('empty-wishlist');

        if (wishlist.length === 0) {
            container.innerHTML = '';
            emptyMsg.style.display = 'block';
            return;
        }

        emptyMsg.style.display = 'none';

        // Build table HTML
        let tableHtml = `
            <form action="#">
                <div class="table-content table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="li-product-remove">Remove</th>
                                <th class="li-product-thumbnail">Images</th>
                                <th class="cart-product-name">Product</th>
                                <th class="li-product-price">Unit Price</th>
                                <th class="li-product-stock-status">Stock Status</th>
                                <th class="li-product-add-cart">Add to Cart</th>
                            </tr>
                        </thead>
                        <tbody>
        `;

        wishlist.forEach((product, index) => {
            const thumbnail = product.thumbnail || product.image;

            tableHtml += `
                <tr data-id="${product.id}" data-index="${index}">
                    <td class="li-product-remove">
                        <a href="javascript:void(0);" class="remove-wishlist" data-index="${index}">
                            <i class="fa fa-times"></i>
                        </a>
                    </td>
                    <td class="li-product-thumbnail">
                        <a href="/our-product/${product.slug}">
                            <img src="${thumbnail}" alt="${product.name}" style="max-width: 80px; height: auto;">
                        </a>
                    </td>
                    <td class="li-product-name">
                        <a href="/our-product/${product.slug}">${product.name}</a>
                    </td>
                    <td class="li-product-price">
                        <span class="amount">₹${parseFloat(product.price).toFixed(2)}</span>
                    </td>
                    <td class="li-product-stock-status">
                        <span class="${product.stock_status === 'out of stock' ? 'out-stock' : 'in-stock'}">
                            ${product.stock_status || 'In Stock'}
                        </span>
                    </td>
                    <td class="li-product-add-cart">
                        <a href="javascript:void(0);"
                           class="add-to-cart"
                           data-product-id="${product.id}"
                           data-product-name="${product.name}"
                           data-product-slug="${product.slug || ''}"
                           data-product-price="${product.price}"
                           data-product-image="${product.image}"
                           data-product-thumbnail="${thumbnail}">
                           Add to Cart
                        </a>
                    </td>
                </tr>
            `;
        });

        tableHtml += `
                        </tbody>
                    </table>
                </div>
            </form>
        `;

        container.innerHTML = tableHtml;

        // Remove from Wishlist - WITHOUT page refresh
        document.querySelectorAll('.remove-wishlist').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();
                const index = parseInt(this.getAttribute('data-index'));
                const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
                wishlist.splice(index, 1);
                localStorage.setItem('wishlist', JSON.stringify(wishlist));
                // Reload wishlist without page refresh
                loadWishlist();
                // Update wishlist count
                updateWishlistCounter();
            });
        });

        // Add to Cart functionality - WITHOUT page refresh
        document.querySelectorAll('.add-to-cart').forEach(btn => {
            btn.addEventListener('click', function (e) {
                e.preventDefault();

                const product = {
                    id: this.getAttribute('data-product-id'),
                    name: this.getAttribute('data-product-name'),
                    slug: this.getAttribute('data-product-slug'),
                    price: this.getAttribute('data-product-price'),
                    image: this.getAttribute('data-product-image'),
                    thumbnail: this.getAttribute('data-product-thumbnail'),
                    quantity: 1
                };

                // Get existing cart from localStorage
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                // Check if product already exists in cart
                const existingIndex = cart.findIndex(item => String(item.id) === String(product.id));
                if (existingIndex > -1) {
                    cart[existingIndex].quantity += 1;
                } else {
                    cart.push(product);
                }

                localStorage.setItem('cart', JSON.stringify(cart));

                // Update mini cart without page refresh
                if (typeof loadMiniCart === 'function') {
                    loadMiniCart();
                }

                // Update cart counter
                updateCartCounter();
                updateWishlistCounter();

                // Show custom toast notification
                showToast(`${product.name} added to cart!`);
            });
        });
    }

    // Custom Toast notification function
    function showToast(message) {
        // Remove existing toast if any
        const existingToast = document.getElementById('custom-toast');
        if (existingToast) {
            existingToast.remove();
        }

        // Create toast element
        const toast = document.createElement('div');
        toast.id = 'custom-toast';
        toast.style.cssText = `
            position: fixed;
            top: 80px;
            right: 20px;
            background: #fffdf3;
            color: #d89b00;
            border: 1px solid #fed700;
            border-radius: 5px;
            padding: 8px 12px;
            min-width: 200px;
            display: flex;
            align-items: center;
            gap: 10px;
            z-index: 9999;
            box-shadow: 0 2px 8px rgba(0,0,0,.12);
            animation: slideInRight 0.3s ease;
        `;

        // Add icon
        const icon = document.createElement('span');
        icon.innerHTML = '✓';
        icon.style.cssText = `
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
            background: #fed700;
            color: #d89b00;
            border-radius: 50%;
            font-weight: bold;
            font-size: 12px;
        `;

        // Add message
        const text = document.createElement('span');
        text.textContent = message;

        // Add close button
        const closeBtn = document.createElement('span');
        closeBtn.innerHTML = '×';
        closeBtn.style.cssText = `
            cursor: pointer;
            font-size: 18px;
            margin-left: auto;
            color: #d89b00;
            opacity: 0.7;
            transition: opacity 0.2s;
        `;
        closeBtn.onmouseover = function() {
            this.style.opacity = '1';
        };
        closeBtn.onmouseout = function() {
            this.style.opacity = '0.7';
        };
        closeBtn.onclick = function() {
            toast.remove();
        };

        // Assemble toast
        toast.appendChild(icon);
        toast.appendChild(text);
        toast.appendChild(closeBtn);
        document.body.appendChild(toast);

        // Auto remove after 3 seconds
        clearTimeout(window.toastTimeout);
        window.toastTimeout = setTimeout(function() {
            if (toast && toast.parentNode) {
                toast.style.animation = 'slideOutRight 0.3s ease forwards';
                setTimeout(function() {
                    if (toast && toast.parentNode) {
                        toast.remove();
                    }
                }, 300);
            }
        }, 3000);
    }

    // Add CSS animations
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideInRight {
            from {
                transform: translateX(100%);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }
        @keyframes slideOutRight {
            from {
                transform: translateX(0);
                opacity: 1;
            }
            to {
                transform: translateX(100%);
                opacity: 0;
            }
        }
    `;
    document.head.appendChild(style);

    // Update cart counter
    function updateCartCounter() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const totalItems = cart.reduce(function (sum, item) {
            return sum + (parseInt(item.quantity) || 1);
        }, 0);

        document.querySelectorAll('.cart-item-count:not(.wishlist-item-count)').forEach(function (counter) {
            if (counter) {
                counter.textContent = totalItems;
            }
        });
    }

    // Update wishlist counter
    function updateWishlistCounter() {
        const wishlist = JSON.parse(localStorage.getItem('wishlist')) || [];
        const totalItems = wishlist.length;

        document.querySelectorAll('.wishlist-item-count').forEach(function (counter) {
            if (counter) {
                counter.textContent = totalItems;
            }
        });
    }

    // Load mini cart function
    function loadMiniCart() {
        const cart = JSON.parse(localStorage.getItem('cart')) || [];
        const list = document.getElementById('minicart-product-list');
        const count = document.getElementById('minicart-count');
        const subtotal = document.getElementById('minicart-subtotal');
        const headerTotal = document.getElementById('minicart-header-total');

        if (!list) return;

        list.innerHTML = '';
        let total = 0;

        cart.forEach(function (product) {
            const price = parseFloat(product.price) || 0;
            const quantity = parseInt(product.quantity) || 1;
            total += price * quantity;

            list.innerHTML += `
                <li>
                    <a href="/our-product/${product.slug}" class="minicart-product-image">
                        <img src="${product.image}" alt="${product.name}">
                    </a>
                    <div class="minicart-product-details">
                        <h6>
                            <a href="/our-product/${product.slug}">
                                ${product.name}
                            </a>
                        </h6>
                        <span>₹${price.toFixed(2)} x ${quantity}</span>
                    </div>
                    <button class="close minicart-remove"
                            data-id="${product.id}"
                            title="Remove">
                        <i class="fa fa-close"></i>
                    </button>
                </li>
            `;
        });

        // Update cart count
        const totalItems = cart.reduce((sum, item) => sum + (parseInt(item.quantity) || 1), 0);
        if (count) count.textContent = totalItems;

        // Update both subtotal and header total
        const formattedTotal = total.toFixed(2);
        if (subtotal) subtotal.textContent = '₹' + formattedTotal;
        if (headerTotal) headerTotal.textContent = formattedTotal;

        // Show empty cart message
        if (cart.length === 0) {
            list.innerHTML = `
                <li style="text-align:center;padding:20px;">
                    Your cart is empty
                </li>
            `;
        }

        // Remove item functionality
        document.querySelectorAll('.minicart-remove').forEach(function (button) {
            button.onclick = function () {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];
                cart = cart.filter(function (product) {
                    return String(product.id) !== String(button.dataset.id);
                });
                localStorage.setItem('cart', JSON.stringify(cart));
                loadMiniCart();
                updateCartCounter();
            };
        });
    }

    // Make functions globally accessible
    window.loadMiniCart = loadMiniCart;
    window.updateCartCounter = updateCartCounter;
    window.updateWishlistCounter = updateWishlistCounter;
    window.loadWishlist = loadWishlist;
    window.showToast = showToast;

    // Initialize counters
    updateCartCounter();
    updateWishlistCounter();
});
</script>
@endpush
