@can('shipping-charge-index')
@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Shipping Charges</h4>
                        <div class="card-header-action">
                            <a href="{{ route('shipping-charges.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Shipping Charge
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Name</th>
                                        <th>State</th>
                                        <th>City</th>
                                        <th>Pincode</th>
                                        <th>Charges</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($shippingCharges as $index => $shippingCharge)
                                        <tr>
                                            <td class="text-center">
                                                {{ $index + 1 }}
                                            </td>

                                            <td>
                                                {{ $shippingCharge->name }}
                                            </td>

                                            <td>
                                                {{ $shippingCharge->state ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $shippingCharge->city ?? '-' }}
                                            </td>

                                            <td>
                                                {{ $shippingCharge->pincode ?? '-' }}
                                            </td>

                                            <td>
                                                ₹{{ number_format($shippingCharge->charges, 2) }}
                                            </td>

                                            <td>
                                                {{ $shippingCharge->created_at?->format('d-m-Y H:i') }}
                                            </td>

                                            <td>
                                                <a href="{{ route('shipping-charges.edit', $shippingCharge->id) }}"
                                                    class="btn btn-sm btn-primary"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('shipping-charges.destroy', $shippingCharge->id) }}"
                                                    method="POST"
                                                    class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-sm btn-danger"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                No shipping charges found.
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
            lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, 'All']],
            columnDefs: [
                {
                    orderable: false,
                    targets: [0, 7]
                }
            ]
        });

        $('.delete-form').on('submit', function (e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Are you sure?',
                text: 'You want to delete this shipping charge.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
</script>
@endpush
@endcan
