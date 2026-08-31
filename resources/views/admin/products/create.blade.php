@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Product</h4>
                        <div class="card-header-action">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Product Brand
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="product_brand_id" id="product_brand_id" class="form-control @error('product_brand_id') is-invalid @enderror">
                                        <option value="">Select Product Brand</option>
                                        @foreach($productBrands as $brand)
                                            <option  value="{{ $brand->id }}" {{ old('product_brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_brand_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>
                                        Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid @enderror">
                                        <option value="">Select Category</option>
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>
                                        Sub Category
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select  name="sub_category_id"  id="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror">
                                        <option value="">Select Sub Category</option>
                                    </select>
                                    @error('sub_category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        Product Name
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text"  name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"  placeholder="Enter product name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        SKU
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="sku" value="{{ old('sku') }}"  class="form-control @error('sku') is-invalid @enderror" placeholder="Enter SKU">
                                    @error('sku')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        Price
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"  class="form-control @error('price') is-invalid @enderror"  placeholder="Enter price">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Sale Price</label>
                                    <input type="number" step="0.01" name="sale_price" value="{{ old('sale_price') }}" class="form-control @error('sale_price') is-invalid @enderror" placeholder="Enter sale price">
                                    @error('sale_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>
                                        Stock Quantity
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="stock_quantity" value="{{ old('stock_quantity') }}"  class="form-control @error('stock_quantity') is-invalid @enderror" placeholder="Enter stock quantity">
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>HSN</label>
                                    <input type="text" name="hsn"  value="{{ old('hsn') }}" class="form-control @error('hsn') is-invalid @enderror" placeholder="Enter HSN">
                                    @error('hsn')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-3">
                                    <label>GST Rate</label>
                                    <input type="number" step="0.01"  name="gst_rate" value="{{ old('gst_rate') }}" class="form-control @error('gst_rate') is-invalid @enderror"  placeholder="Enter GST rate">
                                    @error('gst_rate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>
                                        Product Images
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" name="images[]" id="productImages" multiple  class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                                    @error('images')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    @error('images.*')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        You can select multiple images. Maximum 2MB per image.
                                    </small>
                                    <div id="imagePreview" class="row mt-3"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Warranty Information</label>
                                    <textarea name="warranty_information" rows="1"  class="form-control @error('warranty_information') is-invalid @enderror" placeholder="Enter warranty">{{ old('warranty_information') }}</textarea>
                                    @error('warranty_information')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Short Description</label>
                                    <textarea  name="short_description"  rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Enter short description">{{ old('short_description') }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <div class="col-sm-12 col-md-12">
                                        <textarea name="description"  class="summernote @error('description') is-invalid @enderror">{{ old('description') }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Meta Title</label>
                                    <textarea name="meta_title" rows="3" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title">{{ old('meta_title') }}</textarea>
                                    @error('meta_title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="meta_keywords" rows="3" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Enter meta keywords">{{ old('meta_keywords') }}</textarea>
                                    @error('meta_keywords')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Example: laptop, gaming laptop, dell laptop
                                    </small>
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <h5>Product Specifications</h5>
                                    <div id="specifications">
                                        @php
                                            $oldSpecificationNames = old('specification_name', []);
                                            $oldSpecificationValues = old('specification_value', []);
                                            $specificationCount = max(
                                                count($oldSpecificationNames),
                                                count($oldSpecificationValues),
                                                1
                                            );
                                        @endphp
                                        @for($i = 0; $i < $specificationCount; $i++)
                                            <div class="row specification-row">
                                                <div class="form-group col-md-5">
                                                    <label>Specification Name</label>
                                                    <input type="text"  name="specification_name[]" value="{{ $oldSpecificationNames[$i] ?? '' }}"  class="form-control"  placeholder="Example: RAM">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label>Specification Value</label>
                                                    <input type="text" name="specification_value[]" value="{{ $oldSpecificationValues[$i] ?? '' }}"  class="form-control" placeholder="Example: 16GB DDR5">
                                                </div>
                                               <div class="form-group col-md-2">
                                                    <label>&nbsp;</label>
                                                    <button   type="button"  class="btn btn-danger btn-block remove-specification" >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endfor
                                    </div>
                                    <button  type="button" id="addSpecification" class="btn btn-success" >
                                        <i class="fas fa-plus"></i> Add Specification
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Product
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
    let selectedFiles = [];
    let oldBrandId = "{{ old('product_brand_id') }}";
    let oldCategoryId = "{{ old('category_id') }}";
    let oldSubCategoryId = "{{ old('sub_category_id') }}";
    function loadCategories(brandId, selectedCategoryId = null, loadSubCategory = false) {
        $('#category_id').html(
            '<option value="">Select Category</option>'
        );
        $('#sub_category_id').html(
            '<option value="">Select Sub Category</option>'
        );
        if (!brandId) {
            return;
        }
        $.ajax({
            url: "{{ url('products/categories-by-brand') }}/" + brandId,
            type: "GET",
            success: function(response) {
                $.each(response, function(key, category) {
                    let selected = '';
                    if (
                        selectedCategoryId &&
                        String(selectedCategoryId) === String(category.id)
                    ) {
                        selected = 'selected';
                    }
                    $('#category_id').append(
                        '<option value="' +
                        category.id +
                        '" ' +
                        selected +
                        '>' +
                        category.name +
                        '</option>'
                    );
                });
                if (loadSubCategory && selectedCategoryId) {
                    loadSubCategories(
                        selectedCategoryId,
                        oldSubCategoryId
                    );
                }
            },
            error: function(xhr) {
                console.log('Category loading error:', xhr);
                $('#category_id').html(
                    '<option value="">Unable to load categories</option>'
                );
            }
        });
    }
    function loadSubCategories(categoryId, selectedSubCategoryId = null) {
        $('#sub_category_id').html(
            '<option value="">Select Sub Category</option>'
        );
        if (!categoryId) {
            return;
        }
        $.ajax({
            url: "{{ url('products/sub-categories-by-category') }}/" + categoryId,
            type: "GET",
            success: function(response) {
                $.each(response, function(key, subCategory) {
                    let selected = '';
                    if (
                        selectedSubCategoryId &&
                        String(selectedSubCategoryId) === String(subCategory.id)
                    ) {
                        selected = 'selected';
                    }
                    $('#sub_category_id').append(
                        '<option value="' +
                        subCategory.id +
                        '" ' +
                        selected +
                        '>' +
                        subCategory.name +
                        '</option>'
                    );
                });
            },
            error: function(xhr) {
                console.log('Sub category loading error:', xhr);
                $('#sub_category_id').html(
                    '<option value="">Unable to load sub categories</option>'
                );
            }
        });
    }
    $('#product_brand_id').on('change', function() {
        let brandId = $(this).val();
        loadCategories(
            brandId,
            null,
            false
        );
    });
    $('#category_id').on('change', function() {
        let categoryId = $(this).val();
        loadSubCategories(
            categoryId,
            null
        );
    });
    if (oldBrandId) {
        loadCategories(
            oldBrandId,
            oldCategoryId,
            true
        );
    }
    $('#productImages').on('change', function(e) {
        selectedFiles = Array.from(e.target.files);
        showImagePreview();
    });
    function showImagePreview() {
        $('#imagePreview').html('');
        selectedFiles.forEach(function(file, index) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').append(`
                    <div
                        class="col-md-3 mb-3 image-preview-item"
                        data-index="${index}"
                    >
                        <div class="card">
                            <div class="card-body p-2 text-center">
                                <img
                                    src="${e.target.result}"
                                    class="img-fluid rounded"
                                    style="height:150px;width:100%;object-fit:cover;"
                                >
                                <div class="mt-2">
                                    <small
                                        class="d-block text-muted text-truncate"
                                    >
                                        ${file.name}
                                    </small>
                                    <button
                                        type="button"
                                        class="btn btn-danger btn-sm mt-2 remove-image"
                                        data-index="${index}"
                                    >
                                        <i class="fas fa-trash"></i>
                                        Remove
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                `);
            };
            reader.readAsDataURL(file);
        });
    }
    $(document).on('click', '.remove-image', function() {
        let index = $(this).data('index');
        selectedFiles.splice(index, 1);
        let dataTransfer = new DataTransfer();
        selectedFiles.forEach(function(file) {
            dataTransfer.items.add(file);
        });
        $('#productImages')[0].files = dataTransfer.files;
        showImagePreview();
    });
    $('#addSpecification').on('click', function() {
        $('#specifications').append(`
            <div class="row specification-row">
                <div class="form-group col-md-5">
                    <label>Specification Name</label>
                    <input
                        type="text"
                        name="specification_name[]"
                        class="form-control"
                        placeholder="Example: RAM"
                    >
                </div>
                <div class="form-group col-md-5">
                    <label>Specification Value</label>
                    <input
                        type="text"
                        name="specification_value[]"
                        class="form-control"
                        placeholder="Example: 16GB DDR5"
                    >
                </div>
                <div class="form-group col-md-2">
                    <label>&nbsp;</label>
                    <button
                        type="button"
                        class="btn btn-danger btn-block remove-specification"
                    >
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            </div>
        `);
    });
    $(document).on('click', '.remove-specification', function() {
        if ($('.specification-row').length > 1) {
            $(this)
                .closest('.specification-row')
                .remove();
        }
    });
});
</script>
@endpush