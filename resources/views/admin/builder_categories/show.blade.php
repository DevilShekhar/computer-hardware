@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Builder Category Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-categories.edit', $builderCategory->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Category
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($builderCategory->cat_image)
                                <img src="{{ asset('storage/' . $builderCategory->cat_image) }}"
                                    alt="{{ $builderCategory->name }}"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/img/default.png') }}"
                                    alt="image"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @endif

                                <h5 class="mt-3 mb-1">
                                    {{ $builderCategory->name }}
                                </h5>

                                <p class="text-muted mb-2">
                                    {{ $builderCategory->brand->name ?? '-' }}
                                </p>

                                @if($builderCategory->status)
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
                                                <td>{{ $builderCategory->id }}</td>
                                            </tr>

                                            <tr>
                                                <th>Brand</th>
                                                <td>{{ $builderCategory->brand->name ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Category Name</th>
                                                <td>{{ $builderCategory->name }}</td>
                                            </tr>

                                            <tr>
                                                <th>Slug</th>
                                                <td>{{ $builderCategory->slug }}</td>
                                            </tr>

                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($builderCategory->status)
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
                                                <td>{{ $builderCategory->created_by ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $builderCategory->updated_by ?? '-' }}</td>
                                            </tr>

                                            <tr>
                                                <th>Created At</th>
                                                <td>
                                                    {{ $builderCategory->created_at ? $builderCategory->created_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>

                                            <tr>
                                                <th>Updated At</th>
                                                <td>
                                                    {{ $builderCategory->updated_at ? $builderCategory->updated_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer text-right">
                        <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>

                        <a href="{{ route('builder-categories.edit', $builderCategory->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection