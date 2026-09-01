@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>PC Builder Category Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-types.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('builder-categories.index') }}">
                    Categories
                </a>
            </div>
            <div class="breadcrumb-item active">
                View Category
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Category Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                            <a href="{{ route('builder-categories.edit', $builderCategory->id) }}"
                                class="btn btn-primary ml-2">
                                <i class="fas fa-edit"></i>
                                Edit
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>
                                    Builder Type
                                </label>
                                <div class="form-control bg-light">
                                    @if($builderCategory->brand &&
                                    $builderCategory->brand->builderType)
                                    {{ $builderCategory->brand->builderType->name }}
                                    @else
                                    <span class="text-muted">
                                       -
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Brand
                                </label>
                                <div class="form-control bg-light">
                                    @if($builderCategory->brand)
                                    {{ $builderCategory->brand->name }}
                                    @else
                                    <span class="text-muted">
                                        -
                                    </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Category Name
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->name }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Slug
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->slug ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Category Image
                                </label>
                                <div>
                                    @if($builderCategory->cat_image)
                                    <img src="{{ asset('storage/' . $builderCategory->cat_image) }}"
                                        alt="{{ $builderCategory->name }}" width="150" height="150" class="rounded"
                                        style="object-fit: cover;">
                                    @else
                                    <img src="{{ asset('assets/img/default.png') }}" alt="Default Image" width="150"
                                        height="150" class="rounded" style="object-fit: cover;">
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Status
                                </label>
                                <div class="mt-2">
                                    @if($builderCategory->status)
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
                                <label>
                                    Meta Title
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->meta_title ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Meta Keywords
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->meta_keywords ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>
                                    Meta Description
                                </label>
                                <div class="form-control bg-light" style="min-height: 100px; height: auto;">
                                    {{ $builderCategory->meta_description ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Created At
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->created_at
                                    ? $builderCategory->created_at->format('d-m-Y h:i A')
                                    : '-'
                                }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>
                                    Updated At
                                </label>
                                <div class="form-control bg-light">
                                    {{ $builderCategory->updated_at
                                    ? $builderCategory->updated_at->format('d-m-Y h:i A')
                                    : '-'
                                }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i>
                            Back to Categories
                        </a>
                        <a href="{{ route('builder-categories.edit', $builderCategory->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i>
                            Edit Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection