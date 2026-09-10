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
                        @if(isset($addresses) && $addresses->count())
                            <div class="saved-addresses mb-30">
                                <div class="saved-addresses-head">
                                    <h4 class="saved-addresses-title">Select Delivery Address</h4>
                                    <a href="{{ route('addresses.create') }}" class="add-new-link">+ Add New</a>
                                </div>

                                <div class="address-list">
                                    @foreach($addresses as $address)
                                        @php
                                            $isDefault = $address->is_default
                                                || ($defaultAddress && $defaultAddress->id == $address->id
                                                    && !$addresses->contains('is_default', true));
                                            $label = $address->label ?? null;
                                        @endphp

                                        <label class="address-card {{ $isDefault ? 'selected' : '' }}"
                                            data-address-id="{{ $address->id }}"
                                            data-country="{{ $address->country ?? 'India' }}"
                                            data-name="{{ $address->name }}"
                                            data-mobile="{{ $address->mobile }}"
                                            data-address="{{ $address->address }}"
                                            data-city="{{ $address->city }}"
                                            data-state="{{ $address->state }}"
                                            data-pincode="{{ $address->pincode }}">

                                            <input type="radio" name="delivery_address" class="address-radio" value="{{ $address->id }}"{{ $isDefault ? 'checked' : '' }}>
                                            <div class="address-card-body">
                                                <div class="address-card-head">
                                                    <span class="address-name">{{ $address->name }}</span>

                                                    <span class="address-tags">
                                                        @if($label)
                                                            <span class="address-tag">{{ strtoupper($label) }}</span>
                                                        @endif
                                                        @if($isDefault)
                                                            <span class="address-tag address-tag-default">DEFAULT</span>
                                                        @endif
                                                    </span>
                                                </div>

                                                <div class="address-line">{{ $address->address }}</div>
                                                <div class="address-line">
                                                    {{ $address->city }}, {{ $address->state }} - {{ $address->pincode }}
                                                </div>
                                                <div class="address-line address-muted">
                                                    {{ $address->mobile }} · {{ $address->country ?? 'India' }}
                                                </div>
                                            </div>
                                        </label>
                                    @endforeach

                                    <label class="address-card address-card-new" data-address-id="new">
                                        <input type="radio" class="address-radio">
                                        <div class="address-card-body">
                                            <div class="address-card-head">
                                                <span class="address-name">+ Add New Address</span>
                                            </div>
                                            <div class="address-line address-muted">
                                                Add another delivery address
                                            </div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        @endif
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
                                    <select class="nice-select wide" name="country" id="checkoutCountry" required>
                                        <option value="India" {{ old('country', $defaultAddress->country ?? 'India') == 'India' ? 'selected' : '' }}>India</option>
                                        <option value="UK" {{ old('country', $defaultAddress->country ?? '') == 'UK' ? 'selected' : '' }}>UK</option>
                                        <option value="USA" {{ old('country', $defaultAddress->country ?? '') == 'USA' ? 'selected' : '' }}>USA</option>
                                        <option value="Australia" {{ old('country', $defaultAddress->country ?? '') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                        <option value="Canada" {{ old('country', $defaultAddress->country ?? '') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                    </select>
                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        </div>
                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Full Name <span class="required">*</span></label>
                                <input type="text"
                                    name="customer_name"
                                    id="checkoutName"
                                    value="{{ old('customer_name', $defaultAddress->name ?? auth()->user()->name ?? '') }}"
                                    required>
                                @error('customer_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Email Address <span class="required">*</span></label>
                                <input type="email"
                                    name="email"
                                    value="{{ old('email', auth()->user()->email ?? '') }}"
                                    required>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Mobile Number <span class="required">*</span></label>
                                <input type="text"
                                    name="mobile_number"
                                    id="checkoutMobile"
                                    value="{{ old('mobile_number', $defaultAddress->mobile ?? auth()->user()->mobile ?? '') }}"
                                    required>
                                @error('mobile_number')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Address <span class="required">*</span></label>
                                <input type="text"
                                    name="address"
                                    id="checkoutAddress"
                                    placeholder="Street address"
                                    value="{{ old('address', $defaultAddress->address ?? '') }}"
                                    required>
                                @error('address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>City <span class="required">*</span></label>
                                <input type="text"
                                    name="city"
                                    id="checkoutCity"
                                    value="{{ old('city', $defaultAddress->city ?? '') }}"
                                    required>
                                @error('city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>State <span class="required">*</span></label>
                                <input type="text"
                                    name="state"
                                    id="checkoutState"
                                    value="{{ old('state', $defaultAddress->state ?? '') }}"
                                    required>
                                @error('state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Pincode <span class="required">*</span></label>
                                <input type="text"
                                    name="pincode"
                                    id="checkoutPincode"
                                    value="{{ old('pincode', $defaultAddress->pincode ?? '') }}"
                                    required>
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

                                            $gstRate = 0;
                                            $itemGst = 0;

                                            if ($product->gst_type === 'yes' && $product->gst) {
                                                $gstRate = (float) $product->gst->gst_amount;
                                                $itemGst = ($itemTotal * $gstRate) / 100;
                                            }
                                        @endphp
                                        <tr class="cart_item" id="cart-item-{{ $product->id }}" data-product-id="{{ $product->id }}" data-price="{{ $price }}" data-gst-rate="{{ $gstRate }}">
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
                                                <span class="amount">
                                                    ₹{{ number_format($itemTotal, 2) }}
                                                </span>
                                                @if($gstRate > 0)
                                                    <div class="product-gst">
                                                        GST {{ number_format($gstRate, 2) }}%:
                                                        ₹{{ number_format($itemGst, 2) }}
                                                    </div>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="cart-subtotal">
                                        <th colspan="2">Cart Subtotal</th>
                                        <td>
                                            <span class="amount" id="cartSubtotal">
                                                ₹{{ number_format($subtotal, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="cart-gst" id="cartGstRow" style="{{ $cartGst > 0 ? '' : 'display:none;' }}">
                                        <th colspan="2">GST</th>
                                        <td>
                                            <span class="amount" id="cartGst">
                                                ₹{{ number_format($cartGst, 2) }}
                                            </span>
                                        </td>
                                    </tr>
                                    <tr class="order-total">
                                        <th colspan="2">Order Total</th>
                                        <td>
                                            <strong>
                                                <span class="amount" id="cartGrandTotal">
                                                    ₹{{ number_format($subtotal + $cartGst, 2) }}
                                                </span>
                                            </strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                        <div class="payment-method">
    <h4 class="payment-title">Payment Method</h4>

    <div class="payment-options">

        <label class="payment-option {{ old('payment_method', 'cod') == 'cod' ? 'selected' : '' }}">
            <input type="radio"
                   name="payment_method"
                   value="cod"
                   class="payment-radio"
                   {{ old('payment_method', 'cod') == 'cod' ? 'checked' : '' }}>

            <span class="payment-radio-mark"></span>

            <div class="payment-option-body">
                <div class="payment-option-head">
                    <span class="payment-option-title">Cash on Delivery</span>
                </div>
                <p class="payment-option-desc">Pay when your order is delivered.</p>
            </div>
        </label>

        <label class="payment-option {{ old('payment_method') == 'razorpay' ? 'selected' : '' }}">
            <input type="radio"
                   name="payment_method"
                   value="razorpay"
                   class="payment-radio"
                   {{ old('payment_method') == 'razorpay' ? 'checked' : '' }}>

            <span class="payment-radio-mark"></span>

            <div class="payment-option-body">
                <div class="payment-option-head">
                    <span class="payment-option-title">Online Payment (Razorpay)</span>
                </div>
                <p class="payment-option-desc">Pay securely using UPI, Card, Netbanking, Wallet.</p>
            </div>
        </label>

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
            <div class="different-address mt-30">
            <div class="ship-different-title">
                <h3>
                    <label for="ship-box">Ship to a different address?</label>
                    <input id="ship-box" type="checkbox" name="ship_to_different" value="1"
                        {{ old('ship_to_different') ? 'checked' : '' }}>
                </h3>
            </div>
                    <div id="ship-box-info" class="row" style="{{ old('ship_to_different') ? '' : 'display:none;' }}">
                        <div class="col-md-12">
                            <div class="country-select clearfix">
                                <label>Country <span class="required">*</span></label>
                                <select class="nice-select wide" name="ship_country" id="shipCountry">
                                    <option value="India" {{ old('ship_country') == 'India' ? 'selected' : '' }}>India</option>
                                    <option value="UK" {{ old('ship_country') == 'UK' ? 'selected' : '' }}>UK</option>
                                    <option value="USA" {{ old('ship_country') == 'USA' ? 'selected' : '' }}>USA</option>
                                    <option value="Australia" {{ old('ship_country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                                    <option value="Canada" {{ old('ship_country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                                </select>
                                @error('ship_country')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Full Name <span class="required">*</span></label>
                                <input type="text" name="ship_name" id="shipName"
                                    value="{{ old('ship_name') }}">
                                @error('ship_name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Mobile Number <span class="required">*</span></label>
                                <input type="text" name="ship_mobile" id="shipMobile"
                                    value="{{ old('ship_mobile') }}">
                                @error('ship_mobile')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="checkout-form-list">
                                <label>Address <span class="required">*</span></label>
                                <input type="text" name="ship_address" id="shipAddress"
                                    placeholder="Street address" value="{{ old('ship_address') }}">
                                @error('ship_address')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>City <span class="required">*</span></label>
                                <input type="text" name="ship_city" id="shipCity"
                                    value="{{ old('ship_city') }}">
                                @error('ship_city')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>State <span class="required">*</span></label>
                                <input type="text" name="ship_state" id="shipState"
                                    value="{{ old('ship_state') }}">
                                @error('ship_state')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="checkout-form-list">
                                <label>Pincode <span class="required">*</span></label>
                                <input type="text" name="ship_pincode" id="shipPincode"
                                    value="{{ old('ship_pincode') }}">
                                @error('ship_pincode')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
        </form>
    </div>
</div>
<style>
.payment-title {
    font-size: 16px;
    font-weight: 600;
    color: #222;
    margin-bottom: 12px;
    padding-bottom: 8px;
    border-bottom: 1px solid #eee;
}

.payment-options {
    display: flex;
    flex-direction: column;
    gap: 10px;
    margin-bottom: 18px;
}

.payment-option {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background: #fff;
    cursor: pointer;
    transition: border-color .15s, background .15s, box-shadow .15s;
    margin-bottom: 0;
    position: relative;
}

.payment-option:hover {
    border-color: #2878f0;
    background: #f9fbff;
}

.payment-option.selected {
    border-color: #2878f0;
    background: #f0f7ff;
    box-shadow: 0 0 0 3px rgba(40, 120, 240, 0.08);
}

.payment-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
    width: 0;
    height: 0;
}

.payment-radio-mark {
    flex-shrink: 0;
    width: 20px;
    height: 20px;
    border-radius: 50%;
    border: 2px solid #b5b5b5;
    background: #fff;
    display: inline-block;
    position: relative;
    margin-top: 1px;
    transition: border-color .15s;
}

.payment-radio-mark::after {
    content: "";
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%) scale(0);
    width: 10px;
    height: 10px;
    border-radius: 50%;
    background: #2878f0;
    transition: transform .15s;
}

.payment-option.selected .payment-radio-mark {
    border-color: #2878f0;
}

.payment-option.selected .payment-radio-mark::after {
    transform: translate(-50%, -50%) scale(1);
}

.payment-option-body {
    flex: 1;
    min-width: 0;
}

.payment-option-head {
    display: flex;
    align-items: center;
    gap: 8px;
    margin-bottom: 4px;
}

.payment-option-title {
    font-size: 15px;
    font-weight: 600;
    color: #222;
    line-height: 1.3;
}

.payment-option-desc {
    font-size: 13px;
    color: #666;
    margin: 0;
    line-height: 1.45;
}
</style>
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
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
            let gst = 0;

            document.querySelectorAll('.cart_item').forEach(function (row) {
                const price = parseFloat(row.dataset.price) || 0;
                const gstRate = parseFloat(row.dataset.gstRate) || 0;
                const input = row.querySelector('.quantity-input');
                const qty = parseInt(input?.value) || 1;

                const itemTotal = price * qty;
                const itemGst = (itemTotal * gstRate) / 100;

                subtotal += itemTotal;
                gst += itemGst;
            });

            const grand = Math.max(0, subtotal + gst - appliedDiscount);

            return {
                subtotal: subtotal,
                gst: gst,
                grand: grand
            };
        }

        function updateItemTotal(row, quantity) {
            if (!row) return;

            const price   = parseFloat(row.dataset.price) || 0;
            const gstRate = parseFloat(row.dataset.gstRate) || 0;

            const itemTotal = price * quantity;
            const itemGst   = (itemTotal * gstRate) / 100;

            const totalEl = row.querySelector('.item-total .amount');
            if (totalEl) totalEl.textContent = formatPrice(itemTotal);

            const gstLine = row.querySelector('.item-total .product-gst');
            if (gstLine && gstRate > 0) {
                gstLine.textContent = 'GST ' + gstRate.toFixed(2) + '%: ' + formatPrice(itemGst);
            }
        }

        function refreshTotals(subtotalOverride) {
            const subtotalEl   = document.getElementById('cartSubtotal');
            const gstEl        = document.getElementById('cartGst');
            const gstRow       = document.getElementById('cartGstRow');
            const grandTotalEl = document.getElementById('cartGrandTotal');

            const totals = readCurrentTotals();
            const subtotal = (subtotalOverride === undefined || subtotalOverride === null)
                ? totals.subtotal
                : subtotalOverride;

            const gst = totals.gst;

            if (subtotalEl) subtotalEl.textContent = formatPrice(subtotal);

            if (gstEl)  gstEl.textContent  = formatPrice(gst);
            if (gstRow) gstRow.style.display = gst > 0 ? '' : 'none';

            let grand;
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

                grand = Math.max(0, subtotal + gst - appliedDiscount);
            } else {
                const discountRow = document.getElementById('couponDiscountRow');
                if (discountRow) discountRow.remove();

                grand = subtotal + gst;
            }

            if (grandTotalEl) grandTotalEl.textContent = formatPrice(grand);
        }

        function updateAllTotalsLocally() {
            refreshTotals();
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

        function startRazorpayPayment() {
            const formData = new FormData(form);
            fetch('{{ route('checkout.place-order') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(data.message || 'Unable to create payment.');
                }
                if (!data.payment_required) {
                    window.location.href = data.redirect_url;
                    return;
                }
                const options = {
                    key: data.razorpay_key,
                    amount: data.amount,
                    currency: data.currency || 'INR',
                    name: 'Aethelweave',
                    description: 'Order Payment',
                    order_id: data.razorpay_order_id,
                    prefill: {
                        name: data.customer_name || '',
                        email: data.email || '',
                        contact: data.mobile || ''
                    },
                    theme: {
                        color: '#2878f0'
                    },
                    handler: function (response) {
                        verifyRazorpayPayment(response);
                    },
                    modal: {
                        ondismiss: function () {
                            if (button) {
                                button.disabled = false;
                                button.value = 'Place order';
                            }
                            if (loader) {
                                loader.style.display = 'none';
                            }
                        }
                    }
                };
                const razorpay = new Razorpay(options);
                razorpay.on('payment.failed', function (response) {
                    console.error('Razorpay Payment Failed:', response.error);
                    showToast(
                        response.error.description || 'Payment failed.',
                        'error'
                    );
                    if (button) {
                        button.disabled = false;
                        button.value = 'Place order';
                    }
                    if (loader) {
                        loader.style.display = 'none';
                    }
                });
                razorpay.open();
            })
            .catch(error => {
                console.error(error);
                showToast(
                    error.message || 'Unable to start Razorpay payment.',
                    'error'
                );
                if (button) {
                    button.disabled = false;
                    button.value = 'Place order';
                }
                if (loader) {
                    loader.style.display = 'none';
                }
            });
        }

        function verifyRazorpayPayment(response) {
            fetch('{{ route('razorpay.verify') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({
                    razorpay_payment_id: response.razorpay_payment_id,
                    razorpay_order_id: response.razorpay_order_id,
                    razorpay_signature: response.razorpay_signature
                })
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    throw new Error(
                        data.message || 'Payment verification failed.'
                    );
                }
                window.location.href = data.redirect_url;
            })
            .catch(error => {
                console.error('Payment verification error:', error);
                showToast(
                    error.message || 'Payment verification failed.',
                    'error'
                );
                if (button) {
                    button.disabled = false;
                    button.value = 'Place order';
                }
                if (loader) {
                    loader.style.display = 'none';
                }
            });
        }

        if (form) {
            form.addEventListener('submit', function (e) {
                const paymentMethod = document.querySelector('input[name="payment_method"]:checked')?.value;

                if (button) { button.disabled = true; button.value = 'Processing...'; }
                if (loader) { loader.style.display = 'block'; }

                if (paymentMethod === 'razorpay') {
                    e.preventDefault();
                    startRazorpayPayment();
                    return;
                }
            });
        }

        updateAllTotalsLocally();

        const paymentOptions = document.querySelectorAll('.payment-option');

        function updatePaymentSelection() {
            paymentOptions.forEach(function (opt) {
                const radio = opt.querySelector('.payment-radio');
                if (radio && radio.checked) {
                    opt.classList.add('selected');
                } else {
                    opt.classList.remove('selected');
                }
            });
        }

        paymentOptions.forEach(function (opt) {
            const radio = opt.querySelector('.payment-radio');
            if (radio) {
                radio.addEventListener('change', updatePaymentSelection);
            }
        });

        updatePaymentSelection();

        document.querySelectorAll('.address-radio').forEach(function (radio) {
            radio.addEventListener('change', function () {
                const card = this.closest('.address-card');
                if (!card) return;

                const name    = document.getElementById('checkoutName');
                const mobile  = document.getElementById('checkoutMobile');
                const address = document.getElementById('checkoutAddress');
                const city    = document.getElementById('checkoutCity');
                const state   = document.getElementById('checkoutState');
                const pincode = document.getElementById('checkoutPincode');
                const country = document.getElementById('checkoutCountry');

                const isNew = card.dataset.addressId === 'new';

                if (isNew) {
                    if (name)    name.value    = '';
                    if (mobile)  mobile.value  = '';
                    if (address) address.value = '';
                    if (city)    city.value    = '';
                    if (state)   state.value   = '';
                    if (pincode) pincode.value = '';
                    if (country) {
                        country.value = 'India';
                        if (typeof jQuery !== 'undefined' && jQuery.fn.niceSelect) {
                            jQuery(country).niceSelect('update');
                        }
                    }
                } else {
                    if (name)    name.value    = card.dataset.name    || '';
                    if (mobile)  mobile.value  = card.dataset.mobile  || '';
                    if (address) address.value = card.dataset.address || '';
                    if (city)    city.value    = card.dataset.city    || '';
                    if (state)   state.value   = card.dataset.state   || '';
                    if (pincode) pincode.value = card.dataset.pincode || '';
                    if (country) {
                        country.value = card.dataset.country || 'India';
                        if (typeof jQuery !== 'undefined' && jQuery.fn.niceSelect) {
                            jQuery(country).niceSelect('update');
                        }
                    }
                }

                document.querySelectorAll('.address-card').forEach(function (c) {
                    c.classList.remove('selected');
                });
                card.classList.add('selected');
            });
        });

        const selectedAddress = document.querySelector('.address-radio:checked');
        if (selectedAddress) {
            selectedAddress.dispatchEvent(new Event('change'));
        }

        const shipBox          = document.getElementById('ship-box');
        const shipBoxInfo      = document.getElementById('ship-box-info');
        const savedAddressWrap = document.querySelector('.saved-addresses');

        function toggleShipTo() {
            if (!shipBox || !shipBoxInfo) return;

            const on = shipBox.checked;
            shipBoxInfo.style.display = on ? '' : 'none';

            if (on) {
                if (savedAddressWrap) {
                    savedAddressWrap.classList.add('fields-locked');
                    savedAddressWrap.style.opacity = '0.5';
                    savedAddressWrap.style.pointerEvents = 'none';
                }
                document.querySelectorAll('.address-radio').forEach(r => r.checked = false);
                document.querySelectorAll('.address-card').forEach(c => c.classList.remove('selected'));
            } else {
                if (savedAddressWrap) {
                    savedAddressWrap.classList.remove('fields-locked');
                    savedAddressWrap.style.opacity = '';
                    savedAddressWrap.style.pointerEvents = '';

                    const first = document.querySelector('.address-radio');
                    if (first && !document.querySelector('.address-radio:checked')) {
                        first.checked = true;
                        first.dispatchEvent(new Event('change'));
                    }
                }
            }
        }

        if (shipBox) {
            shipBox.addEventListener('change', toggleShipTo);
            toggleShipTo();
        }
    });
</script>
@endsection
