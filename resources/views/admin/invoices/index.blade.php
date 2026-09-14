<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Invoice - {{ $order->order_number }}
    </title>
    <style>
    @page {
        size: A4;
        margin: 10mm;
    }
    * {
        box-sizing: border-box;
    }
    body {
        margin: 0;
        padding: 0;
        background: #ffffff;
        color: #1f2937;
        font-family: DejaVu Sans, Arial, Helvetica, sans-serif;
        font-size: 10px;
    }
    .invoice-wrapper {
        width: 100%;
        margin: 0 auto;
    }
    .header {
        width: 100%;
        margin-bottom: 14px;
    }
    .logo-section {
        width: 100%;
        text-align: center;
        padding-top: 2px;
    }
    .logo-section img {
        width: 150px;
        max-width: 150px;
        height: auto;
        display: inline-block;
    }
    .company-fallback {
        font-size: 25px;
        font-weight: bold;
        color: #07558e;
        line-height: 1.1;
    }
    .company-subtitle {
        margin-top: 3px;
        font-size: 8px;
        letter-spacing: 3px;
        color: #07558e;
        font-weight: 500;
    }
    .contact-section {
        width: 100%;
        text-align: center;
        margin-top: 9px;
    }
    .business-address {
        color: #07558e;
        font-size: 10px;
        margin-bottom: 6px;
    }
    .contact-row {
        width: 100%;
        text-align: center;
        white-space: nowrap;
    }
    .contact-item {
        display: inline-block;
        margin: 0 8px;
        color: #07558e;
        font-size: 9px;
    }
    .contact-icon {
        color: #07558e;
        font-weight: bold;
        margin-right: 4px;
    }
    .header-bottom {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }
    .header-bottom td {
        vertical-align: middle;
    }
    .invoice-number-cell {
        width: 50%;
        text-align: left;
        color: #07558e;
        font-size: 9px;
        padding-left: 2px;
    }
    .order-date-cell {
        width: 50%;
        text-align: right;
        color: #07558e;
        font-size: 9px;
        padding-right: 2px;
    }
    .header-label {
        font-weight: bold;
        margin-right: 7px;
        color: #07558e;
    }
    .header-value {
        color: #1f2937;
    }
    .header-icon {
        color: #07558e;
        margin-right: 5px;
        font-weight: bold;
    }
    .address-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 8px 0;
        margin-left: -8px;
        margin-bottom: 14px;
    }
    .address-box {
        width: 50%;
        border: 1px solid #d8e1e8;
        border-radius: 4px;
        vertical-align: top;
        padding: 0;
    }
    .address-title {
        background: #edf4f8;
        color: #07558e;
        font-weight: bold;
        font-size: 12px;
        padding: 8px 10px;
        border-bottom: 1px solid #d8e1e8;
    }
    .address-content {
        padding: 8px 10px;
        min-height: 84px;
        line-height: 1.55;
        color: #1f2937;
    }
    .address-name {
        font-weight: bold;
        color: #111827;
        margin-bottom: 2px;
    }
    .products-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 14px;
    }
    .products-table th {
        background: #07558e;
        color: #ffffff;
        border: 1px solid #d0dce5;
        padding: 7px 4px;
        text-align: center;
        font-size: 9px;
        font-weight: bold;
    }
    .products-table td {
        border: 1px solid #d7e0e7;
        padding: 6px 4px;
        vertical-align: middle;
        font-size: 8.5px;
    }
    .products-table tbody tr {
        page-break-inside: avoid;
    }
    .text-center {
        text-align: center;
    }
    .text-right {
        text-align: right;
    }
    .product-name {
        font-weight: bold;
        color: #172033;
        font-size: 9px;
    }
    .product-description {
        color: #667085;
        font-size: 7.5px;
        margin-top: 2px;
    }
    .amount {
        white-space: nowrap;
    }
    .summary-wrapper {
        width: 100%;
        margin-bottom: 14px;
    }
    .summary-table {
        width: 50%;
        margin-left: auto;
        border-collapse: collapse;
    }
    .summary-title {
        background: #07558e;
        color: #ffffff;
        padding: 7px 9px;
        font-size: 11px;
        font-weight: bold;
        text-align: left;
    }
    .summary-table td {
        border: 1px solid #d6e0e7;
        padding: 6px 8px;
        font-size: 9px;
    }
    .summary-label {
        width: 55%;
        color: #4b5563;
    }
    .summary-value {
        width: 45%;
        text-align: right;
        color: #172033;
        white-space: nowrap;
    }
    .discount-value {
        color: #b42318;
    }
    .gst-value {
        color: #07558e;
    }
    .grand-total-row td {
        background: #dff3fc;
        color: #064b82;
        font-size: 12px;
        font-weight: bold;
        padding: 8px;
    }
    .notes-box {
        border: 1px solid #d8e1e8;
        border-radius: 4px;
        margin-bottom: 15px;
        page-break-inside: avoid;
    }
    .notes-title {
        background: #edf4f8;
        color: #07558e;
        padding: 7px 9px;
        font-size: 11px;
        font-weight: bold;
    }
    .notes-content {
        padding: 7px 10px;
    }
    .notes-content ul {
        margin: 0;
        padding-left: 15px;
    }
    .notes-content li {
        margin-bottom: 3px;
        line-height: 1.3;
        font-size: 8.5px;
    }
    .features-table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
    }
    .feature {
        width: 25%;
        text-align: center;
        padding: 7px 5px;
        border-right: 1px solid #d7e0e7;
    }
    .feature:last-child {
        border-right: none;
    }
    .feature-icon {
        color: #07558e;
        font-size: 19px;
        font-weight: bold;
        margin-bottom: 3px;
    }
    .feature-title {
        color: #07558e;
        font-weight: bold;
        font-size: 8.5px;
        margin-bottom: 2px;
    }
    .feature-text {
        color: #596579;
        font-size: 7.5px;
    }
    .footer {
        background: #087fc1;
        color: #ffffff;
        text-align: center;
        padding: 10px;
        font-size: 10px;
        font-weight: bold;
        letter-spacing: 3px;
    }
    @media print {
        body {
            background: #ffffff;
        }
        .invoice-wrapper {
            width: 100%;
        }
    }
    </style>
</head>
<body>
    @php
        $logoPath = public_path('assets/img/logo.png');
        $logoBase64 = null;
        if (file_exists($logoPath)) {
            $logoExtension = strtolower(pathinfo($logoPath, PATHINFO_EXTENSION));
            $logoMime = match ($logoExtension) {
                'jpg','jpeg' => 'image/jpeg',
                'gif' => 'image/gif',
                'webp' => 'image/webp',
                default => 'image/png',
            };
            $logoBase64 = base64_encode(file_get_contents($logoPath));
        }
        $websiteUrl = rtrim(config('app.url'),'/');
        $calculatedSubtotal = 0;
        $calculatedGst = 0;
        foreach ($order->items as $item) {
            $itemQuantity = (int) $item->quantity;
            $itemPrice = (float) $item->price;
            $itemSubtotal = round($itemPrice * $itemQuantity,2);
            $gstRate = 0;
            $hasGst = $item->product &&
                strtolower(trim((string) $item->product->gst_type)) === 'yes';

            if ($hasGst && $item->product->gst) {
                $gstRate = (float) $item->product->gst->gst_amount;
            }

            $itemGst = 0;

            if ($hasGst && $gstRate > 0) {
                $itemGst = round(($itemSubtotal * $gstRate) / 100, 2);
            }

            $calculatedSubtotal += $itemSubtotal;
            $calculatedGst += $itemGst;
            }
        $invoiceSubtotal = round($calculatedSubtotal,2);
        $invoiceDiscount = (float) ($order->discount_amount ?? 0);
        $invoiceTaxableAmount = $invoiceSubtotal - $invoiceDiscount;
        if ($invoiceTaxableAmount < 0) { $invoiceTaxableAmount=0; } $invoiceShipping=(float) ( $order->shipping_amount ?? 0);
        $invoiceGst = round($calculatedGst,2);
        $invoiceGrandTotal = round(
        $invoiceTaxableAmount +
        $invoiceShipping + $invoiceGst, 2);
        $shippingName = $order->shipping_name ?: $order->customer_name;
        $shippingMobile = $order->shipping_mobile ?: $order->mobile_number;
        $shippingAddress = $order->shipping_address ?: $order->address;
        $shippingCity = $order->shipping_city ?: $order->city;
        $shippingState = $order->shipping_state ?: $order->state;
        $shippingPincode = $order->shipping_pincode ?: $order->pincode;
        $shippingCountry = $order->shipping_country ?: $order->country;
    @endphp
    <div class="invoice-wrapper">
        <div class="header">
            <div class="logo-section">
                    @if($logoBase64)
                    <img src="data:{{ $logoMime }};base64,{{ $logoBase64 }}" alt="{{ config('app.name') }}">
                    @else
                    <div class="company-fallback">
                        {{ config('app.name') }}
                    </div>
                    @endif                    
                </div>
                <div class="contact-section">
                    <div class="business-address">
                        Office No. 506, 5th Floor, Maruti Millennium Tower Maruti Chowk, Eternal HighTech Pvt. Ltd, Pune Banglore Highway Pashan Exit, next to Tata Showroom, Baner, Pune, Maharashtra 411045
                    </div>
                    <div class="contact-row">
                        <span class="contact-item">
                            <span class="contact-icon">
                                ☎
                            </span>
                            +91 97675 55737
                        </span>
                        <span class="contact-item">
                            <span class="contact-icon">
                                ✉
                            </span>
                            {{ config('mail.from.address') }}
                        </span>
                        <span class="contact-item">
                            <span class="contact-icon">
                                ◉
                            </span>
                            {{ $websiteUrl }}
                        </span>
                    </div>
                </div>
                <table class="header-bottom">
                    <tr>
                        <td class="invoice-number-cell">
                            <span class="header-icon">
                                ▣
                            </span>
                            <span class="header-label">
                                Invoice No:
                            </span>
                            <span class="header-value">
                                {{ $order->order_number }}
                            </span>
                        </td>
                        <td class="order-date-cell">
                            <span class="header-icon">
                                ⚙
                            </span>
                            <span class="header-label">
                                Order Date:
                            </span>
                            <span class="header-value">
                                {{ $order->created_at ? $order->created_at->format('d M Y'): '-' }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <table class="address-table">
                <tr>
                    <td class="address-box">
                        <div class="address-title">
                            ▣ &nbsp; BILL TO
                        </div>
                        <div class="address-content">
                            <div class="address-name">
                                {{ $order->customer_name }}
                            </div>
                            @if($order->email)
                            <div>
                                {{ $order->email }}
                            </div>
                            @endif
                            @if($order->mobile_number)
                            <div>
                                {{ $order->mobile_number }}
                            </div>
                            @endif
                            @if($order->address)
                            <div>
                                {{ $order->address }}
                            </div>
                            @endif
                            @if($order->city || $order->state || $order->pincode)
                            <div>
                                {{ $order->city }}
                                @if($order->city && $order->state) ,@endif
                                {{ $order->state }}
                                @if($order->pincode)
                                - {{ $order->pincode }}
                                @endif
                            </div>
                            @endif
                            @if($order->country)
                            <div>
                                {{ $order->country }}
                            </div>
                            @endif
                        </div>
                    </td>
                    <td class="address-box">
                        <div class="address-title">
                            ▣ &nbsp; SHIP TO
                        </div>
                        <div class="address-content">
                            <div class="address-name">
                                {{ $shippingName }}
                            </div>
                            @if($shippingMobile)
                            <div>
                                {{ $shippingMobile }}
                            </div>
                            @endif
                            @if($shippingAddress)
                            <div>
                                {{ $shippingAddress }}
                            </div>
                            @endif

                            @if( $shippingCity || $shippingState ||  $shippingPincode)
                            <div>
                                {{ $shippingCity }}
                                @if($shippingCity && $shippingState)
                                ,
                                @endif
                                {{ $shippingState }}
                                @if($shippingPincode)
                                - {{ $shippingPincode }}
                                @endif
                            </div>
                            @endif
                            @if($shippingCountry)
                            <div>
                                {{ $shippingCountry }}
                            </div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
            <table class="products-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">
                            #
                        </th>
                        <th style="width: 31%;">
                            Product
                        </th>
                        <th style="width: 12%;">
                            SKU
                        </th>
                        <th style="width: 7%;">
                            Qty
                        </th>
                        <th style="width: 12%;">
                            Unit Price
                        </th>
                        @php
                            $hasAnyGst = $order->items->contains(function ($item) {
                                return $item->product &&
                                    strtolower(trim((string) $item->product->gst_type)) === 'yes';
                            });
                        @endphp

                        @if($hasAnyGst)
                            <th style="width: 8%;">
                                GST
                            </th>

                            <th style="width: 13%;">
                                GST Amount
                            </th>
                        @endif
                        <th style="width: 12%;">
                            Total
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($order->items as $index => $item)
                    @php
                    $itemQuantity = (int)
                    $item->quantity;
                    $itemPrice = (float)
                    $item->price;
                    $itemSubtotal = round( $itemPrice * $itemQuantity, 2);
                    $gstRate = 0;
                    $hasGst = $item->product && strtolower(trim((string) $item->product->gst_type)) === 'yes';
                    if ($hasGst && $item->product->gst) {
                        $gstRate = (float) $item->product->gst->gst_amount;
                    }
                    $itemGst = 0;
                    if ($hasGst && $gstRate > 0) {
                        $itemGst = round(($itemSubtotal * $gstRate) / 100, 2);
                    }
                    $itemTotal = round($itemSubtotal + $itemGst, 2);
                    @endphp
                    <tr>                       
                        <td class="text-center">
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="product-name">
                                {{ $item->product_name }}
                            </div>
                            @if($item->product &&  $item->product->short_description )
                            <div class="product-description">
                                {{ \Illuminate\Support\Str::limit(
                                    strip_tags(
                                        $item->product->short_description
                                    ),
                                    70
                                ) }}
                            </div>
                            @endif
                        </td>
                        <td class="text-center">
                            {{ $item->sku ?: ($item->product->sku ?? '-') }}
                        </td>
                        <td class="text-center">
                            {{ $itemQuantity }}
                        </td>
                        <td class="text-right amount">
                            ₹{{ number_format($itemPrice, 2 ) }}
                        </td>
                        @if($hasAnyGst)
                        <td class="text-center">
                            @if($hasGst && $gstRate > 0)
                                {{ rtrim(rtrim(number_format($gstRate, 2), '0'), '.') }}%
                            @else
                                0%
                            @endif
                        </td>
                        <td class="text-right amount">
                            @if($hasGst && $itemGst > 0)
                                ₹{{ number_format($itemGst, 2) }}
                            @else
                                -
                            @endif
                        </td>
                        @endif
                        <td class="text-right amount">
                            ₹{{ number_format($itemTotal, 2) }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="{{ $hasAnyGst ? 8 : 6 }}" class="text-center">
                            No products found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="summary-wrapper">
                <table class="summary-table">
                    <tr>
                        <td colspan="2" class="summary-title">
                            ORDER SUMMARY
                        </td>
                    </tr>
                    <tr>
                        <td class="summary-label">
                            Subtotal
                        </td>
                        <td class="summary-value">
                            ₹{{ number_format($invoiceSubtotal, 2) }}
                        </td>
                    </tr>
                    @if($invoiceDiscount > 0)
                    <tr>
                        <td class="summary-label">
                            Discount
                        </td>
                        <td class="summary-value discount-value">
                            - ₹{{ number_format($invoiceDiscount,2) }}
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td class="summary-label">
                            Taxable Amount
                        </td>
                        <td class="summary-value">
                            ₹{{ number_format($invoiceTaxableAmount,2) }}
                        </td>
                    </tr>
                    @if($invoiceShipping > 0)
                    <tr>
                        <td class="summary-label">
                            Shipping Charges
                        </td>
                        <td class="summary-value">
                            ₹{{ number_format($invoiceShipping,2) }}
                        </td>
                    </tr>
                    @endif
                    @if($invoiceGst > 0)
                    <tr>
                        <td class="summary-label">
                            Total GST
                        </td>
                        <td class="summary-value gst-value">
                            ₹{{ number_format($invoiceGst,2) }}
                        </td>
                    </tr>
                    @endif
                    <tr class="grand-total-row">
                        <td>
                            Grand Total
                        </td>
                        <td class="text-right">
                            ₹{{ number_format($invoiceGrandTotal,2) }}
                        </td>
                    </tr>
                </table>
            </div>
            <div class="notes-box">
                <div class="notes-title">
                    ℹ &nbsp; IMPORTANT NOTES
                </div>
                <div class="notes-content">
                    <ul>
                        <li>
                            Products once sold are not returnable except as per applicable warranty policy.
                        </li>
                        <li>
                            Warranty is provided by the respective manufacturer.
                        </li>
                        <li>
                            Please retain this invoice for warranty and service claims.
                        </li>
                        <li>
                            This is a computer-generated invoice and does not require a signature.
                        </li>
                    </ul>
                </div>
            </div>
            <table class="features-table">
                <tr>
                    <td class="feature">
                        <div class="feature-icon">
                           ♢
                        </div>
                        <div class="feature-title">
                            GENUINE PRODUCTS
                        </div>
                        <div class="feature-text">
                            100% Original Products
                        </div>
                    </td>
                    <td class="feature">
                        <div class="feature-icon">
                            🚚
                        </div>
                        <div class="feature-title">
                            FAST DELIVERY
                        </div>
                        <div class="feature-text">
                            Safe & Secure Shipping
                        </div>
                    </td>
                    <td class="feature">
                        <div class="feature-icon">
                            ♧
                        </div>
                        <div class="feature-title">
                            EXPERT SUPPORT
                        </div>
                        <div class="feature-text">
                            Pre & Post Sales Support
                        </div>
                    </td>
                    <td class="feature">
                        <div class="feature-icon">
                           ⚙
                        </div>
                        <div class="feature-title">
                            BUILD A BETTER TOMORROW
                        </div>
                        <div class="feature-text">
                            Your Trusted IT Partner
                        </div>
                    </td>
                </tr>
            </table>
            <div class="footer">
                THANK YOU FOR YOUR BUSINESS!
            </div>
        </div>
    </div>
</body>
</html>