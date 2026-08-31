@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Product Brand Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('product-brands.edit', $productBrand->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Product Brand
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($productBrand->product_brand_image)
                                <img src="{{ asset('storage/' . $productBrand->product_brand_image) }}"
                                    alt="{{ $productBrand->name }}"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/img/default.png') }}"
                                    alt="image"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @endif

                                <h5 class="mt-3 mb-1">
                                    {{ $productBrand->name }}
                                </h5>

                                @if($productBrand->status)
                                <div class="badge badge-success badge-shadow">
                                    Active
                                </div>
                                @else
                                <div class="badge badge-danger badge-shadow">
                                    Inactive
                                </div>
                                @endif
                            </div>

                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th width="35%">ID</th>
                                                <td>{{ $productBrand->id }}</td>
                                            </tr>

                                            <tr>
                                                <th>Product Brand Name</th>
                                                <td>{{ $productBrand->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Slug</th>
                                                <td>{{ $productBrand->slug }}</td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($productBrand->status)
                                                    <span class="badge badge-success badge-shadow">
                                                        Active
                                                    </span>
                                                    @else
                                                    <span class="badge badge-danger badge-shadow">
                                                        Inactive
                                                    </span>
                                                    @endif
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Meta Title</th>
                                                <td>{{ $productBrand->meta_title ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Meta Keywords</th>
                                                <td>{{ $productBrand->meta_keywords ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Meta Description</th>
                                                <td>{{ $productBrand->meta_description ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Created By</th>
                                                <td>{{ $productBrand->createdBy->name ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $productBrand->updatedBy->name ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Created At</th>
                                                <td>
                                                    {{ $productBrand->created_at ? $productBrand->created_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Updated At</th>
                                                <td>
                                                    {{ $productBrand->updated_at ? $productBrand->updated_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('product-brands.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>

                        <a href="{{ route('product-brands.edit', $productBrand->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Product Brand
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection