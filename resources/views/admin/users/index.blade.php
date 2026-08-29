@extends('admin.layouts.app')

@section('content')

<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">

                    <div class="card-header">
                        <h4>User Listing</h4>

                        <div class="card-header-action">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Add User
                            </a>
                        </div>
                    </div>

                    <div class="card-body">

                        @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="close" data-dismiss="alert">
                                <span>&times;</span>
                            </button>
                        </div>
                        @endif

                        <div class="table-responsive">
                            <table class="table table-striped" id="table-1">

                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Profile</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Birth Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>

                                <tbody>

                                    @forelse($users as $user)

                                    <tr>
                                        <td class="text-center">
                                            {{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}
                                        </td>

                                        <td>
                                            @if($user->profile)
                                            <img alt="image" src="{{ asset('storage/' . $user->profile) }}" width="40"
                                                height="40" class="rounded-circle" style="object-fit: cover;">
                                            @else
                                            <img alt="image" src="{{ asset('assets/img/users/user-1.png') }}" width="40"
                                                height="40" class="rounded-circle">
                                            @endif
                                        </td>

                                        <td>
                                            <strong>{{ $user->name }}</strong>
                                        </td>

                                        <td>
                                            {{ $user->email }}
                                        </td>

                                        <td>
                                            {{ $user->phone ?? '-' }}
                                        </td>

                                        <td>
                                            {{ $user->gender ? ucfirst($user->gender) : '-' }}
                                        </td>

                                        <td>
                                            {{ $user->birth_date ? $user->birth_date->format('d-m-Y') : '-' }}
                                        </td>

                                        <td>
                                            @if($user->status)
                                            <div class="badge badge-success badge-shadow">
                                                Active
                                            </div>
                                            @else
                                            <div class="badge badge-danger badge-shadow">
                                                Inactive
                                            </div>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="dropdown">
                                                <a href="#" data-toggle="dropdown"
                                                    class="btn btn-primary dropdown-toggle">
                                                    Action
                                                </a>

                                                <div class="dropdown-menu">

                                                    <a href="{{ route('admin.users.show', $user->id) }}"
                                                        class="dropdown-item has-icon">
                                                        <i class="fas fa-eye"></i>
                                                        View
                                                    </a>

                                                    <a href="{{ route('admin.users.edit', $user->id) }}"
                                                        class="dropdown-item has-icon">
                                                        <i class="fas fa-edit"></i>
                                                        Edit
                                                    </a>

                                                    <div class="dropdown-divider"></div>

                                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this user?');">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
                                                            class="dropdown-item has-icon text-danger">
                                                            <i class="fas fa-trash"></i>
                                                            Delete
                                                        </button>

                                                    </form>

                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                    @empty

                                    <tr>
                                        <td colspan="9" class="text-center">
                                            No users found.
                                        </td>
                                    </tr>

                                    @endforelse

                                </tbody>

                            </table>
                        </div>

                        <div class="mt-3">
                            {{ $users->links() }}
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection