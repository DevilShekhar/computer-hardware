@extends('frontend.layouts.app')
@section('title', $meta_title)
@section('meta_keyword', $meta_keyword)
@section('meta_description', $meta_description)
@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">About Us</li>
            </ul>
        </div>
    </div>
</div>

<div class="about-us-wrapper pt-60 pb-40">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6 order-last order-lg-first">
                <div class="about-text-wrap">
                    <h2><span>About</span> Our Company</h2>
                    <p>We are a trusted destination for computer hardware and technology products, offering a wide range
                        of quality components for gamers, professionals, businesses, PC enthusiasts, and everyday users.
                    </p>
                    <p>Our goal is to make purchasing computer hardware simple, transparent, and convenient. We focus on
                        providing genuine products, competitive pricing, reliable service, and a smooth shopping
                        experience.</p>
                    <p>From individual components to complete PC building solutions, we help our customers find the
                        right technology for their requirements and budget.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-10">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{ asset('assets/frontend/assets/images/product/large-size/aboutcompany.png') }}"
                        alt="About Our Company">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer-static-top">
    <div class="container">
        <div class="footer-shipping pt-60 pb-55 pb-xs-25">
            <div class="row">
                <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                    <div class="li-shipping-inner-box">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/frontend/assets/images/shipping-icon/1.png') }}"
                                alt="Free Delivery">
                        </div>
                        <div class="shipping-text">
                            <h2>Fast Delivery</h2>
                            <p>Get your computer products delivered quickly and safely to your doorstep.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 pb-sm-55 pb-xs-55">
                    <div class="li-shipping-inner-box">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/frontend/assets/images/shipping-icon/2.png') }}"
                                alt="Safe Payment">
                        </div>
                        <div class="shipping-text">
                            <h2>Safe Payment</h2>
                            <p>Shop securely with trusted and convenient payment methods.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                    <div class="li-shipping-inner-box">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/frontend/assets/images/shipping-icon/3.png') }}"
                                alt="Shop With Confidence">
                        </div>
                        <div class="shipping-text">
                            <h2>Shop With Confidence</h2>
                            <p>Quality products and dependable service to give you complete confidence.</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 col-sm-6 pb-xs-30">
                    <div class="li-shipping-inner-box">
                        <div class="shipping-icon">
                            <img src="{{ asset('assets/frontend/assets/images/shipping-icon/4.png') }}"
                                alt="Customer Support">
                        </div>
                        <div class="shipping-text">
                            <h2>Customer Support</h2>
                            <p>Have a question? Our team is ready to help you with your technology needs.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-vision-section pt-60 pb-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-text-wrap">
                    <h2><span>Our</span> Vision</h2>
                    <p>Our vision is to become a trusted and preferred destination for computer hardware and technology
                        products. We aim to create a platform where customers can easily discover, compare, and purchase
                        the right products for their needs.</p>
                    <p>We want to build long-term relationships with our customers by continuously improving our
                        products, services, technology, and overall shopping experience.</p>
                    <p>We envision a future where technology purchasing is simple, transparent, accessible, and
                        supported by dependable service.</p>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-10">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{ asset('assets/frontend/assets/images/product/large-size/vision.png') }}"
                        alt="Our Vision">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-mission-section pt-60 pb-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-10 mb-30 mb-lg-0">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{ asset('assets/frontend/assets/images/product/large-size/mission.png') }}"
                        alt="Our Mission">
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="about-text-wrap">
                    <h2><span>Our</span> Mission</h2>
                    <p>Our mission is to provide customers with quality computer products, honest information,
                        competitive prices, and dependable support.</p>
                    <p>We believe purchasing technology should be simple, transparent, and convenient. Our goal is to
                        help every customer find the right products according to their requirements and budget.</p>
                    <p>We are committed to creating a reliable shopping experience by offering genuine products, trusted
                        brands, helpful guidance, and customer-focused service.</p>
                    <ul class="mt-20">
                        <li><i class="fa fa-check"></i> Quality products at competitive prices</li>
                        <li><i class="fa fa-check"></i> Reliable customer support</li>
                        <li><i class="fa fa-check"></i> Genuine products from trusted brands</li>
                        <li><i class="fa fa-check"></i> Simple and convenient shopping</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-offer-section pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="li-section-title capitalize mb-40 text-center">
                    <h2><span>What We</span> Offer</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/1.png') }}"
                            alt="Computer Components">
                    </div>
                    <div class="shipping-text">
                        <h2>Computer Components</h2>
                        <p>Explore processors, graphics cards, motherboards, memory, storage, power supplies, cabinets,
                            and other essential computer hardware.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/2.png') }}"
                            alt="Gaming Hardware">
                    </div>
                    <div class="shipping-text">
                        <h2>Gaming Hardware</h2>
                        <p>Choose performance-focused hardware for gaming systems designed to deliver the performance
                            you need.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/3.png') }}" alt="PC Building">
                    </div>
                    <div class="shipping-text">
                        <h2>PC Building</h2>
                        <p>Build your ideal PC with compatible components selected according to your performance
                            requirements and budget.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-quality-section pt-60 pb-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="about-text-wrap">
                    <h2><span>Quality</span> Assurance</h2>
                    <p>Quality and reliability are important to us. We focus on offering genuine computer products from
                        trusted brands so our customers can purchase hardware with confidence.</p>
                    <p>We believe that a good product should deliver dependable performance, reliability, and value over
                        time.</p>
                    <p>Our commitment to quality extends from product selection to customer service, helping customers
                        make confident technology decisions.</p>
                </div>
            </div>
            <div class="col-lg-5 offset-lg-1 col-md-10">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{ asset('assets/frontend/assets/images/product/large-size/assurance.png') }}"
                        alt="Quality Assurance">
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-values-section pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="li-section-title capitalize mb-40 text-center">
                    <h2><span>Our</span> Values</h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/1.png') }}" alt="Trust">
                    </div>
                    <div class="shipping-text">
                        <h2>Trust & Transparency</h2>
                        <p>We believe in building long-term relationships through honest information, transparent
                            pricing, and dependable service.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/2.png') }}"
                            alt="Customer First">
                    </div>
                    <div class="shipping-text">
                        <h2>Customer First</h2>
                        <p>Our customers are at the center of our business. We continuously work to make their shopping
                            experience simple and satisfying.</p>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="li-shipping-inner-box mb-40">
                    <div class="shipping-icon">
                        <img src="{{ asset('assets/frontend/assets/images/shipping-icon/4.png') }}" alt="Improvement">
                    </div>
                    <div class="shipping-text">
                        <h2>Continuous Improvement</h2>
                        <p>We continuously improve our products, services, technology, and processes to provide better
                            value to our customers.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-pc-builder-section pt-60 pb-60">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-5 col-md-10 mb-30 mb-lg-0">
                <div class="about-image-wrap">
                    <img class="img-full" src="{{ asset('assets/frontend/assets/images/product/large-size/build.png') }}"
                        alt="PC Builder">
                </div>
            </div>
            <div class="col-lg-6 offset-lg-1">
                <div class="about-text-wrap">
                    <h2><span>Build Your</span> Perfect PC</h2>
                    <p>Choosing compatible components is one of the most important parts of building a PC. Our PC
                        Builder solution makes it easier to select components based on your requirements.</p>
                    <p>Whether you are building a gaming PC, workstation, office computer, or performance system, we
                        help make the PC building process easier and more convenient.</p>
                    <a href="{{ route('pc-builder.index') }}" class="li-btn-3">Start Building</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="about-customer-section pt-60 pb-60">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-9">
                <div class="about-text-wrap text-center">
                    <h2><span>Customer</span> Commitment</h2>
                    <p>We are committed to providing our customers with quality products, reliable service, helpful
                        support, and a convenient shopping experience.</p>
                    <p>Your trust motivates us to continuously improve and provide better technology solutions. We aim
                        to be your trusted technology partner for all your computer hardware needs.</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="counterup-area">
    <div class="container-fluid p-0">
        <div class="row no-gutters">
            <div class="col-lg-3 col-md-6">
                <!-- Begin Limupa Counter Area -->
                <div class="limupa-counter white-smoke-bg">
                    <div class="container">
                        <div class="counter-img">
                            <img src="{{ asset('assets/frontend/assets/images/about-us/icon/1.png')}}" alt="">
                        </div>
                        <div class="counter-info">
                            <div class="counter-number">
                                <h3 class="counter">2169</h3>
                            </div>
                            <div class="counter-text">
                                <span>HAPPY CUSTOMERS</span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/2.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">869</h3>
                        </div>
                        <div class="counter-text">
                            <span>AWARDS WINNED</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter white-smoke-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/3.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">689</h3>
                        </div>
                        <div class="counter-text">
                            <span>HOURS WORKED</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
            <div class="col-lg-3 col-md-6">
                <!-- Begin limupa Counter Area -->
                <div class="limupa-counter gray-bg">
                    <div class="counter-img">
                        <img src="{{ asset('assets/frontend/assets/images/about-us/icon/4.png')}}" alt="">
                    </div>
                    <div class="counter-info">
                        <div class="counter-number">
                            <h3 class="counter">2169</h3>
                        </div>
                        <div class="counter-text">
                            <span>COMPLETE PROJECTS</span>
                        </div>
                    </div>
                </div>
                <!-- limupa Counter Area End Here -->
            </div>
        </div>
    </div>
</div>

<div class="team-area pt-60 pt-sm-44">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="li-section-title capitalize mb-25">
                    <h2><span>Our Team</span></h2>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                    <div class="team-thumb">
                        <img src="{{ asset('assets/frontend/assets/images/team/1.png') }}" alt="Our Team Member">
                    </div>
                    <div class="team-content text-center">
                        <h3>Jonathan Scott</h3>
                        <p>IT Expert</p>
                        <a href="mailto:info@example.com">info@example.com</a>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-member mb-60 mb-sm-30 mb-xs-30">
                    <div class="team-thumb">
                        <img src="{{ asset('assets/frontend/assets/images/team/2.png') }}" alt="Our Team Member">
                    </div>
                    <div class="team-content text-center">
                        <h3>Oliver Bastin</h3>
                        <p>Web Designer</p>
                        <a href="mailto:info@example.com">info@example.com</a>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-member mb-30 mb-sm-60">
                    <div class="team-thumb">
                        <img src="{{ asset('assets/frontend/assets/images/team/3.png') }}" alt="Our Team Member">
                    </div>
                    <div class="team-content text-center">
                        <h3>Erik Jonson</h3>
                        <p>Web Developer</p>
                        <a href="mailto:info@example.com">info@example.com</a>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-6">
                <div class="team-member mb-30 mb-sm-60 mb-xs-60">
                    <div class="team-thumb">
                        <img src="{{ asset('assets/frontend/assets/images/team/4.png') }}" alt="Our Team Member">
                    </div>
                    <div class="team-content text-center">
                        <h3>Maria Mandy</h3>
                        <p>Marketing Officer</p>
                        <a href="mailto:info@example.com">info@example.com</a>
                        <div class="team-social">
                            <a href="#"><i class="fa fa-facebook"></i></a>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                            <a href="#"><i class="fa fa-linkedin"></i></a>
                            <a href="#"><i class="fa fa-google-plus"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection