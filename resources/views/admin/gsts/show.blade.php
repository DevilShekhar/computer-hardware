@can('gst-show')
@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>GST Details</h4>
                        <div class="card-header-action">
                            <a href="{{ route('gsts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label>GST Amount (%)</label>
                                <input type="text" class="form-control" value="{{ number_format($gst->gst_amount, 2) }}%" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Status</label>
                                <div class="form-control" style="height: auto; min-height: 38px;">
                                    @if($gst->status)
                                        <span class="badge badge-success badge-shadow">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge badge-danger badge-shadow">
                                            Inactive
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Created By</label>
                                <input type="text" class="form-control" value="{{ $gst->createdBy->name ?? '-' }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Updated By</label>
                                <input type="text" class="form-control" value="{{ $gst->updatedBy->name ?? '-' }}" readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Created At</label>
                                <input type="text" class="form-control" value="{{ $gst->created_at ? $gst->created_at->format('d-m-Y h:i A') : '-' }}"  readonly>
                            </div>
                            <div class="form-group col-md-6">
                                <label>Updated At</label>
                                <input type="text" class="form-control" value="{{ $gst->updated_at ? $gst->updated_at->format('d-m-Y h:i A') : '-' }}" readonly>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('gsts.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back
                        </a>
                        <a href="{{ route('gsts.edit', $gst->id) }}" class="btn btn-primary">
                            <i class="fas fa-edit"></i> Edit GST
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@else
    @php
        abort(404);
    @endphp
@endcan