@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h4>Edit Address</h4>

                        <div class="card-header-action">
                            <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <form action="{{ route('addresses.update', $address->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="card-body">

                            <div class="row">

                                <div class="form-group col-md-4">
                                    <label>
                                        Address Type
                                        <span class="text-danger">*</span>
                                    </label>

                                    <select name="address_type" class="form-control @error('address_type') is-invalid @enderror">
                                        <option value="home" {{ old('address_type', $address->address_type) == 'home' ? 'selected' : '' }}>Home</option>
                                        <option value="office" {{ old('address_type', $address->address_type) == 'office' ? 'selected' : '' }}>Office</option>
                                        <option value="other" {{ old('address_type', $address->address_type) == 'other' ? 'selected' : '' }}>Other</option>
                                    </select>

                                    @error('address_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Name</label>

                                    <input type="text"
                                        class="form-control"
                                        value="{{ $user->name }}"
                                        readonly>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>
                                        Mobile Number
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="mobile"
                                        value="{{ old('mobile', $address->mobile) }}"
                                        class="form-control @error('mobile') is-invalid @enderror"
                                        placeholder="Enter mobile number">

                                    @error('mobile')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-12">
                                    <label>
                                        Complete Address
                                        <span class="text-danger">*</span>
                                    </label>

                                    <textarea name="address"
                                        rows="4"
                                        class="form-control @error('address') is-invalid @enderror"
                                        placeholder="Enter complete address">{{ old('address', $address->address) }}</textarea>

                                    @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>
                                        City
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="city"
                                        value="{{ old('city', $address->city) }}"
                                        class="form-control @error('city') is-invalid @enderror"
                                        placeholder="Enter city">

                                    @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>
                                        State
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="state"
                                        value="{{ old('state', $address->state) }}"
                                        class="form-control @error('state') is-invalid @enderror"
                                        placeholder="Enter state">

                                    @error('state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>
                                        Country
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="country"
                                        value="{{ old('country', $address->country ?: 'India') }}"
                                        class="form-control @error('country') is-invalid @enderror"
                                        placeholder="Enter country">

                                    @error('country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-4">
                                    <label>
                                        Pin Code
                                        <span class="text-danger">*</span>
                                    </label>

                                    <input type="text"
                                        name="pincode"
                                        value="{{ old('pincode', $address->pincode) }}"
                                        class="form-control @error('pincode') is-invalid @enderror"
                                        placeholder="Enter pin code">

                                    @error('pincode')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-8">
                                    <label>Default Address</label>

                                    <div class="custom-control custom-checkbox mt-2">

                                        <input type="checkbox"
                                            name="is_default"
                                            value="1"
                                            class="custom-control-input"
                                            id="is_default"
                                            {{ old('is_default', $address->is_default) ? 'checked' : '' }}>

                                        <label class="custom-control-label" for="is_default">
                                            Mark this address as default
                                        </label>

                                    </div>
                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">

                            <a href="{{ route('addresses.index') }}" class="btn btn-secondary">
                                Cancel
                            </a>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Update Address
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
