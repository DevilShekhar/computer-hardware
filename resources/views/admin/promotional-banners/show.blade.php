@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Promotional Banner Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('promotional-banners.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>Title</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->title ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <div>
                                    @if($promotionalBanner->status)
                                        <span class="badge badge-success badge-shadow">Active</span>
                                    @else
                                        <span class="badge badge-danger badge-shadow">Inactive</span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Short Description</label>
                                <div class="form-control bg-light" style="height:auto;min-height:80px;">
                                    {{ $promotionalBanner->short_description ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Button Text</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->button_text ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Button URL</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->button_url ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label>Banner Image</label>
                                @if($promotionalBanner->image)
                                    <div class="mt-2">
                                        <img src="{{ asset('storage/' . $promotionalBanner->image) }}" alt="{{ $promotionalBanner->title ?? 'Banner' }}" class="img-fluid rounded" style="max-width:600px;max-height:300px;object-fit:cover;">
                                    </div>
                                @else
                                    <div class="text-muted">No Image</div>
                                @endif
                            </div>
                            <div class="form-group col-md-6">
                                <label>Created By</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->createdBy->name ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Updated By</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->updatedBy->name ?? '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Created At</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->created_at ? $promotionalBanner->created_at->format('d-m-Y H:i:s') : '-' }}
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Updated At</label>
                                <div class="form-control bg-light">
                                    {{ $promotionalBanner->updated_at ? $promotionalBanner->updated_at->format('d-m-Y H:i:s') : '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('promotional-banners.edit', $promotionalBanner->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('promotional-banners.index') }}" class="btn btn-secondary">
                            Back
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection