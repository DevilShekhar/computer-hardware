@extends('admin.layouts.app')
@section('content')

<section class="section">
    <div class="section-header">
        <h1>PC Builder Type Details</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-types.index') }}">PC Builder</a>
            </div>
            <div class="breadcrumb-item active">Builder Type Details</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Builder Type Details</h4>

                        <div class="card-header-action">
                            <a href="{{ route('builder-types.edit', $builderType->id) }}"
                                class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Type
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Type Name</label>

                                <div class="form-control-plaintext">
                                    <strong>{{ $builderType->name }}</strong>
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Slug</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->slug }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Type Image</label>

                                <div>
                                    @if($builderType->image)
                                        <img src="{{ asset('storage/' . $builderType->image) }}"
                                            alt="{{ $builderType->name }}"
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

                                <div class="mt-2">
                                    @if($builderType->status)
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

                            <div class="form-group col-md-12">
                                <label>Description</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->description ?: '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Title</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->meta_title ?: '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Meta Keywords</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->meta_keywords ?: '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label>Meta Description</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->meta_description ?: '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Created By</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->createdBy->name ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Updated By</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->updatedBy->name ?? '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Created At</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->created_at ? $builderType->created_at->format('d-m-Y h:i A') : '-' }}
                                </div>
                            </div>

                            <div class="form-group col-md-6">
                                <label>Updated At</label>

                                <div class="form-control-plaintext">
                                    {{ $builderType->updated_at ? $builderType->updated_at->format('d-m-Y h:i A') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-types.index') }}" class="btn btn-secondary">
                            Back
                        </a>

                        <a href="{{ route('builder-types.edit', $builderType->id) }}"
                            class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Type
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection