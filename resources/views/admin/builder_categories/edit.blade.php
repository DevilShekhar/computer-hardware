@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Edit PC Builder Category</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-categories.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('builder-categories.index') }}">
                    Categories
                </a>
            </div>
            <div class="breadcrumb-item active">
                Edit Category
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit PC Builder Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('builder-categories.update', $builderCategory->id) }}" method="POST"  enctype="multipart/form-data">
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
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="builder_type_id">
                                        Builder Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="builder_type_id" id="builder_type_id" class="form-control @error('builder_type_id') is-invalid @enderror">
                                        <option value="">
                                            Select Builder Type
                                        </option>
                                        @foreach($builderTypes as $type)
                                        <option value="{{ $type->id }}"
                                            {{ old('builder_type_id', $builderCategory->builder_type_id) == $type->id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('builder_type_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="brand_id">
                                        Brand
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">
                                            Select Brand
                                        </option>
                                        @foreach($builderBrands as $brand)
                                        <option value="{{ $brand->id }}"
                                            data-builder-type="{{ $brand->builder_type_id }}"
                                            {{ old('brand_id', $builderCategory->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="name">
                                        Category Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" id="name" name="name"  value="{{ old('name', $builderCategory->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter category name">
                                    @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="cat_image">
                                        Category Image
                                    </label>
                                    <input type="file" id="cat_image" name="cat_image" class="form-control @error('cat_image') is-invalid @enderror"  accept=".jpg,.jpeg,.png,.webp">
                                    @error('cat_image')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP.
                                        Maximum size: 2MB.
                                    </small>
                                    @if($builderCategory->cat_image)
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/' . $builderCategory->cat_image) }}" alt="{{ $builderCategory->name }}" width="100" height="100" class="rounded" style="object-fit: cover;">
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_title">
                                        Meta Title
                                    </label>
                                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title', $builderCategory->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title">
                                    @error('meta_title')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_keywords">
                                        Meta Keywords
                                    </label>
                                    <input type="text" id="meta_keywords" name="meta_keywords"  value="{{ old('meta_keywords', $builderCategory->meta_keywords) }}" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Enter meta keywords">
                                    @error('meta_keywords')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="meta_description">
                                        Meta Description
                                    </label>
                                    <textarea id="meta_description" name="meta_description" rows="4" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Enter meta description">{{ old('meta_description', $builderCategory->meta_description) }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">
                                        Status
                                        <span class="text-danger">*</span>
                                   </label>
                                    <select name="status" id="status"  class="form-control @error('status') is-invalid @enderror">
                                        <option value="1"
                                            {{ old('status', $builderCategory->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0"
                                            {{ old('status', $builderCategory->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@push('scripts')
<script>
$(document).ready(function() {
    function filterBrands() {
        let selectedType = $('#builder_type_id').val();
        let currentBrand = "{{ old('brand_id', $builderCategory->brand_id) }}";
        $('#brand_id option').each(function() {
            let option = $(this);
            if (option.val() === '') {
                option.show();
                return;
            }
            let brandType = option.data('builder-type');
            if (selectedType && String(brandType) === String(selectedType)) {
                option.show();
            } else {
                option.hide();
            }
        });
        let selectedBrandVisible = false;
        $('#brand_id option').each(function() {
            if (
                $(this).val() === currentBrand &&
                $(this).css('display') !== 'none'
            ) {
                selectedBrandVisible = true;
            }
        });
        if (!selectedBrandVisible) {
           $('#brand_id').val('');
        }
    }
    $('#builder_type_id').on('change', function() {
        $('#brand_id').val('');
        filterBrands();
    });
    filterBrands();
});
</script>
@if(session('success'))
<script>
Swal.fire({
    title: 'Success!',
    text: @json(session('success')),
    icon: 'success',
    confirmButtonColor: '#6777ef',
    confirmButtonText: 'OK'
});
</script>
@endif
@endpush