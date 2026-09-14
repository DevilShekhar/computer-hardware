@can('my-pc-builder-order-show')
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>PC Builder Order Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('my-pc-builder-orders') }}" class="btn btn-secondary">
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
                                    @if($pcBuilder->payment_status === 'paid' || $pcBuilder->payment_status == 1)
                                    <span class="badge badge-success">Paid</span>
                                    @elseif($pcBuilder->payment_status === 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                    @elseif($pcBuilder->payment_status === 'refunded')
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
                            <div class="col-md-6">
                                <strong>Razorpay Order ID</strong>
                                <p>{{ $pcBuilder->razorpay_order_id ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Razorpay Payment ID</strong>
                                <p>{{ $pcBuilder->razorpay_payment_id ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Razorpay Signature</strong>
                                <p class="text-break">{{ $pcBuilder->razorpay_signature ?? '-' }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Payment Status</strong>
                                <p>
                                    @if($pcBuilder->payment_status === 'paid' || $pcBuilder->payment_status == 1)
                                    <span class="badge badge-success">Paid</span>
                                    @elseif($pcBuilder->payment_status === 'refunded')
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
                        <p class="mb-1">{{ $pcBuilder->city ?? '-' }}, {{ $pcBuilder->state ?? '-' }}</p>
                        <p class="mb-1">{{ $pcBuilder->pincode ?? '-' }}</p>
                        <p class="mb-0">{{ $pcBuilder->country ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </div>
        @php
            $products = is_array($pcBuilder->products) ? $pcBuilder->products : json_decode($pcBuilder->products, true);
        @endphp
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
                                        <th>Component</th>
                                        <th>Builder Type</th>
                                        <th>Price</th>
                                        <th>Quantity</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($products as $product)
                                    @php
                                        $quantity = (int) ($product['quantity'] ?? 1);
                                        $price = (float) ($product['price'] ?? $product['selling_price'] ?? 0);
                                        $total = $price * $quantity;
                                    @endphp
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>
                                            <strong>{{ $product['name'] ?? 'Product' }}</strong>
                                        </td>
                                        <td>{{ $product['builder_type'] ?? $product['type'] ?? '-' }}</td>
                                        <td>₹{{ number_format($price, 2) }}</td>
                                        <td>{{ $quantity }}</td>
                                        <td>
                                            <strong>₹{{ number_format($total, 2) }}</strong>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No components found.</td>
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
                            <strong>₹{{ number_format($pcBuilder->subtotal, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>GST</span>
                            <strong>₹{{ number_format($pcBuilder->gst_amount, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Shipping</span>
                            <strong>₹{{ number_format($pcBuilder->shipping_amount, 2) }}</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Discount</span>
                            <strong class="text-danger">- ₹{{ number_format($pcBuilder->discount_amount, 2) }}</strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>Total Amount</strong>
                            <strong class="text-success">₹{{ number_format($pcBuilder->total_amount, 2) }}</strong>
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
                        @php
                            $currentStatus = (int) ($pcBuilder->status ?? 0);
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

                        <div class="row text-center">
                            @foreach($statuses as $statusValue => $statusName)
                            <div class="col">
                                <div class="mb-2">
                                    @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned && $statusValue <= $currentStatus)
                                        <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                            <i class="fas fa-check"></i>
                                        </span>
                                    @else
                                        <span class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                            <i class="fas fa-circle"></i>
                                        </span>
                                    @endif
                                </div>
                                <strong>{{ $statusName }}</strong>
                            </div>
                            @endforeach
                        </div>

                        <hr>

                        <div class="text-center">
                            <h5>Current Status</h5>

                            @switch($currentStatus)
                                @case(0)
                                    <span class="badge badge-warning" style="font-size:14px;">
                                        <i class="fas fa-clock"></i> Pending
                                    </span>
                                    @break
                                @case(1)
                                    <span class="badge badge-info" style="font-size:14px;">
                                        <i class="fas fa-check"></i> Confirmed
                                    </span>
                                    @break
                                @case(2)
                                    <span class="badge badge-primary" style="font-size:14px;">
                                        <i class="fas fa-cog"></i> Processing
                                    </span>
                                    @break
                                @case(3)
                                    <span class="badge badge-info" style="font-size:14px;">
                                        <i class="fas fa-truck"></i> Shipped
                                    </span>
                                    @break
                                @case(4)
                                    <span class="badge badge-success" style="font-size:14px;">
                                        <i class="fas fa-check-circle"></i> Delivered
                                    </span>
                                    @break
                                @case(5)
                                    <span class="badge badge-danger" style="font-size:14px;">
                                        <i class="fas fa-times-circle"></i> Cancelled
                                    </span>
                                    @break
                                @case(6)
                                    <span class="badge badge-danger" style="font-size:14px;">
                                        <i class="fas fa-exclamation-circle"></i> Failed
                                    </span>
                                    @break
                                @case(7)
                                    <span class="badge badge-dark" style="font-size:14px;">
                                        <i class="fas fa-undo"></i> Refunded
                                    </span>
                                    @break
                                @case(8)
                                    <span class="badge badge-warning" style="font-size:14px;">
                                        <i class="fas fa-undo"></i> Returned
                                    </span>
                                    @break
                                @default
                                    <span class="badge badge-secondary" style="font-size:14px;">
                                        Unknown
                                    </span>
                            @endswitch
                            @if(in_array($currentStatus, [0, 1]) && $pcBuilder->created_at->diffInHours(now()) < 24)
                                <hr>
                                <div class="text-center">
                                    <h6 class="mb-3">
                                        Order Actions
                                    </h6>
                                    <form action="{{ route('my-pc-builder-orders.cancel', $pcBuilder->id) }}" method="POST" id="cancel-pc-builder-form">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" name="cancel_reason" id="cancel_reason">
                                        <input type="hidden" name="cancel_remark" id="cancel_remark">

                                        <button type="button" class="btn btn-danger" id="cancel-pc-builder-btn">
                                            <i class="fas fa-times"></i>
                                            Cancel Order
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($isCancelled)
                                <hr>
                                <div class="text-center">
                                    <span class="badge badge-danger" style="font-size:15px;">
                                        <i class="fas fa-times-circle"></i>
                                        Order Cancelled
                                    </span>
                                </div>

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
                            @endif

                            @if($currentStatus === 4)
                                <hr>
                                <div class="text-center">
                                    <h6 class="mb-3">
                                        Order Actions
                                    </h6>

                                    <form action="{{ route('my-pc-builder-orders.return', $pcBuilder->id) }}" method="POST" id="return-pc-builder-form">
                                        @csrf
                                        @method('PUT')

                                        <input type="hidden" name="return_reason" id="return_reason">
                                        <input type="hidden" name="return_remark" id="return_remark">

                                        <button type="button" class="btn btn-danger" id="return-pc-builder-btn">
                                            <i class="fas fa-undo"></i>
                                            Return Order
                                        </button>
                                    </form>
                                </div>
                            @endif

                            @if($isReturned)
                                <hr>

                                <div class="text-center">
                                    <span class="badge badge-warning" style="font-size:15px;">
                                        <i class="fas fa-undo"></i>
                                        Product Returned
                                    </span>
                                </div>

                                <div class="mt-4">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <strong>Return Reason</strong>
                                            <p class="mt-1 mb-0">
                                                {{ $pcBuilder->return_reason ?? '-' }}
                                            </p>
                                        </div>

                                        <div class="col-md-4">
                                            <strong>Return Remark</strong>
                                            <p class="mt-1 mb-0">
                                                {{ $pcBuilder->return_remark ?? '-' }}
                                            </p>
                                        </div>

                                        @if($pcBuilder->returned_at)
                                            <div class="col-md-4">
                                                <strong>Returned At</strong>
                                                <p class="mt-1 mb-0">
                                                    {{ $pcBuilder->returned_at->format('d-m-Y h:i A') }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
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
                                            @switch((int) $history->status)
                                                @case(0)
                                                    <span class="badge badge-warning">Pending</span>
                                                    @break
                                                @case(1)
                                                    <span class="badge badge-info">Confirmed</span>
                                                    @break
                                                @case(2)
                                                    <span class="badge badge-primary">Processing</span>
                                                    @break
                                                @case(3)
                                                    <span class="badge badge-info">Shipped</span>
                                                    @break
                                                @case(4)
                                                    <span class="badge badge-success">Delivered</span>
                                                    @break
                                                @case(5)
                                                    <span class="badge badge-danger">Cancelled</span>
                                                    @break
                                                @case(6)
                                                    <span class="badge badge-danger">Failed</span>
                                                    @break
                                                @case(7)
                                                    <span class="badge badge-dark">Refunded</span>
                                                    @break
                                                @case(8)
                                                    <span class="badge badge-warning">Returned</span>
                                                    @break
                                                @default
                                                    <span class="badge badge-secondary">Unknown</span>
                                            @endswitch
                                        </td>
                                        <td>{{ $history->updatedBy->name ?? 'Admin' }}</td>
                                        <td>{{ $history->created_at->format('d M Y, h:i A') }}</td>
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
</section>
@endsection
<script>
document.addEventListener('DOMContentLoaded', function() {
    const cancelBtn = document.getElementById('cancel-pc-builder-btn');
    const cancelForm = document.getElementById('cancel-pc-builder-form');

    if (!cancelBtn || !cancelForm) {
        return;
    }

    cancelBtn.addEventListener('click', function() {
        Swal.fire({
            title: 'Cancel Order',
            html: `
                <select id="swal-cancel-reason" class="swal2-select" style="width:100%;margin:10px 0;">
                    <option value="">Select cancellation reason</option>
                    <option value="Changed my mind">Changed my mind</option>
                    <option value="Ordered by mistake">Ordered by mistake</option>
                    <option value="Found a better price">Found a better price</option>
                    <option value="Product is no longer required">Product is no longer required</option>
                    <option value="Want to change the product">Want to change the product</option>
                    <option value="Delivery is taking too long">Delivery is taking too long</option>
                    <option value="Payment issue">Payment issue</option>
                    <option value="Other">Other</option>
                </select>
                <textarea id="swal-cancel-remark" class="swal2-textarea" placeholder="Enter remark (optional)" style="width:100%;margin:10px 0;"></textarea>
            `,
            showCancelButton: true,
            confirmButtonColor: '#fc544b',
            cancelButtonColor: '#2878f0',
            confirmButtonText: 'Continue',
            cancelButtonText: 'Cancel',
            preConfirm: function() {
                const reason = document.getElementById('swal-cancel-reason').value;
                const remark = document.getElementById('swal-cancel-remark').value.trim();

                if (!reason) {
                    Swal.showValidationMessage('Please select a cancellation reason.');
                    return false;
                }

                return {
                    reason: reason,
                    remark: remark
                };
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                document.getElementById('cancel_reason').value = result.value.reason;
                document.getElementById('cancel_remark').value = result.value.remark;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to cancel this order?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fc544b',
                    cancelButtonColor: '#2878f0',
                    confirmButtonText: 'Yes, Cancel Order',
                    cancelButtonText: 'No'
                }).then(function(confirmResult) {
                    if (confirmResult.isConfirmed) {
                        cancelForm.submit();
                    }
                });
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const returnBtn = document.getElementById('return-pc-builder-btn');
    const returnForm = document.getElementById('return-pc-builder-form');

    if (!returnBtn || !returnForm) return;

    returnBtn.addEventListener('click', function() {
        Swal.fire({
            title: 'Return Order',
            html: `
                <select id="swal-return-reason" class="swal2-select" style="width:100%;margin:10px 0;">
                    <option value="">Select return reason</option>
                    <option value="Product damaged">Product damaged</option>
                    <option value="Wrong product received">Wrong product received</option>
                    <option value="Product not as described">Product not as described</option>
                    <option value="Quality issue">Quality issue</option>
                    <option value="Performance issue">Performance issue</option>
                    <option value="Missing component">Missing component</option>
                    <option value="Other">Other</option>
                </select>
                <textarea id="swal-return-remark" class="swal2-textarea" placeholder="Enter return remark (optional)" style="width:100%;margin:10px 0;"></textarea>
            `,
            showCancelButton: true,
            confirmButtonColor: '#2878f0',
            cancelButtonColor: '#fc544b',
            confirmButtonText: 'Continue',
            cancelButtonText: 'Cancel',
            preConfirm: function() {
                const reason = document.getElementById('swal-return-reason').value;
                const remark = document.getElementById('swal-return-remark').value.trim();

                if (!reason) {
                    Swal.showValidationMessage('Please select a return reason.');
                    return false;
                }

                return {
                    reason: reason,
                    remark: remark
                };
            }
        }).then(function(result) {
            if (result.isConfirmed) {
                document.getElementById('return_reason').value = result.value.reason;
                document.getElementById('return_remark').value = result.value.remark;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'Do you really want to return this order?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#2878f0',
                    cancelButtonColor: '#fc544b',
                    confirmButtonText: 'Yes, Return Order',
                    cancelButtonText: 'No'
                }).then(function(confirmResult) {
                    if (confirmResult.isConfirmed) {
                        returnForm.submit();
                    }
                });
            }
        });
    });
});
</script>
@push('scripts')
@if(session('success'))
<script>
Swal.fire({
    title:'Success!',
    text:@json(session('success')),
    icon:'success',
    confirmButtonColor:'#2878f0',
    confirmButtonText:'OK'
});
</script>
@endif
@if(session('error'))
<script>
Swal.fire({
    title:'Error!',
    text:@json(session('error')),
    icon:'error',
    confirmButtonColor:'#2878f0',
    confirmButtonText:'OK'
});
</script>
@endif
@endpush
@else
@php
abort(403);
@endphp
@endcan
