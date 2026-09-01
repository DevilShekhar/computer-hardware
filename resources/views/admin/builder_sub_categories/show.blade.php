@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-header">
        <h1>PC Builder Sub Category Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-types.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('builder-sub-categories.index') }}">
                    Sub Categories
                </a>
            </div>
            <div class="breadcrumb-item active">
                Details
            </div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Sub Category Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-sub-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                            <a href="{{ route('builder-sub-categories.edit', $builderSubCategory->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">

                            <div class="form-group col-md-6">
                                <label>Builder Type</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->builderType->name ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Brand</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->brand->name ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Category</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->category->name ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sub Category Name</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->name }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Sub Category Image</label>

                                <div>
                                    @if($builderSubCategory->sub_cat_image)
                                    <img src="{{ asset('storage/' . $builderSubCategory->sub_cat_image) }}"
                                        alt="{{ $builderSubCategory->name }}"
                                        width="120"
                                        height="120"
                                        class="rounded"
                                        style="object-fit: cover;">
                                    @else
                                    <img src="{{ asset('assets/img/default.png') }}"
                                        alt="image"
                                        width="120"
                                        height="120"
                                        class="rounded"
                                        style="object-fit: cover;">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>

                                <div>
                                    @if($builderSubCategory->status)
                                    <span class="badge badge-success badge-shadow">
                                        Active
                                    </span>
                                    @else
                                    <span class="badge badge-danger badge-shadow">
                                        Inactive
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Slug</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->slug }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Created At</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->created_at ? $builderSubCategory->created_at->format('d-m-Y H:i:s') : '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Updated At</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->updated_at ? $builderSubCategory->updated_at->format('d-m-Y H:i:s') : '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Created By</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->createdBy->name ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Updated By</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->updatedBy->name ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Title</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->meta_title ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Keywords</label>
                                <input type="text"
                                    class="form-control"
                                    value="{{ $builderSubCategory->meta_keywords ?? '-' }}"
                                    readonly>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Meta Description</label>
                                <textarea rows="4"
                                    class="form-control"
                                    readonly>{{ $builderSubCategory->meta_description ?? '-' }}</textarea>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-sub-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('builder-sub-categories.edit', $builderSubCategory->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Sub Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection