@extends('frontend.layouts.app')

@section('content')

<div class="pc-builder-page">
    <div class="container">

        <div class="pc-builder-title">
            <h1>{{ $builderType->name }}</h1>
            <p>Build your {{ $builderType->name }}.</p>
        </div>

        <div class="pc-builder-content">

            @if($builderType->image)
                <div class="pc-builder-main-image">
                    <img
                        src="{{ asset('storage/' . $builderType->image) }}"
                        alt="{{ $builderType->name }}"
                    >
                </div>
            @endif

            <div class="pc-builder-start">
                <h2>Build Your {{ $builderType->name }}</h2>

                <p>
                    Select your components and create your custom PC.
                </p>

                <a href="#" class="btn btn-primary">
                    Start Building
                </a>
            </div>

        </div>

    </div>
</div>

@endsection