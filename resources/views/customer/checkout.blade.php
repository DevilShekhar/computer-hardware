@extends('frontend.layouts.app')
@section('title', 'Checkout')
@section('content')
<!-- Begin Li's Breadcrumb Area -->
<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li><a href="{{ route('cart.index') }}">Cart</a></li>
                <li class="active">Checkout</li>
            </ul>
        </div>
    </div>
</div>
<div class="checkout-area pt-60 pb-30">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="coupon-accordion">
                    <!--Accordion Start-->
                    <h3>Have a coupon? <span id="showcoupon">Click here to enter your code</span></h3>
                    <div id="checkout_coupon" class="coupon-checkout-content">
                        <div class="coupon-info">
                            <form id="couponForm">
                                @csrf
                                <p class="checkout-coupon">
                                    <input id="couponCode" name="code" placeholder="Coupon code" type="text">
                                    <input value="Apply Coupon" type="submit" id="applyCouponBtn">
                                </p>
                            </form>
                            <div id="couponMessage" class="mt-2"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <form action="{{ route('checkout.place-order') }}" method="POST" id="checkoutForm">
            @csrf
            <div class="row">
                <div class="col-lg-6 col-12">
                    <div class="checkbox-form">
                        <h3>Billing Details</h3>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="row">
                            <div class="col-md-12">
                                <div class="country-select clearfix">
                                    <label>Country <span class="required">*</span></label>
                                    <select class="nice-select wide" name="country" required>
                                        <option data-display="India">India</option>
                                        <option value="India" {{ old('country') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="UK" {{ old('country') == 'UK' ? 'selected' : '' }}>UK</option>
                                        <option value="USA" {{ old('country') == 'USA' ? 'selected' : '' }}>USA</option>
                                        <option value="Australia" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                        <option value="Canada" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Full Name <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="customer_name" value="{{ old('customer_name', auth()->user()->name ?? '') }}" required>
                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Email Address <span class="required">*</span></label>
                                    <input placeholder="" type="email" name="email" value="{{ old('email', auth()->user()->email ?? '') }}" required>
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Mobile Number <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="mobile_number" value="{{ old('mobile_number', auth()->user()->mobile ?? '') }}" required>
                                    @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="checkout-form-list">
                                    <label>Address <span class="required">*</span></label>
                                    <input placeholder="Street address" type="text" name="address" value="{{ old('address') }}" required>
                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>City <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="city" value="{{ old('city') }}" required>
                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>State <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="state" value="{{ old('state') }}" required>
                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="checkout-form-list">
                                    <label>Pincode <span class="required">*</span></label>
                                    <input placeholder="" type="text" name="pincode" value="{{ old('pincode') }}" required>
                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="order-notes">
                                    <div class="checkout-form-list">
                                        <label>Order Notes</label>
                                        <textarea id="checkout-mess" cols="30" rows="10" name="order_notes" placeholder="Notes about your order, e.g. special notes for delivery.">{{ old('order_notes') }}</textarea>
                                        @error('order_notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-12">
                    <div class="your-order">
                        <h3>Your order</h3>
                        <div class="your-order-table table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="cart-product-name">Product</th>
                                        <th class="cart-product-quantity">Quantity</th>
                                        <th class="cart-product-total">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cart->items as $item)
                                        @php
                                            $product = $item->product;
                                            if (!$product) continue;
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
                                        <tr class="cart_item" id="cart-item-{{ $product->id }}" data-product-id="{{ $product->id }}" data-price="{{ $price }}">
                                            <td class="cart-product-name">
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $image }}" alt="{{ $product->name }}"
                                                        style="width: 50px; height: 50px; object-fit: contain;border:1px solid #eee;border-radius:4px;margin-right:10px;">
                                                    <div>{{ $product->name }}</div>
                                                </div>
                                            </td>
                                            <td class="cart-product-quantity">
                                                <div class="cart-plus-minus">
                                                    <input class="cart-plus-minus-box quantity-input"value="{{ $item->quantity }}" type="text" name="quantity"data-product-id="{{ $product->id }}" data-price="{{ $price }}">
                                                </div>
                                            </td>
                                            <td class="cart-product-total item-total" data-product-id="{{ $product->id }}">
                                                <span class="amount">₹{{ number_format($itemTotal, 2) }}</span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th colspan="2">Cart Subtotal</th>
                                        <td><span class="amount"
                                                id="cartSubtotal">₹{{ number_format($subtotal, 2) }}</span></td>
                                    </tr>
                                    <tr class="order-total">
                                        <th colspan="2">Order Total</th>
                                        <td><strong><span class="amount"
                                                    id="cartGrandTotal">₹{{ number_format($subtotal, 2) }}</span></strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
                            <div class="payment-accordion">
                                <div id="accordion">
                                    <div class="card">
                                        <div class="card-header" id="#payment-1">
                                            <h5 class="panel-title">
                                                <a class="" data-toggle="collapse" data-target="#collapseOne"
                                                    aria-expanded="true" aria-controls="collapseOne">
                                                    <input type="radio" name="payment_method" value="cod" {{ old('payment_method') == 'cod' ? 'checked' : '' }} checked>
                                                    Cash on Delivery
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseOne" class="collapse show" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Pay when your order is delivered.</p>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card">
                                        <div class="card-header" id="#payment-2">
                                            <h5 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-target="#collapseTwo"
                                                    aria-expanded="false" aria-controls="collapseTwo">
                                                    <input type="radio" name="payment_method" value="razorpay" {{ old('payment_method') == 'razorpay' ? 'checked' : '' }}>
                                                    Online Payment (Razorpay)
                                                </a>
                                            </h5>
                                        </div>
                                        <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                            <div class="card-body">
                                                <p>Pay securely using Razorpay.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @error('payment_method')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                                <div class="order-button-payment">
                                    <input value="Place order" type="submit" id="placeOrderBtn">
                                </div>
                                <div class="checkout-loader text-center mt-3" id="checkoutLoader" style="display:none;">
                                    <div class="checkout-spinner"
                                        style="width:30px;height:30px;border:3px solid #ddd;border-top-color:#2878f0;border-radius:50%;animation:checkoutSpin .7s linear infinite;margin:auto;">
                                    </div>
                                    <p class="mt-2 text-muted">Processing your order...</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
        </form>
    </div>
    </div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        let appliedDiscount = 0;
        const csrfToken = document.querySelector('meta[name="csrf-token"]')
            ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            : '{{ csrf_token() }}';
        const form = document.getElementById('checkoutForm');
        const button = document.getElementById('placeOrderBtn');
        const loader = document.getElementById('checkoutLoader');
        const showCoupon = document.getElementById('showcoupon');
        const couponContent = document.getElementById('checkout_coupon');

        function formatPrice(amount) {
            return '₹' + Number(amount || 0).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
        }

        function showToast(message, type = 'success') {
            if (typeof window.showToast === 'function') {
                window.showToast(message, type);
            } else {
                alert(message);
            }
        }

        function readCurrentTotals() {
            let subtotal = 0;
            document.querySelectorAll('.cart_item').forEach(function (row) {
                const price = parseFloat(row.dataset.price) || 0;
                const input = row.querySelector('.quantity-input');
                const qty = parseInt(input?.value) || 1;
                subtotal += price * qty;
            });
            const grand = Math.max(0, subtotal - appliedDiscount);
            return { subtotal: subtotal, grand: grand };
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
                subtotal = readCurrentTotals().subtotal;
            }

            if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);

            if (appliedDiscount > 0) {
                let discountRow = document.getElementById('couponDiscountRow');
                if (!discountRow) {
                    const orderTotalRow = document.querySelector('.order-total');
                    if (orderTotalRow) {
                        discountRow = document.createElement('tr');
                        discountRow.id = 'couponDiscountRow';
                        discountRow.innerHTML = '<th colspan="2">Coupon Discount</th><td><span class="amount" id="couponDiscount"></span></td>';
                        orderTotalRow.parentNode.insertBefore(discountRow, orderTotalRow);
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
            refreshTotals(readCurrentTotals().subtotal);
        }

        if (showCoupon && couponContent) {
            couponContent.style.display = 'none';
            showCoupon.addEventListener('click', function () {
                couponContent.style.display = (couponContent.style.display === 'none') ? 'block' : 'none';
            });
        }

        function updateCart(productId, quantity, row) {
            quantity = parseInt(quantity) || 1;
            if (quantity < 1) quantity = 1;

            fetch('{{ route('cart.update') }}', {
                method: 'PATCH',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ product_id: productId, quantity: quantity })
            })
            .then(function (response) {
                return response.json().then(function (data) {
                    return { ok: response.ok, data: data };
                });
            })
            .then(function (result) {
                const data = result.data;
                if (!result.ok || !data.success) {
                    throw new Error(data.message || 'Unable to update cart.');
                }
                if (!data.cart) {
                    throw new Error('Invalid cart response.');
                }

                const cart = data.cart;
                const items = cart.items || [];
                let subtotal = 0;

                items.forEach(function (item) {
                    const itemPrice = parseFloat(item.price) || 0;
                    const itemQty = parseInt(item.quantity) || 0;
                    subtotal += itemPrice * itemQty;

                    if (parseInt(item.product_id) === parseInt(productId) && row) {
                        const quantityInput = row.querySelector('.quantity-input');
                        if (quantityInput) quantityInput.value = itemQty;
                        updateItemTotal(row, itemQty);
                    }
                });

                if (cart.subtotal !== undefined) {
                    subtotal = parseFloat(cart.subtotal) || 0;
                }

                refreshTotals(subtotal);

                if (typeof window.loadMiniCart === 'function') {
                    window.loadMiniCart();
                }
            })
            .catch(function (error) {
                console.error('Update cart error:', error);
                showToast(error.message, 'error');
                if (row) {
                    const input = row.querySelector('.quantity-input');
                    if (input) {
                        input.value = Math.max(1, parseInt(input.value) || 1);
                        updateItemTotal(row, parseInt(input.value) || 1);
                    }
                }
                updateAllTotalsLocally();
            });
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
                updateCart(productId, qty, row);
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
                updateCart(productId, qty, row);
            });
        });

        const couponForm = document.getElementById('couponForm');
        const couponCode = document.getElementById('couponCode');
        const couponMessage = document.getElementById('couponMessage');
        const applyCouponBtn = document.getElementById('applyCouponBtn');

        if (couponForm) {
            couponForm.addEventListener('submit', function (e) {
                e.preventDefault();
                const code = couponCode.value.trim();
                if (!code) {
                    couponMessage.innerHTML = '<span class="text-danger">Please enter coupon code.</span>';
                    return;
                }

                applyCouponBtn.disabled = true;
                applyCouponBtn.value = 'Applying...';

                fetch('{{ route('checkout.apply-coupon') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ code: code })
                })
                .then(function (response) {
                    return response.json().then(function (data) {
                        return { ok: response.ok, data: data };
                    });
                })
                .then(function (result) {
                    const data = result.data;
                    if (!result.ok || !data.success) {
                        throw new Error(data.message || 'Unable to apply coupon.');
                    }
                    couponMessage.innerHTML = '<span class="text-success">' + data.message + '</span>';
                    couponCode.disabled = true;
                    applyCouponBtn.disabled = true;
                    applyCouponBtn.value = 'Applied';
                    appliedDiscount = parseFloat(data.discount) || 0;
                    const current = readCurrentTotals();
                    refreshTotals(current.subtotal);
                })
                .catch(function (error) {
                    couponMessage.innerHTML = '<span class="text-danger">' + error.message + '</span>';
                    applyCouponBtn.disabled = false;
                    applyCouponBtn.value = 'Apply Coupon';
                });
            });
        }

        if (form) {
            form.addEventListener('submit', function () {
                if (button) {
                    button.disabled = true;
                    button.value = 'Processing...';
                }
                if (loader) {
                    loader.style.display = 'block';
                }
            });
        }

        updateAllTotalsLocally();
    });
</script>
@endsection
