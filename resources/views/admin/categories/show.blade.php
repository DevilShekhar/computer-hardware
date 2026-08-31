@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Category Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                                <i class="fas fa-edit"></i> Edit Category
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                @if($category->cat_image)
                                <img src="{{ asset('storage/' . $category->cat_image) }}"
                                    alt="{{ $category->name }}"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                <img src="{{ asset('assets/img/default.png') }}"
                                    alt="image"
                                    class="img-fluid rounded"
                                    style="width: 200px; height: 200px; object-fit: cover;">
                                @endif
                                <h5 class="mt-3 mb-1">
                                    {{ $category->name }}
                                </h5>
                                <p class="text-muted mb-2">
                                    {{ $category->slug }}
                                </p>
                                @if($category->status)
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
                                                <td>{{ $category->id }}</td>
                                            </tr>
                                            <tr>
                                                <th>Category Name</th>
                                                <td>{{ $category->name }}</td>
                                            </tr>
                                            <tr>
                                                <th>Slug</th>
                                                <td>{{ $category->slug }}</td>
                                            </tr>
                                            <tr>
                                                <th>Status</th>
                                                <td>
                                                    @if($category->status)
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
                                                <td>{{ $category->meta_title ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meta Keywords</th>
                                                <td>{{ $category->meta_keywords ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Meta Description</th>
                                                <td>{{ $category->meta_description ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created By</th>
                                                <td>{{ $category->createdBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Updated By</th>
                                                <td>{{ $category->updatedBy->name ?? '-' }}</td>
                                            </tr>
                                            <tr>
                                                <th>Created At</th>
                                                <td>
                                                    {{ $category->created_at ? $category->created_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>Updated At</th>
                                                <td>
                                                    {{ $category->updated_at ? $category->updated_at->format('d-m-Y h:i A') : '-' }}
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit Category
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection