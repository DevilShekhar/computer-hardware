@extends('admin.layouts.app')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Change Password</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">  Dashboard</a>
            </div>
            <div class="breadcrumb-item">
                <a href="{{ route('profile') }}"> Profile </a>
            </div>
            <div class="breadcrumb-item active">
                Change Password
            </div>
        </div>
    </div>
    <div class="section-body">
        <div class="row">
            <div class="col-lg-6 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Verify Old Password</h4>
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
                        <form action="{{ route('password.verify') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label> Old Password</label>
                                <input  type="password" name="old_password" class="form-control @error('old_password') is-invalid @enderror" placeholder="Enter your old password" required autofocus >
                                @error('old_password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group mb-0">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-arrow-right"></i> Continue
                                </button>
                                <a href="{{ route('profile') }}" class="btn btn-secondary"> Cancel </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection