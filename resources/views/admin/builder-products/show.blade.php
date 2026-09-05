@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>PC Builder Product Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-products.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item active">
                Product Details
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Product Details</h4>
                        <div class="card-header-action">
                            <a
                                href="{{ route(
                                    'builder-products.edit',
                                    $builderProduct->id
                                ) }}"
                                class="btn btn-primary"
                            >
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                            <a
                                href="{{ route('builder-products.index') }}"
                                class="btn btn-secondary"
                            >
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4 col-md-5 col-12 mb-4">
                                <div class="product-image text-center">
                                    @php
                                        $productImage = optional(
                                            optional($builderProduct->product)
                                                ->images
                                                ->first()
                                        )->image;
                                    @endphp
                                    @if($productImage)
                                        <img
                                            src="{{ asset('storage/' . $productImage) }}"
                                            alt="{{ $builderProduct->product->name ?? 'Product' }}"
                                            class="img-fluid rounded"
                                            style="max-height: 300px; object-fit: contain;"
                                        >
                                    @else
                                        <img
                                            src="{{ asset('assets/img/default.png') }}"
                                            alt="Product"
                                            class="img-fluid rounded"
                                            style="max-height: 300px; object-fit: contain;"
                                        >
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-8 col-md-7 col-12">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <tbody>
                                            <tr>
                                                <th width="30%">
                                                    PC Builder Type
                                                </th>
                                                <td>
                                                    @if($builderProduct->builderType)
                                                        <span class="badge badge-primary">
                                                            {{ $builderProduct->builderType->name }}
                                                        </span>
                                                    @else
                                                        <span class="text-danger">
                                                            Builder Type Not Found
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Product Type
                                                </th>
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
                                            </tr>
                                            <tr>
                                                <th>
                                                    Product Name
                                                </th>
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
                                            </tr>
                                            <tr>
                                                <th>
                                                    SKU
                                                </th>
                                                <td>
                                                    {{ $builderProduct->product->sku ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Price
                                                </th>
                                                <td>
                                                    @if($builderProduct->product)
                                                        @if($builderProduct->product->sale_price)
                                                            <strong class="text-success">
                                                                ₹{{ number_format(
                                                                    $builderProduct->product->sale_price,
                                                                    2
                                                                ) }}
                                                            </strong>
                                                            <span class="ml-2 text-muted">
                                                                <del>
                                                                    ₹{{ number_format(
                                                                        $builderProduct->product->price,
                                                                        2
                                                                    ) }}
                                                                </del>
                                                            </span>
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
                                            </tr>
                                            <tr>
                                                <th>
                                                    Sort Order
                                                </th>
                                                <td>
                                                    {{ $builderProduct->sort_order ?? 0 }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Status
                                                </th>
                                                <td>
                                                    @if($builderProduct->status)
                                                        <span class="badge badge-success">
                                                            Active
                                                        </span>
                                                    @else
                                                        <span class="badge badge-danger">
                                                            Inactive
                                                        </span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Created By
                                                </th>
                                                <td>
                                                    {{ $builderProduct->createdBy->name ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Created At
                                                </th>
                                                <td>
                                                    {{ $builderProduct->created_at
                                                        ? $builderProduct->created_at->format('d-m-Y h:i A')
                                                        : '-'
                                                    }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Updated By
                                                </th>
                                                <td>
                                                    {{ $builderProduct->updatedBy->name ?? '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Updated At
                                                </th>
                                                <td>
                                                    {{ $builderProduct->updated_at
                                                        ? $builderProduct->updated_at->format('d-m-Y h:i A')
                                                        : '-'
                                                    }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a
                            href="{{ route('builder-products.index') }}"
                            class="btn btn-secondary"
                        >
                            <i class="fas fa-arrow-left"></i>
                            Back to List
                        </a>
                        <a
                            href="{{ route(
                                'builder-products.edit',
                                $builderProduct->id
                            ) }}"
                            class="btn btn-primary"
                        >
                            <i class="fas fa-edit"></i>
                            Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection