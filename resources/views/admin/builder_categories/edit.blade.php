@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Builder Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('builder-categories.update', $builderCategory->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Brand <span class="text-danger">*</span></label>
                                    <select name="brand_id" class="form-control @error('brand_id') is-invalid @enderror">
                                        <option value="">Select Brand</option>
                                        @foreach($builderBrands as $brand)
                                        <option value="{{ $brand->id }}" {{ old('brand_id', $builderCategory->brand_id) == $brand->id ? 'selected' : '' }}>
                                            {{ $brand->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('brand_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Category Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name', $builderCategory->name) }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter category name">
                                    @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Slug</label>
                                    <input type="text"
                                        name="slug"
                                        value="{{ old('slug', $builderCategory->slug) }}"
                                        class="form-control @error('slug') is-invalid @enderror"
                                        placeholder="Enter slug">
                                    @error('slug')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Status <span class="text-danger">*</span></label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $builderCategory->status) == 1 ? 'selected' : '' }}>
                                            Active
                                        </option>
                                        <option value="0" {{ old('status', $builderCategory->status) == 0 ? 'selected' : '' }}>
                                            Inactive
                                        </option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Category Image</label>
                                    <input type="file"
                                        name="cat_image"
                                        class="form-control @error('cat_image') is-invalid @enderror"
                                        accept=".jpg,.jpeg,.png,.webp">
                                    @error('cat_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    @if($builderCategory->cat_image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $builderCategory->cat_image) }}"
                                            alt="{{ $builderCategory->name }}"
                                            width="100"
                                            height="100"
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
                                        value="{{ old('meta_title', $builderCategory->meta_title ?? '') }}"
                                        class="form-control @error('meta_title') is-invalid @enderror"
                                        placeholder="Enter meta title">
                                    @error('meta_title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Meta Keyword</label>
                                    <input type="text"
                                        name="meta_keyword"
                                        value="{{ old('meta_keyword', $builderCategory->meta_keyword ?? '') }}"
                                        class="form-control @error('meta_keyword') is-invalid @enderror"
                                        placeholder="Enter meta keywords">
                                    @error('meta_keyword')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Meta Description</label>
                                    <textarea name="meta_description"
                                        rows="4"
                                        class="form-control @error('meta_description') is-invalid @enderror"
                                        placeholder="Enter meta description">{{ old('meta_description', $builderCategory->meta_description ?? '') }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="card-footer text-right">
                            <a href="{{ route('builder-categories.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Category
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