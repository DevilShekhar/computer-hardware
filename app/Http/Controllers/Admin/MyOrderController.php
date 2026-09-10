<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class MyOrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::where('user_id', $request->user()->id)->latest('created_at') ->get();
        return view('admin.myorders.index', compact('orders'));
    }

    public function show(Request $request, Order $order)
    {
        abort_unless( $order->user_id === $request->user()->id, 403 );
        $order->load('items');
        return view('admin.myorders.show', compact('order'));
    }
    public function cancel(Request $request, Order $order)
    {
        // Make sure this order belongs to logged-in user
        abort_unless(
            $order->user_id === $request->user()->id,
            403
        );

        // Only Pending orders can be cancelled
        if ((int) $order->status !== 0) {
            return back()->with(
                'error',
                'Only pending orders can be cancelled.'
            );
        }

        $order->update([
            'status' => 5,
        ]);

        return redirect()
            ->route('my-orders.show', $order->id)
            ->with(
                'success',
                'Order cancelled successfully.'
            );
    }
    public function returnOrder(Request $request, $id) 
    { 
        $request->validate([ 'return_reason' => 'required|string|max:255', ]); 
        $order = Order::where('id', $id) ->where('user_id', auth()->id()) ->firstOrFail(); 
        if ((int) $order->status !== 4) 
            { return redirect() ->back() ->with('error', 'Only delivered orders can be returned.'); 
        } 
        $order->status = 8; 
        $order->return_reason = $request->return_reason; 
        $order->save();
         return redirect()->back() ->with('success', 'Return request submitted successfully.'); }
}