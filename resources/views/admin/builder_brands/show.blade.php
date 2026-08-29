@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Builder Brand Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-brands.edit', $builderBrand->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Brand
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($builderBrand->brand_image)
                                <img src="{{ asset('storage/' . $builderBrand->brand_image) }}"
                                    alt="{{ $builderBrand->name }}"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/img/default.png') }}"
                                    alt="image"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @endif

                                <h5 class="mt-3 mb-1">
                                    {{ $builderBrand->name }}
                                </h5>

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

                            <div class="col-md-8">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <tbody>
                                            <tr>
                                                <th width="35%">ID</th>
                                                <td>{{ $builderBrand->id }}</td>
                                            </tr>

                                            <tr>
                                                <th>Brand Name</th>
                                                <td>{{ $builderBrand->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($builderBrand->status)
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
                                                <td>{{ $builderBrand->meta_title ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Meta Keyword</th>
                                                <td>{{ $builderBrand->meta_keyword ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Meta Description</th>
                                                <td>{{ $builderBrand->meta_description ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Created By</th>
                                                <td>{{ $builderBrand->created_by ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $builderBrand->updated_by ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Created At</th>
                                                <td>
                                                    {{ $builderBrand->created_at ? $builderBrand->created_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Updated At</th>
                                                <td>
                                                    {{ $builderBrand->updated_at ? $builderBrand->updated_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-brands.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
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