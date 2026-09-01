@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Create PC Builder Type</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-types.index') }}">PC Builder</a>
            </div>
            <div class="breadcrumb-item active">Create PC Builder Type</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add PC Builder Type</h4>
                    </div>

                    <form action="{{ route('builder-types.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="name">
                                        Type Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        id="name"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="Enter builder type name"
                                        required>

                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="image">Type Image</label>

                                    <input type="file"
                                        id="image"
                                        name="image"
                                        class="form-control @error('image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">

                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="description">Description</label>

                                    <textarea id="description"
                                        name="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="4"
                                        placeholder="Enter builder type description">{{ old('description') }}</textarea>

                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="meta_title">Meta Title</label>

                                    <input type="text"
                                        id="meta_title"
                                        name="meta_title"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        value="{{ old('meta_title') }}"
                                        placeholder="Enter meta title">

                                    @error('meta_title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="meta_keywords">Meta Keywords</label>

                                    <textarea id="meta_keywords"
                                        name="meta_keywords"
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        rows="4"
                                        placeholder="Enter meta keywords">{{ old('meta_keywords') }}</textarea>

                                    @error('meta_keywords')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="meta_description">Meta Description</label>

                                    <textarea id="meta_description"
                                        name="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        rows="5"
                                        placeholder="Enter meta description">{{ old('meta_description') }}</textarea>

                                    @error('meta_description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('builder-types.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Type
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection