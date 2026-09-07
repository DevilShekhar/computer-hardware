@extends('frontend.layouts.app')

@section('title', 'Thank You')

@section('content')

<!-- Begin Breadcrumb Area -->

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li>
                    <a href="{{ url('/') }}">Home</a>
                </li>
                <li class="active">Thank You</li>
            </ul>
        </div>
    </div>
</div>
<!-- Breadcrumb Area End Here -->

<!-- Begin Thank You Page Area -->

<div class="contact-main-page mt-60 mb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-md-10">
                <div class="contact-form-content text-center">
                <div class="thank-you-content">

                    <h1 class="mb-20">
                        Thank You!
                    </h1>

                    <h3 class="contact-page-title">
                        Your message has been received.
                    </h3>

                    <p class="mb-30">
                        Thank you for contacting us. We have received your
                        message and will get back to you as soon as possible.
                    </p>

                    @if(session('success'))
                        <div class="alert alert-success mb-30">
                            {{ session('success') }}
                        </div>
                    @endif

                    <a href="{{ route('contact.index') }}" class="li-btn-3">
                        Back to Contact Us
                    </a>

                    <a href="{{ url('/') }}" class="li-btn-3 ml-10">
                        Back to Home
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>
</div>
<!-- Thank You Page Area End Here -->

@endsection
