@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Type Listing</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-types.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Type
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Image</th>
                                        <th>Type Name</th>
                                        <th>Slug</th>
                                        <th>Meta Title</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @forelse($builderTypes as $type)
                                        <tr>
                                            <td class="text-center">
                                                {{ $loop->iteration + ($builderTypes->currentPage() - 1) * $builderTypes->perPage() }}
                                            </td>

                                            <td>
                                                @if($type->image)
                                                    <img src="{{ asset('storage/' . $type->image) }}"
                                                        alt="{{ $type->name }}"
                                                        width="45"
                                                        height="45"
                                                        class="rounded"
                                                        style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/img/default.png') }}"
                                                        alt="image"
                                                        width="45"
                                                        height="45"
                                                        class="rounded"
                                                        style="object-fit: cover;">
                                                @endif
                                            </td>

                                            <td>
                                                <strong>{{ $type->name }}</strong>
                                            </td>

                                            <td>
                                                {{ $type->slug }}
                                            </td>

                                            <td>
                                                {{ $type->meta_title ?? '-' }}
                                            </td>

                                            <td>
                                                @if($type->status)
                                                    <div class="badge badge-success badge-shadow">
                                                        Active
                                                    </div>
                                                @else
                                                    <div class="badge badge-danger badge-shadow">
                                                        Inactive
                                                    </div>
                                                @endif
                                            </td>

                                            <td>
                                                {{ $type->created_at ? $type->created_at->format('d-m-Y') : '-' }}
                                            </td>

                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('builder-types.show', $type->id) }}"
                                                        class="btn btn-info btn-sm mr-1"
                                                        title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>

                                                    <a href="{{ route('builder-types.edit', $type->id) }}"
                                                        class="btn btn-primary btn-sm mr-1"
                                                        title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>

                                                    @if($type->status)
                                                        <form action="{{ route('builder-types.destroy', $type->id) }}"
                                                            method="POST"
                                                            class="delete-type-form">
                                                            @csrf
                                                            @method('DELETE')

                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm"
                                                                title="Deactivate">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('builder-types.update', $type->id) }}"
                                                            method="POST"
                                                            class="activate-type-form">
                                                            @csrf
                                                            @method('PUT')

                                                            <input type="hidden" name="name" value="{{ $type->name }}">
                                                            <input type="hidden" name="status" value="1">

                                                            <button type="submit"
                                                                class="btn btn-success btn-sm"
                                                                title="Activate">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="text-center">
                                                No builder types found.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if($builderTypes->hasPages())
                            <div class="mt-3">
                                {{ $builderTypes->links() }}
                            </div>
                        @endif
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
                    targets: [0, 1, 7]
                }
            ]
        });

        $('.delete-type-form').on('submit', function(e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Are you sure?',
                text: 'This builder type will be deactivated.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, deactivate',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });

        $('.activate-type-form').on('submit', function(e) {
            e.preventDefault();

            let form = this;

            Swal.fire({
                title: 'Activate Builder Type?',
                text: 'This builder type will be activated.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#47c363',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, activate',
                cancelButtonText: 'Cancel'
            }).then(function(result) {
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

@endpush