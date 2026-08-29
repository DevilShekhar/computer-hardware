@extends('designer.layouts.app')

@section('content')
    <div class="pagetitle">
        <h1>View Room Pack</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('room_packs.index') }}">Room Packs</a></li>
                <li class="breadcrumb-item active">View Room Pack</li>
            </ol>
        </nav>
    </div><!-- End Page Title -->

    <section class="section dashboard">
        <div class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="card info-card customers-card">
                        <div class="card-body">

                            <h5 class="card-title">{{ $roomPack->name }}</h5>

                            <div class="row">
                                <div class="mt-3 col-md-6">
                                    <label><strong>Cover Render:</strong></label><br>
                                    <img src="{{ asset('storage/' . $roomPack->cover_render) }}" width="200" class="mb-2">
                                </div>

                                <div class="mt-3 col-md-6">
                                    <label><strong>2D Drawing:</strong></label><br>
                                    <a href="{{ asset('storage/' . $roomPack->pdf_2d_drawing) }}" target="_blank">View PDF</a>
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-3 col-md-12">
                                    <label><strong>Optional Renders:</strong></label><br>
                                    @if(is_array($roomPack->optional_renders) && count($roomPack->optional_renders))
                                        @foreach($roomPack->optional_renders as $render)
                                            <img src="{{ asset('storage/' . $render) }}" width="100" class="mb-2 me-2">
                                        @endforeach
                                    @else
                                        <p class="text-muted">No Optional Renders Uploaded.</p>
                                    @endif
                                </div>
                            </div>

                            <div class="row">
                                <div class="mt-3 col-md-6">
                                    <label><strong>Decor/Material Chart:</strong></label><br>
                                    <a href="{{ asset('storage/' . $roomPack->decor_material_chart) }}" download>Download Chart</a>
                                </div>
                            </div>

                            <a href="{{ route('room_packs.index') }}" class="btn btn-secondary mt-4">Back to List</a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
