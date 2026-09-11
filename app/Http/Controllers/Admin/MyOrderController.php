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
        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_remark' => 'nullable|string|max:1000',
        ]);
        // Only Pending or Confirmed orders can be cancelled
        if (!in_array((int) $order->status,[0, 1])) {
            return back()->with(
                'error',
                'Only pending or confirmed orders can be cancelled.'
            );
        }
        if ($order->created_at->diffInHours(now()) >= 24) {
            return back()->with(
                'error',
                'The cancellation period of 24 hours has expired.'
            );
        }

        $order->update([
            'status' => 5,
            'cancel_reason' => $request->cancel_reason,
            'cancel_remark' => $request->cancel_remark,
            'cancelled_at' => now(),
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
