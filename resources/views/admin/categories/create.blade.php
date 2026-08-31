@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create Category</h4>
                        <div class="card-header-action">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Category Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        value="{{ old('name') }}"
                                        class="form-control @error('name') is-invalid @enderror"
                                        placeholder="Enter category name">
                                    @error('name')
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
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum size: 2MB.
                                    </small>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Meta Title</label>
                                    <input type="text"
                                        name="meta_title"
                                        value="{{ old('meta_title') }}"
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
                                        value="{{ old('meta_keywords') }}"
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
                                        placeholder="Enter meta description">{{ old('meta_description') }}</textarea>
                                    @error('meta_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Category
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