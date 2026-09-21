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
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#bulkUploadModal">
                            <i class="zmdi zmdi-upload"></i> Bulk Upload
                        </button>
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
<div class="modal fade" id="bulkUploadModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Bulk Upload Shipping Charges</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>

            <form action="{{ route('shipping-charges.bulk-upload') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="modal-body">

                    <div class="form-group">
                        <label>Excel File</label>
                        <input type="file"
                               name="file"
                               class="form-control"
                               accept=".xlsx,.xls,.csv"
                               required>
                    </div>

                    <div class="alert alert-info">
                        <strong>Excel columns:</strong>
                        <br>
                        name, state, city, pincode, charges
                    </div>

                    <small class="text-muted">
                        Example:
                        <br>
                        Maharashtra Shipping | Maharashtra | Pune | 411001 | 100
                    </small>

                </div>

                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-secondary"
                            data-dismiss="modal">
                        Cancel
                    </button>

                    <button type="submit"
                            class="btn btn-primary">
                        <i class="zmdi zmdi-upload"></i>
                        Upload
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>
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
