<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
            'quantity' => ['nullable', 'integer', 'min:1'],
        ]);
        $product = Product::findOrFail($validated['product_id']);
        $quantity = $validated['quantity'] ?? 1;
        if (isset($product->stock_quantity) && $product->stock_quantity < $quantity) {
            return response()->json([
                'success' => false,
                'message' => 'Not enough stock available.',
            ], 422);
        }
        $cart = $this->cartService->add($product, $quantity);

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
                $image = $product->image ?? null;
            }

            return [
                'id' => $item->product_id,
                'cart_item_id' => $item->id,
                'name' => $product?->name ?? 'Product',
                'slug' => $product?->slug,
                'price' => (float) $item->price,
                'quantity' => (int) $item->quantity,
                'image' => $image,
                'line_total' => (float) $item->price * $item->quantity,
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
        if (! $cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }
        $subtotal = $cartService->subtotal($cart);

        return view('customer.checkout', compact('cart', 'subtotal'));
    }

    public function placeOrder(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_number' => 'required|string|max:20',
            'address' => 'required|string',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'pincode' => 'required|string|max:10',
            'country' => 'required|string|max:100',
            'payment_method' => 'required|in:cod,razorpay',
            'order_notes' => 'nullable|string|max:2000',
        ]);

        $cart = $this->cartService->getCartWithItems();

        if (! $cart || $cart->items->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
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
                    throw new \Exception(
                        $item->product->name.' does not have enough stock.'
                    );
                }
            }

            $subtotal = $cart->items->sum(function ($item) {
                return (float) $item->price * (int) $item->quantity;
            });

            $shippingAmount = 0;
            $discountAmount = 0;
            $totalAmount = $subtotal + $shippingAmount - $discountAmount;

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => 'ORD-'.strtoupper(uniqid()),
                'customer_name' => $validated['customer_name'],
                'email' => $validated['email'],
                'mobile_number' => $validated['mobile_number'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'pincode' => $validated['pincode'],
                'country' => $validated['country'],
                'subtotal' => $subtotal,
                'shipping_amount' => $shippingAmount,
                'discount_amount' => $discountAmount,
                'total_amount' => $totalAmount,
                'payment_method' => $validated['payment_method'],
                'payment_status' => $validated['payment_method'] === 'cod'
                    ? 'pending'
                    : 'pending',
                'status' => 'pending',
                'order_notes' => $validated['order_notes'] ?? null,
            ]);

            foreach ($cart->items as $item) {
                $product = $item->product;
                $quantity = (int) $item->quantity;
                $price = (float) $item->price;
                $itemTotal = $price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'sku' => $product->sku,
                    'price' => $price,
                    'quantity' => $quantity,
                    'total' => $itemTotal,
                ]);

                if (isset($product->stock_quantity)) {
                    $product->decrement('stock_quantity', $quantity);
                }
            }

            $cart->items()->delete();

            DB::commit();

            return redirect()
                ->route('home')
                ->with('success', 'Order placed successfully.');
        } catch (\Throwable $e) {
            DB::rollBack();

            return back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }
}
