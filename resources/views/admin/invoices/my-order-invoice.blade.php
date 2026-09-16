<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>
        Order #{{ $order->order_number }}
    </title>
    <style>
        @page {
            margin: 28px 48px 35px 48px;
        }

        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            background: #ffffff;
            color: #222222;
            font-family: DejaVu Sans, Arial, sans-serif;
            font-size: 10px;
            line-height: 1.45;
        }
        .invoice {
            width: 100%;
        }
        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }
        .header {
            width: 100%;
            padding-bottom: 18px;
            border-bottom: 1px solid #dddddd;
        }
        .header-left {
            float: left;
            width: 62%;
        }
        .header-right {
            float: right;
            width: 38%;
            text-align: right;
            padding-top: 27px;
        }
        .logo {
            display: block;
            width: auto;
            max-width: 105px;
            max-height: 70px;
            margin-bottom: 12px;
        }
        .company-fallback {
            width: 105px;
            height: 55px;
            font-size: 16px;
            font-weight: bold;
            line-height: 55px;
            margin-bottom: 12px;
        }
        .company-details {
            width: 100%;
            font-size: 8.8px;
            color: #555555;
            line-height: 1.65;
        }
        .company-details strong {
            color: #222222;
        }
        .order-number {
            font-size: 12px;
            font-weight: bold;
            color: #111111;
            margin-bottom: 3px;
        }
        .generated-date {
            font-size: 8.5px;
            color: #888888;
            margin-bottom: 5px;
        }
        .section {
            margin-top: 20px;
        }
        .section-title {
            font-size: 10px;
            font-weight: bold;
            color: #222222;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding-bottom: 6px;
            margin-bottom: 0;
            border-bottom: 1px solid #222222;
        }
        .details-table {
            width: 100%;
            border-collapse: collapse;
        }
        .details-table td {
            width: 50%;
            vertical-align: top;
            border-bottom: 1px solid #eeeeee;
            padding: 9px 8px 9px 0;
        }
        .details-table td:last-child {
            padding-left: 15px;
            padding-right: 0;
        }
        .customer-details-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .customer-details-table td {
            vertical-align: top;
            border-bottom: 1px solid #eeeeee;
            padding: 9px 10px 9px 0;
        }
        .customer-details-table td:nth-child(1) {
            width: 16%;
        }
        .customer-details-table td:nth-child(2) {
            width: 20%;
            padding-left: 8px;
        }
        .customer-details-table td:nth-child(3) {
            width: 16%;
            padding-left: 8px;
        }
        .customer-details-table td:nth-child(4) {
            width: 48%;
            padding-left: 8px;
            padding-right: 0;
        }
        .detail-label {
            font-size: 7.8px;
            color: #888888;
            text-transform: uppercase;
            margin-bottom: 2px;
            letter-spacing: .2px;
        }
        .detail-value {
            font-size: 9.5px;
            font-weight: bold;
            color: #222222;
        }
        .address {
            font-weight: normal;
            line-height: 1.5;
        }
        .products {
            margin-top: 20px;
        }
        .products-table {
            width: 100%;
            border-collapse: collapse;
        }
        .products-table th {
            background: #f5f5f5;
            border-top: 1px solid #dddddd;
            border-bottom: 1px solid #dddddd;
            padding: 8px 6px;
            font-size: 8.5px;
            font-weight: bold;
            color: #333333;
            text-align: left;
            text-transform: uppercase;
        }
        .products-table td {
            border-bottom: 1px solid #eeeeee;
            padding: 9px 6px;
            font-size: 9px;
            vertical-align: top;
        }
        .products-table th:first-child,
        .products-table td:first-child {
            padding-left: 0;
        }
        .products-table th:last-child,
        .products-table td:last-child {
            padding-right: 0;
        }
        .product-name {
            font-size: 9.5px;
            font-weight: bold;
            color: #222222;
        }
        .product-sku {
            font-size: 7.8px;
            color: #888888;
            margin-top: 2px;
        }
        .text-center {
            text-align: center !important;
        }
        .text-right {
            text-align: right !important;
        }
        .amount {
            white-space: nowrap;
        }
        .summary-area {
            width: 100%;
            margin-top: 20px;
        }
        .summary-left {
            float: left;
            width: 55%;
            padding-right: 25px;
        }
        .summary-right {
            float: right;
            width: 45%;
        }
        .note-title {
            font-size: 9px;
            font-weight: bold;
            color: #333333;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        .note-text {
            font-size: 8px;
            color: #777777;
            line-height: 1.55;
        }
        .summary-table {
            width: 100%;
            border-collapse: collapse;
        }
        .summary-table td {
            padding: 5px 0;
            border-bottom: 1px solid #eeeeee;
            font-size: 9px;
        }
        .summary-label {
            color: #666666;
            text-align: left;
        }
        .summary-value {
            color: #222222;
            font-weight: bold;
            text-align: right;
            white-space: nowrap;
        }
        .grand-total td {
            border-top: 1px solid #222222;
            border-bottom: 1px solid #222222;
            padding: 9px 0;
            font-size: 11px;
            font-weight: bold;
            color: #222222;
        }
        .payment {
            margin-top: 15px;
            padding-top: 10px;
            border-top: 1px solid #eeeeee;
        }
        .payment-title {
            font-size: 8px;
            color: #888888;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .payment-value {
            font-size: 9px;
            color: #333333;
        }
        .footer {
            margin-top: 28px;
            padding-top: 12px;
            border-top: 1px solid #dddddd;
            text-align: center;
        }
        .thank-you {
            font-size: 10px;
            font-weight: bold;
            color: #333333;
            margin-bottom: 3px;
        }
        .footer-text {
            font-size: 7.8px;
            color: #888888;
            line-height: 1.5;
        }
        .no-data {
            text-align: center;
            padding: 15px;
            color: #888888;
        }
    </style>
</head>
<body>
@php
    $logoPath = public_path('assets/img/logo.png');
    $logoBase64 = null;
    $logoMime = 'image/png';
    if (file_exists($logoPath)) {
        $logoExtension = strtolower(
            pathinfo($logoPath, PATHINFO_EXTENSION)
        );
        $logoMime = match ($logoExtension) {
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'webp' => 'image/webp',
            default => 'image/png',
        };
        $logoBase64 = base64_encode(
            file_get_contents($logoPath)
        );
    }
    $websiteUrl = rtrim(
        config('app.url'),
        '/'
    );
    $gstType = $order->gst_type
        ?? (
            strtolower(trim((string) $order->state)) === 'maharashtra'
                ? 'intra_state'
                : 'inter_state'
        );
    $isIntraState = $gstType === 'intra_state';
    $isInterState = $gstType === 'inter_state';
    $hasAnyGst = $order->items->contains(function ($item) {
        if ((float) ($item->gst_rate ?? 0) > 0) {
            return true;
        }
        return $item->product
            && strtolower(trim((string) $item->product->gst_type)) === 'yes';
    });
    $statusLabels = [
        0 => 'Pending',
        1 => 'Confirmed',
        2 => 'Processing',
        3 => 'Shipped',
        4 => 'Delivered',
        5 => 'Cancelled',
        6 => 'Failed',
        7 => 'Refunded',
        8 => 'Return Requested',
    ];
    $orderStatus =
        $statusLabels[(int) $order->status]
        ?? 'Unknown';
    $billingAddress = trim(
        implode(', ', array_filter([
            $order->address,
            $order->city,
            $order->state,
            $order->pincode,
            $order->country,
        ]))
    );
    $shippingAddress = trim(
        implode(', ', array_filter([
            $order->shipping_address,
            $order->shipping_city,
            $order->shipping_state,
            $order->shipping_pincode,
            $order->shipping_country,
        ]))
    );
    $shippingIsDifferent =
        trim((string) $order->shipping_name) !== '' &&
        (
            trim((string) $order->shipping_name) !==
                trim((string) $order->customer_name)

            ||
            trim((string) $order->shipping_mobile) !==
                trim((string) $order->mobile_number)

            ||
            $shippingAddress !== $billingAddress
        );
@endphp
<div class="invoice">
    <div class="header clearfix">
        <div class="header-left">
            @if($logoBase64)
                <img  src="data:{{ $logoMime }};base64,{{ $logoBase64 }}" class="logo"  alt="{{ config('app.name') }}">
            @else
                <div class="company-fallback">
                    {{ config('app.name') }}
                </div>
            @endif
            <div class="company-details">
                Office No. 506, 5th Floor,
                Maruti Millennium Tower Maruti Chowk,
                Eternal HighTech Pvt. Ltd.<br>
                Pune Banglore Highway Pashan Exit.
                Next to Tata Showroom, Baner,
                Pune, Maharashtra - 411045<br>
                <strong>Phone:</strong>
                +91 97675 55737
                &nbsp;&nbsp;&nbsp;
                <strong>Email:</strong>
                {{ config('mail.from.address') }}
                <br>
                <strong>Website:</strong>
                {{ $websiteUrl }}
            </div>
        </div>
        <div class="header-right">
            <div class="order-number">
                Order #{{ $order->order_number }}
            </div>
            <div class="generated-date">
                Generated on {{ now()->format('d M Y') }}
            </div>
            <div class="detail-value">
                Order Date
                {{ optional($order->created_at)->format('d M Y, h:i A') }}
            </div>
        </div>
    </div>
    <div class="section">
        <div class="section-title">
           Customer Details
        </div>
        <table class="customer-details-table">
            <tr>
                <td>
                    <div class="detail-label">
                        Customer Name
                    </div>
                    <div class="detail-value">
                        {{ $order->customer_name ?: optional($order->user)->name ?: 'N/A' }}
                    </div>
                </td>
                <td>
                    <div class="detail-label">
                        Email Address
                    </div>
                    <div class="detail-value">
                        {{ $order->email ?: optional($order->user)->email ?: 'N/A' }}
                    </div>
                </td>
                <td>
                    <div class="detail-label">
                        Mobile Number
                    </div>
                    <div class="detail-value">
                        {{ $order->mobile_number ?: 'N/A' }}
                    </div>
                </td>
                <td>
                    <div class="detail-label">
                        Address
                    </div>
                    <div class="detail-value address">
                        @if($order->address)
                            {{ $order->address }}
                        @endif
                        @if($order->city)
                            <br>{{ $order->city }}
                        @endif
                        @if($order->state)
                            , {{ $order->state }}
                        @endif
                        @if($order->pincode)
                            - {{ $order->pincode }}
                        @endif
                        @if($order->country)
                            <br>{{ $order->country }}
                        @endif
                        @if(
                            !$order->address &&
                            !$order->city &&
                            !$order->state &&
                            !$order->pincode &&
                            !$order->country
                        )
                            N/A
                        @endif
                    </div>
                </td>
            </tr>
        </table>
    </div>
    @if($shippingIsDifferent)
        <div class="section">
            <div class="section-title">
                Shipping Details
            </div>
            <table class="details-table">
                <tr>
                    <td>
                        <div class="detail-label">
                           Shipping Name
                        </div>
                        <div class="detail-value">
                            {{ $order->shipping_name }}
                        </div>
                    </td>
                    <td>
                        <div class="detail-label">
                            Shipping Mobile
                        </div>
                        <div class="detail-value">
                            {{ $order->shipping_mobile ?: 'N/A' }}
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <div class="detail-label">
                           Shipping Address
                        </div>
                        <div class="detail-value address">
                            @if($order->shipping_address)
                                {{ $order->shipping_address }}
                            @endif
                            @if($order->shipping_city)
                                <br>{{ $order->shipping_city }}
                            @endif
                            @if($order->shipping_state)
                               , {{ $order->shipping_state }}
                            @endif
                            @if($order->shipping_pincode)
                                - {{ $order->shipping_pincode }}
                            @endif
                            @if($order->shipping_country)
                                <br>{{ $order->shipping_country }}
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
    @endif
    <div class="products">
        <div class="section-title">
            Products Ordered
        </div>
        <table class="products-table">
            <thead>
                <tr>
                    <th style="width: 5%;">
                        #
                    </th>
                    <th style="width: {{ $hasAnyGst ? '30%' : '38%' }};">
                        Product
                    </th>
                    <th style="width: 10%;">
                        SKU
                    </th>
                    <th style="width: 8%;" class="text-center">
                        Qty
                    </th>
                    <th style="width: 13%;" class="text-right">
                        Unit Price
                    </th>
                    @if($hasAnyGst)
                        @if($isIntraState)
                            <th style="width: 8%;" class="text-center">
                                CGST
                            </th>
                            <th style="width: 8%;" class="text-right">
                                CGST Amt
                            </th>
                            <th style="width: 8%;" class="text-center">
                                SGST
                            </th>
                            <th style="width: 8%;" class="text-right">
                                SGST Amt
                            </th>
                        @else
                            <th style="width: 10%;" class="text-center">
                                IGST
                            </th>
                            <th style="width: 14%;" class="text-right">
                                IGST Amt
                            </th>
                        @endif
                    @endif
                    <th style="width: 15%;" class="text-right">
                        Amount
                    </th>
                </tr>
            </thead>
            <tbody>
                @forelse($order->items as $index => $item)
                    @php
                        $itemSubtotal = (float) $item->price * (int) $item->quantity;
                        $gstRate      = (float) ($item->gst_rate ?? 0);
                        $itemGst      = (float) ($item->gst_amount ?? 0);
                        $cgstRate     = (float) ($item->cgst_rate ?? 0);
                        $cgstAmount   = (float) ($item->cgst_amount ?? 0);
                        $sgstRate     = (float) ($item->sgst_rate ?? 0);
                        $sgstAmount   = (float) ($item->sgst_amount ?? 0);
                        $igstRate     = (float) ($item->igst_rate ?? 0);
                        $igstAmount   = (float) ($item->igst_amount ?? 0);

                        // Fallback for very old orders where order_items GST is 0
                        if ($gstRate === 0 && $item->product
                            && strtolower(trim((string) $item->product->gst_type)) === 'yes'
                            && $item->product->gst) {
                            $gstRate   = (float) $item->product->gst->gst_amount;
                            $itemGst   = round(($itemSubtotal * $gstRate) / 100, 2);

                            if ($isIntraState) {
                                $cgstRate   = $gstRate / 2;
                                $sgstRate   = $gstRate / 2;
                                $cgstAmount = $itemGst / 2;
                                $sgstAmount = $itemGst / 2;
                            } else {
                                $igstRate   = $gstRate;
                                $igstAmount = $itemGst;
                            }
                        }

                        $hasGst = $gstRate > 0;
                    @endphp
                    <tr>
                        <td>
                            {{ $index + 1 }}
                        </td>
                        <td>
                            <div class="product-name">
                                {{ $item->product_name }}
                            </div>
                            @if($item->product && $item->product->brand )
                                <div class="product-sku">
                                    Brand: {{ $item->product->brand->name }}
                                </div>
                            @endif
                        </td>
                        <td>
                            {{ $item->sku ?: '-' }}
                        </td>
                        <td class="text-center">
                            {{ $item->quantity }}
                        </td>
                        <td class="text-right amount">
                            ₹{{ number_format((float) $item->price, 2) }}
                        </td>
                        @if($hasAnyGst)
                            @if($isIntraState)
                                <td class="text-center">
                                    @if($cgstRate > 0)
                                        {{ rtrim(rtrim(number_format($cgstRate, 2), '0'), '.') }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right amount">
                                    @if($cgstAmount > 0)
                                        ₹{{ number_format($cgstAmount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if($sgstRate > 0)
                                        {{ rtrim(rtrim(number_format($sgstRate, 2), '0'), '.') }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right amount">
                                    @if($sgstAmount > 0)
                                        ₹{{ number_format($sgstAmount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @else
                                <td class="text-center">
                                    @if($igstRate > 0)
                                        {{ rtrim(rtrim(number_format($igstRate, 2), '0'), '.') }}%
                                    @else
                                        -
                                    @endif
                                </td>
                                <td class="text-right amount">
                                    @if($igstAmount > 0)
                                        ₹{{ number_format($igstAmount, 2) }}
                                    @else
                                        -
                                    @endif
                                </td>
                            @endif
                        @endif
                        <td class="text-right amount">
                            ₹{{ number_format(
                                $itemSubtotal,
                                2
                            ) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $hasAnyGst ? ($isIntraState ? 10 : 8) : 6 }}" class="no-data">
                            No products found for this order.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="summary-area clearfix">
        <div class="summary-left">
            <div class="note-title">
                Important Information
            </div>
            <div class="note-text">
                Please keep this invoice for your records.
                <br>
                Product warranty is subject to the warranty terms
                provided by the respective manufacturer.
                <br>
                For order-related assistance, please contact our
                customer support team.
            </div>
            @if($order->order_notes)
                <div class="payment">
                    <div class="payment-title">
                        Order Notes
                    </div>
                    <div class="payment-value">
                        {{ $order->order_notes }}
                    </div>
                </div>
            @endif
        </div>
        <div class="summary-right">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">
                        Subtotal
                    </td>
                    <td class="summary-value">
                        ₹{{ number_format(
                            (float) $subtotal,
                            2
                        ) }}
                    </td>
                </tr>
                @if((float) $discount > 0)
                    <tr>
                        <td class="summary-label">
                            Discount
                        </td>
                        <td class="summary-value">
                            - ₹{{ number_format(
                                (float) $discount,
                                2
                            ) }}
                        </td>
                    </tr>
                @endif
                <tr>
                    <td class="summary-label">
                        Taxable Amount
                    </td>
                    <td class="summary-value">
                        ₹{{ number_format(
                            (float) $taxableAmount,
                            2
                        ) }}
                    </td>
                </tr>
                @if($hasAnyGst)
                    @if($isIntraState)
                        <tr>
                            <td class="summary-label">
                                CGST
                            </td>
                            <td class="summary-value">
                                ₹{{ number_format((float) $order->cgst_amount, 2) }}
                            </td>
                        </tr>
                        <tr>
                            <td class="summary-label">
                                SGST
                            </td>
                            <td class="summary-value">
                                ₹{{ number_format((float) $order->sgst_amount, 2) }}
                            </td>
                        </tr>
                    @else
                        <tr>
                            <td class="summary-label">
                                IGST
                            </td>
                            <td class="summary-value">
                                ₹{{ number_format((float) $order->igst_amount, 2) }}
                            </td>
                        </tr>
                    @endif
                @endif
                <tr>
                    <td class="summary-label">
                        Shipping
                    </td>
                    <td class="summary-value">
                        @if((float) $shipping > 0)
                            ₹{{ number_format(
                                (float) $shipping,
                                2
                            ) }}
                        @else
                            Free
                        @endif
                    </td>
                </tr>
                <tr class="grand-total">
                    <td>
                        GRAND TOTAL
                    </td>
                    <td class="text-right">
                        ₹{{ number_format(
                            (float) $grandTotal,
                            2
                        ) }}
                    </td>
                </tr>
            </table>
            <div class="payment">
                <div class="payment-title">
                    Payment Information
                </div>
                <div class="payment-value">
                    <strong>
                        Method:
                    </strong>
                    {{ strtoupper( $order->payment_method ?? 'N/A') }}
                    <br>
                    <strong>
                        Status:
                    </strong>
                    {{ ucfirst($order->payment_status ?? 'Pending') }}
                    @if($order->razorpay_payment_id)
                        <br>
                        <strong>
                            Payment ID:
                        </strong>
                        {{ $order->razorpay_payment_id }}
                    @endif
                </div>
            </div>
        </div>
    </div>
    <div class="footer">
        <div class="thank-you">
            Thank You For Your Order!
        </div>
        <div class="footer-text">
            We appreciate your business and hope you enjoy your purchase.
            <br>
            This is a computer-generated invoice and does not require a signature.
            <br>
            For support, please contact
            {{ config('mail.from.address') }}
            or call +91 97675 55737.
        </div>
    </div>
</div>
</body>
</html>
