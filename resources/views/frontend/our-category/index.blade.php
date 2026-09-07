@extends('frontend.layouts.app')
@section('title', 'Our Categories')
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Our Categories</h2>
                        <ul>
                            <li><a href="{{ route('home') }}">Home</a></li>
                            <li class="active">Our Categories</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="team-area pt-60 pt-sm-44">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="li-section-title capitalize mb-25">
                        <h2><span>Our Categories</span></h2>
                    </div>
                </div>
            </div>
            @if($categories->isNotEmpty())
                <div class="row">
                    @foreach($categories as $category)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                                <div class="team-thumb">
                                    <a href="{{ route('our-category.show', ['slug' => $category->slug]) }}">
                                        @if($category->cat_image)
                                            <img src="{{ asset('storage/' . $category->cat_image) }}" alt="{{ $category->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="{{ $category->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                        @endif
                                    </a>
                                </div>
                                <div class="team-content text-center">
                                    <h3>
                                        <a href="{{ route('our-category.show', ['slug' => $category->slug]) }}">{{ $category->name }}</a>
                                    </h3>
                                    <p>
                                        <a href="{{ route('our-category.show', ['slug' => $category->slug]) }}">View Products</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center pt-40 pb-60">
                            <h3>No Categories Available</h3>
                            <p>There are currently no categories available.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection