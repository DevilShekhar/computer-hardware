@extends('designer.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>My Room Packs</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Room Packs</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <section class="section dashboard">
        <div class="row">

            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body">

                            <div class="row">
                                <div class="col-md-3">
                                    <a href="{{ route('room_packs.create') }}" class="mt-3 btn btn-primary">Upload New Room Pack</a>
                                </div>
                                <div class="col-md-9">
                                    <form action="{{ route('room_packs.index') }}" method="GET" class="mt-3">
                                        <div class="input-group">
                                            <input type="text" name="search" class="form-control" placeholder="Search by room pack name" value="{{ request()->query('search') }}">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-success" type="submit">Search</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <table class="table table-bordered mt-3">
                                <thead style="background-color: #f8f9fa;">
                                    <tr>
                                        <th>Sr. No.</th>
                                        <th>Room Pack Name</th>
                                        <th>Cover Render</th>
                                        <th>2D Drawing</th>
                                        <th>Decor/Material Chart</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($roomPacks as $pack)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <a href="{{ route('room_packs.show', $pack->id) }}">
                                                    {{ $pack->name }}
                                                </a>
                                            </td>
                                            <td>
                                                <img src="{{ asset('storage/' . $pack->cover_render) }}" width="100">
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $pack->pdf_2d_drawing) }}" target="_blank">View PDF</a>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $pack->decor_material_chart) }}" download>Download</a>
                                            </td>
                                            <td>
                                                <a href="{{ route('room_packs.edit', $pack->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                                <form action="{{ route('room_packs.destroy', $pack->id) }}" method="POST" style="display:inline-block;" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm">Delete</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="6">No Room Packs Found</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>

                            <div class="pagination d-flex justify-content-center mt-5">
                                @if ($roomPacks->onFirstPage())
                                    <span class="rounded">&laquo;</span>
                                @else
                                    <a href="{{ $roomPacks->previousPageUrl() }}" class="rounded">&laquo;</a>
                                @endif

                                @foreach ($roomPacks->links()->elements[0] as $page => $url)
                                    @if ($page == $roomPacks->currentPage())
                                        <a href="#" class="active rounded">{{ $page }}</a>
                                    @else
                                        <a href="{{ $url }}" class="rounded">{{ $page }}</a>
                                    @endif
                                @endforeach

                                @if ($roomPacks->hasMorePages())
                                    <a href="{{ $roomPacks->nextPageUrl() }}" class="rounded">&raquo;</a>
                                @else
                                    <span class="rounded">&raquo;</span>
                                @endif
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <style>
        .pagination {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1rem;
            font-family: Arial, sans-serif;
        }
        .pagination a {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            color: #007bff;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
            text-decoration: none;
            transition: background-color 0.2s, color 0.2s;
        }
        .pagination a:hover {
            background-color: #007bff;
            color: #fff;
        }
        .pagination .active {
            color: #fff;
            background-color: #007bff;
            border-color: #007bff;
        }
        .pagination span {
            display: inline-block;
            padding: 0.5rem 0.75rem;
            color: #6c757d;
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 0.25rem;
        }
        .pagination .rounded {
            border-radius: 50%;
            width: 2rem;
            height: 2rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>

    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: 'You won\'t be able to revert this!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
