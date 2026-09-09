<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
class OrderController extends Controller
{
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
}
