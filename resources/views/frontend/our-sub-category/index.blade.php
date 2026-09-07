@extends('frontend.layouts.app')
@section('title', 'Our Sub Categories')
@section('content')
    <div class="breadcrumb-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="breadcrumb-content text-center">
                        <h2>Our Sub Categories</h2>
                        <ul>
                            <li>
                                <a href="{{ route('home') }}">Home</a>
                            </li>
                            <li class="active">
                                Our Sub Categories
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
                            <span>Our Sub Categories</span>
                        </h2>
                    </div>
                </div>
            </div>
            @if($subCategories->isNotEmpty())
                <div class="row">
                    @foreach($subCategories as $subCategory)
                        <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                                <div class="team-thumb">
                                    <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                        <img src="{{ $subCategory->sub_cat_image ? asset('storage/' . $subCategory->sub_cat_image) : asset('images/no-image.png') }}"
                                             alt="{{ $subCategory->name }}"
                                             style="width: 100%; height: 220px; object-fit: contain;">
                                    </a>
                                </div>
                                <div class="team-content text-center">
                                    <h3>
                                        <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                            {{ $subCategory->name }}
                                        </a>
                                    </h3>
                                    @if($subCategory->category)
                                        <p>
                                            {{ $subCategory->category->name }}
                                        </p>
                                    @endif
                                    <p>
                                        <a href="{{ route('our-sub-category.show', ['slug' => $subCategory->slug]) }}">
                                            View Products
                                        </a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @if($subCategories->hasPages())
                    <div class="paginatoin-area">
                        <div class="row">
                            <div class="col-lg-6 col-md-6">
                                <p>
                                    Showing
                                    {{ $subCategories->firstItem() }}
                                    -
                                    {{ $subCategories->lastItem() }}
                                    of
                                    {{ $subCategories->total() }}
                                    item(s)
                                </p>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <ul class="pagination-box">
                                    @if($subCategories->onFirstPage())
                                        <li>
                                            <span class="Previous disabled">
                                                <i class="fa fa-chevron-left"></i>
                                                Previous
                                            </span>
                                        </li>
                                    @else
                                        <li>
                                            <a href="{{ $subCategories->previousPageUrl() }}"
                                               class="Previous">
                                                <i class="fa fa-chevron-left"></i>
                                                Previous
                                            </a>
                                        </li>
                                    @endif
                                    @foreach($subCategories->getUrlRange(1, $subCategories->lastPage()) as $page => $url)
                                        @if($page == $subCategories->currentPage())
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
                                    @if($subCategories->hasMorePages())
                                        <li>
                                            <a href="{{ $subCategories->nextPageUrl() }}"
                                               class="Next">
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
                            <h3>No Sub Categories Available</h3>
                            <p>
                                There are currently no sub categories available.
                            </p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection