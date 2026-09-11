@can('order-show')
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
                    <div class="card-header">
                        <h4>
                            Order Details
                        </h4>
                        <div class="card-header-action">
                            <a href="{{ route('customer-orders.index') }}" class="btn btn-secondary">
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
                                    {{ $order->created_at ? $order->created_at->format('d-m-Y h:i A') : '-' }}
                                </p>
                            </div>

                            <div class="col-md-3">
                                <strong>
                                    Payment Method
                                </strong>
                                <p>
                                    {{ $order->payment_method ?? '-' }}
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

                            <div class="col-md-6">
                                <strong>
                                    User ID
                                </strong>
                                <p>
                                    {{ $order->user_id ?? '-' }}
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
        $canRefund = $isReturned;
        @endphp

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h4>
                            Order Status
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="row text-center">

                            @foreach($statuses as $statusValue => $statusName)

                            <div class="col">

                                <div class="mb-2">

                                    @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned && $statusValue <= $currentStatus)

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

                            @endswitch

                        </div>

                        @if($isCancelled)
                            <div class="row mt-3">
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
                        @endif
                        @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned && $currentStatus < 4)

                        @php
                        $nextStatus = $currentStatus + 1;
                        $nextStatusName = $statuses[$nextStatus];
                        @endphp

                        <div class="text-center mb-4">

                            <form
                                action="{{ route('customer-orders.update-status', $order->id) }}"
                                method="POST"
                                class="status-update-form"
                                data-status-name="{{ $nextStatusName }}">

                                @csrf

                                <input
                                    type="hidden"
                                    name="status"
                                    value="{{ $nextStatus }}">

                                <button type="submit" class="btn btn-primary">

                                    <i class="fas fa-arrow-right"></i>

                                    Move to {{ $nextStatusName }}

                                </button>

                            </form>

                        </div>

                        @endif

                        @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned && $currentStatus < 4)

                        <hr>

                        <div class="text-center">

                            <h6 class="mb-3">
                                Other Actions
                            </h6>

                            <form
                                action="{{ route('customer-orders.update-status', $order->id) }}"
                                method="POST"
                                class="status-update-form d-inline"
                                data-status-name="Failed">

                                @csrf

                                <input
                                    type="hidden"
                                    name="status"
                                    value="6">

                                <button type="submit" class="btn btn-warning">

                                    <i class="fas fa-exclamation-triangle"></i>

                                    Mark as Failed

                                </button>

                            </form>

                        </div>

                        @endif

                        @if($canRefund && !$isRefunded)

                        <hr>

                        <div class="text-center">

                            <h6 class="mb-3">
                                Refund
                            </h6>

                            <p class="text-muted">
                                This order has been returned.
                                You can now process the refund.
                            </p>

                            <form
                                action="{{ route('customer-orders.update-status', $order->id) }}"
                                method="POST"
                                class="status-update-form d-inline"
                                data-status-name="Refunded">

                                @csrf

                                <input
                                    type="hidden"
                                    name="status"
                                    value="7">

                                <button type="submit" class="btn btn-dark">

                                    <i class="fas fa-undo"></i>

                                    Refund Order

                                </button>

                            </form>

                        </div>

                        @endif

                        @if($isRefunded)

                        <div class="text-center">

                            <span class="badge badge-dark" style="font-size:15px;">

                                <i class="fas fa-check-circle"></i>

                                Order Refunded

                            </span>

                        </div>

                        @endif

                        @if($isReturned)

                        <div class="text-center">

                            <span class="badge badge-warning" style="font-size:15px;">

                                <i class="fas fa-undo"></i>

                                Product Returned

                            </span>

                        </div>

                        @endif

                        @if($isFailed)

                        <div class="text-center">

                            <span class="badge badge-danger" style="font-size:15px;">

                                <i class="fas fa-exclamation-circle"></i>

                                Order Failed

                            </span>

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
                        <h4>
                            Status History
                        </h4>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped">

                                <thead>

                                    <tr>

                                        <th>
                                            #
                                        </th>

                                        <th>
                                            Status
                                        </th>

                                        <th>
                                            Updated By
                                        </th>

                                        <th>
                                            Date & Time
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($order->statusHistories->sortByDesc('created_at') as $history)

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>

                                            @switch((int) $history->status)

                                            @case(0)

                                            <span class="badge badge-warning">
                                                Pending
                                            </span>

                                            @break

                                            @case(1)

                                            <span class="badge badge-info">
                                                Confirmed
                                            </span>

                                            @break

                                            @case(2)

                                            <span class="badge badge-primary">
                                                Processing
                                            </span>

                                            @break

                                            @case(3)

                                            <span class="badge badge-info">
                                                Shipped
                                            </span>

                                            @break

                                            @case(4)

                                            <span class="badge badge-success">
                                                Delivered
                                            </span>

                                            @break

                                            @case(5)

                                            <span class="badge badge-danger">
                                                Cancelled
                                            </span>

                                            @break

                                            @case(6)

                                            <span class="badge badge-danger">
                                                Failed
                                            </span>

                                            @break

                                            @case(7)

                                            <span class="badge badge-dark">
                                                Refunded
                                            </span>

                                            @break

                                            @case(8)

                                            <span class="badge badge-warning">
                                                Returned
                                            </span>

                                            @break

                                            @endswitch

                                        </td>

                                        <td>
                                            {{ $history->updatedBy->name ?? 'System' }}
                                        </td>

                                        <td>
                                            {{ $history->created_at ? $history->created_at->format('d-m-Y h:i A') : '-' }}
                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="4" class="text-center">
                                            No status history found.
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
        let message = '';

        if (statusName === 'Refunded') {

            message = 'This order will be marked as refunded. Are you sure you want to continue?';

        } else if (statusName === 'Failed') {

            message = 'This order will be marked as failed.';

        } else {

            message = 'The order status will be changed to ' + statusName + '.';

        }

        Swal.fire({

            title: 'Are you sure?',

            text: message,

            icon: 'warning',

            showCancelButton: true,

            confirmButtonColor: '#6777ef',

            cancelButtonColor: '#fc544b',

            confirmButtonText: 'Yes, continue',

            cancelButtonText: 'Cancel'

        }).then(function(result) {

            if (result.isConfirmed) {

                form.submit();

            }

        });

    });

});

</script>

@endpush
@else
    @php
        abort(404);
    @endphp
@endcan
