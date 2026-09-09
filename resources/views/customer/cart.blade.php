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

                                            <tr id="cart-item-{{ $product->id }}" data-product-id="{{ $product->id }}">
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
                                                    <label>Quantity</label>
                                                    <div class="cart-plus-minus">
                                                        <div class="dec qtybutton decrease-btn"
                                                            data-product-id="{{ $product->id }}">
                                                            <i class="fa fa-angle-down"></i>
                                                        </div>
                                                        <input class="cart-plus-minus-box quantity-input"
                                                            value="{{ $item->quantity }}" type="text"
                                                            data-product-id="{{ $product->id }}">
                                                        <div class="inc qtybutton increase-btn"
                                                            data-product-id="{{ $product->id }}">
                                                            <i class="fa fa-angle-up"></i>
                                                        </div>
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

    <style>
        .spinner {
            width: 35px;
            height: 35px;
            border: 3px solid #ddd;
            border-top-color: #2878f0;
            border-radius: 50%;
            animation: spin .7s linear infinite;
            margin: auto;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')
                ? document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                : '{{ csrf_token() }}';

            function showLoader() {
                const loader = document.getElementById('cartLoader');
                if (loader) {
                    loader.style.display = 'block';
                }
            }

            function hideLoader() {
                const loader = document.getElementById('cartLoader');
                if (loader) {
                    loader.style.display = 'none';
                }
            }

            function showToast(message, type = 'success') {
                if (typeof window.showToast === 'function') {
                    window.showToast(message, type);
                    return;
                }
                alert(message);
            }

            async function updateCart(productId, quantity) {
                quantity = parseInt(quantity);
                if (quantity < 1) {
                    quantity = 1;
                }

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
                        if (quantityInput) {
                            quantityInput.value = data.item.quantity;
                        }

                        const itemTotal = row.querySelector('.item-total .amount');
                        if (itemTotal) {
                            itemTotal.textContent = '₹' + Number(data.item.total).toLocaleString('en-IN', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        }
                    }

                    updateSummary(data);

                    if (typeof window.loadMiniCart === 'function') {
                        window.loadMiniCart();
                    }

                } catch (error) {
                    showToast(error.message, 'error');
                } finally {
                    hideLoader();
                }
            }

            function updateSummary(data) {
                const subtotal = document.getElementById('cartSubtotal');
                const grandTotal = document.getElementById('cartGrandTotal');

                const formattedTotal = '₹' + Number(data.subtotal).toLocaleString('en-IN', {
                    minimumFractionDigits: 2,
                    maximumFractionDigits: 2
                });

                if (subtotal) {
                    subtotal.textContent = formattedTotal;
                }

                if (grandTotal) {
                    grandTotal.textContent = formattedTotal;
                }
            }

            // Increase quantity
            document.querySelectorAll('.increase-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const productId = this.dataset.productId;
                    const input = document.querySelector('.quantity-input[data-product-id="' + productId + '"]');
                    if (!input) return;
                    let quantity = parseInt(input.value) || 1;
                    quantity++;
                    updateCart(productId, quantity);
                });
            });

            // Decrease quantity
            document.querySelectorAll('.decrease-btn').forEach(function (button) {
                button.addEventListener('click', function () {
                    const productId = this.dataset.productId;
                    const input = document.querySelector('.quantity-input[data-product-id="' + productId + '"]');
                    if (!input) return;
                    let quantity = parseInt(input.value) || 1;
                    if (quantity > 1) {
                        quantity--;
                    }
                    updateCart(productId, quantity);
                });
            });

            // Manual quantity input change
            document.querySelectorAll('.quantity-input').forEach(function (input) {
                input.addEventListener('change', function () {
                    const productId = this.dataset.productId;
                    let quantity = parseInt(this.value) || 1;
                    if (quantity < 1) {
                        quantity = 1;
                        this.value = 1;
                    }
                    updateCart(productId, quantity);
                });
            });

            // Remove item
            document.querySelectorAll('.remove-cart-btn').forEach(function (button) {
                button.addEventListener('click', async function (e) {
                    e.preventDefault();
                    const productId = this.dataset.productId;

                    if (!confirm('Remove this product from cart?')) {
                        return;
                    }

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
                        if (row) {
                            row.remove();
                        }

                        if (data.item_count === 0) {
                            window.location.reload();
                            return;
                        }

                        updateSummary(data);

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

            // Clear cart
            const clearCartBtn = document.getElementById('clearCartBtn');
            if (clearCartBtn) {
                clearCartBtn.addEventListener('click', async function () {
                    if (!confirm('Are you sure you want to clear your cart?')) {
                        return;
                    }

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
            const couponCode=document.getElementById('coupon_code');
            const applyCouponBtn=document.getElementById('applyCouponBtn');
            const couponMessage=document.getElementById('couponMessage');

            if(applyCouponBtn){
                applyCouponBtn.addEventListener('click',async function(){

                    const code=couponCode.value.trim();

                    if(!code){
                        couponMessage.innerHTML='<span class="text-danger">Please enter coupon code.</span>';
                        return;
                    }

                    applyCouponBtn.disabled=true;
                    applyCouponBtn.value='Applying...';

                    try{
                        const response=await fetch('{{ route('checkout.apply-coupon') }}',{
                            method:'POST',
                            headers:{
                                'Content-Type':'application/json',
                                'Accept':'application/json',
                                'X-CSRF-TOKEN':csrfToken
                            },
                            body:JSON.stringify({
                                code:code
                            })
                        });

                        const data=await response.json();

                        if(!response.ok||!data.success){
                            throw new Error(data.message||'Unable to apply coupon.');
                        }

                        couponMessage.innerHTML='<span class="text-success">'+data.message+'</span>';

                        couponCode.disabled=true;
                        applyCouponBtn.disabled=true;
                        applyCouponBtn.value='Applied';

                        const grandTotal=document.getElementById('cartGrandTotal');

                        if(grandTotal){
                            grandTotal.textContent='₹'+Number(data.total).toLocaleString('en-IN',{
                                minimumFractionDigits:2,
                                maximumFractionDigits:2
                            });
                        }

                    }catch(error){

                        couponMessage.innerHTML='<span class="text-danger">'+error.message+'</span>';

                        applyCouponBtn.disabled=false;
                        applyCouponBtn.value='Apply coupon';
                    }
                });
            }
        });
    </script>

@endsection
