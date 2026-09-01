@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>Builder Product Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-products.index') }}">Builder Products</a>
            </div>
            <div class="breadcrumb-item active">Details</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <i class="fas fa-cube"></i> Builder Product Details
                        </h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-products.edit', $builderProduct->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                            <a href="{{ route('builder-products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            {{-- Left Column - Product Info --}}
                            <div class="col-md-6">
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h4>Product Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th width="40%">Product Name</th>
                                                    <td>
                                                        <strong>{{ $builderProduct->product->name ?? '-' }}</strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>SKU</th>
                                                    <td>{{ $builderProduct->product->sku ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Price</th>
                                                    <td>
                                                        @if($builderProduct->product)
                                                            @if($builderProduct->product->sale_price)
                                                                <strong>₹{{ number_format($builderProduct->product->sale_price, 2) }}</strong>
                                                                <br>
                                                                <small class="text-muted">
                                                                    <del>₹{{ number_format($builderProduct->product->price, 2) }}</del>
                                                                </small>
                                                            @else
                                                                <strong>₹{{ number_format($builderProduct->product->price, 2) }}</strong>
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Stock</th>
                                                    <td>
                                                        @if($builderProduct->product)
                                                            @if($builderProduct->product->stock_quantity > 10)
                                                                <span class="badge badge-success">{{ $builderProduct->product->stock_quantity }}</span>
                                                            @elseif($builderProduct->product->stock_quantity > 0)
                                                                <span class="badge badge-warning">{{ $builderProduct->product->stock_quantity }}</span>
                                                            @else
                                                                <span class="badge badge-danger">Out of Stock</span>
                                                            @endif
                                                        @else
                                                            -
                                                        @endif
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Product Status</th>
                                                    <td>
                                                        @if($builderProduct->product && $builderProduct->product->status)
                                                            <span class="badge badge-success badge-shadow">Active</span>
                                                        @else
                                                            <span class="badge badge-danger badge-shadow">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Right Column - Builder Mapping --}}
                            <div class="col-md-6">
                                <div class="card card-info">
                                    <div class="card-header">
                                        <h4>Builder Mapping</h4>
                                    </div>
                                    <div class="card-body">
                                        <table class="table table-bordered table-striped mb-0">
                                            <tbody>
                                                <tr>
                                                    <th width="40%">Builder Brand</th>
                                                    <td>{{ $builderProduct->builderBrand->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Builder Category</th>
                                                    <td>{{ $builderProduct->builderCategory->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Builder Sub Category</th>
                                                    <td>{{ $builderProduct->builderSubCategory->name ?? '-' }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Sort Order</th>
                                                    <td>
                                                        <span class="badge badge-primary">{{ $builderProduct->sort_order ?? 0 }}</span>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <th>Status</th>
                                                    <td>
                                                        @if($builderProduct->status)
                                                            <span class="badge badge-success badge-shadow">Active</span>
                                                        @else
                                                            <span class="badge badge-danger badge-shadow">Inactive</span>
                                                        @endif
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                            {{-- Timestamps --}}
                            <div class="col-md-12 mt-3">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Additional Information</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="form-group col-md-4">
                                                <label>Created At</label>
                                                <div class="form-control">
                                                    {{ $builderProduct->created_at ? $builderProduct->created_at->format('d-m-Y H:i') : '-' }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Updated At</label>
                                                <div class="form-control">
                                                    {{ $builderProduct->updated_at ? $builderProduct->updated_at->format('d-m-Y H:i') : '-' }}
                                                </div>
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label>Record ID</label>
                                                <div class="form-control">
                                                    #{{ $builderProduct->id }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('builder-products.edit', $builderProduct->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Builder Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
