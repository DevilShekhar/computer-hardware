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
                <li class="active">Disclaimer</li>
            </ul>
        </div>
    </div>
</div>

<div class="disclaimer-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="disclaimer-content">
                    <div class="li-section-title capitalize mb-25">
                        <h2><span>Website</span> Disclaimer</h2>
                    </div>

                    <p>The information provided on this website is intended for general informational and shopping
                        purposes. While we make reasonable efforts to ensure that the information displayed on our
                        website is accurate and up to date, we do not guarantee that all information is complete,
                        accurate, or error-free at all times.</p>

                    <h5>1. General Information</h5>
                    <p>Product descriptions, specifications, images, prices, availability, features, and other
                        information displayed on our website are provided for general reference. Product specifications
                        and features may change based on updates provided by manufacturers or suppliers.</p>

                    <h5>2. Product Images</h5>
                    <p>We make reasonable efforts to display product images accurately. However, actual product
                        appearance, packaging, colors, accessories, and other visual details may vary from the images
                        shown on the website.</p>

                    <h5>3. Product Specifications</h5>
                    <p>Computer hardware specifications may change without prior notice due to manufacturer revisions,
                        model updates, regional variations, or product availability. Customers should verify important
                        specifications before purchasing.</p>

                    <h5>4. Pricing and Availability</h5>
                    <p>Prices and product availability displayed on the website are subject to change without prior
                        notice. Although we make efforts to maintain accurate pricing and stock information, errors may
                        occasionally occur.</p>

                    <h5>5. Performance Information</h5>
                    <p>Any performance information, benchmarks, comparisons, recommendations, or technical information
                        provided on the website is intended for general guidance only. Actual performance may vary
                        depending on system configuration, software, drivers, usage conditions, and other factors.</p>

                    <h5>6. PC Building Information</h5>
                    <p>Information provided through our PC Builder and related services is intended to assist customers
                        in selecting computer components. Customers should verify compatibility, specifications,
                        dimensions, power requirements, and other technical requirements before completing a purchase or
                        assembling a system.</p>

                    <h5>7. Third-Party Information</h5>
                    <p>Our website may contain information, links, specifications, trademarks, or references belonging
                        to third-party manufacturers, brands, payment providers, logistics providers, or other
                        organizations. We do not claim ownership of third-party trademarks or intellectual property.</p>

                    <h5>8. External Links</h5>
                    <p>Our website may contain links to external websites or services. These links are provided for
                        convenience and informational purposes. We are not responsible for the content, accuracy,
                        availability, security, or privacy practices of external websites.</p>

                    <h5>9. Professional Advice</h5>
                    <p>Information available on this website should not be considered professional, technical,
                        financial, legal, or other specialized advice. Customers should seek appropriate professional or
                        technical assistance where necessary.</p>

                    <h5>10. Website Availability</h5>
                    <p>We make reasonable efforts to keep our website available and functioning properly. However, we do
                        not guarantee uninterrupted access to the website. Temporary interruptions may occur due to
                        maintenance, technical problems, network issues, or circumstances beyond our control.</p>

                    <h5>11. Limitation of Responsibility</h5>
                    <p>To the extent permitted by applicable law, we are not responsible for losses or damages arising
                        from reliance on information provided on the website, including errors, omissions, temporary
                        unavailability, product information changes, or third-party content.</p>

                    <h5>12. Changes to This Disclaimer</h5>
                    <p>We reserve the right to update or modify this Disclaimer at any time. Any changes will be
                        published on this page and will become effective when posted.</p>

                    <h5>13. Contact Us</h5>
                    <p>If you have any questions regarding this Disclaimer or any information provided on our website,
                        please contact our support team.</p>

                    <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection