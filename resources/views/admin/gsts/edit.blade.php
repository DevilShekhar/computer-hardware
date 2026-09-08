@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit GST</h4>
                        <div class="card-header-action">
                            <a href="{{ route('gsts.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>
                    <form action="{{ route('gsts.update', $gst->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label>
                                        GST Amount (%)
                                        <span class="text-danger">*</span>
                                    </label>
                                    <input type="number" name="gst_amount" value="{{ old('gst_amount', $gst->gst_amount) }}"
                                        class="form-control @error('gst_amount') is-invalid @enderror" placeholder="Enter GST percentage"
                                        min="0" max="100" step="0.01">
                                    @error('gst_amount')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <small class="form-text text-muted">
                                        Enter GST percentage, for example 5, 12, 18 or 28.
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer text-right">
                            <a href="{{ route('gsts.index') }}" class="btn btn-secondary"> Cancel</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update GST
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