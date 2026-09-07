@extends('frontend.layouts.app')

@section('title', 'Privacy Policy')

@section('content')

<div class="breadcrumb-area">
    <div class="container">
        <div class="breadcrumb-content">
            <ul>
                <li><a href="{{ route('home') }}">Home</a></li>
                <li class="active">Privacy Policy</li>
            </ul>
        </div>
    </div>
</div>

<div class="privacy-policy-area pt-60 pb-60">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="privacy-policy-content">
                    <div class="li-section-title capitalize mb-25">
                        <h2><span>Privacy</span> Policy</h2>
                    </div>

                    <p>We respect your privacy and are committed to protecting your personal information. This Privacy
                        Policy explains how we collect, use, protect, and handle your information when you visit or use
                        our website.</p>

                    <h5>1. Information We Collect</h5>
                    <p>We may collect information that you provide directly to us when you create an account, place an
                        order, contact us, submit a review, or use other services available on our website.</p>

                    <p>This information may include your name, email address, phone number, billing address, shipping
                        address, account details, and order information.</p>

                    <h5>2. How We Use Your Information</h5>
                    <p>We use the information we collect to provide and improve our services, process and deliver
                        orders, manage your account, communicate with you, provide customer support, and maintain the
                        security of our website.</p>

                    <h5>3. Account Information</h5>
                    <p>If you create an account with us, you are responsible for keeping your login credentials
                        confidential. You should immediately contact us if you believe that your account has been
                        accessed without authorization.</p>

                    <h5>4. Order Information</h5>
                    <p>When you place an order, we use the information provided by you to process your purchase, arrange
                        delivery, communicate order updates, and provide after-sales support.</p>

                    <h5>5. Payment Information</h5>
                    <p>Payment information may be processed through secure payment service providers. We do not
                        knowingly store sensitive payment information such as complete card details on our website
                        unless required and permitted by applicable law.</p>

                    <h5>6. Cookies</h5>
                    <p>Our website may use cookies and similar technologies to improve website functionality, remember
                        preferences, understand website usage, and provide a better user experience.</p>

                    <h5>7. Product Reviews</h5>
                    <p>If you submit a product review or other public content, information associated with that
                        submission may be displayed publicly on our website. Please avoid including sensitive or private
                        information in reviews or other public submissions.</p>

                    <h5>8. Information Sharing</h5>
                    <p>We do not sell or rent your personal information. We may share necessary information with trusted
                        service providers, delivery partners, payment providers, or other parties when required to
                        provide our services, process transactions, or comply with legal obligations.</p>

                    <h5>9. Data Security</h5>
                    <p>We take reasonable measures to protect your personal information against unauthorized access,
                        misuse, alteration, disclosure, or destruction. However, no internet-based system can be
                        guaranteed to be completely secure.</p>

                    <h5>10. Third-Party Services</h5>
                    <p>Our website may use third-party services for payment processing, delivery, analytics,
                        authentication, or other functionality. These services may process information according to
                        their own privacy policies.</p>

                    <h5>11. Your Rights</h5>
                    <p>Depending on applicable laws, you may have rights regarding your personal information, including
                        the right to request access, correction, or deletion of certain information. You may contact us
                        to make such a request.</p>

                    <h5>12. Children's Privacy</h5>
                    <p>Our website is not intended to knowingly collect personal information from children without
                        appropriate consent. If you believe that a child has provided personal information to us, please
                        contact us so that appropriate action can be taken.</p>

                    <h5>13. Changes to This Privacy Policy</h5>
                    <p>We may update this Privacy Policy from time to time to reflect changes in our services, business
                        practices, or legal requirements. Any updated policy will be published on this page.</p>

                    <h5>14. Contact Us</h5>
                    <p>If you have any questions, concerns, or requests regarding this Privacy Policy or the handling of
                        your personal information, please contact our support team.</p>

                    <p><strong>Last Updated:</strong> {{ date('F d, Y') }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection