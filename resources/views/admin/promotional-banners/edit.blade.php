@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Promotional Banner</h4>
                        <div class="card-header-action">
                            <a href="{{ route('promotional-banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('promotional-banners.update', $promotionalBanner->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-8">
                                    <label>Title</label>
                                    <input type="text" name="title" value="{{ old('title', $promotionalBanner->title) }}" class="form-control @error('title') is-invalid @enderror" placeholder="Enter banner title">
                                    @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="form-group col-md-4">
                                    <label>Status</label>
                                    <select name="status" class="form-control @error('status') is-invalid @enderror">
                                        <option value="1" {{ old('status', $promotionalBanner->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $promotionalBanner->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Short Description</label>
                                    <textarea name="short_description" rows="3" class="form-control @error('short_description') is-invalid @enderror" placeholder="Enter short description">{{ old('short_description', $promotionalBanner->short_description) }}</textarea>
                                    @error('short_description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Button Text</label>
                                    <input type="text" name="button_text" value="{{ old('button_text', $promotionalBanner->button_text) }}" class="form-control @error('button_text') is-invalid @enderror" placeholder="Enter button text">
                                    @error('button_text')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Button URL</label>
                                    <input type="text" name="button_url" value="{{ old('button_url', $promotionalBanner->button_url) }}" class="form-control @error('button_url') is-invalid @enderror" placeholder="Enter button URL">
                                    @error('button_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Banner Image</label>
                                    <input type="file" name="image" id="bannerImage" class="form-control @error('image') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                                    @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="form-text text-muted">Maximum 2MB. Supported formats: JPG, JPEG, PNG, WEBP.</small>
                                    <div id="imagePreview" class="mt-3">
                                        @if($promotionalBanner->image)
                                            <div class="card" style="width:300px;">
                                                <div class="card-body p-2">
                                                    <img src="{{ asset('storage/' . $promotionalBanner->image) }}" alt="{{ $promotionalBanner->title ?? 'Banner' }}" class="img-fluid rounded" style="width:100%;height:150px;object-fit:cover;">
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('promotional-banners.index') }}" class="btn btn-secondary">Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Promotional Banner
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
$(document).ready(function(){
    $('#bannerImage').on('change',function(e){
        let file=e.target.files[0];
        $('#imagePreview').html('');
        if(file){
            let reader=new FileReader();
            reader.onload=function(e){
                $('#imagePreview').html('<div class="card" style="width:300px;"><div class="card-body p-2"><img src="'+e.target.result+'" class="img-fluid rounded" style="width:100%;height:150px;object-fit:cover;"></div></div>');
            };
            reader.readAsDataURL(file);
        }
    });
});
</script>
@endpush