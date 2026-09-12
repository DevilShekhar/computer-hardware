<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user')->latest();
        if ($request->filled('status')) {
            $query->where('status', (int) $request->status);
        }
        $orders = $query->get();
        return view('admin.customer-orders.index', compact('orders'));
    }
    public function show(Order $order)
    {
        $order->load(['user','items.product','statusHistories.updatedBy',]);
        return view('admin.customer-orders.show',compact('order'));
    }
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4,5,6,7',
        ]);
        $newStatus = (int) $request->status;
        $currentStatus = (int) $order->status;
        if ($newStatus === $currentStatus) {
            return back()->with(
                'error',
                'Order is already in this status.'
            );
        }
        $normalFlow = [
            0 => 1,
            1 => 2,
            2 => 3,
            3 => 4,
        ];
        $isNormalNextStatus =
            isset($normalFlow[$currentStatus])
            && $normalFlow[$currentStatus] === $newStatus;
        $isCancelled =
            $newStatus === OrderStatusHistory::STATUS_CANCELLED
            && in_array(
                $currentStatus,
                [
                    OrderStatusHistory::STATUS_PENDING,
                    OrderStatusHistory::STATUS_CONFIRMED,
                    OrderStatusHistory::STATUS_PROCESSING,
                    OrderStatusHistory::STATUS_SHIPPED,
                ],
                true
            );
        $isFailed =
            $newStatus === OrderStatusHistory::STATUS_FAILED
            && in_array(
                $currentStatus,
                [
                    OrderStatusHistory::STATUS_PENDING,
                    OrderStatusHistory::STATUS_CONFIRMED,
                    OrderStatusHistory::STATUS_PROCESSING,
                    OrderStatusHistory::STATUS_SHIPPED,
                ],
                true
            );
        $isRefunded =
            $newStatus === OrderStatusHistory::STATUS_REFUNDED
            && in_array(
                $currentStatus,
                [
                    OrderStatusHistory::STATUS_CANCELLED,
                    OrderStatusHistory::STATUS_DELIVERED,
                ],
                true
            );
        if (
            !$isNormalNextStatus
            && !$isCancelled
            && !$isFailed
            && !$isRefunded
        ) {
            return back()->with(
                'error',
                'Invalid order status change.'
            );
        }
        DB::transaction(function () use ($order, $newStatus) {
            $order->update([
                'status' => $newStatus,
            ]);
            OrderStatusHistory::create([
                'order_id' => $order->id,
                'updated_by' => auth()->id(),
                'status' => $newStatus,
            ]);
        });
        $statusNames = [
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Failed',
            7 => 'Refunded',
        ];
        return back()->with(
            'success',
            'Order status changed to '
            . $statusNames[$newStatus]
            . ' successfully.'
        );
    }
   public function refund(Request $request, Order $order)
    {
        if (!in_array((int) $order->status, [5, 8], true)) {
            return back()->with(
                'error',
                'Only returned and cancelled orders can be refunded.'
            );
        }

        if (!empty($order->razorpay_refund_id)) {
            return back()->with(
                'error',
                'Refund has already been processed.'
            );
        }

        if ($order->payment_method === 'razorpay') {

            if (empty($order->razorpay_payment_id)) {
                return back()->with(
                    'error',
                    'Razorpay payment ID is missing.'
                );
            }

            try {
                $api = new \Razorpay\Api\Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                $refund = $api->payment
                    ->fetch($order->razorpay_payment_id)
                    ->refund([
                        'amount' => (int) round($order->total_amount * 100),
                    ]);

                DB::transaction(function () use ($order, $refund) {

                    $order->update([
                        'razorpay_refund_id' => $refund['id'],
                        'refund_status' => 'processed',
                        'refund_method' => 'razorpay',
                        'refund_amount' => $order->total_amount,
                        'refunded_at' => now(),
                        'payment_status' => 'refunded',
                        'status' => 7,
                    ]);

                    OrderStatusHistory::create([
                        'order_id' => $order->id,
                        'updated_by' => auth()->id(),
                        'status' => 7,
                    ]);
                });

                return back()->with(
                    'success',
                    'Razorpay refund processed successfully.'
                );

            } catch (\Throwable $e) {

                Log::error('Razorpay refund failed', [
                    'order_id' => $order->id,
                    'razorpay_payment_id' => $order->razorpay_payment_id,
                    'message' => $e->getMessage(),
                ]);

                return back()->with(
                    'error',
                    'Razorpay refund failed. Please try again.'
                );
            }
        }

        if ($order->payment_method === 'cod') {

            if (empty($order->customer_upi_id)) {
                return back()->with(
                    'error',
                    'Customer UPI ID is missing for COD refund.'
                );
            }

            DB::transaction(function () use ($order) {

                $order->update([
                    'refund_status' => 'processed',
                    'refund_method' => 'manual',
                    'refund_amount' => $order->total_amount,
                    'refunded_at' => now(),
                    'payment_status' => 'refunded',
                    'status' => 7,
                ]);

                OrderStatusHistory::create([
                    'order_id' => $order->id,
                    'updated_by' => auth()->id(),
                    'status' => 7,
                ]);
            });

            return back()->with(
                'success',
                'COD refund marked successfully. Refund customer through the provided UPI ID.'
            );
        }

        return back()->with(
            'error',
            'Invalid payment method.'
        );
    }
}
