<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Models\CouponUsage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Mail\OrderPaymentSuccessMail;
use App\Models\ShippingCharge;
use App\Services\GstService;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected CartService $cartService;
    protected GstService $gstService;

    public function __construct(CartService $cartService ,GstService $gstService)
    {
        $this->cartService = $cartService;
        $this->gstService  = $gstService;
    }
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('customer.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        abort_unless($order->user_id === Auth::id(), 403);

        $order->load('items.product');

        return view('frontend.home.index', compact('order'));
    }
    public function applyCoupon(Request $request)
    {
        $request->validate([
            'code'=>'required|string|max:50'
        ]);

        $coupon=Coupon::where('code',strtoupper(trim($request->code)))
            ->where('status',1)
            ->first();

        if(!$coupon){
            return response()->json([
                'success'=>false,
                'message'=>'Invalid or already used coupon.'
            ],422);
        }

        if(!auth()->check()){
            return response()->json([
                'success'=>false,
                'message'=>'Please login to use a coupon.'
            ],401);
        }

        $alreadyUsed=CouponUsage::where('coupon_id',$coupon->id)
            ->where('user_id',auth()->id())
            ->exists();

        if($alreadyUsed){
            return response()->json([
                'success'=>false,
                'message'=>'You have already used this coupon.'
            ],422);
        }

        $now=now();

        if($now->lt($coupon->start_date)){
            return response()->json([
                'success'=>false,
                'message'=>'This coupon is upcoming and cannot be used yet.'
            ],422);
        }

        if($now->gt($coupon->end_date)){
            return response()->json([
                'success'=>false,
                'message'=>'This coupon has expired.'
            ],422);
        }

        $cart=app(\App\Services\CartService::class)->getCartWithItems();

        $subtotal=$cart->items->sum(function($item){
            return(float)$item->price*(int)$item->quantity;
        });

        if($coupon->minimum_order_value&&$subtotal<$coupon->minimum_order_value){
            return response()->json([
                'success'=>false,
                'message'=>'Minimum order value is ₹'.number_format($coupon->minimum_order_value,2)
            ],422);
        }

        if($coupon->usage_limit!==null&&$coupon->used_count>=$coupon->usage_limit){
            return response()->json([
                'success'=>false,
                'message'=>'This coupon usage limit has been reached.'
            ],422);
        }

        if($coupon->discount_type==='percentage'){
            $discount=($subtotal*$coupon->discount_value)/100;
        }else{
            $discount=$coupon->discount_value;
        }

        $discount=min($discount,$subtotal);
        $total=$subtotal-$discount;

        session([
            'coupon_id'=>$coupon->id,
            'coupon_code'=>$coupon->code,
            'coupon_discount'=>$discount
        ]);

        return response()->json([
            'success'=>true,
            'message'=>'Coupon applied successfully.',
            'coupon_code'=>$coupon->code,
            'discount'=>(float)$discount,
            'subtotal'=>(float)$subtotal,
            'total'=>(float)$total
        ]);
    }
    public function updateQuantity(Request $request)
    {
        try {
            $request->validate([
                'item_id' => 'required|exists:cart_items,id',
                'quantity' => 'required|integer|min:1'
            ]);

            $cartItem = CartItem::findOrFail($request->item_id);
            $product = $cartItem->product;
            $cartItem->quantity = $request->quantity;
            $cartItem->save();
            $cart = $request->user()->cart;
            $subtotal = $cart->items->sum(function($item) {
                return $item->price * $item->quantity;
            });
            $discount = 0;
            $couponCode = $request->input('coupon_code');
            if ($couponCode) {
                $coupon = Coupon::where('code', $couponCode)->where('is_active', true)->first();
                if ($coupon) {
                    if ($coupon->type === 'percentage') {
                        $discount = ($coupon->value / 100) * $subtotal;
                    } else {
                        $discount = min($coupon->value, $subtotal);
                    }
                    if ($coupon->max_discount && $discount > $coupon->max_discount) {
                        $discount = $coupon->max_discount;
                    }
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully',
                'subtotal' => $subtotal,
                'discount' => $discount,
                'total' => $subtotal - $discount,
                'item_total' => $cartItem->price * $cartItem->quantity,
                'quantity' => $cartItem->quantity
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error updating quantity: ' . $e->getMessage()
            ], 500);
        }
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name'     => 'required|string|max:255',
            'email'             => 'required|email|max:255',
            'mobile_number'     => 'required|string|max:20',
            'address'           => 'required|string|max:1000',
            'city'              => 'required|string|max:100',
            'state'             => 'required|string|max:100',
            'pincode'           => 'required|string|max:10',
            'country'           => 'required|string|max:100',
            'payment_method'    => 'required|in:cod,razorpay',
            'order_notes'       => 'nullable|string|max:2000',
            'ship_to_different' => 'nullable|boolean',
            'ship_name'         => 'required_if:ship_to_different,1|nullable|string|max:255',
            'ship_mobile'       => 'required_if:ship_to_different,1|nullable|string|max:20',
            'ship_address'      => 'required_if:ship_to_different,1|nullable|string|max:1000',
            'ship_city'         => 'required_if:ship_to_different,1|nullable|string|max:100',
            'ship_state'        => 'required_if:ship_to_different,1|nullable|string|max:100',
            'ship_pincode'      => 'required_if:ship_to_different,1|nullable|string|max:10',
            'ship_country'      => 'required_if:ship_to_different,1|nullable|string|max:100',
        ]);

        $cart = $this->cartService->getCartWithItems();

        if (! $cart || $cart->items->isEmpty()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your cart is empty.',
                ], 422);
            }
            return redirect()->route('cart.index')->with('error', 'Your cart is empty.');
        }

        $shipToDifferent = $request->boolean('ship_to_different');

        if ($shipToDifferent) {
            $orderAddress = [
                'customer_name' => $validated['ship_name'],
                'mobile_number' => $validated['ship_mobile'],
                'address'       => $validated['ship_address'],
                'city'          => $validated['ship_city'],
                'state'         => $validated['ship_state'],
                'pincode'       => $validated['ship_pincode'],
                'country'       => $validated['ship_country'] ?? 'India',
            ];
        } else {
            $orderAddress = [
                'customer_name' => $validated['customer_name'],
                'mobile_number' => $validated['mobile_number'],
                'address'       => $validated['address'],
                'city'          => $validated['city'],
                'state'         => $validated['state'],
                'pincode'       => $validated['pincode'],
                'country'       => $validated['country'],
            ];
        }
        $isMaharashtra = strtolower(trim($orderAddress['state'])) === 'maharashtra';
        $subtotal = $cart->items->sum(function ($item) {
            return (float) $item->price * (int) $item->quantity;
        });
        $deliveryState = $shipToDifferent
            ? $orderAddress['state']
            : $validated['state'];

        $gst = $this->calculateGst($cart->items, $deliveryState);

        $gstAmount   = $gst['gst_amount'];
        $cgstAmount  = $gst['cgst_amount'];
        $sgstAmount  = $gst['sgst_amount'];
        $igstAmount  = $gst['igst_amount'];
        $gstItems    = $gst['items'];
        $gstType     = $gst['gst_type'];
        $discountAmount = (float) session('coupon_discount', 0);
        $discountAmount = min($discountAmount, $subtotal + $gstAmount);
        $shippingAmount = $this->resolveShippingCharge(
            $orderAddress['pincode'] ?? null,
            $orderAddress['city']    ?? null,
            $orderAddress['state']   ?? null
        );
        $totalAmount = $subtotal + $gstAmount + $shippingAmount - $discountAmount;
        if ($validated['payment_method'] === 'razorpay') {
            foreach ($cart->items as $item) {
                if (! $item->product) {
                    return response()->json([
                        'success' => false,
                        'message' => 'A product in your cart is no longer available.',
                    ], 422);
                }
                if (
                    isset($item->product->stock_quantity) &&
                    $item->product->stock_quantity < $item->quantity
                ) {
                    return response()->json([
                        'success' => false,
                        'message' => $item->product->name . ' does not have enough stock.',
                    ], 422);
                }
            }

            $amountInPaise = (int) round($totalAmount * 100);

            if ($amountInPaise < 100) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order amount is too small for online payment.',
                ], 422);
            }

            try {
                $api = new \Razorpay\Api\Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                $rzpOrder = $api->order->create([
                    'receipt'  => 'RC-' . Auth::id() . '-' . time(),
                    'amount'   => $amountInPaise,
                    'currency' => 'INR',
                    'notes'    => [
                        'user_id' => Auth::id(),
                    ],
                ]);
            } catch (\Throwable $e) {
                Log::error('Razorpay order create failed', [
                    'message' => $e->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Unable to start payment. Please try again.',
                ], 500);
            }
            session([
                'razorpay_pending' => [
                    'razorpay_order_id' => $rzpOrder['id'],
                    'user_id'           => Auth::id(),
                    'validated'         => $validated,
                    'order_address'     => $orderAddress,
                    'ship_to_different' => $shipToDifferent,
                    'subtotal'          => $subtotal,
                    'gst_type'          => $gstType,
                    'gst_amount'        => $gstAmount,
                    'cgst_amount'       => $cgstAmount,
                    'sgst_amount'       => $sgstAmount,
                    'igst_amount'       => $igstAmount,
                    'discount_amount'   => $discountAmount,
                    'shipping_amount'   => $shippingAmount,
                    'total_amount'      => $totalAmount,
                    'cart_items'        => $gstItems,
                ],
            ]);

            return response()->json([
                'success'           => true,
                'payment_required'  => true,
                'razorpay_key'      => config('services.razorpay.key'),
                'razorpay_order_id' => $rzpOrder['id'],
                'amount'            => $amountInPaise,
                'currency'          => 'INR',
                'customer_name'     => $orderAddress['customer_name'],
                'email'             => $validated['email'],
                'mobile'            => $orderAddress['mobile_number'],
            ]);
        }
        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => 'ORD-' . strtoupper(uniqid()),
                'customer_name'   => $orderAddress['customer_name'],
                'email'           => $validated['email'],
                'mobile_number'   => $orderAddress['mobile_number'],
                'address'         => $orderAddress['address'],
                'city'            => $orderAddress['city'],
                'state'           => $orderAddress['state'],
                'pincode'         => $orderAddress['pincode'],
                'country'         => $orderAddress['country'],
                'subtotal'        => $subtotal,
                'gst_type'        => $gstType,
                'gst_amount'      => $gstAmount,
                'cgst_amount'     => $cgstAmount,
                'sgst_amount'     => $sgstAmount,
                'igst_amount'     => $igstAmount,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'total_amount'    => $totalAmount,
                'payment_method'  => 'cod',
                'payment_status'  => 'pending',
                'status'          => 0,
                'order_notes'     => $validated['order_notes'] ?? null,
            ]);

            foreach ($gstItems as $row) {
            OrderItem::create([
                'order_id'     => $order->id,
                'product_id'   => $row['product_id'],
                'product_name' => $row['product_name'],
                'sku'          => $row['sku'],
                'price'        => $row['price'],
                'quantity'     => $row['quantity'],
                'total'        => $row['price'] * $row['quantity'],
                'gst_rate'     => $row['gst_rate'],
                'gst_amount'   => $row['gst_amount'],
                'cgst_rate'    => $row['cgst_rate'],
                'cgst_amount'  => $row['cgst_amount'],
                'sgst_rate'    => $row['sgst_rate'],
                'sgst_amount'  => $row['sgst_amount'],
                'igst_rate'    => $row['igst_rate'],
                'igst_amount'  => $row['igst_amount'],
            ]);
            if (isset($row['product_id'])) {
                $product = Product::find($row['product_id']);
                if ($product && isset($product->stock_quantity)) {
                    $product->decrement('stock_quantity', $row['quantity']);
                }
            }
        }

            if ($shipToDifferent) {
                $userId = Auth::id();
                $alreadyExists = Address::where('user_id', $userId)
                    ->where('mobile',  $validated['ship_mobile'])
                    ->where('address', $validated['ship_address'])
                    ->where('city',    $validated['ship_city'])
                    ->where('state',   $validated['ship_state'])
                    ->where('pincode', $validated['ship_pincode'])
                    ->exists();

                if (! $alreadyExists) {
                    $isFirstAddress = ! Address::where('user_id', $userId)->exists();
                    if ($isFirstAddress) {
                        Address::where('user_id', $userId)->update(['is_default' => false]);
                    }
                    Address::create([
                        'user_id'      => $userId,
                        'address_type' => 'other',
                        'name'         => $validated['ship_name'],
                        'mobile'       => $validated['ship_mobile'],
                        'address'      => $validated['ship_address'],
                        'city'         => $validated['ship_city'],
                        'state'        => $validated['ship_state'],
                        'country'      => $validated['ship_country'] ?: 'India',
                        'pincode'      => $validated['ship_pincode'],
                        'is_default'   => $isFirstAddress,
                    ]);
                }
            }

            $cart->items()->delete();

            if (session()->has('coupon_id')) {
                CouponUsage::create([
                    'coupon_id' => session('coupon_id'),
                    'user_id'   => Auth::id(),
                    'order_id'  => $order->id,
                ]);

                Coupon::where('id', session('coupon_id'))->increment('used_count');

                session()->forget(['coupon_id', 'coupon_code', 'coupon_discount']);
            }

            DB::commit();
            $order->load(['user', 'items.product']);
            try
            {
                if (!empty($order->email))
                {
                    Mail::to($order->email)->send(new OrderPaymentSuccessMail($order));
                }
                $adminEmail = config('mail.admin_email');
                if (!empty($adminEmail)) {
                    Mail::to($adminEmail)->send(new OrderPaymentSuccessMail($order));
                }
            }  catch (\Throwable $e) {
                ([
                    'order_id' => $order->id,
                    'order_number' => $order->order_number,
                    'customer' => $order->email,
                    'admin' => config('mail.admin_email'),
                    'message' => $e->getMessage(),
                ]);
            }
            return redirect()
                ->route('home')
                ->with('success', 'Order placed successfully.');

        } catch (\Throwable $e) {
            DB::rollBack();

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->with('error', $e->getMessage());
        }
    }

    private function calculateGst($cartItems, string $state): array
    {
        $isMaharashtra = strtolower(trim($state)) === 'maharashtra';

        $gstAmount  = 0;
        $cgstAmount = 0;
        $sgstAmount = 0;
        $igstAmount = 0;

        $items = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            $price     = (float) $item->price;
            $quantity  = (int) $item->quantity;
            $itemTotal = $price * $quantity;

            $gstRate = 0;

            if ($product && $product->gst_type === 'yes' && $product->gst) {
                $gstRate = (float) $product->gst->gst_amount;
            }

            $itemGstAmount = $gstRate > 0
                ? ($itemTotal * $gstRate) / 100
                : 0;

            $itemCgstRate   = 0;
            $itemCgstAmount = 0;
            $itemSgstRate   = 0;
            $itemSgstAmount = 0;
            $itemIgstRate   = 0;
            $itemIgstAmount = 0;

            if ($isMaharashtra && $gstRate > 0) {
                $itemCgstRate   = $gstRate / 2;
                $itemSgstRate   = $gstRate / 2;
                $itemCgstAmount = $itemGstAmount / 2;
                $itemSgstAmount = $itemGstAmount / 2;

                $cgstAmount += $itemCgstAmount;
                $sgstAmount += $itemSgstAmount;
            } elseif ($gstRate > 0) {
                $itemIgstRate   = $gstRate;
                $itemIgstAmount = $itemGstAmount;

                $igstAmount += $itemIgstAmount;
            }

            $gstAmount += $itemGstAmount;

            $items[] = [
                'product_id'    => $item->product_id,
                'product_name'  => $product->name ?? '',
                'sku'           => $product->sku ?? null,
                'price'         => $price,
                'quantity'      => $quantity,

                'gst_rate'      => $gstRate,
                'gst_amount'    => $itemGstAmount,

                'cgst_rate'     => $itemCgstRate,
                'cgst_amount'   => $itemCgstAmount,

                'sgst_rate'     => $itemSgstRate,
                'sgst_amount'   => $itemSgstAmount,

                'igst_rate'     => $itemIgstRate,
                'igst_amount'   => $itemIgstAmount,
            ];
        }

        return [
            'gst_type'    => $isMaharashtra ? 'intra_state' : 'inter_state',
            'gst_amount'  => $gstAmount,
            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'igst_amount' => $igstAmount,
            'items'       => $items,
        ];
    }
    private function resolveShippingCharge(?string $pincode, ?string $city, ?string $state): float
    {
        $pincode = preg_replace('/\D/', '', (string) $pincode);
        $city    = trim((string) $city);
        $state   = trim((string) $state);

        $charge = null;

        if ($pincode !== '') {
            $charge = ShippingCharge::where('pincode', $pincode)->first();
        }

        if (! $charge && $city !== '') {
            $charge = ShippingCharge::where('city', $city)->first();
        }

        if (! $charge && $state !== '') {
            $charge = ShippingCharge::where('state', $state)->first();
        }

        if (! $charge) {
            $charge = ShippingCharge::whereNull('pincode')
                ->whereNull('city')
                ->whereNull('state')
                ->first();
        }

        return $charge ? (float) $charge->charges : 0.0;
    }
    public function verifyRazorpayPayment(Request $request)
    {
        $request->validate([
            'razorpay_payment_id' => 'required|string',
            'razorpay_order_id'   => 'required|string',
            'razorpay_signature'  => 'required|string',
        ]);

        $pending = session('razorpay_pending');

        if (! $pending || $pending['razorpay_order_id'] !== $request->razorpay_order_id) {
            return response()->json([
                'success' => false,
                'message' => 'Payment session expired. Please try again.',
            ], 422);
        }

        try {
            $api = new \Razorpay\Api\Api(
                config('services.razorpay.key'),
                config('services.razorpay.secret')
            );

            $api->utility->verifyPaymentSignature([
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);
        } catch (\Razorpay\Api\Errors\SignatureVerificationError $e) {
            return response()->json([
                'success' => false,
                'message' => 'Payment verification failed.',
            ], 400);
        }
        DB::beginTransaction();

        try {
            $validated    = $pending['validated'];
            $orderAddress = $pending['order_address'];

            $order = Order::create([
                'user_id'             => $pending['user_id'],
                'order_number'        => 'ORD-' . strtoupper(uniqid()),
                'customer_name'       => $orderAddress['customer_name'],
                'email'               => $validated['email'],
                'mobile_number'       => $orderAddress['mobile_number'],
                'address'             => $orderAddress['address'],
                'city'                => $orderAddress['city'],
                'state'               => $orderAddress['state'],
                'pincode'             => $orderAddress['pincode'],
                'country'             => $orderAddress['country'],
                'subtotal'            => $pending['subtotal'],
                'gst_type'            => $pending['gst_type'],
                'gst_amount'          => $pending['gst_amount'],
                'cgst_amount'         => $pending['cgst_amount'],
                'sgst_amount'         => $pending['sgst_amount'],
                'igst_amount'         => $pending['igst_amount'],
                'shipping_amount'     => $pending['shipping_amount'],
                'discount_amount'     => $pending['discount_amount'],
                'total_amount'        => $pending['total_amount'],
                'payment_method'      => 'razorpay',
                'payment_status'      => 'paid',
                'status'              => 1,
                'order_notes'         => $validated['order_notes'] ?? null,
                'razorpay_order_id'   => $request->razorpay_order_id,
                'razorpay_payment_id' => $request->razorpay_payment_id,
                'razorpay_signature'  => $request->razorpay_signature,
            ]);

            foreach ($pending['cart_items'] as $row) {
                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $row['product_id'],
                    'product_name' => $row['product_name'],
                    'sku'          => $row['sku'],
                    'price'        => $row['price'],
                    'quantity'     => $row['quantity'],
                    'total'        => $row['price'] * $row['quantity'],
                    'gst_rate'     => $row['gst_rate'],
                    'gst_amount'   => $row['gst_amount'],
                    'cgst_rate'    => $row['cgst_rate'],
                    'cgst_amount'  => $row['cgst_amount'],
                    'sgst_rate'    => $row['sgst_rate'],
                    'sgst_amount'  => $row['sgst_amount'],
                    'igst_rate'    => $row['igst_rate'],
                    'igst_amount'  => $row['igst_amount'],
                ]);

                $product = Product::find($row['product_id']);
                if ($product && isset($product->stock_quantity)) {
                    $product->decrement('stock_quantity', $row['quantity']);
                }
            }

            if (! empty($pending['ship_to_different'])) {
                $userId = $pending['user_id'];
                $alreadyExists = Address::where('user_id', $userId)
                    ->where('mobile',  $validated['ship_mobile'])
                    ->where('address', $validated['ship_address'])
                    ->where('city',    $validated['ship_city'])
                    ->where('state',   $validated['ship_state'])
                    ->where('pincode', $validated['ship_pincode'])
                    ->exists();

                if (! $alreadyExists) {
                    $isFirstAddress = ! Address::where('user_id', $userId)->exists();
                    if ($isFirstAddress) {
                        Address::where('user_id', $userId)->update(['is_default' => false]);
                    }
                    Address::create([
                        'user_id'      => $userId,
                        'address_type' => 'other',
                        'name'         => $validated['ship_name'],
                        'mobile'       => $validated['ship_mobile'],
                        'address'      => $validated['ship_address'],
                        'city'         => $validated['ship_city'],
                        'state'        => $validated['ship_state'],
                        'country'      => $validated['ship_country'] ?: 'India',
                        'pincode'      => $validated['ship_pincode'],
                        'is_default'   => $isFirstAddress,
                    ]);
                }
            }
            $cart = $this->cartService->getCartWithItems();
            if ($cart) {
                $cart->items()->delete();
            }

            if (session()->has('coupon_id')) {
                Coupon::where('id', session('coupon_id'))->increment('used_count');
                session()->forget(['coupon_id', 'coupon_code', 'coupon_discount']);
            }

            session()->forget('razorpay_pending');

            DB::commit();

            $order->load([
                'user',
                'items.product',
            ]);

            try {
                if (! empty($order->email)) {
                    Mail::to($order->email)->send(
                        new OrderPaymentSuccessMail($order)
                    );
                }

                $adminEmail = config('mail.admin_email');

                if (! empty($adminEmail)) {
                    Mail::to($adminEmail)->send(
                        new OrderPaymentSuccessMail($order)
                    );
                }
            } catch (\Throwable $e) {
                Log::error('Order payment success email failed', [
                    'order_id'     => $order->id,
                    'order_number' => $order->order_number,
                    'customer'     => $order->email,
                    'admin'        => config('mail.admin_email'),
                    'message'      => $e->getMessage(),
                ]);
            }

            return response()->json([
                'success'      => true,
                'message'      => 'Payment successful.',
                'redirect_url' => route('home'),
            ]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Order create after payment failed', [
                'message' => $e->getMessage(),
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Payment succeeded but order could not be saved. Contact support.',
            ], 500);
        }
    }
}
