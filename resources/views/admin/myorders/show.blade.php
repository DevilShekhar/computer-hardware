@can('my-order-show')
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
                        <h4>
                            Order Details
                        </h4>
                        <div class="card-header-action">
                            <a href="{{ route('my-orders') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <strong>
                                   Order Number
                                </strong>
                                <p>
                                    {{ $order->order_number }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <strong>
                                    Order Date
                                </strong>
                                <p>
                                    {{ $order->created_at  ? $order->created_at->format('d-m-Y h:i A') : '-' }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <strong>
                                    Payment Method
                                </strong>
                                <p>
                                    {{ strtoupper($order->payment_method ?? '-') }}
                                </p>
                            </div>
                            <div class="col-md-3">
                                <strong>
                                    Payment Status
                                </strong>
                                <p>
                                    @if($order->payment_status == 1)
                                    <span class="badge badge-success">
                                        Paid
                                    </span>
                                    @else
                                    <span class="badge badge-warning">
                                        Pending
                                    </span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Customer Details
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>
                                    Name
                                </strong>
                                <p>
                                    {{ $order->customer_name ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>
                                    Email
                                </strong>
                                <p>
                                    {{ $order->email ?? '-' }}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>
                                    Mobile Number
                                </strong>
                                <p>
                                    {{ $order->mobile_number ?? '-' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                           Shipping Address
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-1">
                            <strong>
                               {{ $order->customer_name }}
                            </strong>
                        </p>
                        <p class="mb-1">
                            {{ $order->address }}
                        </p>
                        <p class="mb-1">
                            {{ $order->city }},
                            {{ $order->state }}
                        </p>
                        <p class="mb-1">
                            {{ $order->pincode }}
                        </p>
                        <p class="mb-0">
                            {{ $order->country }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Order Items
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>
                                            Product
                                        </th>
                                        <th>
                                            SKU
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Quantity
                                        </th>
                                        <th>
                                            Total
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($order->items as $item)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            <strong>
                                                {{ $item->product_name }}
                                            </strong>
                                        </td>
                                        <td>
                                            {{ $item->sku ?? '-' }}
                                        </td>
                                        <td>
                                            ₹{{ number_format($item->price, 2) }}
                                        </td>
                                        <td>
                                            {{ $item->quantity }}
                                        </td>
                                        <td>
                                            <strong>
                                                ₹{{ number_format($item->total, 2) }}
                                            </strong>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="6" class="text-center">
                                            No order items found.
                                        </td>
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
                        <h4>
                           Order Notes
                        </h4>
                    </div>
                    <div class="card-body">
                        <p class="mb-0">
                            {{ $order->order_notes ?? 'No order notes.' }}
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h4>
                           Order Summary
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                Subtotal
                            </span>
                            <strong>
                                ₹{{ number_format($order->subtotal, 2) }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                Shipping
                            </span>
                            <strong>
                                ₹{{ number_format($order->shipping_amount, 2) }}
                            </strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>
                                Discount
                            </span>
                            <strong class="text-danger">
                                - ₹{{ number_format($order->discount_amount, 2) }}
                            </strong>
                        </div>
                        <hr>
                        <div class="d-flex justify-content-between">
                            <strong>
                                Total Amount
                            </strong>
                            <strong class="text-primary">
                                ₹{{ number_format($order->total_amount, 2) }}
                            </strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            Order Status
                        </h4>
                    </div>
                    <div class="card-body">
                        @php
                            $statuses = [
                                0 => 'Pending',
                                1 => 'Confirmed',
                                2 => 'Processing',
                                3 => 'Shipped',
                                4 => 'Delivered',
                            ];
                            $currentStatus = (int) $order->status;
                            $isCancelled = $currentStatus === 5;
                            $isFailed = $currentStatus === 6;
                            $isRefunded = $currentStatus === 7;
                            $isReturned = $currentStatus === 8;
                        @endphp
                        @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned)
                            <div class="row text-center">
                                @foreach($statuses as $statusValue => $statusName)
                                    <div class="col">
                                        <div class="mb-2">
                                            @if($statusValue <= $currentStatus)
                                            <span class="rounded-circle bg-success text-white d-inline-flex align-items-center justify-content-center" style="width:45px;height:45px;">
                                                <i class="fas fa-check"></i>
                                            </span>
                                            @else
                                            <span class="rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center" style="width:45px;height:45px;">
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
                        @endif
                        <div class="text-center">
                            <h5>
                                Current Status
                            </h5>
                            @switch($currentStatus)
                                @case(0)
                                <span class="badge badge-warning" style="font-size:14px;">
                                    <i class="fas fa-clock"></i>
                                    Pending
                                </span>
                                @break
                                @case(1)
                                <span class="badge badge-info"  style="font-size:14px;">
                                    <i class="fas fa-check"></i>
                                    Confirmed
                                </span>
                                @break
                                @case(2)
                                <span class="badge badge-primary" style="font-size:14px;">
                                    <i class="fas fa-cog"></i>
                                    Processing
                                </span>
                                @break
                                @case(3)
                                <span class="badge badge-info" style="font-size:14px;">
                                    <i class="fas fa-truck"></i>
                                    Shipped
                                </span>
                                @break
                                @case(4)
                                <span class="badge badge-success" style="font-size:14px;">
                                    <i class="fas fa-check-circle"></i>
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
                        @if(in_array($currentStatus, [0, 1]) && $order->created_at->diffInHours(now()) < 24)
                            <hr>
                            <div class="text-center">
                                <h6 class="mb-3">
                                    Order Actions
                                </h6>
                                <form action="{{ route('my-orders.cancel', $order->id) }}" method="POST" id="cancel-order-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="cancel_reason" id="cancel_reason">
                                    <input type="hidden" name="cancel_remark" id="cancel_remark">
                                    <button type="button" class="btn btn-danger" id="cancel-order-btn">
                                        <i class="fas fa-times"></i>
                                        Cancel Order
                                    </button>
                                </form>
                            </div>
                        @endif
                        @if($currentStatus === 4)
                            <hr>
                            <div class="text-center">
                                <h6 class="mb-3">
                                    Order Actions
                                </h6>
                                <button type="button"  class="btn btn-warning" id="return-product-btn">
                                    <i class="fas fa-undo"></i>
                                    Return Product
                                </button>
                                <form action="{{ route('my-orders.return', $order->id) }}" method="POST" id="return-product-form">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="return_reason" id="return_reason">
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
                                            {{ $order->cancel_reason ?? '-' }}
                                        </p>
                                    </div>

                                    <div class="col-md-6">
                                        <strong>
                                            Cancellation Remark
                                        </strong>
                                        <p class="mt-1 mb-0">
                                            {{ $order->cancel_remark ?? '-' }}
                                        </p>
                                    </div>
                                </div>

                                @if($order->cancelled_at)
                                    <div class="row mt-3">
                                        <div class="col-md-6">
                                            <strong>
                                                Cancelled At
                                            </strong>
                                            <p class="mt-1 mb-0">
                                                {{ $order->cancelled_at->format('d-m-Y h:i A') }}
                                            </p>
                                        </div>
                                    </div>
                                @endif
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
                        @endif
                        @if($isFailed)
                            <hr>
                            <div class="text-center">
                                <span class="badge badge-danger" style="font-size:15px;">
                                    <i class="fas fa-exclamation-circle"></i>
                                    Order Failed
                                </span>
                            </div>
                        @endif
                        @if($isRefunded)
                            <hr>
                            <div class="text-center">
                                <span class="badge badge-dark" style="font-size:15px;">
                                    <i class="fas fa-undo"></i>
                                    Order Refunded
                                </span>
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
        $('#cancel-order-btn').on('click', function() {
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
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Continue',
                cancelButtonText: 'Cancel',
                preConfirm: function() {
                    const reason = $('#swal-cancel-reason').val();
                    const remark = $('#swal-cancel-remark').val().trim();

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
                    $('#cancel_reason').val(result.value.reason);
                    $('#cancel_remark').val(result.value.remark);

                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'Do you really want to cancel this order?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#fc544b',
                        cancelButtonColor: '#6777ef',
                        confirmButtonText: 'Yes, Cancel Order',
                        cancelButtonText: 'No'
                    }).then(function(confirmResult) {
                        if (confirmResult.isConfirmed) {
                            $('#cancel-order-form').submit();
                        }
                    });
                }
            });
        });
        function confirmCancelOrder() {
            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to cancel this order?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, Cancel Order',
                cancelButtonText: 'No'
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('#cancel-order-form').submit();
                }
            });
        }
        $('#return-product-btn').on('click', function() {
            Swal.fire({
                title: 'Return Product',
                text: 'Please select a reason for returning this product.',
                input: 'select',
                inputOptions: {
                    'Product damaged': 'Product damaged',
                    'Wrong product received': 'Wrong product received',
                    'Product not as described': 'Product not as described',
                    'Size or fit issue': 'Size or fit issue',
                    'Quality issue': 'Quality issue',
                    'Other': 'Other'
                },
                inputPlaceholder: 'Select return reason',
                showCancelButton: true,
                confirmButtonColor: '#6777ef',
                cancelButtonColor: '#fc544b',
                confirmButtonText: 'Submit Return',
                cancelButtonText: 'Cancel',
                inputValidator: function(value) {
                    return new Promise(function(resolve) {
                        if (value) {
                            resolve();
                        } else {
                            resolve('Please select a return reason.');
                        }
                    });
                }
            }).then(function(result) {
                if (result.isConfirmed) {
                    $('#return_reason').val(result.value);
                    Swal.fire({
                        title: 'Are you sure?',
                        text: 'You want to return this product?',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#6777ef',
                        cancelButtonColor: '#fc544b',
                        confirmButtonText: 'Yes, Return Product',
                        cancelButtonText: 'Cancel'
                    }).then(function(confirmResult) {
                        if (confirmResult.isConfirmed) {
                            $('#return-product-form').submit();
                        }
                    });
                }
            });
        });
    });
</script>
@if(session('success'))
<script>
    Swal.fire({
        title: 'Success!',
        text: @json(session('success')),
        icon: 'success',
        confirmButtonColor: '#6777ef',
        confirmButtonText: 'OK'
    });
</script>
@endif
@if(session('error'))
<script>
    Swal.fire({
        title: 'Error!',
        text: @json(session('error')),
        icon: 'error',
        confirmButtonColor: '#fc544b',
        confirmButtonText: 'OK'
    });
</script>
@endif
@endpush
@else
    @php
        abort(404);
    @endphp
@endcan
