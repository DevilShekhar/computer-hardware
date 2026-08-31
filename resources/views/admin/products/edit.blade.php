@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product</h4>
                        <div class="card-header-action">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('products.update', $product->id) }}"  method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-4">
                                    <label>Product Brand <span class="text-danger">*</span> </label>
                                    <select name="product_brand_id" id="product_brand_id" class="form-control @error('product_brand_id') is-invalid @enderror">
                                        <option value="">Select Product Brand</option>
                                        @foreach($productBrands as $brand)
                                            <option  value="{{ $brand->id }}" {{ old('product_brand_id', $product->product_brand_id) == $brand->id ? 'selected' : '' }}>
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
                                        <option value="">
                                            Select Category
                                        </option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                                {{ $category->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sub Category<span class="text-danger">*</span></label>
                                    <select  name="sub_category_id" id="sub_category_id" class="form-control @error('sub_category_id') is-invalid @enderror">
                                        <option value="">Select Sub Category</option>
                                        @foreach($subCategories as $subCategory)
                                            <option value="{{ $subCategory->id }}"  {{ old('sub_category_id', $product->sub_category_id) == $subCategory->id ? 'selected' : '' }}>
                                                {{ $subCategory->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('sub_category_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product Name<span class="text-danger">*</span></label>
                                    <input type="text" name="name" value="{{ old('name', $product->name) }}" class="form-control @error('name') is-invalid @enderror" placeholder="Enter product name">
                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>SKU<span class="text-danger">*</span></label>
                                    <input type="text" name="sku" value="{{ old('sku', $product->sku) }}" class="form-control @error('sku') is-invalid @enderror" placeholder="Enter SKU">
                                    @error('sku')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Price <span class="text-danger">*</span></label>
                                    <input type="number" step="0.01" name="price" value="{{ old('price', $product->price) }}" class="form-control @error('price') is-invalid @enderror" placeholder="Enter price">
                                    @error('price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Sale Price</label>
                                    <input type="number"step="0.01"   name="sale_price" value="{{ old('sale_price', $product->sale_price) }}" class="form-control @error('sale_price') is-invalid @enderror"placeholder="Enter sale price">
                                    @error('sale_price')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Stock Quantity <span class="text-danger">*</span> </label>
                                    <input  type="number"  name="stock_quantity"  value="{{ old('stock_quantity', $product->stock_quantity) }}" class="form-control @error('stock_quantity') is-invalid @enderror"  placeholder="Enter stock quantity">
                                    @error('stock_quantity')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>HSN</label>
                                    <input type="text"  name="hsn"  value="{{ old('hsn', $product->hsn) }}" class="form-control @error('hsn') is-invalid @enderror" placeholder="Enter HSN">
                                    @error('hsn')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-4">
                                    <label>GST Rate</label>
                                    <input type="number"  step="0.01"  name="gst_rate" value="{{ old('gst_rate', $product->gst_rate) }}" class="form-control @error('gst_rate') is-invalid @enderror"  placeholder="Enter GST rate">
                                    @error('gst_rate')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Add Product Images </label>
                                    <input type="file"  name="images[]" id="productImages" multiple  class="form-control @error('images') is-invalid @enderror @error('images.*') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
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
                                    <div  id="imagePreview" class="row mt-3"></div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Current Product Images</label>
                                    <div class="row">
                                        @forelse($product->images as $image)
                                            <div class="col-md-2 mb-3 image-item-{{ $image->id }}">
                                                <div class="card">
                                                    <img src="{{ asset('storage/' . $image->image) }}" class="card-img-top" style="height:120px;object-fit:cover;">
                                                    <div class="card-body p-2 text-center">
                                                        @if($image->is_primary)
                                                            <span class="badge badge-success mb-2">
                                                                Primary
                                                            </span>
                                                        @endif
                                                        <button type="button" class="btn btn-danger btn-sm delete-image-btn" data-url="{{ route('products.images.delete', $image->id) }}">
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="col-12">
                                                <p class="text-muted">
                                                    No product images found.
                                                </p>
                                            </div>
                                        @endforelse
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>
                                        Warranty Information
                                    </label>
                                    <textarea  name="warranty_information" rows="3" class="form-control @error('warranty_information') is-invalid @enderror"  placeholder="Enter warranty information"
                                    >{{ old('warranty_information', $product->warranty_information) }}</textarea>
                                    @error('warranty_information')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label> Short Description</label>
                                    <textarea  name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror"  placeholder="Enter short description"
                                    >{{ old('short_description', $product->short_description) }}</textarea>
                                    @error('short_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Description</label>
                                    <div class="col-sm-12 col-md-12 p-0">
                                        <textarea name="description" class="summernote @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Meta Title</label>
                                    <textarea name="meta_title" rows="3" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title">{{ old('meta_title', $product->meta_title) }}</textarea>
                                    @error('meta_title')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Meta Keywords</label>
                                    <textarea name="meta_keywords" rows="3" class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Enter meta keywords">{{ old('meta_keywords', $product->meta_keywords) }}</textarea>
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
                                    <textarea name="meta_description" rows="3" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Enter meta description">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div> 
                                <div class="form-group col-md-4">
                                    <label>Status<span class="text-danger">*</span></label>
                                    <select  name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $product->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option  value="0" {{ old('status', $product->status) == 0 ? 'selected' : '' }}>
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
                            <div class="row">
                                <div class="col-12">
                                    <h5>Product Specifications</h5>
                                    <div id="specifications">
                                        @php
                                            $oldSpecificationNames =  old('specification_name');
                                            $oldSpecificationValues =  old('specification_value');
                                        @endphp
                                        @if(is_array($oldSpecificationNames) && count($oldSpecificationNames) > 0)
                                            @foreach($oldSpecificationNames as $index => $name)
                                                <div class="row specification-row">
                                                    <div class="form-group col-md-5">
                                                        <label>Specification Name</label>
                                                        <input  type="text"  name="specification_name[]" value="{{ $name }}" class="form-control" placeholder="Example: RAM"  >
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label> Specification Value </label>
                                                        <input  type="text"  name="specification_value[]" value="{{ $oldSpecificationValues[$index] ?? '' }}"  class="form-control" placeholder="Example: 16GB DDR5">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>
                                                            &nbsp;
                                                        </label>
                                                        <button  type="button"  class="btn btn-danger btn-block remove-specification">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @elseif($product->specifications->count() > 0)
                                            @foreach($product->specifications as $specification)
                                                <div class="row specification-row">
                                                    <div class="form-group col-md-5">
                                                        <label>Specification Name </label>
                                                        <input  type="text" name="specification_name[]"  value="{{ $specification->specification_name }}" class="form-control"  placeholder="Example: RAM">
                                                    </div>
                                                    <div class="form-group col-md-5">
                                                        <label> Specification Value</label>
                                                        <input type="text" name="specification_value[]" value="{{ $specification->specification_value }}" class="form-control"  placeholder="Example: 16GB DDR5">
                                                    </div>
                                                    <div class="form-group col-md-2">
                                                        <label>
                                                            &nbsp;
                                                        </label>
                                                        <button  type="button"
                                                            class="btn btn-danger btn-block remove-specification">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <div class="row specification-row">
                                                <div class="form-group col-md-5">
                                                    <label>
                                                        Specification Name
                                                    </label>
                                                    <input  type="text"   name="specification_name[]" class="form-control"  placeholder="Example: RAM">
                                                </div>
                                                <div class="form-group col-md-5">
                                                    <label>   Specification Value </label>
                                                    <input type="text" name="specification_value[]" class="form-control"  placeholder="Example: 16GB DDR5">
                                                </div>
                                                <div class="form-group col-md-2">
                                                    <label>
                                                        &nbsp;
                                                    </label>
                                                    <button type="button" class="btn btn-danger btn-block remove-specification" >
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" id="addSpecification" class="btn btn-success">
                                        <i class="fas fa-plus"></i>
                                        Add Specification
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('products.index') }}"
                                class="btn btn-secondary" >
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Update Product</button>
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
$(document).ready(function () {
    let oldBrandId =  @json(old('product_brand_id', $product->product_brand_id));
    let oldCategoryId =  @json(old('category_id', $product->category_id));
    let oldSubCategoryId = @json(old('sub_category_id', $product->sub_category_id));

    function loadCategories(
        brandId,
        selectedCategoryId = null,
        loadSubCategory = false
    ) {

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
            url:
                "{{ url('products/categories-by-brand') }}/" +
                brandId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $.each(response, function (key, category) {
                    let selected = '';
                    if (
                        selectedCategoryId !== null &&
                        String(selectedCategoryId) ===
                        String(category.id)
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
                if (
                    loadSubCategory &&
                    selectedCategoryId
                ) {
                    loadSubCategories(
                        selectedCategoryId,
                        oldSubCategoryId
                    );
                }
            },
            error: function (xhr) {
                console.log(
                    'Category loading error:',
                    xhr.responseText
                );
            }
        });
    }

    function loadSubCategories(
        categoryId,
        selectedSubCategoryId = null
    ) {
        $('#sub_category_id').html(
            '<option value="">Select Sub Category</option>'
        );
        if (!categoryId) {
            return;
        }
        $.ajax({
            url:
                "{{ url('products/sub-categories-by-category') }}/" +
                categoryId,
            type: "GET",
            dataType: "json",
            success: function (response) {
                $.each(response, function (key, subCategory) {
                    let selected = '';
                    if (
                        selectedSubCategoryId !== null &&
                        String(selectedSubCategoryId) ===
                        String(subCategory.id)
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
            error: function (xhr) {
                console.log(
                    'Sub category loading error:',
                    xhr.responseText
                );
            }
        });
    }
    $('#product_brand_id').on('change', function () {
        let brandId = $(this).val();
        loadCategories(
            brandId,
            null,
            false
        );
    });
    $('#category_id').on('change', function () {
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
    let selectedFiles = [];
    $('#productImages').on('change', function (e) {
        selectedFiles =
            Array.from(e.target.files);
        showImagePreview();
    });
    function showImagePreview() {
        $('#imagePreview').html('');
        selectedFiles.forEach(function (file, index) {
            let reader =
                new FileReader();
            reader.onload = function (e) {
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
                                    style="
                                        height:150px;
                                        width:100%;
                                        object-fit:cover;
                                    "
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
    $(document).on(
        'click',
        '.remove-image',
        function () {
            let index =
                parseInt($(this).data('index'));
            selectedFiles.splice(
                index,
                1
            );
            let dataTransfer =
                new DataTransfer();
            selectedFiles.forEach(function (file) {
                dataTransfer.items.add(file);
            });
            $('#productImages')[0].files =
                dataTransfer.files;
            showImagePreview();
        }
    );
    $(document).on(
        'click',
        '.delete-image-btn',
        function () {
            let deleteUrl =
                $(this).data('url');
            Swal.fire({
                title: 'Are you sure?',
                text:
                    'This product image will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#fc544b',
                cancelButtonColor: '#6777ef',
                confirmButtonText:
                    'Yes, delete it!',
                cancelButtonText:
                    'Cancel'
            }).then(function (result) {
                if (result.isConfirmed) {
                    let form =
                        $('<form>', {
                            method: 'POST',
                            action: deleteUrl
                        });
                    form.append(
                        $('<input>', {
                            type: 'hidden',
                            name: '_token',
                            value:
                               '{{ csrf_token() }}'
                        })
                    );
                    form.append(
                        $('<input>', {
                            type: 'hidden',
                            name: '_method',
                            value: 'DELETE'
                        })
                    );
                    $('body').append(form);
                    form.submit();
                }
            });
        }
    );
    $('#addSpecification').on(
        'click',
        function () {
            $('#specifications').append(`
                <div class="row specification-row">
                    <div class="form-group col-md-5">
                        <label>
                            Specification Name
                        </label>
                        <input
                            type="text"
                            name="specification_name[]"
                            class="form-control"
                            placeholder="Example: RAM"
                        >
                    </div>
                    <div class="form-group col-md-5">
                        <label>
                            Specification Value
                        </label>
                        <input
                            type="text"
                            name="specification_value[]"
                            class="form-control"
                            placeholder="Example: 16GB DDR5"
                        >
                    </div>
                    <div class="form-group col-md-2">
                        <label>
                            &nbsp;
                        </label>
                        <button
                            type="button"
                            class="btn btn-danger btn-block remove-specification"
                        >
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            `);
        }
    );
    $(document).on(
        'click',
        '.remove-specification',
        function () {
            if (
                $('.specification-row').length > 1
            ) {
                $(this)
                    .closest('.specification-row')
                    .remove();
            }
        }
    );
});
</script>
@endpush