@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Product Brand</h4>
                        <div class="card-header-action">
                            <a href="{{ route('product-brands.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('product-brands.update', $productBrand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Product Brand Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name', $productBrand->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter product brand name">

                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status"
                                        class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $productBrand->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $productBrand->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>

                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Product Brand Image</label>
                                    <input type="file"
                                        name="product_brand_image"
                                        class="form-control @error('product_brand_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">

                                    @error('product_brand_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>

                                    @if($productBrand->product_brand_image)
                                    <div class="mt-3">
                                        <img src="{{ asset('storage/' . $productBrand->product_brand_image) }}"
                                            alt="{{ $productBrand->name }}"
                                            width="100"
                                            height="100"
                                            class="rounded"
                                            style="object-fit: cover;">
                                    </div>
                                    @endif
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Meta Title</label>
                                    <input type="text"
                                        name="meta_title"
                                        value="{{ old('meta_title', $productBrand->meta_title) }}"
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
                                        value="{{ old('meta_keywords', $productBrand->meta_keywords) }}"
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
                                        placeholder="Enter meta description">{{ old('meta_description', $productBrand->meta_description) }}</textarea>

                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('product-brands.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Product Brand
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

@endpush