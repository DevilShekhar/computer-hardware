@can('order-index')
@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center flex-wrap">
                        <h4 class="mb-2 mb-md-0">
                            Customer Orders Listing
                        </h4>
                        <div class="d-flex flex-wrap" style="gap: 5px;">
                            <a href="{{ route('customer-orders.index') }}" class="btn btn-sm {{ !request()->has('status') ? 'btn-secondary' : 'btn-outline-secondary' }}">
                                All
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 0]) }}" class="btn btn-sm {{ request('status') == 0 ? 'btn-warning' : 'btn-outline-warning' }}">
                                Pending
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 1]) }}" class="btn btn-sm {{ request('status') == 1 ? 'btn-info' : 'btn-outline-info' }}">
                                Confirmed
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 2]) }}" class="btn btn-sm {{ request('status') == 2 ? 'btn-primary' : 'btn-outline-primary' }}">
                                Processing
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 3]) }}" class="btn btn-sm {{ request('status') == 3 ? 'btn-dark' : 'btn-outline-dark' }}">
                                Shipped
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 4]) }}" class="btn btn-sm {{ request('status') == 4 ? 'btn-success' : 'btn-outline-success' }}">
                                Delivered
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 5]) }}" class="btn btn-sm {{ request('status') == 5 ? 'btn-danger' : 'btn-outline-danger' }}">
                                Cancelled
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 6]) }}" class="btn btn-sm {{ request('status') == 6 ? 'btn-danger' : 'btn-outline-danger' }}">
                                Failed
                            </a>
                            <a href="{{ route('customer-orders.index', ['status' => 7]) }}"  class="btn btn-sm {{ request('status') == 7 ? 'btn-dark' : 'btn-outline-dark' }}">
                                Refunded
                            </a>
                        </div>
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
                                            Customer
                                        </th>
                                        <th>
                                            Mobile
                                        </th>
                                        <th>
                                            Total Amount
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
                                                {{ $order->customer_name }}
                                            </strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $order->email }}
                                            </small>
                                        </td>
                                        <td>
                                            {{ $order->mobile_number ?? '-' }}
                                        </td>
                                        <td>
                                            <strong>
                                                ₹{{ number_format($order->total_amount, 2) }}
                                            </strong>
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
                                            @default
                                            <div class="badge badge-secondary badge-shadow">
                                                Unknown
                                            </div>
                                            @endswitch
                                        </td>
                                        <td>
                                            {{ $order->created_at  ? $order->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('customer-orders.show', $order->id) }}" class="btn btn-info btn-sm" title="View Order">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No customer orders found.
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
        columnDefs: [
            {
                orderable: false,
                targets: [0, 8]
            }
        ]
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