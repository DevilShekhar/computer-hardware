@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>Edit PC Builder Brand</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-brands.index') }}">PC Builder</a>
            </div>
            <div class="breadcrumb-item active">Edit PC Builder Brand</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit PC Builder Brand</h4>
                    </div>

                    <form action="{{ route('builder-brands.update', $builderBrand->id) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

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
                                    <label for="builder_type_id">
                                        Builder Type <span class="text-danger">*</span>
                                    </label>

                                    <select id="builder_type_id" name="builder_type_id"
                                        class="form-control @error('builder_type_id') is-invalid @enderror" required>
                                        <option value="">Select Builder Type</option>

                                        @foreach($builderTypes as $builderType)
                                        <option value="{{ $builderType->id }}"
                                            {{ old('builder_type_id', $builderBrand->builder_type_id) == $builderType->id ? 'selected' : '' }}>
                                            {{ $builderType->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                    @error('builder_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="name">
                                        Brand Name <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" id="name" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $builderBrand->name) }}" placeholder="Enter brand name"
                                        required>

                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="brand_image">Brand Image</label>

                                    <input type="file" id="brand_image" name="brand_image"
                                        class="form-control @error('brand_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">

                                    @error('brand_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>

                                    @if($builderBrand->brand_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $builderBrand->brand_image) }}"
                                            alt="{{ $builderBrand->name }}" width="80" height="80" class="rounded"
                                            style="object-fit: cover;">
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">
                                        Status <span class="text-danger">*</span>
                                    </label>

                                    <select id="status" name="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="1"
                                            {{ old('status', $builderBrand->status) == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>

                                        <option value="0"
                                            {{ old('status', $builderBrand->status) == '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="meta_title">Meta Title</label>

                                    <input type="text" id="meta_title" name="meta_title"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        value="{{ old('meta_title', $builderBrand->meta_title) }}"
                                        placeholder="Enter meta title">

                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="meta_keyword">Meta Keyword</label>

                                    <textarea id="meta_keyword" name="meta_keyword"
                                        class="form-control @error('meta_keyword') is-invalid @enderror" rows="4"
                                        placeholder="Enter meta keywords">{{ old('meta_keyword', $builderBrand->meta_keyword) }}</textarea>

                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="meta_description">Meta Description</label>

                                    <textarea id="meta_description" name="meta_description"
                                        class="form-control @error('meta_description') is-invalid @enderror" rows="5"
                                        placeholder="Enter meta description">{{ old('meta_description', $builderBrand->meta_description) }}</textarea>

                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('builder-brands.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Brand
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</section>

@endsection