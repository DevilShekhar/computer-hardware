@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4>Addresses</h4>

                        <div class="card-header-action">
                            <a href="{{ route('addresses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Address
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">

                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Mobile</th>
                                        <th>Address</th>
                                        <th>City</th>
                                        <th>State</th>
                                        <th>Country</th>
                                        <th>Pin Code</th>
                                        <th>Default</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($addresses as $address)

                                    <tr>

                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            @if($address->address_type == 'home')
                                                <div class="badge badge-info badge-shadow">
                                                    <i class="fas fa-home"></i> Home
                                                </div>
                                            @elseif($address->address_type == 'office')
                                                <div class="badge badge-primary badge-shadow">
                                                    <i class="fas fa-building"></i> Office
                                                </div>
                                            @else
                                                <div class="badge badge-secondary badge-shadow">
                                                    <i class="fas fa-map-marker-alt"></i> Other
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $address->name }}
                                        </td>

                                        <td>
                                            {{ $address->mobile }}
                                        </td>

                                        <td>
                                            {{ \Illuminate\Support\Str::limit($address->address, 50) }}
                                        </td>

                                        <td>
                                            {{ $address->city }}
                                        </td>

                                        <td>
                                            {{ $address->state }}
                                        </td>

                                        <td>
                                            {{ $address->country }}
                                        </td>

                                        <td>
                                            {{ $address->pincode }}
                                        </td>

                                        <td>
                                            @if($address->is_default)
                                                <div class="badge badge-success badge-shadow">
                                                    Default
                                                </div>
                                            @else
                                                <div class="badge badge-light">
                                                    No
                                                </div>
                                            @endif
                                        </td>

                                        <td>
                                            {{ $address->created_at ? $address->created_at->format('d-m-Y') : '-' }}
                                        </td>

                                        <td>
                                            <div class="d-flex align-items-center">

                                                <a href="{{ route('addresses.show', $address->id) }}"
                                                    class="btn btn-info btn-sm mr-1"
                                                    title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>

                                                <a href="{{ route('addresses.edit', $address->id) }}"
                                                    class="btn btn-primary btn-sm mr-1"
                                                    title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>

                                                <form action="{{ route('addresses.destroy', $address->id) }}"
                                                    method="POST"
                                                    class="delete-address-form">
                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>

                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="12" class="text-center">
                                            No address found.
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
        columnDefs: [
            {
                orderable: false,
                targets: [0, 11]
            }
        ]
    });

    $('.delete-address-form').on('submit', function(e) {
        e.preventDefault();

        const form = this;

        Swal.fire({
            title: 'Are you sure?',
            text: 'This address will be deleted.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#fc544b',
            cancelButtonColor: '#6777ef',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
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
