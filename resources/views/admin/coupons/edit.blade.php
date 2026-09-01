@extends('admin.layouts.app')
@section('title', 'Edit Coupon')

@section('content')

<section class="section">
    <div class="section-body">

        <div class="row">

            <div class="col-12">

                <div class="card">

                    <div class="card-header">
                        <h4>Edit Coupon</h4>

                        <div class="card-header-action">
                            <a href="{{ route('coupons.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </div>

                    <form id="coupon-edit-form" method="POST" action="{{ route('coupons.update', $coupon->id) }}">
                        @csrf
                        @method('PUT')

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

                            <div class="section-title mt-0">
                                Coupon Information
                            </div>

                            <div class="form-row">


                                    <div class="form-group col-md-6">
                                        <label for="product_id">
                                            Product
                                        </label>

                                        <select name="product_id" id="product_id"
                                            class="form-control @error('product_id') is-invalid @enderror">
                                            <option value="">All Products</option>

                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    @selected(old('product_id', $coupon->product_id) == $product->id)>
                                                    {{ $product->name }} - {{ $product->sku }}
                                                </option>
                                            @endforeach
                                        </select>

                                        @error('product_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                <div class="form-group col-md-6">
                                    <label for="code">
                                        Coupon Code <span class="text-danger">*</span>
                                    </label>

                                    <input type="text" name="code" id="code"
                                        class="form-control @error('code') is-invalid @enderror"
                                        value="{{ old('code', $coupon->code) }}" placeholder="Enter Coupon Code" required>

                                    @error('code')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="discount_type">
                                        Discount Type <span class="text-danger">*</span>
                                    </label>

                                    <select name="discount_type" id="discount_type"
                                        class="form-control @error('discount_type') is-invalid @enderror" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="percentage" {{ old('discount_type', $coupon->discount_type) == 'percentage' ? 'selected' : '' }}>Percentage</option>
                                        <option value="flat" {{ old('discount_type', $coupon->discount_type) == 'flat' ? 'selected' : '' }}>Flat</option>
                                    </select>

                                    @error('discount_type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="discount_value">
                                        Discount Value <span class="text-danger">*</span>
                                    </label>

                                    <input type="number" name="discount_value" id="discount_value"
                                        class="form-control @error('discount_value') is-invalid @enderror"
                                        value="{{ old('discount_value', $coupon->discount_value) }}"
                                        placeholder="Enter Discount Value" min="0" step="0.01" required>

                                    @error('discount_value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="minimum_order_value">
                                        Minimum Order Value
                                    </label>

                                    <input type="number" name="minimum_order_value" id="minimum_order_value"
                                        class="form-control @error('minimum_order_value') is-invalid @enderror"
                                        value="{{ old('minimum_order_value', $coupon->minimum_order_value) }}"
                                        placeholder="Enter Minimum Order Value" min="0" step="0.01">

                                    @error('minimum_order_value')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="usage_limit">
                                        Usage Limit
                                    </label>

                                    <input type="number" name="usage_limit" id="usage_limit"
                                        class="form-control @error('usage_limit') is-invalid @enderror"
                                        value="{{ old('usage_limit', $coupon->usage_limit) }}"
                                        placeholder="Enter Usage Limit" min="1">

                                    @error('usage_limit')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="start_date">
                                        Start Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="start_date" id="start_date"
                                        class="form-control @error('start_date') is-invalid @enderror"
                                        value="{{ old('start_date', $coupon->start_date?->format('Y-m-d')) }}" required>

                                    @error('start_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label for="end_date">
                                        End Date <span class="text-danger">*</span>
                                    </label>

                                    <input type="date" name="end_date" id="end_date"
                                        class="form-control @error('end_date') is-invalid @enderror"
                                        value="{{ old('end_date', $coupon->end_date?->format('Y-m-d')) }}" required>

                                    @error('end_date')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="form-group col-md-6">
                                    <label for="status">
                                        Status <span class="text-danger">*</span>
                                    </label>

                                    <select name="status" id="status"
                                        class="form-control @error('status') is-invalid @enderror" required>
                                        <option value="1" {{ old('status', $coupon->status) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('status', $coupon->status) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>

                                    @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                            <div class="form-row">

                                <div class="form-group col-md-12">
                                    <label for="description">
                                        Description
                                    </label>

                                    <textarea name="description" id="description"
                                        class="form-control @error('description') is-invalid @enderror"
                                        rows="4"
                                        placeholder="Enter Coupon Description">{{ old('description', $coupon->description) }}</textarea>

                                    @error('description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                            </div>

                        </div>

                        <div class="card-footer text-right">

                            <a href="{{ route('coupons.index') }}" class="btn btn-secondary mr-1">
                                Cancel
                            </a>

                            <button type="reset" class="btn btn-light mr-1">
                                Reset
                            </button>

                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i>
                                Update Coupon
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>
</section>

@endsection
