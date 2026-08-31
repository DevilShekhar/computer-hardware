@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">


                <div class="card-header">
                    <h4>PC Builder Sub Category Listing</h4>

                    <div class="card-header-action">
                        <a href="{{ route('builder-sub-categories.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Sub Category
                        </a>
                    </div>
                </div>

                <div class="card-body">

                    <div class="table-responsive">
                        <table class="table table-striped" id="table-1">

                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Sub Category Image</th>
                                    <th>Brand</th>
                                    <th>Category</th>
                                    <th>Sub Category Name</th>
                                    <th>Slug</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($builderSubCategories as $subCategory)

                                <tr>

                                    {{-- Serial Number --}}
                                    <td class="text-center">
                                        {{ $loop->iteration }}
                                    </td>

                                    {{-- Image --}}
                                    <td>
                                        @if($subCategory->cat_image)

                                            <img src="{{ asset('storage/' . $subCategory->cat_image) }}"
                                                alt="{{ $subCategory->name }}"
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

                                    {{-- Brand --}}
                                    <td>
                                        <strong>
                                            {{ $subCategory->brand->name ?? '-' }}
                                        </strong>
                                    </td>

                                    {{-- Category --}}
                                    <td>
                                        <strong>
                                            {{ $subCategory->category->name ?? '-' }}
                                        </strong>
                                    </td>

                                    {{-- Sub Category Name --}}
                                    <td>
                                        <strong>
                                            {{ $subCategory->name }}
                                        </strong>
                                    </td>

                                    {{-- Slug --}}
                                    <td>
                                        {{ $subCategory->slug }}
                                    </td>

                                    {{-- Status --}}
                                    <td>

                                        @if($subCategory->status)

                                            <div class="badge badge-success badge-shadow">
                                                Active
                                            </div>

                                        @else

                                            <div class="badge badge-danger badge-shadow">
                                                Inactive
                                            </div>

                                        @endif

                                    </td>

                                    {{-- Created At --}}
                                    <td>
                                        {{ $subCategory->created_at
                                            ? $subCategory->created_at->format('d-m-Y')
                                            : '-' }}
                                    </td>

                                    {{-- Actions --}}
                                    <td>

                                        <div class="d-flex align-items-center">

                                            {{-- View --}}
                                            <a href="{{ route('builder-sub-categories.show', $subCategory->id) }}"
                                                class="btn btn-info btn-sm mr-1"
                                                title="View">

                                                <i class="fas fa-eye"></i>

                                            </a>

                                            {{-- Edit --}}
                                            <a href="{{ route('builder-sub-categories.edit', $subCategory->id) }}"
                                                class="btn btn-primary btn-sm mr-1"
                                                title="Edit">

                                                <i class="fas fa-edit"></i>

                                            </a>

                                            {{-- Deactivate / Activate --}}
                                            @if($subCategory->status)

                                                <form action="{{ route('builder-sub-categories.destroy', $subCategory->id) }}"
                                                    method="POST"
                                                    class="delete-sub-category-form">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                        class="btn btn-danger btn-sm"
                                                        title="Deactivate">

                                                        <i class="fas fa-ban"></i>

                                                    </button>

                                                </form>

                                            @else

                                                <a href="{{ route('builder-sub-categories.edit', $subCategory->id) }}"
                                                    class="btn btn-success btn-sm"
                                                    title="Activate">

                                                    <i class="fas fa-check"></i>

                                                </a>

                                            @endif

                                        </div>

                                    </td>

                                </tr>

                                @empty

                                <tr>

                                    <td colspan="9" class="text-center">
                                        No builder sub categories found.
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
                    targets: [0, 1, 8]
                }
            ]

        });


        /*
        |--------------------------------------------------------------------------
        | Deactivate Sub Category Confirmation
        |--------------------------------------------------------------------------
        */

        $('.delete-sub-category-form').on('submit', function(e) {

            e.preventDefault();

            let form = this;

            Swal.fire({

                title: 'Are you sure?',

                text: 'This sub category will be deactivated.',

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
