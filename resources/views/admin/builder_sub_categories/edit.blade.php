@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit PC Builder Sub Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-sub-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('builder-sub-categories.update', $builderSubCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Builder Type <span class="text-danger">*</span></label>
                                    <select name="builder_type_id" id="builder_type_id" class="form-control @error('builder_type_id') is-invalid @enderror">
                                        <option value="">Select Builder Type</option>
                                        @foreach($builderTypes as $builderType)
                                        <option value="{{ $builderType->id }}" {{ old('builder_type_id', $builderSubCategory->builder_type_id) == $builderType->id ? 'selected' : '' }}>
                                            {{ $builderType->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('builder_type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Brand <span class="text-danger">*</span></label>
                                    <select name="brand_id" id="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">Select Brand</option>
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub Category Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name"  value="{{ old('name', $builderSubCategory->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter sub category name">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub Category Image</label>
                                    <input type="file"  name="sub_cat_image" class="form-control @error('sub_cat_image') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                                    @error('sub_cat_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>
                                    @if($builderSubCategory->sub_cat_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $builderSubCategory->sub_cat_image) }}" alt="{{ $builderSubCategory->name }}"  width="80" height="80" class="rounded" style="object-fit: cover;">
                                    </div>
                                    @endif
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $builderSubCategory->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $builderSubCategory->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meta Title</label>
                                    <input type="text" name="meta_title" value="{{ old('meta_title', $builderSubCategory->meta_title) }}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meta Keywords</label>
                                    <input type="text" name="meta_keywords" value="{{ old('meta_keywords', $builderSubCategory->meta_keywords) }}" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Enter meta keywords">
                                    @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description"  rows="4" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Enter meta description">{{ old('meta_description', $builderSubCategory->meta_description) }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('builder-sub-categories.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Sub Category
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
        let selectedBrandId = "{{ old('brand_id', $builderSubCategory->brand_id) }}";
        let selectedCategoryId = "{{ old('category_id', $builderSubCategory->category_id) }}";
        let selectedBuilderTypeId = "{{ old('builder_type_id', $builderSubCategory->builder_type_id) }}";
        $('#builder_type_id').on('change', function() {
            let builderTypeId = $(this).val();
            let brandSelect = $('#brand_id');
            let categorySelect = $('#category_id');
            brandSelect.html('<option value="">Select Brand</option>');
            categorySelect.html('<option value="">Select Category</option>');
            if (builderTypeId) {
                $.ajax({
                    url: "{{ route('builder-sub-categories.brands-by-type', ':builderType') }}".replace(':builderType', builderTypeId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(key, brand) {
                            brandSelect.append(
                                $('<option>', {
                                    value: brand.id,
                                    text: brand.name
                                })
                            );
                        });
                        if (selectedBrandId) {
                            brandSelect.val(selectedBrandId).trigger('change');
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
        $('#brand_id').on('change', function() {
            let brandId = $(this).val();
            let categorySelect = $('#category_id');
            categorySelect.html('<option value="">Select Category</option>');
            if (brandId) {
                $.ajax({
                    url: "{{ route('builder-sub-categories.categories-by-brand', ':brand') }}".replace(':brand', brandId),
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(key, category) {
                            categorySelect.append(
                                $('<option>', {
                                    value: category.id,
                                    text: category.name
                                })
                            );
                        });
                        if (selectedCategoryId) {
                            categorySelect.val(selectedCategoryId);
                        }
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                    }
                });
            }
        });
        if (selectedBuilderTypeId) {
            $('#builder_type_id').trigger('change');
        }
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