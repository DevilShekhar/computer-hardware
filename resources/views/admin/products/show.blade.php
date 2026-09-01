@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Product
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="row">
                                    @forelse($product->images as $image)
                                    <div class="col-md-6 mb-3">
                                        <img src="{{ asset('storage/'.$image->image) }}" alt="{{ $product->name }}" class="img-fluid rounded" style="width:100%;height:180px;object-fit:cover;">
                                        @if($image->is_primary)
                                        <span class="badge badge-success mt-2">Primary Image</span>
                                        @endif
                                    </div>
                                    @empty
                                    <div class="col-12 text-center">
                                        <img src="{{ asset('assets/img/default.png') }}" class="img-fluid rounded" style="width:200px;height:200px;object-fit:cover;">
                                    </div>
                                    @endforelse
                                </div>
                            </div>
                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th width="35%">Product ID</th>
                                                <td>{{ $product->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Product Brand</th>
                                                <td>{{ $product->productBrand->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Category</th>
                                                <td>{{ $product->category->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sub Category</th>
                                                <td>{{ $product->subCategory->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Product Name</th>
                                                <td><strong>{{ $product->name }}</strong></td>
                                            </tr>
                                            <tr>
                                                <th>Slug</th>
                                                <td>{{ $product->slug }}</td>
                                            </tr>
                                            <tr>
                                                <th>SKU</th>
                                                <td>{{ $product->sku }}</td>
                                            </tr>
                                            <tr>
                                                <th>Price</th>
                                                <td>₹{{ number_format($product->price,2) }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sale Price</th>
                                                <td>{{ $product->sale_price ? '₹'.number_format($product->sale_price,2) : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Stock Quantity</th>
                                                <td>{{ $product->stock_quantity }}</td>
                                            </tr>
                                            <tr>
                                                <th>HSN</th>
                                                <td>{{ $product->hsn ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>GST Rate</th>
                                                <td>{{ $product->gst_rate ? $product->gst_rate.'%' : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Warranty</th>
                                                <td>{{ $product->warranty_information ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($product->status)
                                                    <span class="badge badge-success badge-shadow">Active</span>
                                                    @else
                                                    <span class="badge badge-danger badge-shadow">Inactive</span>
                                                    @endif
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Created By</th>
                                                <td>{{ $product->createdBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $product->updatedBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>{{ $product->created_at ? $product->created_at->format('d-m-Y h:i A') : '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Updated At</th>
                                                <td>{{ $product->updated_at ? $product->updated_at->format('d-m-Y h:i A') : '-' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-6">
                                <h5>Short Description</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {{ $product->short_description ?? '-' }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h5>Description</h5>
                                <div class="card">
                                    <div class="card-body">
                                        {!! $product->description ?? '-' !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-12">
                                <h5>Product Specifications</h5>
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th width="40%">Specification</th>
                                                <th>Value</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($product->specifications as $specification)
                                            <tr>
                                                <td><strong>{{ $specification->specification_name }}</strong></td>
                                                <td>{{ $specification->specification_value }}</td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center">No specifications found.</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('products.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('products.edit',$product->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Product
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
