{{-- @can('coupons-index') --}}
@extends('admin.layouts.app')

@section('title', 'Coupon Management')

@section('content')
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Coupon Management</h4>
                            <div class="card-header-action">
                                <a href="{{ route('coupons.create') }}" class="btn btn-primary">
                                    <i class="fas fa-plus"></i> Add Coupon
                                </a>
                            </div>
                        </div>
                        <div class="card-body">
                            @if(session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Coupon Code</th>
                                            <th>Discount</th>
                                            <th>Minimum Order</th>
                                            <th>Usage</th>
                                            <th>Validity</th>
                                            <th>Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($coupons as $coupon)
                                            <tr>
                                                <td class="text-center">
                                                    {{ $loop->iteration }}
                                                </td>
                                                <td>
                                                    <strong>{{ $coupon->code }}</strong>
                                                </td>
                                                <td>
                                                    @if($coupon->discount_type == 'percentage')
                                                        {{ $coupon->discount_value }}%
                                                    @else
                                                        ₹{{ number_format($coupon->discount_value, 2) }}
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($coupon->minimum_order_value)
                                                        ₹{{ number_format($coupon->minimum_order_value, 2) }}
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $coupon->used_count }}
                                                    /
                                                    {{ $coupon->usage_limit ?? 'Unlimited' }}
                                                </td>
                                                <td>
                                                    {{ $coupon->start_date ? $coupon->start_date->format('d M Y') : '-' }}
                                                    -
                                                    {{ $coupon->end_date ? $coupon->end_date->format('d M Y') : '-' }}
                                                </td>
                                                <td>
                                                    @if($coupon->status == 0)
                                                        <div class="badge badge-secondary badge-shadow">
                                                            Inactive
                                                        </div>
                                                    @elseif(now()->lt($coupon->start_date))
                                                        <div class="badge badge-warning badge-shadow">
                                                            Upcoming
                                                        </div>
                                                    @elseif(now()->gt($coupon->end_date))
                                                        <div class="badge badge-danger badge-shadow">
                                                            Expired
                                                        </div>
                                                    @else
                                                        <div class="badge badge-success badge-shadow">
                                                            Available
                                                        </div>
                                                    @endif
                                                </td>
                                                <td>
                                                    <div class="d-flex align-items-center justify-content-center">
                                                        {{-- Edit --}}
                                                        <a href="{{ route('coupons.edit', $coupon->id) }}"
                                                            class="btn btn-primary btn-sm mr-1" title="Edit">
                                                            <i class="fas fa-edit"></i>
                                                        </a>

                                                        {{-- Delete --}}
                                                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST"
                                                            class="d-inline delete-coupon-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="8" class="text-center">
                                                    No coupons found.
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
        $(document).ready(function () {
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
                        targets: [0, 7]
                    }
                ]
            });

            $('.delete-coupon-form').on('submit', function (e) {
                e.preventDefault();
                let form = this;

                Swal.fire({
                    title: 'Are you sure?',
                    text: 'This coupon will be deleted.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fc544b',
                    cancelButtonColor: '#6777ef',
                    confirmButtonText: 'Yes, delete',
                    cancelButtonText: 'Cancel'
                }).then(function (result) {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        @if(session('success'))
            Swal.fire({
                title: 'Success!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#6777ef',
                confirmButtonText: 'OK'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: @json(session('error')),
                icon: 'error',
                confirmButtonColor: '#6777ef',
                confirmButtonText: 'OK'
            });
        @endif
    </script>
@endpush

{{-- @else
@php
abort(403);
@endphp
@endcan --}}
