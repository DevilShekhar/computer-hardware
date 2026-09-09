<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartService
{
   public function getCurrentCart(): Cart
{
    if (Auth::check()) {

        $userCart = Cart::firstOrCreate(
            ['user_id' => Auth::id()],
            ['session_id' => null]
        );

        $guestSessionId = session('guest_cart_session_id');

        if ($guestSessionId) {
            $this->mergeGuestCart($guestSessionId);
        }

        return $userCart;
    }

    $sessionId = session()->getId();

    session()->put('guest_cart_session_id', $sessionId);

    return Cart::firstOrCreate(
        [
            'session_id' => $sessionId,
            'user_id' => null
        ]
    );
}

    public function getCartWithItems(): Cart
{
    return $this->getCurrentCart()->load([
        'items.product.images'
    ]);
}

    public function add(Product $product, int $quantity = 1): Cart
    {
        $cart = $this->getCurrentCart();

        $item = $cart->items()
            ->where('product_id', $product->id)
            ->first();

        if ($item) {
            $item->quantity += $quantity;
            $item->price = $this->getProductPrice($product);
            $item->save();
        } else {
            $cart->items()->create([
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $this->getProductPrice($product),
            ]);
        }

        return $cart->load('items.product');
    }

    public function updateQuantity(int $productId, int $quantity): Cart
    {
        $cart = $this->getCurrentCart();

        $item = $cart->items()
            ->where('product_id', $productId)
            ->firstOrFail();

        if ($quantity <= 0) {
            $item->delete();
        } else {
            $item->quantity = $quantity;
            $item->save();
        }

        return $cart->load('items.product');
    }

    public function remove(int $productId): Cart
    {
        $cart = $this->getCurrentCart();

        $cart->items()
            ->where('product_id', $productId)
            ->delete();

        return $cart->load('items.product');
    }

    public function clear(): void
    {
        $cart = $this->getCurrentCart();
        $cart->items()->delete();
    }

    public function subtotal(?Cart $cart = null): float
    {
        $cart ??= $this->getCurrentCart();

        return (float) $cart->items->sum(function ($item) {
            return (float) $item->price * (int) $item->quantity;
        });
    }

    public function itemCount(?Cart $cart = null): int
    {
        $cart ??= $this->getCurrentCart();

        return (int) $cart->items->sum('quantity');
    }

    public function mergeGuestCart(?string $guestSessionId = null): void
    {
        if (!Auth::check()) {
            return;
        }

        if (!$guestSessionId) {
            return;
        }

        $guestCart = Cart::whereNull('user_id')
            ->where('session_id', $guestSessionId)
            ->with('items.product')
            ->first();

        if (!$guestCart) {
            return;
        }

        if ($guestCart->items->isEmpty()) {
            $guestCart->delete();
            session()->forget('guest_cart_session_id');
            return;
        }

        $userCart = Cart::firstOrCreate(
            [
                'user_id' => Auth::id(),
            ],
            [
                'session_id' => null,
            ]
        );

        foreach ($guestCart->items as $guestItem) {

            if (!$guestItem->product) {
                continue;
            }

            $existingItem = $userCart->items()
                ->where('product_id', $guestItem->product_id)
                ->first();

            if ($existingItem) {

                $existingItem->quantity =
                    (int) $existingItem->quantity +
                    (int) $guestItem->quantity;

                $existingItem->price = $this->getProductPrice(
                    $guestItem->product
                );

                $existingItem->save();

            } else {

                $userCart->items()->create([
                    'product_id' => $guestItem->product_id,
                    'quantity' => $guestItem->quantity,
                    'price' => $this->getProductPrice(
                        $guestItem->product
                    ),
                ]);
            }
        }

        $guestCart->items()->delete();
        $guestCart->delete();

        session()->forget('guest_cart_session_id');
    }

    private function getProductPrice(Product $product): float
    {
        if (
            isset($product->sale_price) &&
            $product->sale_price !== null &&
            $product->sale_price > 0
        ) {
            return (float) $product->sale_price;
        }

        return (float) $product->price;
    }
}
