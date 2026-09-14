@can('pc-builder-order-show')
@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        @if(session('success'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        @php
            $products = is_array($pcBuilder->products) ? $pcBuilder->products : json_decode($pcBuilder->products, true);
            $products = is_array($products) ? $products : [];

            $currentStatus = (int) ($pcBuilder->status ?? 0);
            $paymentStatus = strtolower((string) ($pcBuilder->payment_status ?? 'pending'));

            $statuses = [
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

            $isCancelled = $currentStatus === 5;
            $isFailed = $currentStatus === 6;
            $isRefunded = $currentStatus === 7;
            $isReturned = $currentStatus === 8;
        @endphp

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Order Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('pc-builder-orders.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>Builder Number</strong>
                                <p>{{ $pcBuilder->builder_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Order Date</strong>
                                <p>{{ $pcBuilder->created_at ? $pcBuilder->created_at->format('d-m-Y h:i A') : '-' }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Payment Method</strong>
                                <p>{{ strtoupper($pcBuilder->payment_method ?? '-') }}</p>
                            </div>
                            <div class="col-md-3">
                                <strong>Payment Status</strong>
                                <p>
                                    @if($paymentStatus === 'paid' || $paymentStatus === '1')
                                    <span class="badge badge-success">Paid</span>
                                    @elseif($paymentStatus === 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                    @elseif($paymentStatus === 'refunded')
                                    <span class="badge badge-dark">Refunded</span>
                                    @else
                                    <span class="badge badge-warning">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($pcBuilder->payment_method === 'razorpay')
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Razorpay Payment Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <strong>Razorpay Order ID</strong>
                                <p>{{ $pcBuilder->razorpay_order_id ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Razorpay Payment ID</strong>
                                <p>{{ $pcBuilder->razorpay_payment_id ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Razorpay Signature</strong>
                                <p>{{ $pcBuilder->razorpay_signature ?? '-' }}</p>
                            </div>
                            <div class="col-md-4">
                                <strong>Payment Status</strong>
                                <p>
                                    @if($paymentStatus === 'paid' || $paymentStatus === '1')
                                    <span class="badge badge-success">Paid</span>
                                    @elseif($paymentStatus === 'refunded')
                                    <span class="badge badge-dark">Refunded</span>
                                    @else
                                    <span class="badge badge-warning">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Customer Details</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Name</strong>
                                <p>{{ $pcBuilder->customer_name ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Email</strong>
                                <p>{{ $pcBuilder->email ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Mobile Number</strong>
                                <p>{{ $pcBuilder->mobile_number ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>User ID</strong>
                                <p>{{ $pcBuilder->user_id ?? '-' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Shipping Address</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>{{ $pcBuilder->customer_name ?? '-' }}</strong>
                        </p>
                        <p class="mb-1">{{ $pcBuilder->address ?? '-' }}</p>
                        <p class="mb-1">
                            {{ $pcBuilder->city ?? '-' }},
                            {{ $pcBuilder->state ?? '-' }}
                        </p>
                        <p class="mb-1">{{ $pcBuilder->pincode ?? '-' }}</p>
                        <p class="mb-0">{{ $pcBuilder->country ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Components</h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product</th>
                                        <th>SKU</th>
                                        <th>Builder Type</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    @php
                                        $productName = $product['product_name'] ?? $product['name'] ?? '-';
                                        $sku = $product['sku'] ?? '-';
                                        $builderType = $product['builder_type'] ?? $product['type'] ?? '-';
                                        $price = (float) ($product['price'] ?? $product['selling_price'] ?? 0);
                                        $quantity = (int) ($product['quantity'] ?? 1);
                                        $itemTotal = $price * $quantity;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td><strong>{{ $productName }}</strong></td>
                                        <td>{{ $sku }}</td>
                                        <td>{{ $builderType }}</td>
                                        <td>₹{{ number_format($price, 2) }}</td>
                                        <td>{{ $quantity }}</td>
                                        <td><strong>₹{{ number_format($itemTotal, 2) }}</strong></td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No PC builder components found.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Notes</h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">{{ $pcBuilder->order_notes ?? 'No order notes.' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Order Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subtotal</span>
                            <strong>₹{{ number_format($pcBuilder->subtotal ?? 0, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>GST</span>
                            <strong>₹{{ number_format($pcBuilder->gst_amount ?? 0, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <strong>₹{{ number_format($pcBuilder->shipping_amount ?? 0, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Discount</span>
                            <strong class="text-danger">- ₹{{ number_format($pcBuilder->discount_amount ?? 0, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Amount</strong>
                            <strong class="text-success">₹{{ number_format($pcBuilder->total_amount ?? 0, 2) }}</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Order Status</h4>
                        </div>

                        <div class="card-body">

                            <div class="row text-center">

                                @foreach($statuses as $statusValue => $statusName)

                                <div class="col">

                                    <div class="mb-2">

                                        @if(
                                            !$isCancelled &&
                                            !$isFailed &&
                                            !$isRefunded &&
                                            !$isReturned &&
                                            $statusValue <= $currentStatus
                                        )

                                        <span
                                            class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center"
                                            style="width:45px;height:45px;">
                                            <i class="fas fa-check"></i>
                                        </span>

                                        @else

                                        <span
                                            class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center"
                                            style="width:45px;height:45px;">
                                            <i class="fas fa-circle"></i>
                                        </span>

                                        @endif

                                    </div>

                                    <strong>
                                        {{ $statusName }}
                                    </strong>

                                </div>

                                @endforeach

                            </div>

                            <hr>

                            <div class="text-center mb-4">

                                <h5>
                                    Current Status
                                </h5>

                                @switch($currentStatus)

                                @case(0)

                                <span class="badge badge-warning" style="font-size:14px;">
                                    Pending
                                </span>

                                @break

                                @case(1)

                                <span class="badge badge-info" style="font-size:14px;">
                                    Confirmed
                                </span>

                                @break

                                @case(2)

                                <span class="badge badge-primary" style="font-size:14px;">
                                    Processing
                                </span>

                                @break

                                @case(3)

                                <span class="badge badge-info" style="font-size:14px;">
                                    Shipped
                                </span>

                                @break

                                @case(4)

                                <span class="badge badge-success" style="font-size:14px;">
                                    Delivered
                                </span>

                                @break

                                @case(5)

                                <span class="badge badge-danger" style="font-size:14px;">
                                    <i class="fas fa-times-circle"></i>
                                    Cancelled
                                </span>

                                @break

                                @case(6)

                                <span class="badge badge-danger" style="font-size:14px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Failed
                                </span>

                                @break

                                @case(7)

                                <span class="badge badge-dark" style="font-size:14px;">
                                    <i class="fas fa-undo"></i>
                                    Refunded
                                </span>

                                @break

                                @case(8)

                                <span class="badge badge-warning" style="font-size:14px;">
                                    <i class="fas fa-undo"></i>
                                    Returned
                                </span>

                                @break

                                @default

                                <span class="badge badge-secondary" style="font-size:14px;">
                                    Unknown
                                </span>

                                @endswitch

                            </div>

                            @if(
                                !$isCancelled &&
                                !$isFailed &&
                                !$isRefunded &&
                                !$isReturned &&
                                $currentStatus < 4
                            )

                            @php
                                $nextStatus = $currentStatus + 1;
                                $nextStatusName = $statuses[$nextStatus];
                            @endphp

                            <div class="text-center mb-4">

                                <form
                                    action="{{ route('pc-builder-orders.update-status', $pcBuilder->id) }}"
                                    method="POST"
                                    class="status-update-form"
                                    data-status-name="{{ $nextStatusName }}">

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="{{ $nextStatus }}">

                                    <button
                                        type="submit"
                                        class="btn btn-primary">

                                        <i class="fas fa-arrow-right"></i>

                                        Move to {{ $nextStatusName }}

                                    </button>

                                </form>

                            </div>

                            <hr>

                            <div class="text-center">

                                <h6 class="mb-3">
                                    Other Actions
                                </h6>

                                <form
                                    action="{{ route('pc-builder-orders.update-status', $pcBuilder->id) }}"
                                    method="POST"
                                    class="status-update-form d-inline"
                                    data-status-name="Failed">

                                    @csrf

                                    <input
                                        type="hidden"
                                        name="status"
                                        value="6">

                                    <button
                                        type="submit"
                                        class="btn btn-warning">

                                        <i class="fas fa-exclamation-triangle"></i>

                                        Mark as Failed

                                    </button>

                                </form>

                            </div>

                            @endif

                            @if($isRefunded)

                            <div class="text-center">

                                <span
                                    class="badge badge-dark"
                                    style="font-size:15px;">

                                    <i class="fas fa-check-circle"></i>

                                    Order Refunded

                                </span>

                            </div>

                            @endif

                            @if($isReturned)

                            <div class="text-center">

                                <span
                                    class="badge badge-warning"
                                    style="font-size:15px;">

                                    <i class="fas fa-undo"></i>

                                    Product Returned

                                </span>

                            </div>

                            @endif

                            @if($isFailed)

                            <div class="text-center">

                                <span
                                    class="badge badge-danger"
                                    style="font-size:15px;">

                                    <i class="fas fa-exclamation-circle"></i>

                                    Order Failed

                                </span>

                            </div>

                            @endif

                            @if($isCancelled)

                            <div class="text-center">

                                <span
                                    class="badge badge-danger"
                                    style="font-size:15px;">

                                    <i class="fas fa-times-circle"></i>

                                    Order Cancelled

                                </span>
                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <strong>
                                                Cancellation Reason
                                            </strong>
                                            <p class="mt-1 mb-0">
                                                {{ $pcBuilder->cancel_reason ?? '-' }}
                                            </p>
                                        </div>

                                        <div class="col-md-6">
                                            <strong>
                                                Cancellation Remark
                                            </strong>
                                            <p class="mt-1 mb-0">
                                                {{ $pcBuilder->cancel_remark ?? '-' }}
                                            </p>
                                        </div>
                                    </div>

                                    @if($pcBuilder->cancelled_at)
                                        <div class="row mt-3">
                                            <div class="col-md-6">
                                                <strong>
                                                    Cancelled At
                                                </strong>
                                                <p class="mt-1 mb-0">
                                                    {{ $pcBuilder->cancelled_at->format('d-m-Y h:i A') }}
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>

                            @endif

                        </div>
                    </div>
                </div>
        </div>

        <div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4>Status History</h4>
            </div>
            <div class="card-body">
                @php
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
                @endphp

                @if($pcBuilder->statusHistories->count())
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <th>Updated By</th>
                                    <th>Date & Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pcBuilder->statusHistories as $history)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @php
                                                $status = (int) $history->status;
                                            @endphp

                                            @if($status === 0)
                                                <span class="badge badge-warning">Pending</span>
                                            @elseif($status === 1)
                                                <span class="badge badge-info">Confirmed</span>
                                            @elseif($status === 2)
                                                <span class="badge badge-primary">Processing</span>
                                            @elseif($status === 3)
                                                <span class="badge badge-info">Shipped</span>
                                            @elseif($status === 4)
                                                <span class="badge badge-success">Delivered</span>
                                            @elseif($status === 5)
                                                <span class="badge badge-danger">Cancelled</span>
                                            @elseif($status === 6)
                                                <span class="badge badge-danger">Failed</span>
                                            @elseif($status === 7)
                                                <span class="badge badge-dark">Refunded</span>
                                            @elseif($status === 8)
                                                <span class="badge badge-warning">Returned</span>
                                            @else
                                                <span class="badge badge-secondary">Unknown</span>
                                            @endif
                                        </td>
                                        <td>
                                            {{ $history->updatedBy->name ?? 'System' }}
                                        </td>
                                        <td>
                                            {{ $history->created_at->format('d M Y, h:i A') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center text-muted py-3">
                        No status history available.
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

    </div>
</section>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('.status-update-form').on('submit', function(e) {
        e.preventDefault();
        let form = this;
        let statusName = $(form).data('status-name');
        let message = statusName === 'Failed'
            ? 'This order will be marked as failed.'
            : 'The order status will be changed to ' + statusName + '.';

        Swal.fire({
            title:'Are you sure?',
            text:message,
            icon:'warning',
            showCancelButton:true,
            confirmButtonColor:'#2878f0',
            cancelButtonColor:'#fc544b',
            confirmButtonText:'Yes, continue',
            cancelButtonText:'Cancel'
        }).then(function(result) {
            if(result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
@endpush
@else
@php abort(404); @endphp
@endcan
