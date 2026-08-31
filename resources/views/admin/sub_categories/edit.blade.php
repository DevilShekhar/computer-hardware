@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Sub Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('sub-categories.update', $subCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Product Brand <span class="text-danger">*</span></label>
                                    <select name="product_brand_id" id="product_brand_id" class="form-control @error('product_brand_id') is-invalid @enderror">
                                        <option value="">Select Product Brand</option>
                                        @foreach($productBrands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('product_brand_id', $subCategory->product_brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('product_brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                        @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id', $subCategory->category_id) == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub Category Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name', $subCategory->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter sub category name">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Sub Category Image</label>
                                    <input type="file"
                                        name="sub_cat_image"
                                        class="form-control @error('sub_cat_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    @error('sub_cat_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    @if($subCategory->sub_cat_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $subCategory->sub_cat_image) }}"
                                            alt="{{ $subCategory->name }}"
                                            width="80"
                                            height="80"
                                            class="rounded"
                                            style="object-fit: cover;">
                                    </div>
                                    @endif
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meta Title</label>
                                    <input type="text"
                                        name="meta_title"
                                        value="{{ old('meta_title', $subCategory->meta_title) }}"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        placeholder="Enter meta title">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meta Keywords</label>
                                    <input type="text"
                                        name="meta_keywords"
                                        value="{{ old('meta_keywords', $subCategory->meta_keywords) }}"
                                        class="form-control @error('meta_keywords') is-invalid @enderror"
                                        placeholder="Enter meta keywords">
                                    @error('meta_keywords')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description"
                                        rows="4"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        placeholder="Enter meta description">{{ old('meta_description', $subCategory->meta_description) }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $subCategory->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $subCategory->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('sub-categories.index') }}" class="btn btn-secondary">
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
<script>
    $(document).ready(function() {
        $('#product_brand_id').on('change', function() {
            let brandId = $(this).val();
            let categorySelect = $('#category_id');
            let selectedCategoryId = "{{ old('category_id', $subCategory->category_id) }}";
            categorySelect.html('<option value="">Select Category</option>');
            if (brandId) {
                $.ajax({
                    url: "{{ url('sub-categories/categories-by-brand') }}/" + brandId,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        $.each(response, function(key, category) {
                            let selected = category.id == selectedCategoryId ? 'selected' : '';

                            categorySelect.append(
                                '<option value="' + category.id + '" ' + selected + '>' +
                                category.name +
                                '</option>'
                            );
                        });
                    }
                });
            }
        });
    });
</script>
@endpush