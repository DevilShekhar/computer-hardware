@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create PC Builder Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-categories.index') }}"
                                class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i>
                                Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('builder-categories.store') }}"  method="POST" enctype="multipart/form-data">
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
                                        @foreach($builderTypes as $builderType)
                                            <option value="{{ $builderType->id }}"
                                                {{ old('builder_type_id') == $builderType->id ? 'selected' : '' }}>
                                                {{ $builderType->name }}
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
                                    <select name="brand_id" id="brand_id"  class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">
                                            Select Brand
                                        </option>
                                        @foreach($builderBrands as $brand)
                                            <option value="{{ $brand->id }}"
                                                data-builder-type="{{ $brand->builder_type_id }}"
                                                {{ old('brand_id') == $brand->id ? 'selected' : '' }}>
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
                                    <input type="text" id="name"  name="name" value="{{ old('name') }}" class="form-control @error('name') is-invalid @enderror"  placeholder="Enter category name">
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
                                    <input type="file"  id="cat_image" name="cat_image"  class="form-control @error('cat_image') is-invalid @enderror"  accept=".jpg,.jpeg,.png,.webp">
                                    @error('cat_image')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP.
                                        Maximum size: 2MB.
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="meta_title">
                                        Meta Title
                                    </label>
                                    <input type="text" id="meta_title" name="meta_title" value="{{ old('meta_title') }}" class="form-control @error('meta_title') is-invalid @enderror" placeholder="Enter meta title">
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
                                    <input type="text" id="meta_keywords" name="meta_keywords"  value="{{ old('meta_keywords') }}"  class="form-control @error('meta_keywords') is-invalid @enderror" placeholder="Enter meta keywords">
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
                                    <textarea id="meta_description" name="meta_description" rows="4" class="form-control @error('meta_description') is-invalid @enderror" placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('builder-categories.index') }}"
                                class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit"
                                class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Save Category
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
    $(document).ready(function () {
        let oldBuilderType = "{{ old('builder_type_id') }}";
        let oldBrand = "{{ old('brand_id') }}";
        function filterBrands() {
            let builderTypeId = $('#builder_type_id').val();
            let brandSelect = $('#brand_id');
            brandSelect.find('option').each(function () {
                let option = $(this);
                if (option.val() === '') {
                    option.show();
                    return;
                }
                let brandTypeId = option.data('builder-type');
                if (
                    builderTypeId &&
                    String(brandTypeId) === String(builderTypeId)
                ) {
                    option.show();
                } else {
                    option.hide();
                }
            });
            /*
            |--------------------------------------------------------------------------
            | Reset Brand
            |--------------------------------------------------------------------------
            */
            let selectedBrand = brandSelect.val();
            if (selectedBrand) {
                let selectedOption = brandSelect
                    .find('option:selected');
                if (
                    String(selectedOption.data('builder-type')) !==
                    String(builderTypeId)
                ) {
                    brandSelect.val('');
                }
            }
        }
        /*
        |--------------------------------------------------------------------------
        | Builder Type Change
        |--------------------------------------------------------------------------
        */
        $('#builder_type_id').on('change', function () {
            filterBrands();
            $('#brand_id').val('');
        });
        /*
        |--------------------------------------------------------------------------
        | Initial Load
        |--------------------------------------------------------------------------
        */

        if (oldBuilderType) {
            $('#builder_type_id').val(oldBuilderType);
            filterBrands();
            if (oldBrand) {
                $('#brand_id').val(oldBrand);
            }
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