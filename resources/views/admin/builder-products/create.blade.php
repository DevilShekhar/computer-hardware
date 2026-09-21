@can('pc-builder-product-create')
@extends('admin.layouts.app')
@section('content')
<style>
    .product-search-dropdown {
    position: relative;
    width: 100%;
}

.product-search-list {
    display: none;
    position: absolute;
    top: 100%;
    left: 0;
    right: 0;
    max-height: 250px;
    overflow-y: auto;
    background: #fff;
    border: 1px solid #ddd;
    border-radius: 4px;
    z-index: 9999;
}

.product-search-item {
    padding: 10px 12px;
    cursor: pointer;
    border-bottom: 1px solid #f1f1f1;
}

.product-search-item:hover {
    background: #f5f5f5;
}

.product-search-item:last-child {
    border-bottom: none;
}

.product-search-no-result {
    padding: 10px 12px;
    color: #777;
}

</style>
<section class="section">
    <div class="section-header">
        <h1>Create PC Builder Product</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('builder-products.index') }}">
                    PC Builder
                </a>
            </div>
            <div class="breadcrumb-item active">
                Create PC Builder Product
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add PC Builder Product</h4>
                    </div>
                    <form action="{{ route('builder-products.store') }}" method="POST">
                        @csrf
                        <div class="card-body">
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <div class="d-flex align-items-center mb-2">
                                        <i class="fas fa-exclamation-triangle mr-2"></i>
                                        <strong>
                                            Please fix the following errors:
                                        </strong>
                                    </div>
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    {{ session('error') }}
                                </div>
                            @endif
                            <div class="row">
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label for="builder_type_id">
                                        PC Builder Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="builder_type_id"  name="builder_type_id" class="form-control @error('builder_type_id') is-invalid @enderror" required>
                                        <option value="">
                                            Select PC Builder Type
                                        </option>
                                        @foreach($builderTypes as $builderType)
                                            <option value="{{ $builderType->id }}" {{ old('builder_type_id') == $builderType->id ? 'selected' : '' }}>
                                                {{ $builderType->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('builder_type_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Select the PC Builder type for this product.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label for="product_type">
                                        Product Type
                                        <span class="text-danger">*</span>
                                    </label>
                                    <select id="product_type" name="product_type" class="form-control @error('product_type') is-invalid @enderror" required>
                                        <option value="">
                                            Select Product Type
                                        </option>
                                        @foreach($productTypes as $productType)
                                            <option value="{{ $productType }}" {{ old('product_type') == $productType ? 'selected' : '' }}>
                                                {{ $productType }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('product_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Select the type of component for the PC Builder.
                                    </small>
                                </div>
                                <div class="form-group col-lg-12 col-md-12 col-12">
                                    <label for="product_id">
                                        Product
                                        <span class="text-danger">*</span>
                                    </label>
                                    <div class="product-search-dropdown" id="productSearchDropdown">

                                    <input type="text"
                                        id="productSearchInput"
                                        class="form-control"
                                        placeholder="Search Product..."
                                        autocomplete="off">

                                    <input type="hidden"
                                        id="product_id"
                                        name="product_id"
                                        value="{{ old('product_id') }}">

                                    <div class="product-search-list" id="productSearchList">

                                        @foreach($products as $product)
                                            <div class="product-search-item"
                                                data-id="{{ $product->id }}"
                                                data-search="{{ strtolower($product->name . ' ' . $product->sku) }}">

                                                {{ $product->name }}

                                            </div>
                                        @endforeach

                                    </div>

                                </div>
                                    @error('product_id')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Select the product you want to add to this PC Builder.
                                    </small>
                                </div>
                                <div class="form-group col-lg-6 col-md-6 col-12">
                                    <label for="sort_order">
                                        Sort Order
                                    </label>
                                    <input type="number" id="sort_order"  name="sort_order" class="form-control @error('sort_order') is-invalid @enderror" value="{{ old('sort_order', 0) }}" min="0" placeholder="Enter sort order">
                                    @error('sort_order')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Lower numbers will appear first.
                                    </small>
                                </div>
                                <div class="col-lg-12 col-md-12 col-12">
                                    <div class="alert alert-light border">
                                        <div class="d-flex align-items-start">
                                            <div class="mr-3">
                                                <i class="fas fa-info-circle text-primary fa-lg"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1">
                                                    PC Builder Product
                                                </h6>
                                                <p class="mb-0 text-muted">
                                                    Select a PC Builder Type, Product Type,
                                                    and Product. Brand, Category, and Sub Category
                                                    are managed through the product itself.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('builder-products.index') }}" class="btn btn-secondary mr-2">
                                <i class="fas fa-arrow-left"></i>
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Product
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    $(document).ready(function () {
        $('#product_id').select2({
            placeholder: 'Select Product',
            allowClear: true,
            width: '100%'
        });
    });
</script>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        $('#builder_type_id').on('change', function () {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
        });
        $('#product_type').on('change', function () {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
        });
        $('#product_id').on('change', function () {
            if ($(this).val()) {
                $(this).removeClass('is-invalid');
            }
        });
        $('form').on('submit', function () {
            let form = $(this);
            let submitButton = form.find('button[type="submit"]');
            if (form.data('submitted')) {
                return false;
            }
            form.data('submitted', true);
            submitButton.prop('disabled', true);
            submitButton.html(
                '<i class="fas fa-spinner fa-spin"></i> Saving...'
            );
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const dropdown = document.getElementById('productSearchDropdown');
        const input = document.getElementById('productSearchInput');
        const hiddenInput = document.getElementById('product_id');
        const list = document.getElementById('productSearchList');
        const items = list.querySelectorAll('.product-search-item');

        input.addEventListener('focus', function () {
            list.style.display = 'block';
        });

        input.addEventListener('input', function () {

            const search = this.value.toLowerCase().trim();
            let found = false;

            items.forEach(function (item) {

                const text = item.getAttribute('data-search');

                if (text.includes(search)) {
                    item.style.display = 'block';
                    found = true;
                } else {
                    item.style.display = 'none';
                }

            });

            let noResult = list.querySelector('.product-search-no-result');

            if (!found) {

                if (!noResult) {
                    noResult = document.createElement('div');
                    noResult.className = 'product-search-no-result';
                    noResult.textContent = 'No products found';
                    list.appendChild(noResult);
                }

                noResult.style.display = 'block';

            } else if (noResult) {

                noResult.style.display = 'none';

            }

            list.style.display = 'block';
        });

        items.forEach(function (item) {

            item.addEventListener('click', function () {

                input.value = this.textContent.trim();
                hiddenInput.value = this.dataset.id;

                list.style.display = 'none';

            });

        });

        document.addEventListener('click', function (event) {

            if (!dropdown.contains(event.target)) {
                list.style.display = 'none';
            }

        });

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
@else
    @php
        abort(404);
    @endphp
@endcan
