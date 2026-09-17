@extends('frontend.layouts.app')

@section('title', $meta_title ?? 'PC Builder Checkout')

@section('meta')
    <meta name="keywords" content="{{ $meta_keyword ?? '' }}">
    <meta name="description" content="{{ $meta_description ?? '' }}">
@endsection

@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <h2>PC Builder Checkout</h2>
            <ul>
                <li><a href="{{ url('/') }}">Home</a></li>
                <li>PC Builder Checkout</li>
            </ul>
        </div>
    </div>
</div>

<div class="checkout-area pt-60 pb-60">
    <div class="container">

        <div id="pcBuilderLoading" class="text-center py-5">
            <div class="checkout-spinner"></div>
            <p class="mt-3 text-muted">Loading your PC build...</p>
        </div>

        <div id="pcBuilderEmpty" class="text-center py-5" style="display:none;">
            <h3>No components selected</h3>
            <p class="text-muted">
                Please select components before proceeding to checkout.
            </p>
            <a href="{{ route('pc-builder.index') }}" class="btn btn-danger mt-3">
                Back to PC Builder
            </a>
        </div>

        <form
            action="{{ route('pc-builder.place-order') }}"
            method="POST"
            id="pcBuilderCheckoutForm"
            style="display:none;"
        >
            @csrf

            <input type="hidden" name="delivery_address" id="deliveryAddressId">

            <div class="row">

                <div class="col-lg-6 col-12">

                    <div class="checkbox-form">

                        <h3>Billing Details</h3>

                        @if(isset($addresses) && $addresses->count())

                            <div class="saved-addresses mb-30">

                                <div class="saved-addresses-head">
                                    <h4 class="saved-addresses-title">
                                        Select Delivery Address
                                    </h4>

                                    <a href="{{ route('addresses.create') }}" class="add-new-link">
                                        + Add New
                                    </a>
                                </div>

                                <div class="address-list">

                                    @foreach($addresses as $address)

                                        @php
                                            $isDefault =
                                                $address->is_default ||
                                                (
                                                    $defaultAddress &&
                                                    $defaultAddress->id == $address->id &&
                                                    !$addresses->contains('is_default', true)
                                                );

                                            $label = $address->label ?? null;
                                        @endphp

                                        <label
                                            class="address-card {{ $isDefault ? 'selected' : '' }}"
                                            data-address-id="{{ $address->id }}"
                                            data-country="{{ $address->country ?? 'India' }}"
                                            data-name="{{ $address->name }}"
                                            data-mobile="{{ $address->mobile }}"
                                            data-address="{{ $address->address }}"
                                            data-city="{{ $address->city }}"
                                            data-state="{{ $address->state }}"
                                            data-pincode="{{ $address->pincode }}"
                                        >

                                            <input
                                                type="radio"
                                                name="delivery_address"
                                                class="address-radio"
                                                value="{{ $address->id }}"
                                                {{ $isDefault ? 'checked' : '' }}
                                            >

                                            <div class="address-card-body">

                                                <div class="address-card-head">

                                                    <span class="address-name">
                                                        {{ $address->name }}
                                                    </span>

                                                    <span class="address-tags">

                                                        @if($label)
                                                            <span class="address-tag">
                                                                {{ strtoupper($label) }}
                                                            </span>
                                                        @endif

                                                        @if($isDefault)
                                                            <span class="address-tag address-tag-default">
                                                                DEFAULT
                                                            </span>
                                                        @endif

                                                    </span>

                                                </div>

                                                <div class="address-line">
                                                    {{ $address->address }}
                                                </div>

                                                <div class="address-line">
                                                    {{ $address->city }},
                                                    {{ $address->state }} -
                                                    {{ $address->pincode }}
                                                </div>

                                                <div class="address-line address-muted">
                                                    {{ $address->mobile }}
                                                    ·
                                                    {{ $address->country ?? 'India' }}
                                                </div>

                                            </div>

                                        </label>

                                    @endforeach

                                </div>

                            </div>

                        @else

                            <div class="alert alert-warning">
                                No saved address found.
                                <a href="{{ route('addresses.create') }}">
                                    Add a new address
                                </a>
                            </div>

                        @endif

                        @if($errors->any())

                            <div class="alert alert-danger">

                                <ul class="mb-0">

                                    @foreach($errors->all() as $error)

                                        <li>{{ $error }}</li>

                                    @endforeach

                                </ul>

                            </div>

                        @endif

                        <div id="billingFields" class="billing-fields">
                            <div class="billing-locked-hint">
                                These details are filled from your selected saved address.
                                Uncheck or choose another address to edit them.
                            </div>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="country-select clearfix">

                                    <label>
                                        Country
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        class="nice-select wide"
                                        name="country"
                                        id="checkoutCountry"
                                        required
                                    >

                                        <option
                                            value="India"
                                            {{ old('country', $defaultAddress->country ?? 'India') == 'India' ? 'selected' : '' }}
                                        >
                                            India
                                        </option>

                                        <option
                                            value="UK"
                                            {{ old('country', $defaultAddress->country ?? '') == 'UK' ? 'selected' : '' }}
                                        >
                                            UK
                                        </option>

                                        <option
                                            value="USA"
                                            {{ old('country', $defaultAddress->country ?? '') == 'USA' ? 'selected' : '' }}
                                        >
                                            USA
                                        </option>

                                        <option
                                            value="Australia"
                                            {{ old('country', $defaultAddress->country ?? '') == 'Australia' ? 'selected' : '' }}
                                        >
                                            Australia
                                        </option>

                                        <option
                                            value="Canada"
                                            {{ old('country', $defaultAddress->country ?? '') == 'Canada' ? 'selected' : '' }}
                                        >
                                            Canada
                                        </option>

                                    </select>

                                    @error('country')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Full Name
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="customer_name"
                                        id="checkoutName"
                                        value="{{ old('customer_name', $defaultAddress->name ?? auth()->user()->name ?? '') }}"
                                        required
                                    >

                                    @error('customer_name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Email Address
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="email"
                                        name="email"
                                        value="{{ old('email', auth()->user()->email ?? '') }}"
                                        required
                                    >

                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Mobile Number
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="mobile_number"
                                        id="checkoutMobile"
                                        value="{{ old('mobile_number', $defaultAddress->mobile ?? auth()->user()->mobile ?? '') }}"
                                        required
                                    >

                                    @error('mobile_number')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="checkout-form-list">

                                    <label>
                                        Address
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="address"
                                        id="checkoutAddress"
                                        placeholder="Street address"
                                        value="{{ old('address', $defaultAddress->address ?? '') }}"
                                        required
                                    >

                                    @error('address')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        City
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="city"
                                        id="checkoutCity"
                                        value="{{ old('city', $defaultAddress->city ?? '') }}"
                                        required
                                    >

                                    @error('city')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        State
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="state"
                                        id="checkoutState"
                                        value="{{ old('state', $defaultAddress->state ?? '') }}"
                                        required
                                    >

                                    @error('state')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Pincode
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="pincode"
                                        id="checkoutPincode"
                                        value="{{ old('pincode', $defaultAddress->pincode ?? '') }}"
                                        required
                                    >

                                    @error('pincode')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="order-notes">

                                    <div class="checkout-form-list">

                                        <label>Order Notes</label>

                                        <textarea
                                            id="checkout-mess"
                                            cols="30"
                                            rows="8"
                                            name="order_notes"
                                            placeholder="Notes about your order, e.g. special notes for delivery."
                                        >{{ old('order_notes') }}</textarea>

                                        @error('order_notes')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>

                                </div>

                            </div>

                        </div>
                        </div>

                    </div>

                </div>

                <div class="col-lg-6 col-12">
                    <div class="your-order">
                        <h3 class="order-title">Your PC Build</h3>

                        <div id="selectedComponentsArea"></div>
                        <div class="order-table-wrap">
                            <table class="order-table">
                                <thead>
                                    <tr>
                                    <th>Image</th>
                                    <th>Components</th>
                                    <th>Price</th>
                                    <th>GST Rate</th>
                                    <th>GST Amount</th>
                                    <th>Total</th>
                                </tr>
                                </thead>
                                <tbody id="pcBuilderProductsList"></tbody>
                                <tfoot>
                                    <tr>
                                        <td>Cart Subtotal</td>
                                        <td class="text-end"><span id="cartSubtotal">₹0.00</span></td>
                                    </tr>
                                    <tr id="cartCgstRow" style="display:none;">
                                        <td>CGST</td>
                                        <td class="text-end"><span id="cartCgst">₹0.00</span></td>
                                    </tr>
                                    <tr id="cartSgstRow" style="display:none;">
                                        <td>SGST</td>
                                        <td class="text-end"><span id="cartSgst">₹0.00</span></td>
                                    </tr>
                                    <tr id="cartIgstRow" style="display:none;">
                                        <td>IGST</td>
                                        <td class="text-end"><span id="cartIgst">₹0.00</span></td>
                                    </tr>
                                    <tr id="cartShippingRow">
                                        <td>
                                            Shipping
                                            <small id="shippingLabel" class="text-muted"></small>
                                        </td>
                                        <td class="text-end"><span id="cartShipping">₹0.00</span></td>
                                    </tr>
                                    <tr class="grand-total">
                                        <td><strong>Order Total</strong></td>
                                        <td class="text-end"><strong><span id="cartGrandTotal">₹0.00</span></strong></td>
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

                            <label class="payment-option payment-option-disabled">
                                <input type="radio"
                                    name="payment_method"
                                    value="snapmint_emi"
                                    class="payment-radio"
                                    disabled>

                                <span class="payment-radio-mark"></span>

                                <div class="payment-option-body">
                                    <div class="payment-option-head">
                                        <span class="payment-option-title">
                                            Snapmint EMI
                                            <span class="payment-option-badge">Coming Soon</span>
                                        </span>
                                    </div>
                                    <p class="payment-option-desc">This payment method will be available in the future. Stay tuned!</p>
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
                            <p class="mt-2 text-muted">Processing your order...</p>
                        </div>
                    </div>
                    </div>
                </div>

            </div>

            <div class="different-address mt-30">

                <div class="ship-different-title">

                    <h3>

                        <label for="ship-box">
                            Ship to a different address?
                        </label>

                        <input
                            id="ship-box"
                            type="checkbox"
                            name="ship_to_different"
                            value="1"
                            {{ old('ship_to_different') ? 'checked' : '' }}
                        >

                    </h3>

                </div>

                <div
                    id="ship-box-info"
                    style="display:none;"
                >

                    <div class="checkbox-form">

                        <h3>Shipping Details</h3>

                        <div class="row">

                            <div class="col-md-12">

                                <div class="country-select clearfix">

                                    <label>
                                        Country
                                        <span class="required">*</span>
                                    </label>

                                    <select
                                        class="nice-select wide"
                                        name="ship_country"
                                        id="shipCountry"
                                    >

                                        <option
                                            value="India"
                                            {{ old('ship_country', 'India') == 'India' ? 'selected' : '' }}
                                        >
                                            India
                                        </option>

                                        <option
                                            value="UK"
                                            {{ old('ship_country') == 'UK' ? 'selected' : '' }}
                                        >
                                            UK
                                        </option>

                                        <option
                                            value="USA"
                                            {{ old('ship_country') == 'USA' ? 'selected' : '' }}
                                        >
                                            USA
                                        </option>

                                        <option
                                            value="Australia"
                                            {{ old('ship_country') == 'Australia' ? 'selected' : '' }}
                                        >
                                            Australia
                                        </option>

                                        <option
                                            value="Canada"
                                            {{ old('ship_country') == 'Canada' ? 'selected' : '' }}
                                        >
                                            Canada
                                        </option>

                                    </select>

                                    @error('ship_country')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Full Name
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_name"
                                        id="shipName"
                                        value="{{ old('ship_name') }}"
                                    >

                                    @error('ship_name')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Mobile Number
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_mobile"
                                        id="shipMobile"
                                        value="{{ old('ship_mobile') }}"
                                    >

                                    @error('ship_mobile')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-12">

                                <div class="checkout-form-list">

                                    <label>
                                        Address
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_address"
                                        id="shipAddress"
                                        placeholder="Street address"
                                        value="{{ old('ship_address') }}"
                                    >

                                    @error('ship_address')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        City
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_city"
                                        id="shipCity"
                                        value="{{ old('ship_city') }}"
                                    >

                                    @error('ship_city')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        State
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_state"
                                        id="shipState"
                                        value="{{ old('ship_state') }}"
                                    >

                                    @error('ship_state')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                            <div class="col-md-6">

                                <div class="checkout-form-list">

                                    <label>
                                        Pincode
                                        <span class="required">*</span>
                                    </label>

                                    <input
                                        type="text"
                                        name="ship_pincode"
                                        id="shipPincode"
                                        value="{{ old('ship_pincode') }}"
                                    >

                                    @error('ship_pincode')
                                        <span class="text-danger">
                                            {{ $message }}
                                        </span>
                                    @enderror

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </form>

    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<script>
    function showSwal(message, icon = 'error') {
    return Swal.fire({
        icon: icon,
        title: icon === 'success' ? 'Success' : 'Oops!',
        text: message,
        confirmButtonText: 'OK',
        confirmButtonColor: '#fed700'
    });
}
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       CONFIGURATION & STATE
       ============================================================ */

    const storageKey = 'pcBuilderProducts';
    const quantityStorageKey = 'pcBuilderQuantities';

    let selectedProducts = {};
    let quantities = {};
    let productsData = {};
    let currentTotal = 0;
    let isSubmitting = false;
    let shippingCharge = 0;
    let shippingFetchTimer = null;

    try {
        selectedProducts = JSON.parse(localStorage.getItem(storageKey)) || {};
    } catch (error) {
        selectedProducts = {};
    }

    try {
        quantities = JSON.parse(localStorage.getItem(quantityStorageKey)) || {};
    } catch (error) {
        quantities = {};
    }

    /* ============================================================
       DOM ELEMENTS
       ============================================================ */

    const loading = document.getElementById('pcBuilderLoading');
    const empty = document.getElementById('pcBuilderEmpty');
    const form = document.getElementById('pcBuilderCheckoutForm');
    const productsList = document.getElementById('pcBuilderProductsList');

    const billingFields = document.getElementById('billingFields');

    /* ============================================================
       BILLING LOCK HELPERS
       ============================================================ */

    function setBillingLocked(locked) {
        if (!billingFields) return;

        if (locked) {
            billingFields.classList.add('billing-locked');
            billingFields
                .querySelectorAll('input, select, textarea')
                .forEach(el => {
                    if (el.type === 'hidden') return;
                    el.setAttribute('tabindex', '-1');
                });
        } else {
            billingFields.classList.remove('billing-locked');
            billingFields
                .querySelectorAll('input, select, textarea')
                .forEach(el => {
                    el.removeAttribute('tabindex');
                });
        }
    }

    /* ============================================================
       UTILITY FUNCTIONS
       ============================================================ */

    function showEmptyState() {
        if (loading) {
            loading.style.display = 'none';
        }

        if (form) {
            form.style.display = 'none';
        }

        if (empty) {
            empty.style.display = 'block';
        }
    }

    function saveQuantities() {
        localStorage.setItem(
            quantityStorageKey,
            JSON.stringify(quantities)
        );
    }

    function getQuantity(productId) {
        productId = String(productId);

        let quantity = parseInt(quantities[productId], 10);

        if (!Number.isFinite(quantity) || quantity < 1) {
            quantity = 1;
        }

        return quantity;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text || '';
        return div.innerHTML;
    }

    function buildImageUrl(image) {
        if (!image) {
            return null;
        }

        image = String(image).trim();

        if (!image) {
            return null;
        }

        if (
            image.startsWith('http://') ||
            image.startsWith('https://') ||
            image.startsWith('data:')
        ) {
            return image;
        }

        image = image.replace(/^\/+/, '');

        if (image.startsWith('storage/')) {
            return "{{ url('/') }}/" + image;
        }

        return "{{ url('/storage') }}/" + image;
    }

    function getProductImage(product) {
        const fallback =
            "{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}";

        if (!product) {
            return fallback;
        }

        if (product.image) {
            const imageUrl = buildImageUrl(product.image);

            if (imageUrl) {
                return imageUrl;
            }
        }

        if (product.productimage) {
            const imageUrl = buildImageUrl(product.productimage);

            if (imageUrl) {
                return imageUrl;
            }
        }

        if (
            product.images &&
            Array.isArray(product.images) &&
            product.images.length > 0
        ) {
            let primaryImage = product.images.find(function (image) {
                return (
                    image &&
                    (image.isprimary == 1 || image.isprimary === true)
                );
            });

            if (!primaryImage) {
                primaryImage = product.images[0];
            }

            if (primaryImage) {
                const imageValue =
                    primaryImage.image ||
                    primaryImage.productimage ||
                    primaryImage.imagepath ||
                    primaryImage.path;

                const imageUrl = buildImageUrl(imageValue);

                if (imageUrl) {
                    return imageUrl;
                }
            }
        }

        return fallback;
    }

    function getProductPrice(product) {
        if (!product) {
            return 0;
        }

        const regularPrice = parseFloat(product.price) || 0;
        const salePrice = parseFloat(product.saleprice) || 0;

        if (
            salePrice > 0 &&
            regularPrice > 0 &&
            salePrice < regularPrice
        ) {
            return salePrice;
        }

        return regularPrice;
    }

    function formatPrice(value) {
        return '₹' +
            Number(value || 0).toLocaleString('en-IN', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
    }

    function getStock(product) {
    const stock = parseInt(product.stockquantity, 10);

        if (!Number.isFinite(stock)) {
            return 0;
        }

        return stock;
    }


    function getProductGstRate(product) {
        if (!product) {
            return 0;
        }

        // Backend field: gst_rate (e.g. 10 means 10%)
        const rate = parseFloat(product.gst_rate);

        return Number.isFinite(rate) && rate > 0 ? rate : 0;
    }

    /* ============================================================
       DELIVERY ADDRESS RESOLVER
       ============================================================ */

    function getDeliveryAddressFields() {
        const shipBox = document.getElementById('ship-box');
        const useShipping = shipBox && shipBox.checked;

        if (useShipping) {
            return {
                pincode: document.getElementById('shipPincode'),
                city:    document.getElementById('shipCity'),
                state:   document.getElementById('shipState'),
            };
        }
        return {
            pincode: document.getElementById('checkoutPincode'),
            city:    document.getElementById('checkoutCity'),
            state:   document.getElementById('checkoutState'),
        };
    }

    function fetchShippingCharge(immediate) {
        const delivery = getDeliveryAddressFields();
        const labelEl  = document.getElementById('shippingLabel');

        const pincode = delivery.pincode ? delivery.pincode.value.trim() : '';
        const city    = delivery.city    ? delivery.city.value.trim()    : '';
        const state   = delivery.state   ? delivery.state.value.trim()   : '';

        const doFetch = function () {
            fetch('{{ route('checkout.shipping-charge') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                body: JSON.stringify({ pincode: pincode, city: city, state: state })
            })
            .then(function (r) { return r.json(); })
            .then(function (data) {
                if (data.success) {
                    shippingCharge = parseFloat(data.charge) || 0;
                    if (labelEl) labelEl.textContent = data.name ? '(' + data.name + ')' : '';
                } else {
                    shippingCharge = 0;
                    if (labelEl) labelEl.textContent = '';
                }
                calculateTotals();
            })
            .catch(function (err) {
                console.error('Shipping fetch error:', err);
                shippingCharge = 0;
                calculateTotals();
            });
        };

        if (immediate) {
            doFetch();
        } else {
            clearTimeout(shippingFetchTimer);
            shippingFetchTimer = setTimeout(doFetch, 400);
        }
    }

    // Attach listeners to BOTH billing and shipping address fields
    [
        'checkoutPincode', 'checkoutCity', 'checkoutState',
        'shipPincode',     'shipCity',     'shipState'
    ].forEach(function (id) {
        const el = document.getElementById(id);
        if (!el) return;
        el.addEventListener('input',  function () { fetchShippingCharge(false); calculateTotals(); });
        el.addEventListener('change', function () { fetchShippingCharge(true);  calculateTotals(); });
    });

    /* ============================================================
       CALCULATION FUNCTIONS
       ============================================================ */

    function calculateTotals() {
        let subtotal = 0;
        let gstTotal = 0;
        let cgstTotal = 0;
        let sgstTotal = 0;
        let igstTotal = 0;

        // Delivery state — shipping if ship_to_different, else billing
        const delivery = getDeliveryAddressFields();
        const state = (delivery.state?.value || '').trim().toLowerCase();
        const isMaharashtra = state === 'maharashtra';

        Object.keys(productsData).forEach(function (id) {
            const product = productsData[id];
            const quantity = getQuantity(id);
            const price = getProductPrice(product);
            const itemTotal = price * quantity;

            subtotal += itemTotal;

            const gstRate = getProductGstRate(product);

            if (gstRate > 0) {
                const itemGst = (itemTotal * gstRate) / 100;
                gstTotal += itemGst;

                if (isMaharashtra) {
                    cgstTotal += itemGst / 2;
                    sgstTotal += itemGst / 2;
                } else {
                    igstTotal += itemGst;
                }
            }
        });

        currentTotal = subtotal + gstTotal + shippingCharge;

        const subtotalElement = document.getElementById('cartSubtotal');
        const grandTotalElement = document.getElementById('cartGrandTotal');
        const shippingElement = document.getElementById('cartShipping');
        const shippingRow = document.getElementById('cartShippingRow');

        const cgstRow = document.getElementById('cartCgstRow');
        const sgstRow = document.getElementById('cartSgstRow');
        const igstRow = document.getElementById('cartIgstRow');

        if (subtotalElement) {
            subtotalElement.textContent = formatPrice(subtotal);
        }

        if (cgstRow) {
            cgstRow.style.display = cgstTotal > 0 ? '' : 'none';
            const el = document.getElementById('cartCgst');
            if (el) el.textContent = formatPrice(cgstTotal);
        }

        if (sgstRow) {
            sgstRow.style.display = sgstTotal > 0 ? '' : 'none';
            const el = document.getElementById('cartSgst');
            if (el) el.textContent = formatPrice(sgstTotal);
        }

        if (igstRow) {
            igstRow.style.display = igstTotal > 0 ? '' : 'none';
            const el = document.getElementById('cartIgst');
            if (el) el.textContent = formatPrice(igstTotal);
        }

        if (shippingElement) {
            shippingElement.textContent = shippingCharge > 0
                ? formatPrice(shippingCharge)
                : formatPrice(0);
        }

        if (shippingRow) {
            shippingRow.style.display = '';
        }

        if (grandTotalElement) {
            grandTotalElement.textContent = formatPrice(currentTotal);
        }
    }

    /* ============================================================
       RENDER FUNCTIONS
       ============================================================ */

    function renderProducts(products) {
        productsData = {};

        if (!productsList) {
            return;
        }

        productsList.innerHTML = '';

        if (!products || products.length === 0) {
            showEmptyState();
            return;
        }

        products.forEach(function (product) {
            const id = String(product.id);

            productsData[id] = product;

            let quantity = getQuantity(id);
            const stock = getStock(product);

            if (stock > 0 && quantity > stock) {
                quantity = stock;
                quantities[id] = stock;
                saveQuantities();
            }

            if (stock <= 0) {
                quantity = 1;
            }

            const price = getProductPrice(product);
            const itemTotal = price * quantity;
            const gstRate = getProductGstRate(product);
            const gstAmount = gstRate > 0 ? (itemTotal * gstRate) / 100 : 0;

            const image = getProductImage(product);

            const row = document.createElement('tr');

            row.className = 'cartitem';
            row.id = 'builder-cart-item-' + id;
            row.dataset.productId = id;
            row.dataset.price = price;
            row.dataset.gstRate = gstRate;

            row.innerHTML = `
                <td class="cart-product-image">
                    <img
                        src="${image}"
                        alt="${escapeHtml(product.name)}"
                        class="pc-builder-product-image"
                        onerror="this.onerror=null;this.src='{{ asset('assets/frontend/assets/images/product/large-size/1.jpg') }}';"
                    style="width: 60px;height: 40px;">
                </td>
                <td class="cart-product-name">
                    ${escapeHtml(product.name)}
                </td>
                <td class="cart-product-price">
                    ${formatPrice(price)}
                </td>
                <td class="cart-product-gst-rate">
                    ${gstRate > 0 ? gstRate.toFixed(2) + '%' : '0%'}
                </td>
                <td class="cart-product-gst-amount">
                    ${gstAmount > 0 ? formatPrice(gstAmount) : formatPrice(0)}
                </td>
                <td class="cart-product-total item-total text-end">
                    <div class="price-cell">
                        <span class="amount">
                            ${formatPrice(itemTotal + gstAmount)}
                        </span>
                    </div>
                </td>
            `;

            productsList.appendChild(row);
        });

        calculateTotals();

        if (loading) {
            loading.style.display = 'none';
        }

        if (form) {
            form.style.display = 'block';
        }
    }

    /* ============================================================
       DATA LOADING FUNCTIONS
       ============================================================ */

    function loadProducts() {
        fetch("{{ route('pc-builder.products') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}",
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                products: selectedProducts
            })
        })
        .then(function (response) {
            return response.json().then(function (data) {
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(function (result) {
            const response = result.data;

            if (
                response &&
                response.success &&
                response.products &&
                response.products.length
            ) {
                renderProducts(response.products);
            } else {
                showEmptyState();

                if (response && response.message) {
                    console.error(response.message);
                }
            }
        })
        .catch(function (error) {
            console.error('PC Builder products error:', error);
            showEmptyState();
        });
    }

    function getComponentKey(productId) {
        return Object.keys(selectedProducts).find(function (component) {
            return String(selectedProducts[component]) === String(productId);
        }) || null;
    }

    /* ============================================================
       ADDRESS FUNCTIONS
       ============================================================ */

    function loadSelectedAddress() {
        const selectedRadio = document.querySelector('.address-radio:checked');

        if (!selectedRadio) {
            setBillingLocked(false);
            return;
        }

        const selected = selectedRadio.closest('.address-card');

        if (!selected) {
            return;
        }

        const addressId = selected.dataset.addressId || '';
        const country = selected.dataset.country || 'India';
        const name = selected.dataset.name || '';
        const mobile = selected.dataset.mobile || '';
        const address = selected.dataset.address || '';
        const city = selected.dataset.city || '';
        const state = selected.dataset.state || '';
        const pincode = selected.dataset.pincode || '';

        const deliveryAddressId = document.getElementById('deliveryAddressId');
        const checkoutCountry = document.getElementById('checkoutCountry');
        const checkoutName = document.getElementById('checkoutName');
        const checkoutMobile = document.getElementById('checkoutMobile');
        const checkoutAddress = document.getElementById('checkoutAddress');
        const checkoutCity = document.getElementById('checkoutCity');
        const checkoutState = document.getElementById('checkoutState');
        const checkoutPincode = document.getElementById('checkoutPincode');

        if (deliveryAddressId) {
            deliveryAddressId.value = addressId;
        }

        if (checkoutName) {
            checkoutName.value = name;
        }

        if (checkoutMobile) {
            checkoutMobile.value = mobile;
        }

        if (checkoutAddress) {
            checkoutAddress.value = address;
        }

        if (checkoutCity) {
            checkoutCity.value = city;
        }

        if (checkoutState) {
            checkoutState.value = state;
        }

        if (checkoutPincode) {
            checkoutPincode.value = pincode;
        }

        if (checkoutCountry) {
            checkoutCountry.value = country;

            checkoutCountry.dispatchEvent(
                new Event('change', { bubbles: true })
            );
        }

        document.querySelectorAll('.address-card').forEach(function (card) {
            card.classList.remove('selected');
        });

        selected.classList.add('selected');
        setBillingLocked(true);
        fetchShippingCharge(true);
        calculateTotals();
    }

    /* ============================================================
       SHIPPING TOGGLE FUNCTIONS
       ============================================================ */

    function toggleDifferentShipping() {
        const checkbox = document.getElementById('ship-box');
        const shippingBox = document.getElementById('ship-box-info');

        if (!checkbox || !shippingBox) {
            return;
        }

        const fields = [
            'shipCountry',
            'shipName',
            'shipMobile',
            'shipAddress',
            'shipCity',
            'shipState',
            'shipPincode'
        ];

        if (checkbox.checked) {
            shippingBox.style.display = 'block';

            fields.forEach(function (id) {
                const field = document.getElementById(id);

                if (field) {
                    field.required = true;
                }
            });
        } else {
            shippingBox.style.display = 'none';

            fields.forEach(function (id) {
                const field = document.getElementById(id);

                if (field) {
                    field.required = false;
                }
            });
        }

        // Delivery address just changed — recalc shipping + GST
        fetchShippingCharge(true);
        calculateTotals();
    }

    /* ============================================================
       SUBMIT BUTTON FUNCTIONS
       ============================================================ */

    function resetSubmitButton() {
        isSubmitting = false;

        const button = document.getElementById('placeOrderBtn');
        const loader = document.getElementById('checkoutLoader');

        if (button) {
            button.disabled = false;
            button.value = 'Place order';
        }

        if (loader) {
            loader.style.display = 'none';
        }
    }

    /* ============================================================
       RAZORPAY FUNCTIONS
       ============================================================ */

    function loadRazorpayScript() {
        return new Promise(function (resolve, reject) {
            if (typeof Razorpay !== 'undefined') {
                resolve();
                return;
            }

            const existingScript = document.querySelector(
                'script[src="https://checkout.razorpay.com/v1/checkout.js"]'
            );

            if (existingScript) {
                existingScript.addEventListener('load', function () {
                    resolve();
                });

                existingScript.addEventListener('error', function () {
                    reject();
                });

                return;
            }

            const script = document.createElement('script');

            script.src = 'https://checkout.razorpay.com/v1/checkout.js';
            script.async = true;

            script.onload = function () {
                resolve();
            };

            script.onerror = function () {
                reject();
            };

            document.head.appendChild(script);
        });
    }

    function openRazorpay(response) {
        loadRazorpayScript()
            .then(function () {
                if (typeof Razorpay === 'undefined') {
                    alert('Razorpay checkout could not be loaded.');
                    resetSubmitButton();
                    return;
                }

                if (
                    !response.razorpay_key ||
                    !response.razorpay_order_id ||
                    !response.amount
                ) {
                    console.error('Invalid Razorpay response:', response);
                    alert('Razorpay payment information is missing.');
                    resetSubmitButton();
                    return;
                }

                const options = {
                    key: response.razorpay_key,
                    amount: response.amount,
                    currency: response.currency || 'INR',
                    name: response.name || 'Computer Hardware',
                    description: 'PC Builder Order',
                    order_id: response.razorpay_order_id,

                    prefill: {
                        name: document.getElementById('checkoutName')?.value || '',
                        email: document.querySelector('input[name="email"]')?.value || '',
                        contact: document.getElementById('checkoutMobile')?.value || ''
                    },

                    theme: {
                        color: '#fed700'
                    },

                    handler: function (paymentResponse) {
                        verifyRazorpayPayment(paymentResponse, response);
                    },

                    modal: {
                        ondismiss: function () {
                            resetSubmitButton();
                        }
                    }
                };

                try {
                    const razorpay = new Razorpay(options);
                    razorpay.open();
                } catch (error) {
                    console.error('Razorpay error:', error);
                    alert('Unable to open Razorpay checkout.');
                    resetSubmitButton();
                }
            })
            .catch(function (error) {
                console.error('Razorpay script loading error:', error);

                alert(
                    'Razorpay checkout could not be loaded. Please check your internet connection and try again.'
                );

                resetSubmitButton();
            });
    }

    function verifyRazorpayPayment(paymentResponse, orderResponse) {
        const data = new URLSearchParams();

        data.append('_token', "{{ csrf_token() }}");
        data.append('razorpay_payment_id', paymentResponse.razorpay_payment_id || '');
        data.append('razorpay_order_id',   paymentResponse.razorpay_order_id   || '');
        data.append('razorpay_signature',  paymentResponse.razorpay_signature  || '');

        fetch("{{ route('pc-builder.verify-payment') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: data.toString()
        })
        .then(function (response) {
            return response.json().then(function (data) {
                return {
                    status: response.status,
                    data: data
                };
            });
        })
        .then(function (result) {
            const response = result.data;

            if (response && response.success) {
                localStorage.removeItem(storageKey);
                localStorage.removeItem(quantityStorageKey);

                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: response.message || 'PC Builder order placed successfully.',
                    confirmButtonText: 'Continue',
                    confirmButtonColor: '#2878f0',
                    allowOutsideClick: false
                }).then(function () {
                    if (response.redirect_url) {
                        window.location.href = response.redirect_url;
                    } else {
                        window.location.reload();
                    }
                });

                return;
            }

            alert(
                response && response.message
                    ? response.message
                    : 'Payment verification failed.'
            );

            resetSubmitButton();
        })
        .catch(function (error) {
            console.error('Payment verification error:', error);
            alert('Payment verification failed. Please contact support.');
            resetSubmitButton();
        });
    }

    /* ============================================================
       EVENT LISTENERS
       ============================================================ */

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.quantity-minus');

        if (!button) {
            return;
        }

        const id = String(button.dataset.productId);
        let quantity = getQuantity(id);

        if (quantity <= 1) {
            return;
        }

        quantity--;

        quantities[id] = quantity;
        saveQuantities();

        renderProducts(Object.values(productsData));
    });

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.quantity-plus');

        if (!button) {
            return;
        }

        const id = String(button.dataset.productId);
        const product = productsData[id];

        if (!product) {
            return;
        }

        const stock = getStock(product);

        if (stock <= 0) {
            return;
        }

        let quantity = getQuantity(id);

        if (quantity >= stock) {
            return;
        }

        quantity++;

        quantities[id] = quantity;
        saveQuantities();

        renderProducts(Object.values(productsData));
    });

    document.addEventListener('click', function (e) {
        const button = e.target.closest('.remove-builder-product');

        if (!button) {
            return;
        }

        const id = String(button.dataset.productId);
        const componentKey = getComponentKey(id);

        if (componentKey) {
            delete selectedProducts[componentKey];
        }

        delete quantities[id];

        localStorage.setItem(storageKey, JSON.stringify(selectedProducts));
        saveQuantities();

        if (Object.keys(selectedProducts).length === 0) {
            showEmptyState();
            return;
        }

        loadProducts();
    });

    document.addEventListener('change', function (e) {
        if (e.target.matches('.address-radio')) {
            loadSelectedAddress();
        }
    });

    document.addEventListener('change', function (e) {
        if (!e.target.matches('.payment-radio')) {
            return;
        }

        document.querySelectorAll('.payment-option').forEach(function (option) {
            option.classList.remove('selected');
        });

        const option = e.target.closest('.payment-option');

        if (option) {
            option.classList.add('selected');
        }
    });

    const shipBox = document.getElementById('ship-box');

    if (shipBox) {
        shipBox.addEventListener('change', toggleDifferentShipping);
    }

    /* ============================================================
       FORM SUBMISSION
       ============================================================ */

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            if (isSubmitting) {
                return;
            }

            const paymentRadio = document.querySelector(
                'input[name="payment_method"]:checked'
            );

            const addressRadio = document.querySelector(
                'input[name="delivery_address"]:checked'
            );

            if (!addressRadio) {
                showSwal('Please select a delivery address.');
                return;
            }

            if (!paymentRadio) {
                showSwal('Please select a payment method.');
                return;
            }

            const paymentMethod = String(paymentRadio.value)
                .trim()
                .toLowerCase();

            if (paymentMethod !== 'cod' && paymentMethod !== 'razorpay') {
                alert('Please select a valid payment method.');
                return;
            }

            if (
                !selectedProducts ||
                Object.keys(selectedProducts).length === 0
            ) {
                alert('Please select at least one component.');
                return;
            }

            let invalidQuantity = false;

            Object.keys(productsData).forEach(function (id) {
                const product = productsData[id];
                const quantity = getQuantity(id);
                const stock = getStock(product);

                if (stock <= 0 || quantity > stock) {
                    invalidQuantity = true;
                }
            });

            // if (invalidQuantity) {
            //     alert(
            //         'One or more selected products have an invalid quantity or are out of stock. Please check your PC build.'
            //     );

            //     return;
            // }

            isSubmitting = true;

            const placeOrderBtn = document.getElementById('placeOrderBtn');
            const checkoutLoader = document.getElementById('checkoutLoader');

            if (placeOrderBtn) {
                placeOrderBtn.disabled = true;
                placeOrderBtn.value = 'Processing...';
            }

            if (checkoutLoader) {
                checkoutLoader.style.display = 'block';
            }

            const formData = new FormData(form);

            formData.set('delivery_address', addressRadio.value);
            formData.set('payment_method', paymentMethod);

            /*
             * Send quantities using PRODUCT ID as the primary key.
             */

            const submitQuantities = {};

            Object.keys(selectedProducts).forEach(function (builderType) {
                const productId = String(selectedProducts[builderType]);
                const quantity = getQuantity(productId);

                submitQuantities[productId] = quantity;
            });

            formData.set('products', JSON.stringify(selectedProducts));
            formData.set('quantities', JSON.stringify(submitQuantities));
            formData.set('totalamount', Number(currentTotal).toFixed(2));
            formData.set('payment_method', paymentMethod);
            formData.set('shipping_charge', Number(shippingCharge || 0).toFixed(2));

            fetch("{{ route('pc-builder.place-order') }}", {
                method: 'POST',

                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    'Accept': 'application/json'
                },

                body: formData
            })
            .then(function (response) {
                return response.json().then(function (data) {
                    return {
                        status: response.status,
                        data: data
                    };
                });
            })
            .then(function (result) {
                const response = result.data;

                console.log('Place order response:', response);

                if (!response || !response.success) {
                    let message =
                        response && response.message
                            ? response.message
                            : 'Unable to place order.';

                    if (response && response.errors) {
                        Object.keys(response.errors).forEach(function (key) {
                            if (
                                response.errors[key] &&
                                response.errors[key][0]
                            ) {
                                message += '\n' + response.errors[key][0];
                            }
                        });
                    }

                    alert(message);
                    resetSubmitButton();
                    return;
                }

                /*
                 * COD
                 */
                if (paymentMethod === 'cod') {
                    localStorage.removeItem(storageKey);
                    localStorage.removeItem(quantityStorageKey);

                    Swal.fire({
                        icon: 'success',
                        title: 'Order Placed!',
                        text: response.message || 'Your PC Builder order has been placed successfully.',
                        confirmButtonText: 'Continue',
                        confirmButtonColor: '#2878f0',
                        allowOutsideClick: false
                    }).then(function () {
                        if (response.redirecturl) {
                            window.location.href = response.redirecturl;
                        } else {
                            window.location.reload();
                        }
                    });

                    return;
                }

                /*
                 * Razorpay
                 */
                if (paymentMethod === 'razorpay') {
                    openRazorpay(response);
                    return;
                }

                resetSubmitButton();
            })
            .catch(function (error) {
                console.error('Place order error:', error);

                alert(
                    'Something went wrong while placing your order.'
                );

                resetSubmitButton();
            });
        });
    }

    /* ============================================================
       INITIALIZATION
       ============================================================ */

    loadSelectedAddress();
    toggleDifferentShipping();
    loadProducts();

});
</script>

@endsection
