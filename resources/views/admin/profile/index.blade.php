@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-header">
        <h1>My Profile</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item">
                <a href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <div class="breadcrumb-item active">
                Profile
            </div>
        </div>
    </div>
    <div class="section-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    {{ session('success') }}
                </div>
            </div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger alert-dismissible show fade">
                <div class="alert-body">
                    <button class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <div class="card">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            @if($user->profile)
                                <img src="{{ asset('storage/' . $user->profile) }}" alt="{{ $user->name }}" class="rounded-circle" style="width: 130px; height: 130px; object-fit: cover;">
                            @else
                                <img src="{{ asset('assets/img/user.png') }}" alt="Profile" class="rounded-circle" style="width: 130px; height: 130px; object-fit: cover;">
                            @endif
                        </div>
                        <h4 class="mb-1">{{ $user->name }}</h4>
                        <p class="text-muted mb-3">{{ $user->email }} </p>
                        @if($user->status)
                            <span class="badge badge-success">
                                Active
                            </span>
                        @else
                            <span class="badge badge-danger">
                                Inactive
                            </span>
                        @endif
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Account Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong>User Name</strong>
                            <p class="text-muted mb-0">{{ $user->name }}</p>
                        </div>
                        <div class="mb-3">
                            <strong>Created At</strong>
                            <p class="text-muted mb-0"> {{ $user->created_at ? $user->created_at->format('d M Y, h:i A') : '-' }}</p>
                        </div>
                        <div>
                            <strong>Last Updated</strong>
                            <p class="text-muted mb-0"> {{ $user->updated_at ? $user->updated_at->format('d M Y, h:i A') : '-' }} </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8 col-md-8 col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Profile Details</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Name</label>
                                    <input  type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <input type="email"name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Phone</label>
                                    <input  type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" placehold er="Enter phone number">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Gender</label>
                                    <select name="gender" class="form-control">
                                        <option value="">
                                            Select Gender
                                        </option>
                                        <option value="male"
                                            {{ old('gender', $user->gender) == 'male' ? 'selected' : '' }}>
                                            Male
                                        </option>
                                        <option value="female"
                                            {{ old('gender', $user->gender) == 'female' ? 'selected' : '' }}>
                                            Female
                                        </option>
                                        <option value="other"
                                            {{ old('gender', $user->gender) == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Birth Date</label>
                                    <input type="date" name="birth_date" class="form-control" value="{{ old('birth_date', $user->birth_date ? $user->birth_date->format('Y-m-d') : '') }}">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Profile Image</label>
                                    <input type="file" name="profile" class="form-control"  accept="image/*">
                                    <small class="form-text text-muted">
                                        JPG, JPEG, PNG or WEBP. Maximum 2MB.
                                    </small>
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Update Profile
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Security</h4>
                    </div>
                    <div class="card-body">
                        <p class="text-muted">
                            Update your account password to keep your account secure.
                        </p>
                        <a href="{{ route('password.index') }}" class="btn btn-warning"> <i class="fas fa-key"></i>Change Password</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection