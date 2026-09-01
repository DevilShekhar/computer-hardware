@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Create PC Builder Product</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-products.index') }}">PC Builder</a>
            </div>
            <div class="breadcrumb-item active">Create PC Builder Product</div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add PC Builder Product</h4>
                    </div>
                    <form action="{{ route('builder-products.store') }}" method="POST">
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
                                    <label for="product_id">Product <span class="text-danger">*</span></label>
                                    <select id="product_id"
                                        name="product_id"
                                        class="form-control @error('product_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select Product</option>
                                        @foreach($products as $product)
                                            <option value="{{ $product->id }}"
                                                {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                                {{ $product->name }}{{ $product->sku ? ' - ' . $product->sku : '' }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="builder_brand_id">Builder Brand <span class="text-danger">*</span></label>
                                    <select id="builder_brand_id"
                                        name="builder_brand_id"
                                        class="form-control @error('builder_brand_id') is-invalid @enderror"
                                        required>
                                        <option value="">Select Builder Brand</option>
                                        @foreach($builderBrands as $brand)
                                            <option value="{{ $brand->id }}"
                                                {{ old('builder_brand_id') == $brand->id ? 'selected' : '' }}>
                                                {{ $brand->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('builder_brand_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="builder_category_id">Builder Category <span class="text-danger">*</span></label>
                                    <select id="builder_category_id"
                                        name="builder_category_id"
                                        class="form-control @error('builder_category_id') is-invalid @enderror"
                                        required
                                        disabled>
                                        <option value="">Select Builder Brand First</option>
                                    </select>
                                    @error('builder_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="builder_sub_category_id">Builder Sub Category <span class="text-danger">*</span></label>
                                    <select id="builder_sub_category_id"
                                        name="builder_sub_category_id"
                                        class="form-control @error('builder_sub_category_id') is-invalid @enderror"
                                        required
                                        disabled>
                                        <option value="">Select Builder Category First</option>
                                    </select>
                                    @error('builder_sub_category_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="sort_order">Sort Order</label>
                                    <input type="number"
                                        id="sort_order"
                                        name="sort_order"
                                        class="form-control @error('sort_order') is-invalid @enderror"
                                        value="{{ old('sort_order', 0) }}"
                                        min="0"
                                        placeholder="Enter sort order">
                                    @error('sort_order')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="status">Status <span class="text-danger">*</span></label>
                                    <select id="status"
                                        name="status"
                                        class="form-control @error('status') is-invalid @enderror"
                                        required>
                                        <option value="1" {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('builder-products.index') }}" class="btn btn-secondary">
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
    $('#builder_brand_id').on('change', function() {
        let brandId = $(this).val();
        let categorySelect = $('#builder_category_id');
        let subCategorySelect = $('#builder_sub_category_id');
        categorySelect.html('<option value="">Loading categories...</option>');
        categorySelect.prop('disabled', true);
        subCategorySelect.html('<option value="">Select Builder Category First</option>');
        subCategorySelect.prop('disabled', true);
        if (!brandId) {
            categorySelect.html('<option value="">Select Builder Brand First</option>');
            return;
        }
        $.ajax({
            url: "{{ url('/builder-products/categories') }}/" + brandId,
            type: "GET",
            dataType: "json",
            success: function(categories) {
                categorySelect.html('<option value="">Select Builder Category</option>');
                if (categories.length > 0) {
                    $.each(categories, function(index, category) {
                        categorySelect.append(
                            '<option value="' + category.id + '">' +
                            category.name +
                            '</option>'
                        );
                    });
                    categorySelect.prop('disabled', false);
                } else {
                    categorySelect.html('<option value="">No categories found</option>');
                }
            },
            error: function() {
                categorySelect.html('<option value="">Unable to load categories</option>');
            }
        });
    });
    $('#builder_category_id').on('change', function() {
        let categoryId = $(this).val();
        let subCategorySelect = $('#builder_sub_category_id');
        subCategorySelect.html('<option value="">Loading sub categories...</option>');
        subCategorySelect.prop('disabled', true);
        if (!categoryId) {
            subCategorySelect.html('<option value="">Select Builder Category First</option>');
            return;
        }
        $.ajax({
            url: "{{ url('/builder-products/sub-categories') }}/" + categoryId,
            type: "GET",
            dataType: "json",
            success: function(subCategories) {
                subCategorySelect.html('<option value="">Select Builder Sub Category</option>');
                if (subCategories.length > 0) {
                    $.each(subCategories, function(index, subCategory) {
                        subCategorySelect.append(
                            '<option value="' + subCategory.id + '">' +
                            subCategory.name +
                            '</option>'
                        );
                    });

                    subCategorySelect.prop('disabled', false);
                } else {
                    subCategorySelect.html('<option value="">No sub categories found</option>');
                }
            },
            error: function() {
                subCategorySelect.html('<option value="">Unable to load sub categories</option>');
            }
        });
    });
    @if(old('builder_brand_id'))
        $('#builder_brand_id').trigger('change');
        setTimeout(function() {
            let oldCategory = "{{ old('builder_category_id') }}";
            if (oldCategory) {
                $('#builder_category_id').val(oldCategory).trigger('change');
                setTimeout(function() {
                    let oldSubCategory = "{{ old('builder_sub_category_id') }}";
                    if (oldSubCategory) {
                        $('#builder_sub_category_id').val(oldSubCategory);
                    }
                }, 500);
            }
        }, 500);
    @endif
});
</script>
@endpush