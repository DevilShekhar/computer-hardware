<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class CartController extends Controller
{
    protected CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(CartService $cartService)
    {
        $cart = $cartService->getCartWithItems();
        if (! $cart || $cart->items->isEmpty()) {
            return view('customer.cart', [
                'cart' => $cart,
                'subtotal' => 0,
            ]);
        }
        $subtotal = $cartService->subtotal($cart);

        return view('customer.cart', compact('cart', 'subtotal'));
    }
   public function add(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $product = Product::findOrFail($validated['product_id']);
        if (isset($product->stock_quantity) && $product->stock_quantity < $validated['quantity']) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }
        $cart = $this->cartService->add(
            $product,
            (int) $validated['quantity']
        );
        $cart->load(['items.product.images']);

        return response()->json([
            'success' => true,
            'message' => 'Product added to cart.',
            'cart' => $this->formatCart($cart),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'product_id' => ['required', 'integer'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);
        $cart = $this->cartService->updateQuantity(
            $validated['product_id'],
            $validated['quantity']
        );

        return response()->json([
            'success' => true,
            'message' => 'Cart updated.',
            'cart' => $this->formatCart($cart),
        ]);
    }

    public function remove($productId)
    {
        $cart = $this->cartService->remove((int) $productId);

        return response()->json([
            'success' => true,
            'message' => 'Product removed from cart.',
            'cart' => $this->formatCart($cart),
        ]);
    }

    public function miniCart(CartService $cartService)
    {
        $cart = $cartService->getCurrentCart();

        $cart->load([
            'items.product.images',
        ]);

        return response()->json([
            'success' => true,

            'cart' => [
                'id' => $cart->id,

                'items' => $cart->items->map(function ($item) {

                    $product = $item->product;

                    $image = $product?->images
                        ->sortByDesc('is_primary')
                        ->sortBy('sort_order')
                        ->first();

                    return [
                        'id' => $product?->id,
                        'name' => $product?->name,
                        'slug' => $product?->slug,
                        'price' => (float) $item->price,
                        'quantity' => (int) $item->quantity,

                        'image' => $image
                            ? asset('storage/'.$image->image)
                            : null,
                    ];
                })->values(),

                'item_count' => $cart->items->sum('quantity'),

                'subtotal' => $cart->items->sum(function ($item) {
                    return (float) $item->price * (int) $item->quantity;
                }),
            ],
        ]);
    }

    public function clear()
    {
        $this->cartService->clear();

        return response()->json([
            'success' => true,
            'message' => 'Cart cleared.',
        ]);
    }

    private function formatCart($cart): array
    {
        $items = $cart->items->map(function ($item) {
            $product = $item->product;
            $image = null;
            if ($product) {
                $primaryImage = $product->images
                    ->sortByDesc('is_primary')
                    ->sortBy('sort_order')
                    ->first();

                if ($primaryImage) {
                    $image = asset('storage/' . $primaryImage->image);
                }
            }
            return [
                'id' => $item->product_id,
                'cart_item_id' => $item->id,
                'product_id' => $item->product_id,
                'name' => $product?->name ?? 'Product',
                'slug' => $product?->slug,
                'price' => (float) $item->price,
                'quantity' => (int) $item->quantity,
                'image' => $image,
                'line_total' => (float) $item->price * (int) $item->quantity,
            ];
        })->values();
        return [
            'items' => $items,
            'item_count' => $items->sum('quantity'),
            'subtotal' => $items->sum('line_total'),
        ];
    }

    public function checkout(CartService $cartService)
    {
        if (! Auth::check()) {
            session([
                'guest_cart_session_id' => session()->getId(),
                'url.intended' => route('checkout.index'),
            ]);

            return redirect()
                ->route('login')
                ->with('info', 'Please login to continue checkout.');
        }
        $cart = $cartService->getCartWithItems();
        $cart->load('items.product.gst');
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        $subtotal = $cartService->subtotal($cart);

        $addresses = Address::where('user_id', Auth::id())
            ->orderByDesc('is_default')
            ->latest()
            ->get();
        $defaultAddress = $addresses->firstWhere('is_default', true);
        $subtotal = $cartService->subtotal($cart);

        $cartGst = 0;

        foreach ($cart->items as $item) {
            $product = $item->product;
            if (!$product) {
                continue;
            }
            $itemPrice = (float) $item->price;
            $itemTotal = $itemPrice * $item->quantity;
            if ($product->gst_type === 'yes' && $product->gst) {
                $gstRate = (float) $product->gst->gst_amount;
                $cartGst += ($itemTotal * $gstRate) / 100;
            }
        }
        return view('customer.checkout', compact('cart', 'subtotal','addresses','defaultAddress','cartGst'));
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

        DB::beginTransaction();

        try {
            foreach ($cart->items as $item) {
                if (! $item->product) {
                    throw new \Exception('A product in your cart is no longer available.');
                }
                if (
                    isset($item->product->stock_quantity) &&
                    $item->product->stock_quantity < $item->quantity
                ) {
                    throw new \Exception($item->product->name.' does not have enough stock.');
                }
            }

            $subtotal = $cart->items->sum(function ($item) {
                return (float) $item->price * (int) $item->quantity;
            });

            // GST calculation
            $gstAmount = 0;
            foreach ($cart->items as $item) {
                $product = $item->product;
                if ($product && $product->gst_type === 'yes' && $product->gst) {
                    $rate = (float) $product->gst->gst_amount;
                    $gstAmount += ((float) $item->price * (int) $item->quantity) * $rate / 100;
                }
            }

            // Coupon discount from session
            $discountAmount = (float) session('coupon_discount', 0);
            $discountAmount = min($discountAmount, $subtotal + $gstAmount);

            $shippingAmount = 0;
            $totalAmount = $subtotal + $gstAmount + $shippingAmount - $discountAmount;

            $order = Order::create([
                'user_id'         => Auth::id(),
                'order_number'    => 'ORD-'.strtoupper(uniqid()),
                'customer_name'   => $orderAddress['customer_name'],
                'email'           => $validated['email'],
                'mobile_number'   => $orderAddress['mobile_number'],
                'address'         => $orderAddress['address'],
                'city'            => $orderAddress['city'],
                'state'           => $orderAddress['state'],
                'pincode'         => $orderAddress['pincode'],
                'country'         => $orderAddress['country'],
                'subtotal'        => $subtotal,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'total_amount'    => $totalAmount,
                'payment_method'  => $validated['payment_method'],
                'payment_status'  => 'pending',
                'status'          => 0,
                'order_notes'     => $validated['order_notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $product   = $item->product;
                $quantity  = (int) $item->quantity;
                $price     = (float) $item->price;
                $itemTotal = $price * $quantity;

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'sku'          => $product->sku,
                    'price'        => $price,
                    'quantity'     => $quantity,
                    'total'        => $itemTotal,
                ]);

                if (isset($product->stock_quantity)) {
                    $product->decrement('stock_quantity', $quantity);
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
            if ($validated['payment_method'] === 'razorpay') {

                $amountInPaise = (int) round($totalAmount * 100);

                if ($amountInPaise < 100) {
                    throw new \Exception('Order amount is too small for online payment.');
                }

                $api = new \Razorpay\Api\Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                $rzpOrder = $api->order->create([
                    'receipt'  => $order->order_number,
                    'amount'   => $amountInPaise,
                    'currency' => 'INR',
                    'notes'    => [
                        'order_id' => $order->id,
                        'user_id'  => Auth::id(),
                    ],
                ]);

                $order->update([
                    'razorpay_order_id' => $rzpOrder['id'],
                ]);

                $cart->items()->delete();
                DB::commit();

                return response()->json([
                    'success'           => true,
                    'payment_required'  => true,
                    'razorpay_key'      => config('services.razorpay.key'),
                    'razorpay_order_id' => $rzpOrder['id'],
                    'amount'            => $amountInPaise,
                    'currency'          => 'INR',
                    'customer_name'     => $order->customer_name,
                    'email'             => $order->email,
                    'mobile'            => $order->mobile_number,
                    'order_id'          => $order->id,
                ]);
            }
            $cart->items()->delete();
            DB::commit();

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

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
