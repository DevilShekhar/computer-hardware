@extends('frontend.layouts.app')

@section('title', 'Shopping Cart')

@section('content')

    <!-- Begin Li's Breadcrumb Area -->
    <div class="breadcrumb-area">
        <div class="container">
            <div class="breadcrumb-content">
                <ul>
                    <li><a href="{{ route('home') }}">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ul>
            </div>
        </div>
    </div>
    <!-- Li's Breadcrumb Area End Here -->

    <!--Shopping Cart Area Strat-->
    <div class="Shopping-cart-area pt-60 pb-60">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(!$cart || $cart->items->isEmpty())
                        <div class="text-center py-5">
                            <h3>Your Cart is Empty</h3>
                            <p class="mb-4">Looks like you haven't added anything to your cart yet.</p>
                            <a href="{{ route('our-products') }}" class="li-button li-button-fullwidth li-button-dark"
                                style="display: inline-block; width: auto; padding: 12px 40px;">
                                Continue Shopping
                            </a>
                        </div>
                    @else
                        <form action="#" id="cartForm">
                            <div class="table-content table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="li-product-remove">SrNo.</th>
                                            <th class="li-product-thumbnail">images</th>
                                            <th class="cart-product-name">Product</th>
                                            <th class="li-product-price">Unit Price</th>
                                            <th class="li-product-quantity">Quantity</th>
                                            <th class="li-product-subtotal">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartItemsBody">
                                        @foreach($cart->items as $item)
                                            @php
                                                $product = $item->product;
                                                if (!$product)
                                                    continue;

                                                $image = null;
                                                if (isset($product->image) && $product->image) {
                                                    $image = asset('storage/' . $product->image);
                                                } elseif (isset($product->product_image) && $product->product_image) {
                                                    $image = asset('storage/' . $product->product_image);
                                                }

                                                if (!$image && $product->images) {
                                                    $primaryImage = $product->images->where('is_primary', true)->first();
                                                    if (!$primaryImage) {
                                                        $primaryImage = $product->images->first();
                                                    }
                                                    if ($primaryImage) {
                                                        $image = asset('storage/' . $primaryImage->image);
                                                    }
                                                }

                                                if (!$image) {
                                                    $image = asset('assets/frontend/assets/images/product/large-size/1.jpg');
                                                }

                                                $price = (float) $item->price;
                                                $itemTotal = $price * $item->quantity;
                                            @endphp

                                            <tr class="cart_item" id="cart-item-{{ $product->id }}"
                                                data-product-id="{{ $product->id }}"
                                                data-price="{{ $price }}">
                                                <td class="li-product-remove">
                                                    <span class="sr-no">{{ $loop->iteration }}</span>
                                                </td>
                                                <td class="li-product-thumbnail">
                                                    <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                        <img src="{{ $image }}" alt="{{ $product->name }}"
                                                            style="max-width: 80px; height: auto;">
                                                    </a>
                                                </td>
                                                <td class="li-product-name">
                                                    <a href="{{ route('product.details', ['slug' => $product->slug]) }}">
                                                        {{ $product->name }}
                                                    </a>
                                                </td>
                                                <td class="li-product-price">
                                                    <span class="amount">₹{{ number_format($price, 2) }}</span>
                                                </td>
                                                <td class="quantity">
                                                    <div class="cart-plus-minus">
                                                        <input class="cart-plus-minus-box quantity-input"
                                                            value="{{ $item->quantity }}" type="text"
                                                            name="quantity"
                                                            data-product-id="{{ $product->id }}"
                                                            data-price="{{ $price }}">
                                                    </div>
                                                </td>
                                                <td class="product-subtotal item-total" data-product-id="{{ $product->id }}">
                                                    <span class="amount">₹{{ number_format($itemTotal, 2) }}</span>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="coupon-all">
                                        <div class="coupon">
                                            <input id="coupon_code" class="input-text" name="coupon_code" value=""
                                                placeholder="Coupon code" type="text">

                                            <input class="button" name="apply_coupon" value="Apply coupon" type="button"
                                                id="applyCouponBtn">
                                        </div>

                                        <div id="couponMessage" class="mt-2"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-5 ml-auto">
                                    <div class="cart-page-total">
                                        <h2>Cart totals</h2>
                                        <ul>
                                            <li>Subtotal <span id="cartSubtotal">₹{{ number_format($subtotal, 2) }}</span></li>
                                            <li>Total <span id="cartGrandTotal">₹{{ number_format($subtotal, 2) }}</span></li>
                                        </ul>
                                        <a href="{{ route('checkout.index') }}">Proceed to checkout</a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!--Shopping Cart Area End-->

    <!-- Cart Loader -->
    <div class="cart-loader" id="cartLoader" style="display:none; text-align:center; padding:30px;">
        <div class="spinner"
            style="width:35px;height:35px;border:3px solid #ddd;border-top-color:#2878f0;border-radius:50%;animation:spin .7s linear infinite;margin:auto;">
        </div>
        <p class="mt-3 text-muted">Updating cart...</p>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '{{ csrf_token() }}';

            let appliedDiscount = 0;

            function showLoader() {
                const loader = document.getElementById('cartLoader');
                if (loader) loader.style.display = 'block';
            }

            function hideLoader() {
                const loader = document.getElementById('cartLoader');
                if (loader) loader.style.display = 'none';
            }

            function showToast(message, type = 'success') {
                if (typeof window.showToast === 'function') {
                    window.showToast(message, type);
                    return;
                }
                alert(message);
            }

            function formatPrice(amount) {
                return '₹' + Number(amount || 0).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });
            }

            function readCurrentTotals() {
                let subtotal = 0;
                document.querySelectorAll('.cart_item').forEach(function (row) {
                    const price = parseFloat(row.dataset.price) || 0;
                    const input = row.querySelector('.quantity-input');
                    const qty = parseInt(input?.value) || 1;
                    subtotal += price * qty;
                });
                return subtotal;
            }

            function updateItemTotal(row, quantity) {
                if (!row) return;
                const price = parseFloat(row.dataset.price) || 0;
                const el = row.querySelector('.item-total .amount');
                if (el) el.textContent = formatPrice(price * quantity);
            }

            function refreshTotals(subtotalOverride) {
                const subtotalEl = document.getElementById('cartSubtotal');
                const grandTotalEl = document.getElementById('cartGrandTotal');

                let subtotal = subtotalOverride;
                if (subtotal === undefined || subtotal === null) {
                    subtotal = readCurrentTotals();
                }

                if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);

                if (appliedDiscount > 0) {
                    let discountRow = document.getElementById('couponDiscountRow');
                    if (!discountRow) {
                        const totalList = document.querySelector('.cart-page-total ul');
                        if (totalList) {
                            const li = document.createElement('li');
                            li.id = 'couponDiscountRow';
                            li.innerHTML = 'Coupon Discount <span id="couponDiscount"></span>';
                            const totalLi = totalList.querySelector('li:last-child');
                            if (totalLi) totalList.insertBefore(li, totalLi);
                        }
                    }
                    const discountEl = document.getElementById('couponDiscount');
                    if (discountEl) discountEl.textContent = '− ' + formatPrice(appliedDiscount);

                    const grand = Math.max(0, subtotal - appliedDiscount);
                    if (grandTotalEl) grandTotalEl.textContent = formatPrice(grand);
                } else {
                    const discountRow = document.getElementById('couponDiscountRow');
                    if (discountRow) discountRow.remove();
                    if (grandTotalEl) grandTotalEl.textContent = formatPrice(subtotal);
                }
            }

            function updateAllTotalsLocally() {
                refreshTotals(readCurrentTotals());
            }

            async function updateCart(productId, quantity) {
                quantity = parseInt(quantity) || 1;
                if (quantity < 1) quantity = 1;

                showLoader();

                try {
                    const response = await fetch('{{ route('cart.update') }}', {
                        method: 'PATCH',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        },
                        body: JSON.stringify({
                            product_id: productId,
                            quantity: quantity
                        })
                    });

                    const data = await response.json();

                    if (!response.ok || !data.success) {
                        throw new Error(data.message || 'Unable to update cart.');
                    }

                    const row = document.getElementById('cart-item-' + productId);
                    if (row) {
                        const quantityInput = row.querySelector('.quantity-input');
                        if (quantityInput && data.item) {
                            quantityInput.value = data.item.quantity;
                        }

                        const itemTotal = row.querySelector('.item-total .amount');
                        if (itemTotal && data.item) {
                            itemTotal.textContent = formatPrice(data.item.total);
                        }
                    }

                    if (data.subtotal !== undefined) {
                        refreshTotals(parseFloat(data.subtotal) || 0);
                    } else {
                        updateAllTotalsLocally();
                    }

                    if (typeof window.loadMiniCart === 'function') {
                        window.loadMiniCart();
                    }

                } catch (error) {
                    console.error('Update cart error:', error);
                    showToast(error.message, 'error');
                    updateAllTotalsLocally();
                } finally {
                    hideLoader();
                }
            }

            document.addEventListener('click', function (e) {
                const btn = e.target.closest('.qtybutton');
                if (!btn) return;

                const row = btn.closest('.cart_item');
                if (!row) return;

                const input = row.querySelector('.quantity-input');
                const productId = row.dataset.productId;
                if (!input || !productId) return;

                setTimeout(function () {
                    let qty = parseInt(input.value) || 1;
                    if (qty < 1) qty = 1;
                    if (qty > 9999) qty = 9999;

                    input.value = qty;

                    updateItemTotal(row, qty);
                    updateAllTotalsLocally();
                    updateCart(productId, qty);
                }, 0);
            }, false);

            document.querySelectorAll('.quantity-input').forEach(function (input) {
                input.addEventListener('input', function () {
                    const row = this.closest('.cart_item');
                    if (!row) return;

                    let qty = parseInt(this.value) || 1;
                    if (qty < 1) qty = 1;

                    updateItemTotal(row, qty);
                    updateAllTotalsLocally();
                });

                input.addEventListener('change', function () {
                    const row = this.closest('.cart_item');
                    if (!row) return;

                    const productId = row.dataset.productId;
                    if (!productId) return;

                    let qty = parseInt(this.value) || 1;
                    if (qty < 1) qty = 1;

                    this.value = qty;

                    updateItemTotal(row, qty);
                    updateAllTotalsLocally();
                    updateCart(productId, qty);
                });
            });

            document.querySelectorAll('.remove-cart-btn').forEach(function (button) {
                button.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;

                    if (!confirm('Remove this product from cart?')) return;

                    showLoader();

                    try {
                        const response = await fetch('{{ url('/cart/remove') }}/' + productId, {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Unable to remove product.');
                        }

                        const row = document.getElementById('cart-item-' + productId);
                        if (row) row.remove();

                        if (data.item_count === 0) {
                            window.location.reload();
                            return;
                        }

                        if (data.subtotal !== undefined) {
                            refreshTotals(parseFloat(data.subtotal) || 0);
                        } else {
                            updateAllTotalsLocally();
                        }

                        if (typeof window.loadMiniCart === 'function') {
                            window.loadMiniCart();
                        }

                        showToast('Product removed from cart.');

                    } catch (error) {
                        showToast(error.message, 'error');
                    } finally {
                        hideLoader();
                    }
                });
            });

            const clearCartBtn = document.getElementById('clearCartBtn');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', async function () {
                    if (!confirm('Are you sure you want to clear your cart?')) return;

                    showLoader();

                    try {
                        const response = await fetch('{{ route('cart.clear') }}', {
                            method: 'DELETE',
                            headers: {
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            }
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Unable to clear cart.');
                        }

                        window.location.reload();

                    } catch (error) {
                        showToast(error.message, 'error');
                    } finally {
                        hideLoader();
                    }
                });
            }

            const couponCode = document.getElementById('coupon_code');
            const applyCouponBtn = document.getElementById('applyCouponBtn');
            const couponMessage = document.getElementById('couponMessage');

            if (applyCouponBtn) {
                applyCouponBtn.addEventListener('click', async function () {

                    const code = couponCode.value.trim();

                    if (!code) {
                        couponMessage.innerHTML = '<span class="text-danger">Please enter coupon code.</span>';
                        return;
                    }

                    applyCouponBtn.disabled = true;
                    applyCouponBtn.value = 'Applying...';

                    try {
                        const response = await fetch('{{ route('checkout.apply-coupon') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({ code: code })
                        });

                        const data = await response.json();

                        if (!response.ok || !data.success) {
                            throw new Error(data.message || 'Unable to apply coupon.');
                        }

                        couponMessage.innerHTML = '<span class="text-success">' + data.message + '</span>';

                        couponCode.disabled = true;
                        applyCouponBtn.disabled = true;
                        applyCouponBtn.value = 'Applied';

                        appliedDiscount = parseFloat(data.discount) || 0;

                        refreshTotals(readCurrentTotals());

                    } catch (error) {

                        couponMessage.innerHTML = '<span class="text-danger">' + error.message + '</span>';

                        applyCouponBtn.disabled = false;
                        applyCouponBtn.value = 'Apply coupon';
                    }
                });
            }

            updateAllTotalsLocally();
        });
    </script>

@endsection
