@extends('admin.layouts.app')

@section('content')

<section class="section">

    <div class="section-body">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

                        <h4 class="mb-2 mb-md-0">
                            Refunded PC Builder Orders
                        </h4>

                    </div>

                    <div class="card-body">

                        <div class="table-responsive">

                            <table class="table table-striped" id="table-1">

                                <thead>

                                    <tr>

                                        <th class="text-center">
                                            #
                                        </th>

                                        <th>
                                            Builder Number
                                        </th>

                                        <th>
                                            Components
                                        </th>

                                        <th>
                                            Refunded Amount
                                        </th>

                                        <th>
                                            Payment Method
                                        </th>

                                        <th>
                                            Refund Method
                                        </th>

                                        <th>
                                            Refund ID
                                        </th>

                                        <th>
                                            Refunded At
                                        </th>

                                        <th>
                                            Action
                                        </th>

                                    </tr>

                                </thead>

                                <tbody>

                                    @forelse($orders as $order)

                                    @php
                                        $products = is_array($order->products)
                                            ? $order->products
                                            : (json_decode($order->products, true) ?: []);

                                        $orderSubtotal = (float) $order->subtotal;
                                        $refundAmount  = (float) ($order->refund_amount ?? $order->total_amount);

                                        $visibleProducts   = array_slice($products, 0, 4);
                                        $remainingProducts = max(0, count($products) - 3);
                                    @endphp

                                    <tr>

                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>

                                            <strong>
                                                {{ $order->builder_number }}
                                            </strong>

                                        </td>

                                        <td>

                                            @forelse($visibleProducts as $item)

                                            @php
                                                $productId    = $item['product_id'] ?? ($item['id'] ?? null);
                                                $productName  = $item['product_name']
                                                    ?? ($item['name']
                                                    ?? ($item['title'] ?? 'Component'));

                                                $quantity     = (float) ($item['quantity'] ?? ($item['qty'] ?? 1));

                                                $unitPrice    = (float) (
                                                    $item['price']
                                                    ?? ($item['sale_price']
                                                    ?? ($item['unit_price']
                                                    ?? ($item['amount'] ?? 0)))
                                                );

                                                $itemTotal    = $unitPrice * $quantity;

                                                $productRefund = $orderSubtotal > 0
                                                    ? ($itemTotal / $orderSubtotal) * $refundAmount
                                                    : 0;
                                            @endphp

                                            <div class="mb-2">

                                                <strong>
                                                    {{ $productName }}
                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    Qty: {{ $quantity }}
                                                    × ₹{{ number_format($unitPrice, 2) }}
                                                </small>

                                                <br>

                                                <span class="text-danger">
                                                    Refunded:
                                                    ₹{{ number_format($productRefund, 2) }}
                                                </span>

                                            </div>

                                            @empty

                                            <span class="text-muted">
                                                No components found.
                                            </span>

                                            @endforelse

                                            @if($remainingProducts > 0)

                                            <div class="text-muted">

                                                <strong>
                                                    +{{ $remainingProducts }} more
                                                </strong>

                                            </div>

                                            @endif

                                        </td>

                                        <td>

                                            <strong class="text-danger">
                                                ₹{{ number_format($order->refund_amount ?? $order->total_amount, 2) }}
                                            </strong>

                                        </td>

                                        <td>

                                            {{ strtoupper($order->payment_method ?? '-') }}

                                        </td>

                                        <td>

                                            @if($order->refund_method === 'razorpay')

                                            <span class="badge badge-info badge-shadow">
                                                Razorpay
                                            </span>

                                            @elseif($order->refund_method === 'upi')

                                            <span class="badge badge-warning badge-shadow">
                                                Manual / UPI
                                            </span>

                                            @elseif($order->refund_method === 'manual')

                                            <span class="badge badge-warning badge-shadow">
                                                Manual / UPI
                                            </span>

                                            @else

                                            <span class="badge badge-secondary badge-shadow">
                                                -
                                            </span>

                                            @endif

                                        </td>

                                        <td>

                                            @if($order->razorpay_refund_id)

                                            <strong>
                                                {{ $order->razorpay_refund_id }}
                                            </strong>

                                            @elseif($order->refund_method === 'upi' || $order->refund_method === 'manual')

                                            <span class="text-muted">
                                                Manual Refund
                                                @if($order->customer_upi_id)
                                                    <br>
                                                    UPI: {{ $order->customer_upi_id }}
                                                @endif
                                            </span>

                                            @else

                                            <span class="text-muted">
                                                -
                                            </span>

                                            @endif

                                        </td>

                                        <td>

                                            {{ $order->refunded_at
                                                ? $order->refunded_at->format('d-m-Y h:i A')
                                                : '-' }}

                                        </td>

                                        <td>

                                            <div class="d-flex align-items-center">

                                                <a href="{{ route('my-pc-builder-orders.show', $order->id) }}" class="btn btn-info btn-sm" title="View Order">
                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="9" class="text-center">

                                            No refunded PC Builder orders found.

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

    $('#table-1').DataTable({

        ordering: true,

        searching: true,

        paging: true,

        info: true,

        pageLength: 10,

        lengthMenu: [

            [10, 25, 50, 100, -1],

            [10, 25, 50, 100, 'All']

        ],

        columnDefs: [{

            orderable: false,

            targets: [0, 2, 8]

        }]

    });

});

</script>

@endpush
