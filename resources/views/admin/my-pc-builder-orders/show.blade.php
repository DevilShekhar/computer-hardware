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
                            <strong class="text-primary">₹{{ number_format($pcBuilder->total_amount, 2) }}</strong>
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
                            $statuses = [
                                'pending' => 'Pending',
                                'confirmed' => 'Confirmed',
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'delivered' => 'Delivered'
                            ];
                            $currentStatus = strtolower((string) $pcBuilder->status);
                            $isCancelled = in_array($currentStatus, ['cancelled', 'canceled']);
                            $isFailed = $currentStatus === 'failed';
                            $isRefunded = $currentStatus === 'refunded';
                            $isReturned = in_array($currentStatus, ['returned', 'return_requested']);
                        @endphp
                        @if(!$isCancelled && !$isFailed && !$isRefunded && !$isReturned)
                        <div class="row text-center">
                            @foreach($statuses as $statusValue => $statusName)
                            @php
                                $statusKeys = array_keys($statuses);
                                $currentIndex = array_search($currentStatus, $statusKeys);
                                $statusIndex = array_search($statusValue, $statusKeys);
                            @endphp
                            <div class="col">
                                <div class="mb-2">
                                    @if($currentIndex !== false && $statusIndex !== false && $statusIndex <= $currentIndex)
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
                        @endif
                        <div class="text-center">
                            <h5>Current Status</h5>
                            @switch($currentStatus)
                                @case('pending')
                                <span class="badge badge-warning" style="font-size:14px;">
                                    <i class="fas fa-clock"></i> Pending
                                </span>
                                @break
                                @case('confirmed')
                                <span class="badge badge-info" style="font-size:14px;">
                                    <i class="fas fa-check"></i> Confirmed
                                </span>
                                @break
                                @case('processing')
                                <span class="badge badge-primary" style="font-size:14px;">
                                    <i class="fas fa-cog"></i> Processing
                                </span>
                                @break
                                @case('shipped')
                                <span class="badge badge-info" style="font-size:14px;">
                                    <i class="fas fa-truck"></i> Shipped
                                </span>
                                @break
                                @case('delivered')
                                <span class="badge badge-success" style="font-size:14px;">
                                    <i class="fas fa-check-circle"></i> Delivered
                                </span>
                                @break
                                @case('cancelled')
                                @case('canceled')
                                <span class="badge badge-danger" style="font-size:14px;">
                                    <i class="fas fa-times-circle"></i> Cancelled
                                </span>
                                @break
                                @case('failed')
                                <span class="badge badge-danger" style="font-size:14px;">
                                    <i class="fas fa-exclamation-circle"></i> Failed
                                </span>
                                @break
                                @case('refunded')
                                <span class="badge badge-dark" style="font-size:14px;">
                                    <i class="fas fa-undo"></i> Refunded
                                </span>
                                @break
                                @case('returned')
                                <span class="badge badge-warning" style="font-size:14px;">
                                    <i class="fas fa-undo"></i> Returned
                                </span>
                                @break
                                @case('return_requested')
                                <span class="badge badge-warning" style="font-size:14px;">
                                    <i class="fas fa-undo"></i> Return Requested
                                </span>
                                @break
                                @default
                                <span class="badge badge-secondary" style="font-size:14px;">
                                    Unknown
                                </span>
                            @endswitch
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
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
