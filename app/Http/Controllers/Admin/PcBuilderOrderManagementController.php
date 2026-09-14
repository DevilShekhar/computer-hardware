<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PcBuilder;
use App\Models\PcBuilderStatusHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        if (! in_array(
            $pcBuilder->status,
            ['cancelled', 'returned'],
            true
        )) {
            return back()->with(
                'error',
                'Only returned and cancelled orders can be refunded.'
            );
        }

        if ($pcBuilder->payment_status === 'refunded') {
            return back()->with(
                'error',
                'Refund has already been processed.'
            );
        }

        if ($pcBuilder->payment_method === 'razorpay') {

            if (empty($pcBuilder->razorpay_payment_id)) {
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
                    ->fetch($pcBuilder->razorpay_payment_id)
                    ->refund([
                        'amount' => (int) round(
                            $pcBuilder->total_amount * 100
                        ),
                    ]);

                DB::transaction(function () use ($pcBuilder) {
                    $pcBuilder->update([
                        'payment_status' => 'refunded',
                        'status' => 'refunded',
                    ]);
                });

                return back()->with(
                    'success',
                    'Razorpay refund processed successfully.'
                );

            } catch (\Throwable $e) {

                Log::error('PC Builder Razorpay refund failed', [
                    'pc_builder_id' => $pcBuilder->id,
                    'builder_number' => $pcBuilder->builder_number,
                    'razorpay_payment_id' => $pcBuilder->razorpay_payment_id,
                    'message' => $e->getMessage(),
                ]);

                return back()->with(
                    'error',
                    'Razorpay refund failed. Please try again.'
                );
            }
        }

        if ($pcBuilder->payment_method === 'cod') {
            DB::transaction(function () use ($pcBuilder) {
                $pcBuilder->update([
                    'payment_status' => 'refunded',
                    'status' => 'refunded',
                ]);
            });

            return back()->with(
                'success',
                'COD refund marked successfully.'
            );
        }

        return back()->with(
            'error',
            'Invalid payment method.'
        );
    }
}
