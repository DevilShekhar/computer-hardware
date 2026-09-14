<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;
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
        $order = Order::where('id', $id) ->where('user_id', auth()->id()) ->firstOrFail();
        if ((int) $order->status !== 4)
            { return redirect() ->back() ->with('error', 'Only delivered orders can be returned.');
        }
        $rules = [
            'return_reason' => 'required|string|max:255',
        ];
        if ($order->payment_method === 'cod') {
            $rules['customer_upi_id'] = 'required|string|max:100';
        }
        $validated = $request->validate($rules);
        $order->status = 8;
        $order->return_reason = $validated['return_reason'];
        if ($order->payment_method === 'cod') {
            $order->customer_upi_id = $validated['customer_upi_id'];
        }
        $order->save();
         return redirect()->back() ->with('success', 'Return request submitted successfully.'); }

    public function refundedOrders()
    {
        $orders = Order::where('user_id', auth()->id())
            ->where('status', 7)
            ->with(['user', 'items.product'])
            ->latest('refunded_at')
            ->get();

        return view('admin.myorders.refund', compact('orders'));
    }
    
    public function downloadInvoice(Request $request, Order $order)
    {
        abort_unless(
            $order->user_id === $request->user()->id,
            403
        );

        $order->load([
            'user',
            'items.product.gst',
        ]);

        $subtotal = 0;
        $totalGst = 0;

        foreach ($order->items as $item) {
            $itemSubtotal = (float) $item->price * (int) $item->quantity;

            $hasGst = $item->product &&
                strtolower(trim((string) $item->product->gst_type)) === 'yes';

            $gstRate = 0;

            if ($hasGst && $item->product->gst) {
                $gstRate = (float) $item->product->gst->gst_amount;
            }

            $itemGst = 0;

            if ($hasGst && $gstRate > 0) {
                $itemGst = round(
                    ($itemSubtotal * $gstRate) / 100,
                    2
                );
            }

            $subtotal += $itemSubtotal;
            $totalGst += $itemGst;
        }

        $discount = (float) ($order->discount_amount ?? 0);
        $shipping = (float) ($order->shipping_amount ?? 0);

        $taxableAmount = $subtotal - $discount;

        if ($taxableAmount < 0) {
            $taxableAmount = 0;
        }

        $grandTotal = round(
            $taxableAmount + $shipping + $totalGst,
            2
        );

        $pdf = Pdf::loadView('admin.invoices.my-order-invoice', [
            'order' => $order,
            'subtotal' => round($subtotal, 2),
            'discount' => $discount,
            'shipping' => $shipping,
            'taxableAmount' => round($taxableAmount, 2),
            'totalGst' => round($totalGst, 2),
            'grandTotal' => $grandTotal,
        ]);

        $pdf->setPaper('A4', 'portrait');

        return $pdf->download(
            'invoice-' . $order->order_number . '.pdf'
        );
    }
}
