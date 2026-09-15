@can('shipping-charge-create')
@extends('admin.layouts.app')

@section('content')
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Add Shipping Charge</h4>

                        <div class="card-header-action">
                            <a href="{{ route('shipping-charges.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('shipping-charges.store') }}" method="POST">
                            @csrf

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name <span class="text-danger">*</span></label>
                                    <input type="text"
                                        name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name') }}"
                                        placeholder="Enter shipping charge name">

                                    @error('name')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>State</label>
                                    <input type="text"
                                        name="state"
                                        class="form-control @error('state') is-invalid @enderror"
                                        value="{{ old('state') }}"
                                        placeholder="Enter state">

                                    @error('state')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>City</label>
                                    <input type="text"
                                        name="city"
                                        class="form-control @error('city') is-invalid @enderror"
                                        value="{{ old('city') }}"
                                        placeholder="Enter city">

                                    @error('city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Pincode</label>
                                    <input type="text"
                                        name="pincode"
                                        class="form-control @error('pincode') is-invalid @enderror"
                                        value="{{ old('pincode') }}"
                                        placeholder="Enter pincode">

                                    @error('pincode')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Shipping Charges <span class="text-danger">*</span></label>
                                    <input type="number"
                                        name="charges"
                                        class="form-control @error('charges') is-invalid @enderror"
                                        value="{{ old('charges') }}"
                                        placeholder="Enter shipping charges"
                                        min="0"
                                        step="0.01">

                                    @error('charges')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Save Shipping Charge
                                </button>

                                <a href="{{ route('shipping-charges.index') }}"
                                    class="btn btn-secondary">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@endcan
