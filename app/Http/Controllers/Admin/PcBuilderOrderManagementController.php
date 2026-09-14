<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PcBuilder;
use App\Models\PcBuilderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Razorpay\Api\Api;

class PcBuilderOrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = PcBuilder::latest('created_at');

        if ($request->has('status') && $request->status !== '') {
            $query->where('status', (int) $request->status);
        }

        $orders = $query->get();

        return view('admin.customer-pc-builder-orders.index', compact('orders'));
    }

    public function show(PcBuilder $pcBuilder)
    {
        $pcBuilder->load(['statusHistories.updatedBy']);

        return view('admin.customer-pc-builder-orders.show', compact('pcBuilder'));
    }

    public function updateStatus(Request $request, PcBuilder $pcBuilder)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1,2,3,4,5,6,7,8',
        ]);

        $newStatus = (int) $request->status;
        $currentStatus = (int) $pcBuilder->status;

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
            $newStatus === 5
            && in_array(
                $currentStatus,
                [0, 1, 2, 3],
                true
            );

        $isFailed =
            $newStatus === 6
            && in_array(
                $currentStatus,
                [0, 1, 2, 3],
                true
            );

        $isRefunded =
            $newStatus === 7
            && in_array(
                $currentStatus,
                [5, 8],
                true
            );

        $isReturned =
            $newStatus === 8
            && $currentStatus === 4;

        if (
            ! $isNormalNextStatus
            && ! $isCancelled
            && ! $isFailed
            && ! $isRefunded
            && ! $isReturned
        ) {
            return back()->with(
                'error',
                'Invalid order status change.'
            );
        }

        DB::transaction(function () use ($pcBuilder, $newStatus) {
            $pcBuilder->update(['status' => $newStatus]);

            if ($newStatus === 7) {
                $pcBuilder->update(['payment_status' => 'refunded']);
            }

            PcBuilderStatusHistory::create([
                'pc_builder_id' => $pcBuilder->id,
                'status' => $newStatus,
                'updated_by' => auth()->id(),
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
            8 => 'Returned',
        ];

        return back()->with(
            'success',
            'Order status changed to '
            .$statusNames[$newStatus]
            .' successfully.'
        );
    }

    public function refund(Request $request, PcBuilder $pcBuilder)
    {
        if ((int) $pcBuilder->status !== 8) {
            return back()->with('error', 'Only returned orders can be refunded.');
        }

        if ($pcBuilder->payment_status === 'refunded' || (int) $pcBuilder->status === 7) {
            return back()->with('error', 'This order has already been refunded.');
        }

        $refundAmount = (float) $pcBuilder->total_amount;

        if ($refundAmount <= 0) {
            return back()->with('error', 'Invalid refund amount.');
        }

        if ($pcBuilder->payment_method === 'cod') {
            $request->validate([
                'customer_upi_id' => 'nullable|string|max:255',
            ]);

            DB::transaction(function () use ($pcBuilder, $refundAmount, $request) {
                $pcBuilder->update([
                    'status' => 7,
                    'payment_status' => 'refunded',
                    'refund_status' => 'processed',
                    'refund_method' => 'upi',
                    'refund_amount' => $refundAmount,
                    'customer_upi_id' => $request->customer_upi_id,
                    'refunded_at' => now(),
                ]);

                PcBuilderStatusHistory::create([
                    'pc_builder_id' => $pcBuilder->id,
                    'status' => 7,
                    'updated_by' => auth()->id(),
                ]);
            });

            return back()->with('success', 'COD refund marked as processed successfully.');
        }

        if ($pcBuilder->payment_method === 'razorpay') {
            if (!$pcBuilder->razorpay_payment_id) {
                return back()->with('error', 'Razorpay payment ID not found.');
            }

            try {
                $api = new Api(
                    config('services.razorpay.key'),
                    config('services.razorpay.secret')
                );

                $payment = $api->payment->fetch($pcBuilder->razorpay_payment_id);

                if (($payment['status'] ?? null) !== 'captured') {
                    return back()->with(
                        'error',
                        'Razorpay payment is not captured. Current status: '.($payment['status'] ?? 'unknown')
                    );
                }

                $capturedAmount = (int) ($payment['amount'] ?? 0);
                $refundedAmount = (int) ($payment['amount_refunded'] ?? 0);
                $remainingAmount = $capturedAmount - $refundedAmount;

                $refundAmountPaise = (int) round($refundAmount * 100);

                if ($refundAmountPaise > $remainingAmount) {
                    return back()->with(
                        'error',
                        'Refund amount is greater than the remaining Razorpay payment amount.'
                    );
                }

                $refund = $payment->refund([
                    'amount' => $refundAmountPaise,
                ]);

                DB::transaction(function () use ($pcBuilder, $refund, $refundAmount) {
                    $pcBuilder->update([
                        'status' => 7,
                        'payment_status' => 'refunded',
                        'refund_status' => $refund['status'] ?? 'processed',
                        'refund_method' => 'razorpay',
                        'refund_amount' => $refundAmount,
                        'razorpay_refund_id' => $refund['id'] ?? null,
                        'refunded_at' => now(),
                    ]);

                    PcBuilderStatusHistory::create([
                        'pc_builder_id' => $pcBuilder->id,
                        'status' => 7,
                        'updated_by' => auth()->id(),
                    ]);
                });

                return back()->with('success', 'Razorpay refund processed successfully.');

            } catch (\Throwable $e) {
                return back()->with('error', 'Razorpay refund failed: '.$e->getMessage());
            }
        }

        return back()->with('error', 'Invalid payment method.');
    }

    public function cancel(Request $request, PcBuilder $pcBuilder)
    {
        abort_unless($pcBuilder->user_id === $request->user()->id, 403);

        $request->validate([
            'cancel_reason' => 'required|string|max:255',
            'cancel_remark' => 'nullable|string|max:1000',
        ]);

        $currentStatus = (int) $pcBuilder->status;

        if (! in_array($currentStatus, [0, 1], true)) {
            return back()->with('error', 'This order cannot be cancelled at this stage.');
        }

        if ($pcBuilder->created_at->diffInHours(now()) >= 24) {
            return back()->with('error', 'Order cancellation is available only within 24 hours of placing the order.');
        }

        DB::transaction(function () use ($pcBuilder, $request) {
            $pcBuilder->update([
                'status' => 5,
                'cancel_reason' => $request->cancel_reason,
                'cancel_remark' => $request->cancel_remark,
                'cancelled_at' => now(),
            ]);

            PcBuilderStatusHistory::create([
                'pc_builder_id' => $pcBuilder->id,
                'status' => 5,
                'updated_by' => auth()->id(),
            ]);
        });

        return back()->with('success', 'PC Builder order cancelled successfully.');
    }

    public function returnOrder(Request $request, PcBuilder $pcBuilder)
    {
        abort_unless($pcBuilder->user_id === $request->user()->id, 403);

        $request->validate([
            'return_reason' => 'required|string|max:1000',
            'return_remark' => 'nullable|string|max:1000',
            'customer_upi_id' => 'required|string|max:255',
        ]);

        if ((int) $pcBuilder->status !== 4) {
            return back()->with('error', 'Only delivered orders can be returned.');
        }

        DB::transaction(function () use ($pcBuilder, $request) {
            $pcBuilder->update([
                'status' => 8,
                'return_reason' => $request->return_reason,
                'return_remark' => $request->return_remark,
                'customer_upi_id' => $request->customer_upi_id,
                'returned_at' => now(),
            ]);

            PcBuilderStatusHistory::create([
                'pc_builder_id' => $pcBuilder->id,
                'status' => 8,
                'updated_by' => auth()->id(),
            ]);
        });

        return back()->with('success', 'Return request submitted successfully.');
    }
}
