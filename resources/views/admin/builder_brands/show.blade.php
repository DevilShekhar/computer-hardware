@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>PC Builder Brand Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-brands.index') }}">PC Builder</a>
            </div>
            <div class="breadcrumb-item active">Brand Details</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>PC Builder Brand Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-brands.edit', $builderBrand->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Brand
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Brand Name</label>
                                <div class="form-control">
                                    {{ $builderBrand->name }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Slug</label>
                                <div class="form-control">
                                    {{ $builderBrand->slug ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Builder Type</label>
                                <div class="form-control">
                                    {{ $builderBrand->builderType->name ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <div>
                                    @if($builderBrand->status)
                                    <div class="badge badge-success badge-shadow">
                                        Active
                                    </div>
                                    @else
                                    <div class="badge badge-danger badge-shadow">
                                        Inactive
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Brand Image</label>
                                <div>
                                    @if($builderBrand->brand_image)
                                    <img src="{{ asset('storage/' . $builderBrand->brand_image) }}"
                                        alt="{{ $builderBrand->name }}" width="120" height="120" class="rounded"
                                        style="object-fit: cover;">
                                    @else
                                    <img src="{{ asset('assets/img/default.png') }}" alt="image" width="120"
                                        height="120" class="rounded" style="object-fit: cover;">
                                    @endif
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Created At</label>
                                <div class="form-control">
                                    {{ $builderBrand->created_at ? $builderBrand->created_at->format('d-m-Y H:i') : '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Updated At</label>
                                <div class="form-control">
                                    {{ $builderBrand->updated_at ? $builderBrand->updated_at->format('d-m-Y H:i') : '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Title</label>
                                <div class="form-control">
                                    {{ $builderBrand->meta_title ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Keyword</label>
                                <div class="form-control">
                                    {{ $builderBrand->meta_keyword ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Meta Description</label>
                                <div class="form-control" style="height: auto; min-height: 100px;">
                                    {{ $builderBrand->meta_description ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-brands.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <a href="{{ route('builder-brands.edit', $builderBrand->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Brand
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection