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


}
