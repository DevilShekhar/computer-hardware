@extends('designer.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>Edit Room Pack</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('room_packs.index') }}">Room Packs</a></li>
                <li class="breadcrumb-item active">Edit Room Pack</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('room_packs.update', $roomPack->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="mt-3 col-md-6 form-group">
                                        <label for="name">Room Pack Name</label>
                                        <input type="text" name="name" class="form-control" required value="{{ old('name', $roomPack->name) }}">
                                        @error('name')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mt-3 col-md-6 form-group">
                                        <label for="cover_render">Cover Render</label>
                                        <input type="file" name="cover_render" class="form-control">
                                        <small class="text-muted">Current:</small><br>
                                        <img src="{{ asset('storage/' . $roomPack->cover_render) }}" width="100">
                                        @error('cover_render')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mt-3 col-md-12 form-group">
                                        <label for="optional_renders">Optional Renders 
                                            <small class="text-muted">(Max 3 renders)</small>
                                        </label>

                                        <div id="optional_renders_container">
                                            <input type="file" name="optional_renders[]" class="form-control mb-2">
                                        </div>

                                        <button type="button" id="add_render_btn" class="btn btn-sm btn-secondary mt-2 mb-3">
                                            + Add More
                                        </button>

                                        @if(is_array($roomPack->optional_renders) && count($roomPack->optional_renders))
                                            <div class="mt-3">
                                                <small class="text-muted">Current Optional Renders:</small><br>
                                                @foreach($roomPack->optional_renders as $render)
                                                    <img src="{{ asset('storage/' . $render) }}" width="80" class="mb-2 me-2">
                                                @endforeach
                                            </div>
                                        @endif

                                        @error('optional_renders.*')
                                            <small class="text-danger d-block">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mt-3 col-md-6 form-group">
                                        <label for="pdf_2d_drawing">2D Drawing</label>
                                        <input type="file" name="pdf_2d_drawing" class="form-control">
                                        <small class="text-muted">Current:</small>
                                        <a href="{{ asset('storage/' . $roomPack->pdf_2d_drawing) }}" target="_blank">View PDF</a>
                                        @error('pdf_2d_drawing')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mt-3 col-md-6 form-group">
                                        <label for="decor_material_chart">Decor/Material Chart</label>
                                        <input type="file" name="decor_material_chart" class="form-control">
                                        <small class="text-muted">Current:</small>
                                        <a href="{{ asset('storage/' . $roomPack->decor_material_chart) }}" download>Download</a>
                                        @error('decor_material_chart')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary mt-4">Update Room Pack</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const container = document.getElementById('optional_renders_container');
        const addBtn = document.getElementById('add_render_btn');
        let count = 1;

        addBtn.addEventListener('click', function () {
            if (count >= 3) return;

            const input = document.createElement('input');
            input.type = 'file';
            input.name = 'optional_renders[]';
            input.className = 'form-control mb-2';
            container.appendChild(input);

            count++;
            if (count >= 3) {
                addBtn.disabled = true;
            }
        });
    });
</script>
@endsection


