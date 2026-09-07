@extends('frontend.layouts.app')

@section('title', 'Terms and Conditions')

@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Terms and Conditions</li>
            </ul>
        </div>
    </div>
</div>

<div class="terms-condition-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="terms-condition-content">
                    <div class="li-section-title capitalize mb-25">
                        <h2><span>Terms</span> and Conditions</h2>
                    </div>

                    <p>Welcome to our website. By accessing or using our website, you agree to comply with and be bound
                        by these Terms and Conditions. Please read these terms carefully before using our website or
                        purchasing our products.</p>

                    <h5>1. Acceptance of Terms</h5>
                    <p>By accessing, browsing, registering an account, or purchasing products through our website, you
                        acknowledge that you have read, understood, and agreed to these Terms and Conditions.</p>

                    <h5>2. Use of Website</h5>
                    <p>You agree to use our website only for lawful purposes. You must not use the website in any way
                        that may damage, disable, overburden, or interfere with the proper operation of the website.</p>

                    <h5>3. User Account</h5>
                    <p>Some features of our website may require you to create an account. You are responsible for
                        providing accurate information and maintaining the confidentiality of your account credentials.
                    </p>

                    <p>You are responsible for all activities performed through your account. If you believe that your
                        account has been accessed without authorization, you should contact us immediately.</p>

                    <h5>4. Product Information</h5>
                    <p>We make reasonable efforts to ensure that product descriptions, images, specifications, prices,
                        and availability displayed on our website are accurate. However, minor differences may occur due
                        to product updates, manufacturer changes, or display settings.</p>

                    <h5>5. Product Availability</h5>
                    <p>All products are subject to availability. We reserve the right to limit quantities or discontinue
                        products without prior notice.</p>

                    <h5>6. Pricing</h5>
                    <p>Product prices displayed on the website are subject to change without prior notice. We reserve
                        the right to correct pricing errors, inaccuracies, or omissions, including after an order has
                        been submitted.</p>

                    <h5>7. Orders</h5>
                    <p>When you place an order, you agree to provide accurate billing, shipping, and contact
                        information. Placing an order does not necessarily guarantee acceptance. We reserve the right to
                        accept or cancel an order at our discretion.</p>

                    <h5>8. Payment</h5>
                    <p>All payments must be made using the payment methods available on our website. Payment information
                        may be processed securely through third-party payment service providers.</p>

                    <h5>9. Shipping and Delivery</h5>
                    <p>We aim to process and deliver orders within the estimated delivery period displayed during
                        checkout. Delivery times may vary depending on product availability, location, logistics
                        providers, weather conditions, and other circumstances beyond our control.</p>

                    <h5>10. Returns and Refunds</h5>
                    <p>Returns, replacements, and refunds are subject to our applicable return and refund policies.
                        Customers may be required to meet specific conditions before a return or refund can be approved.
                    </p>

                    <h5>11. Warranty</h5>
                    <p>Products may be covered by manufacturer or seller warranties where applicable. Warranty terms,
                        duration, and coverage may vary depending on the product and manufacturer.</p>

                    <h5>12. User Reviews</h5>
                    <p>Customers may submit product reviews and other content where this functionality is available.
                        Reviews should be honest, relevant, and respectful.</p>

                    <p>We reserve the right to remove content that is abusive, misleading, offensive, fraudulent, or
                        otherwise inappropriate.</p>

                    <h5>13. Intellectual Property</h5>
                    <p>All website content, including text, graphics, logos, images, product information, design
                        elements, and software, is protected by applicable intellectual property laws and may not be
                        copied, reproduced, distributed, or used without appropriate authorization.</p>

                    <h5>14. Third-Party Links</h5>
                    <p>Our website may contain links to third-party websites or services. We are not responsible for the
                        content, policies, availability, or practices of third-party websites.</p>

                    <h5>15. Limitation of Liability</h5>
                    <p>To the extent permitted by applicable law, we will not be responsible for indirect, incidental,
                        special, or consequential damages resulting from the use of our website or products.</p>

                    <h5>16. Changes to Terms</h5>
                    <p>We reserve the right to update or modify these Terms and Conditions at any time. Changes will
                        become effective when published on this page. Your continued use of the website after changes
                        are published constitutes acceptance of the updated terms.</p>

                    <h5>17. Governing Law</h5>
                    <p>These Terms and Conditions shall be governed by and interpreted according to the applicable laws
                        and regulations of the jurisdiction in which our business operates.</p>

                    <h5>18. Contact Us</h5>
                    <p>If you have any questions regarding these Terms and Conditions, please contact our support team.
                    </p>

                    <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection