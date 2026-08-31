@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Sub Category Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('sub-categories.edit', $subCategory->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Sub Category
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($subCategory->sub_cat_image)
                                <img src="{{ asset('storage/' . $subCategory->sub_cat_image) }}"
                                    alt="{{ $subCategory->name }}"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/img/default.png') }}"
                                    alt="image"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @endif
                                <h5 class="mt-3 mb-1">
                                    {{ $subCategory->name }}
                                </h5>
                                <p class="text-muted mb-1">
                                    {{ $subCategory->productBrand->name ?? '-' }}
                                </p>
                                <p class="text-muted mb-2">
                                    {{ $subCategory->category->name ?? '-' }}
                                </p>
                                @if($subCategory->status)
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
                                                <td>{{ $subCategory->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Product Brand</th>
                                                <td>{{ $subCategory->productBrand->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Category</th>
                                                <td>{{ $subCategory->category->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Sub Category Name</th>
                                                <td>{{ $subCategory->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Slug</th>
                                                <td>{{ $subCategory->slug }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meta Title</th>
                                                <td>{{ $subCategory->meta_title ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meta Keywords</th>
                                                <td>{{ $subCategory->meta_keywords ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meta Description</th>
                                                <td>{{ $subCategory->meta_description ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($subCategory->status)
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
                                                <th>Created By</th>
                                                <td>{{ $subCategory->createdBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $subCategory->updatedBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>
                                                    {{ $subCategory->created_at ? $subCategory->created_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Updated At</th>
                                                <td>
                                                    {{ $subCategory->updated_at ? $subCategory->updated_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('sub-categories.edit', $subCategory->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Sub Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection