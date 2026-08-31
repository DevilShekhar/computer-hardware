@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Set New Password</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('dashboard') }}"> Dashboard </a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('profile') }}"> Profile </a>
            </div>
            <div class="breadcrumb-item active">
                New Password
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create New Password</h4>
                    </div>
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
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>New Password </label>
                                <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter new password" required autofocus>
                                @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <small class="form-text text-muted">
                                    Password must be at least 8 characters.
                                </small>
                            </div>
                            <div class="form-group">
                                <label> Confirm New Password</label>
                                <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm new password" required>
                            </div>
                            <div class="form-group mb-0">
                                <button  type="submit" class="btn btn-success">
                                    <i class="fas fa-check"></i>
                                    Update Password
                                </button>
                                <a href="{{ route('profile') }}" class="btn btn-secondary">
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