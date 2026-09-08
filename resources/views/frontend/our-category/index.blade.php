@extends('frontend.layouts.app')
@section('title', $meta_title)
@section('meta_keyword', $meta_keyword)
@section('meta_description', $meta_description)
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Our Categories</h2>
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="active">
                                Our Categories
                            </li>
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
                        <h2>
                            <span>Our Categories</span>
                        </h2>
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
                                            <img src="{{ $category->cat_image ? asset('storage/' . $category->cat_image) : asset('images/no-image.png') }}" alt="{{ $category->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                        @else
                                            <img src="{{ asset('images/no-image.png') }}" alt="{{ $category->name }}" style="width: 100%; height: 220px; object-fit: contain;">
                                        @endif
                                    </a>
                                </div>
                                <div class="team-content text-center">
                                    <h3>
                                        <a href="{{ route('our-category.show', ['slug' => $category->slug]) }}">
                                            {{ $category->name }}
                                        </a>
                                    </h3>
                                    <p>
                                        <a href="{{ route('our-category.show', ['slug' => $category->slug]) }}">
                                            View Products
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($categories->hasPages())
                    <div class="paginatoin-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p>
                                    Showing
                                    {{ $categories->firstItem() }}
                                    -
                                    {{ $categories->lastItem() }}
                                    of
                                    {{ $categories->total() }}
                                    item(s)
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <ul class="pagination-box">
                                    @if($categories->onFirstPage())
                                        <li>
                                            <span class="Previous disabled">
                                                <i class="fa fa-chevron-left"></i>
                                                Previous
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $categories->previousPageUrl() }}"  class="Previous">
                                                <i class="fa fa-chevron-left"></i>
                                                Previous
                                            </a>
                                        </li>
                                    @endif
                                    @foreach($categories->getUrlRange(1, $categories->lastPage()) as $page => $url)
                                        @if($page == $categories->currentPage())
                                            <li class="active">
                                                <a href="javascript:void(0);">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @else
                                            <li>
                                                <a href="{{ $url }}">
                                                    {{ $page }}
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                    @if($categories->hasMorePages())
                                        <li>
                                            <a href="{{ $categories->nextPageUrl() }}"  class="Next">
                                                Next
                                                <i class="fa fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    @else
                                        <li>
                                            <span class="Next disabled">
                                                Next
                                                <i class="fa fa-chevron-right"></i>
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif
            @else
                <div class="row">
                    <div class="col-12">
                        <div class="text-center pt-40 pb-60">
                            <h3>No Categories Available</h3>
                            <p>
                                There are currently no categories available.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection