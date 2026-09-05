@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>PC Builder Product Listing</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-products.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item active">
                Product Listing
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Product Listing</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-products.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i>
                                Add Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="GET" action="{{ route('builder-products.index') }}"  class="mb-4" >
                            <div class="row">
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <label for="search">
                                        Search Product
                                    </label>
                                    <input type="text" id="search" name="search"  class="form-control" placeholder="Product name or SKU"  value="{{ request('search') }}">
                                </div>
                                <div class="col-lg-3 col-md-6 col-12 mb-3">
                                    <label for="builder_type_id">
                                        PC Builder Type
                                    </label>
                                    <select id="builder_type_id" name="builder_type_id" class="form-control">
                                        <option value="">
                                            All Builder Types
                                        </option>
                                        @foreach($builderTypes as $builderType)
                                            <option value="{{ $builderType->id }}" {{ request('builder_type_id') == $builderType->id ? 'selected' : '' }}>
                                                {{ $builderType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12 mb-3">
                                    <label for="product_type">
                                        Product Type
                                    </label>
                                    <select  id="product_type"  name="product_type" class="form-control">
                                        <option value="">
                                            All Product Types
                                        </option>
                                        @foreach($productTypes as $productType)
                                            <option value="{{ $productType }}" {{ request('product_type') == $productType ? 'selected' : '' }}>
                                                {{ $productType }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12 mb-3">
                                    <label for="status">
                                        Status
                                    </label>
                                    <select id="status" name="status" class="form-control">
                                        <option value=""> All </option>
                                        <option value="1" {{ request('status') === '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ request('status') === '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                </div>
                                <div class="col-lg-2 col-md-6 col-12 mb-3">
                                    <label>&nbsp;</label>
                                    <div class="d-flex">
                                        <button type="submit" class="btn btn-primary mr-2">
                                            <i class="fas fa-search"></i>
                                            Filter
                                        </button>
                                        <a href="{{ route('builder-products.index') }}" class="btn btn-light">
                                            <i class="fas fa-sync-alt"></i>
                                            Reset
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" id="table-1">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            #
                                        </th>
                                        <th>
                                            Product Image
                                        </th>
                                        <th>
                                            Product Name
                                        </th>
                                        <th>
                                            SKU
                                        </th>
                                        <th>
                                            PC Builder Type
                                        </th>
                                        <th>
                                            Product Type
                                        </th>
                                        <th>
                                            Price
                                        </th>
                                        <th>
                                            Status
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
                                    @forelse($builderProducts as $builderProduct)
                                        <tr>
                                            <td class="text-center">
                                                {{ $builderProducts->firstItem() + $loop->index }}
                                            </td>
                                            <td>
                                                @php
                                                    $productImage = optional(
                                                        optional($builderProduct->product)
                                                            ->images
                                                            ->first()
                                                    )->image;
                                                @endphp
                                                @if($productImage)
                                                    <img src="{{ asset('storage/' . $productImage) }}" alt="{{ $builderProduct->product->name ?? 'Product' }}" width="50" height="50" class="rounded" style="object-fit: cover;">
                                                @else
                                                    <img src="{{ asset('assets/img/default.png') }}" alt="Product" width="50" height="50" class="rounded"  style="object-fit: cover;">
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
                                                        Builder Type Not Found
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($builderProduct->product_type)
                                                    <span class="badge badge-info">
                                                        {{ $builderProduct->product_type }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">
                                                       -
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($builderProduct->product)
                                                    @if($builderProduct->product->sale_price)
                                                        <strong class="text-success">
                                                            ₹{{ number_format(
                                                                $builderProduct->product->sale_price,
                                                                2
                                                            ) }}
                                                        </strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <del>
                                                                ₹{{ number_format(
                                                                    $builderProduct->product->price,
                                                                    2
                                                                ) }}
                                                            </del>
                                                        </small>
                                                    @else
                                                        <strong>
                                                            ₹{{ number_format(
                                                                $builderProduct->product->price,
                                                                2
                                                            ) }}
                                                        </strong>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>
                                                @if($builderProduct->status)
                                                    <span class="badge badge-success badge-shadow">
                                                        Active
                                                    </span>
                                                @else
                                                    <span class="badge badge-danger badge-shadow">
                                                        Inactive
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                {{ $builderProduct->created_at
                                                    ? $builderProduct->created_at->format('d-m-Y')
                                                    : '-'
                                                }}
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <a href="{{ route('builder-products.show',$builderProduct->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('builder-products.edit',$builderProduct->id) }}" class="btn btn-primary btn-sm mr-1" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    @if($builderProduct->status)
                                                        <form action="{{ route('builder-products.destroy',$builderProduct->id) }}" method="POST" class="delete-builder-product-form">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Deactivate">
                                                                <i class="fas fa-ban"></i>
                                                            </button>
                                                        </form>
                                                    @else
                                                        <form action="{{ route('builder-products.update',$builderProduct->id) }}" method="POST" class="activate-builder-product-form">
                                                            @csrf
                                                            @method('PUT')
                                                            <input type="hidden" name="builder_type_id" value="{{ $builderProduct->builder_type_id }}">
                                                            <input type="hidden" name="product_type" value="{{ $builderProduct->product_type }}">
                                                            <input type="hidden" name="product_id" value="{{ $builderProduct->product_id }}">
                                                            <input type="hidden" name="sort_order" value="{{ $builderProduct->sort_order }}">
                                                            <input type="hidden" name="status" value="1">
                                                            <button type="submit" class="btn btn-success btn-sm" title="Activate">
                                                                <i class="fas fa-check"></i>
                                                            </button>
                                                        </form>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="10" class="text-center py-4">
                                                <div class="empty-state">
                                                    <div class="empty-state-icon">
                                                        <i class="fas fa-box-open"></i>
                                                    </div>
                                                    <h2>
                                                        No PC Builder Products Found
                                                    </h2>
                                                    <p class="lead">
                                                        No products have been added
                                                        to a PC Builder Type yet.
                                                    </p>
                                                    <a href="{{ route('builder-products.create') }}" class="btn btn-primary">
                                                        <i class="fas fa-plus"></i>
                                                        Add Product
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        @if($builderProducts->hasPages())
                            <div class="mt-4">
                                {{ $builderProducts->links() }}
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
    $(document).ready(function () {
        $('#table-1').DataTable({
            ordering: true,
            searching: true,
            paging: false,
            info: true,
            lengthChange: false,
            columnDefs: [
                {
                    orderable: false,
                    targets: [0, 1, 9]
                }
            ]
        });
        $('.delete-builder-product-form').on('submit', function (e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Are you sure?',
                text: 'This product will be removed from the PC Builder.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, deactivate',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
        $('.activate-builder-product-form').on('submit', function (e) {
            e.preventDefault();
            let form = this;
            Swal.fire({
                title: 'Activate Product?',
                text: 'This product will be available in the PC Builder.',
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#47c363',
                cancelButtonColor: '#6777ef',
                confirmButtonText: 'Yes, activate',
                cancelButtonText: 'Cancel'
            }).then(function (result) {
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