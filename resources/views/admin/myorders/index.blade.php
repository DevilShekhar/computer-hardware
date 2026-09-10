@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-2 mb-md-0">
                            My Orders
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>
                                            Order Number
                                        </th>
                                        <th>
                                           Total Amount
                                        </th>
                                        <th>
                                            Payment Method
                                        </th>
                                        <th>
                                            Payment Status
                                        </th>
                                        <th>
                                            Order Status
                                        </th>
                                        <th>
                                            Created At
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
                                            <strong>
                                                ₹{{ number_format($order->total_amount, 2) }}
                                            </strong>
                                        </td>
                                        <td>
                                            {{ strtoupper($order->payment_method ?? '-') }}
                                        </td>
                                        <td>
                                            @if($order->payment_status == 1)
                                            <div class="badge badge-success badge-shadow">
                                                Paid
                                            </div>
                                            @else
                                            <div class="badge badge-warning badge-shadow">
                                                Pending
                                            </div>
                                            @endif
                                        </td>
                                        <td>
                                            @switch((int) $order->status)
                                            @case(0)
                                            <div class="badge badge-warning badge-shadow">
                                                Pending
                                            </div>
                                            @break
                                            @case(1)
                                            <div class="badge badge-info badge-shadow">
                                                Confirmed
                                            </div>
                                            @break
                                            @case(2)
                                            <div class="badge badge-primary badge-shadow">
                                                Processing
                                            </div>
                                            @break
                                            @case(3)
                                            <div class="badge badge-info badge-shadow">
                                                Shipped
                                            </div>
                                            @break
                                            @case(4)
                                            <div class="badge badge-success badge-shadow">
                                                Delivered
                                            </div>
                                            @break
                                            @case(5)
                                            <div class="badge badge-danger badge-shadow">
                                                Cancelled
                                            </div>
                                            @break
                                            @case(6)
                                            <div class="badge badge-danger badge-shadow">
                                                Failed
                                            </div>
                                            @break
                                            @case(7)
                                            <div class="badge badge-dark badge-shadow">
                                                Refunded
                                            </div>
                                            @break
                                            @case(8)
                                            <div class="badge badge-warning badge-shadow">
                                                Returned
                                            </div>
                                            @break
                                            @default
                                            <div class="badge badge-secondary badge-shadow">
                                                Unknown
                                            </div>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $order->created_at ? $order->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('my-orders.show', $order->id) }}" class="btn btn-info btn-sm" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="8" class="text-center">
                                            No orders found.
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
            targets: [0, 7]
        }]
    });
});
</script>
@endpush