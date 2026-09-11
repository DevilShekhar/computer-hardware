
@extends('admin.layouts.app')

@section('content')

<section class="section">

    <div class="section-body">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">

                        <h4 class="mb-2 mb-md-0">
                            Refunded Orders
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
                                            Order Number
                                        </th>

                                        <th>
                                            Products
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

                                    <tr>

                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>

                                            <strong>
                                                {{ $order->order_number }}
                                            </strong>

                                        </td>

                                        <td>

                                            @forelse($order->items as $item)

                                            @php
                                                $itemTotal = (float) $item->total;
                                                $orderSubtotal = (float) $order->subtotal;
                                                $refundAmount = (float) ($order->refund_amount ?? $order->total_amount);

                                                $productRefund = $orderSubtotal > 0
                                                    ? ($itemTotal / $orderSubtotal) * $refundAmount
                                                    : 0;
                                            @endphp

                                            <div class="mb-2">

                                                <strong>
                                                    {{ $item->product_name }}
                                                </strong>

                                                <br>

                                                <small class="text-muted">
                                                    Qty: {{ $item->quantity }}
                                                    × ₹{{ number_format($item->price, 2) }}
                                                </small>

                                                <br>

                                                <span class="text-danger">
                                                    Refunded:
                                                    ₹{{ number_format($productRefund, 2) }}
                                                </span>

                                            </div>

                                            @empty

                                            <span class="text-muted">
                                                No products found.
                                            </span>

                                            @endforelse

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

                                            @elseif($order->refund_method === 'manual')

                                            <span class="text-muted">
                                                Manual Refund
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

                                                <a
                                                    href="{{ route('customer-orders.show', $order->id) }}"
                                                    class="btn btn-info btn-sm"
                                                    title="View Order">

                                                    <i class="fas fa-eye"></i>

                                                </a>

                                            </div>

                                        </td>

                                    </tr>

                                    @empty

                                    <tr>

                                        <td colspan="9" class="text-center">

                                            No refunded orders found.

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

