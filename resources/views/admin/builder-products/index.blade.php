@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Product Listing</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Product Image</th>
                                        <th>Product Name</th>
                                        <th>SKU</th>
                                        <th>Builder Type</th>
                                        <th>Builder Brand</th>
                                        <th>Builder Category</th>
                                        <th>Builder Sub Category</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created At</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($builderProducts as $builderProduct)
                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration }}
                                        </td>
                                        <td>
                                            @php
                                                $productImage = optional(
                                                    $builderProduct->product->images->first()
                                                )->image;
                                            @endphp
                                            @if($productImage)
                                                <img src="{{ asset('storage/' . $productImage) }}"
                                                    alt="{{ $builderProduct->product->name ?? 'Product' }}"
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
                                            @if($builderProduct->product)
                                                <strong>
                                                    {{ $builderProduct->product->name }}
                                                </strong>
                                            @else
                                                <span class="text-danger">
                                                    Product Not Found
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->product)
                                                {{ $builderProduct->product->sku ?? '-' }}
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->builderType)
                                                <strong>
                                                    {{ $builderProduct->builderType->name }}
                                                </strong>
                                            @else
                                                <span class="text-danger">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->builderBrand)
                                                {{ $builderProduct->builderBrand->name }}
                                            @else
                                                <span class="text-danger">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->builderCategory)
                                                {{ $builderProduct->builderCategory->name }}
                                            @else
                                                <span class="text-danger">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->builderSubCategory)
                                                {{ $builderProduct->builderSubCategory->name }}
                                            @else
                                                <span class="text-danger">
                                                    -
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->product)
                                                @if($builderProduct->product->sale_price)
                                                    <strong>
                                                        ₹{{ number_format($builderProduct->product->sale_price, 2) }}
                                                    </strong>
                                                    <br>
                                                    <small class="text-muted">
                                                        <del>
                                                            ₹{{ number_format($builderProduct->product->price, 2) }}
                                                        </del>
                                                    </small>
                                                @else
                                                    <strong>
                                                        ₹{{ number_format($builderProduct->product->price, 2) }}
                                                    </strong>
                                                @endif
                                            @else
                                                -
                                            @endif
                                        </td>
                                        <td>
                                            @if($builderProduct->status)
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
                                            {{ $builderProduct->created_at ? $builderProduct->created_at->format('d-m-Y') : '-' }}
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <a href="{{ route('builder-products.show', $builderProduct->id) }}"
                                                    class="btn btn-info btn-sm mr-1" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <a href="{{ route('builder-products.edit', $builderProduct->id) }}"
                                                    class="btn btn-primary btn-sm mr-1" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                @if($builderProduct->status)
                                                    <form action="{{ route('builder-products.destroy', $builderProduct->id) }}"
                                                        method="POST"
                                                        class="delete-builder-product-form">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-danger btn-sm"
                                                            title="Deactivate">
                                                            <i class="fas fa-ban"></i>
                                                        </button>
                                                    </form>
                                                @else
                                                    <form action="{{ route('builder-products.update', $builderProduct->id) }}"
                                                        method="POST"
                                                        class="activate-builder-product-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="builder_type_id" value="{{ $builderProduct->builder_type_id }}">
                                                        <input type="hidden" name="product_id" value="{{ $builderProduct->product_id }}">
                                                        <input type="hidden" name="builder_brand_id" value="{{ $builderProduct->builder_brand_id }}">
                                                        <input type="hidden" name="builder_category_id" value="{{ $builderProduct->builder_category_id }}">
                                                        <input type="hidden" name="builder_sub_category_id" value="{{ $builderProduct->builder_sub_category_id }}">
                                                        <input type="hidden" name="sort_order" value="{{ $builderProduct->sort_order }}">
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
                                        <td colspan="12" class="text-center">
                                            No PC builder products found.
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
                targets: [0, 1, 11]
            }]
        });

        $('.delete-builder-product-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Are you sure?',
                text: 'This builder product will be deactivated.',
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

        $('.activate-builder-product-form').on('submit', function(e) {
            e.preventDefault();
            let form = this;

            Swal.fire({
                title: 'Activate Product?',
                text: 'This builder product will be activated.',
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
