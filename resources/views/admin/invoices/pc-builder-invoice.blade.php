<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>PC Builder Invoice</title>
    <style>
        @page {
            margin: 0;
        }
        * {
            box-sizing: border-box;
        }
        body {
            margin: 0;
            padding: 0;
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            background: #ffffff;
            font-size: 10px;
        }
        .page {
            padding: 32px 35px;
        }
        .top-bar {
            height: 6px;
            background: #d71920;
            margin: -32px -35px 25px -35px;
        }
        .header {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        .header-left {
            width: 60%;
            vertical-align: top;
        }
        .header-right {
            width: 40%;
            vertical-align: top;
            text-align: right;
        }
        .company-table {
            width: 100%;
            border-collapse: collapse;
        }
        .logo-area {
            width: 90px;
            vertical-align: top;
            padding-right: 15px;
        }
        .logo {
            width: 78px;
            max-height: 78px;
        }
        .company-name {
            font-size: 19px;
            font-weight: bold;
            color: #111827;
            margin-bottom: 4px;
        }
        .company-tagline {
            color: #d71920;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 7px;
        }
        .company-details {
            color: #6b7280;
            font-size: 8.5px;
            line-height: 1.55;
        }
        .invoice-box {
            background: #fffafa;
            padding: 18px 16px;
        }
        .invoice-title {
            font-size: 27px;
            font-weight: bold;
            color: #d71920;
            letter-spacing: 1px;
            margin-bottom: 5px;
        }
        .invoice-subtitle {
            color: #6b7280;
            font-size: 8px;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 10px;
        }
        .invoice-detail {
            color: #374151;
            font-size: 9px;
            margin-bottom: 3px;
        }
        .status {
            display: inline-block;
            margin-top: 7px;
            padding: 5px 12px;
            background: #fff1f2;
            border: 1px solid #fecdd3;
            color: #d71920;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .line {
            height: 1px;
            background: #e5e7eb;
            margin-bottom: 20px;
        }
        .information {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 25px;
        }
        .information-box {
            width: 100%;
            border: 1px solid #e5e7eb;
            vertical-align: top;
            padding: 14px;
        }
        .section-label {
            color: #d71920;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            margin-bottom: 8px;
        }
        .customer-name {
            color: #111827;
            font-size: 12px;
            font-weight: bold;
            margin-bottom: 6px;
        }
        .information-text {
            color: #4b5563;
            font-size: 8.5px;
            line-height: 1.65;
        }
        .information-text strong {
            color: #374151;
        }
        .configuration-header {
            margin-bottom: 9px;
        }
        .configuration-title {
            color: #111827;
            font-size: 13px;
            font-weight: bold;
        }
        .configuration-description {
            color: #9ca3af;
            font-size: 8px;
            margin-top: 2px;
        }
        .products {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 22px;
        }
        .products thead th {
            background: #d71920;
            color: #ffffff;
            padding: 8px 6px;
            font-size: 7.5px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }
        .products tbody td {
            padding: 8px 6px;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: top;
            font-size: 8.5px;
        }
        .products tbody tr:last-child td {
            border-bottom: 1px solid #fecdd3;
        }
        .text-left {
            text-align: left;
        }
        .text-center {
            text-align: center;
        }
        .text-right {
            text-align: right;
        }
        .component-type {
            color: #d71920;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 3px;
        }
        .product-name {
            color: #111827;
            font-size: 9px;
            font-weight: bold;
            line-height: 1.4;
        }
        .product-sku {
            color: #9ca3af;
            font-size: 7px;
            margin-top: 2px;
        }
        .gst-yes {
            color: #d71920;
            font-weight: bold;
        }
        .gst-no {
            color: #9ca3af;
        }
        .bottom {
            width: 100%;
            border-collapse: collapse;
        }
        .payment-column {
            width: 53%;
            vertical-align: top;
            padding-right: 25px;
        }
        .total-column {
            width: 47%;
            vertical-align: top;
        }
        .payment-box {
            border: 1px solid #e5e7eb;
            padding: 13px 14px;
        }
        .payment-title {
            color: #d71920;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 8px;
        }
        .payment-method {
            color: #111827;
            font-size: 10px;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .payment-text {
            color: #6b7280;
            font-size: 8px;
            line-height: 1.7;
        }
        .payment-text strong {
            color: #374151;
        }
        .summary {
            width: 100%;
            border-collapse: collapse;
        }
        .summary td {
            padding: 5px 0;
            font-size: 9px;
        }
        .summary-label {
            color: #6b7280;
            text-align: left;
        }
        .summary-value {
            color: #111827;
            text-align: right;
        }
        .discount {
            color: #16a34a;
            text-align: right;
        }
        .grand-total td {
            border-top: 2px solid #d71920;
            padding-top: 10px;
            font-size: 13px;
            font-weight: bold;
        }
        .grand-total .summary-label {
            color: #111827;
        }
        .grand-total .summary-value {
            color: #d71920;
        }
        .notes {
            margin-top: 22px;
            padding: 12px 14px;
            background: #fff8f8;
            border: 1px solid #fecdd3;
        }
        .notes-title {
            color: #d71920;
            font-size: 8px;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.7px;
            margin-bottom: 5px;
        }
        .notes-text {
            color: #4b5563;
            font-size: 8.5px;
            line-height: 1.6;
        }
        .footer {
            margin-top: 25px;
            padding-top: 12px;
            border-top: 1px solid #e5e7eb;
            text-align: center;
        }
        .footer-title {
            color: #111827;
            font-size: 9px;
            font-weight: bold;
            margin-bottom: 3px;
        }
        .footer-text {
            color: #9ca3af;
            font-size: 7.5px;
        }
    </style>
</head>
<body>
    @php
        $products = is_array($pcBuilder->products) ? $pcBuilder->products : (json_decode($pcBuilder->products, true) ?: []);
        $statusMap = [
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            5 => 'Cancelled',
            6 => 'Failed',
            7 => 'Refunded',
            8 => 'Returned',
        ];
        $paymentStatus = strtolower((string) $pcBuilder->payment_status);
        if ($paymentStatus === 'paid' || $paymentStatus === '1') {
            $paymentStatusText = 'Paid';
        } elseif ($paymentStatus === 'failed') {
            $paymentStatusText = 'Failed';
        } elseif ($paymentStatus === 'refunded') {
            $paymentStatusText = 'Refunded';
        } else {
            $paymentStatusText = 'Pending';
        }
        $orderStatus = $statusMap[$pcBuilder->status] ?? ucfirst((string) $pcBuilder->status);
        $subtotal = (float) $pcBuilder->subtotal;
        $shipping = (float) $pcBuilder->shipping_amount;
        $discount = (float) $pcBuilder->discount_amount;
        $gstTotal = (float) $pcBuilder->gst_amount;
        $total = (float) $pcBuilder->total_amount;
        $customerName = $pcBuilder->customer_name ?: ($pcBuilder->user->name ?? 'Customer');
        $customerEmail = $pcBuilder->email ?: ($pcBuilder->user->email ?? '');
        $paymentMethod = $pcBuilder->payment_method ? ucfirst(str_replace('_', ' ', $pcBuilder->payment_method)) : 'N/A';
        $logoPath = public_path('assets/img/logo.png');
        $gstType = $pcBuilder->gst_type
            ?? (
                strtolower(trim((string) $pcBuilder->state)) === 'maharashtra'
                    ? 'intra_state'
                    : 'inter_state'
            );
        $isIntraState = $gstType === 'intra_state';
        $isInterState = $gstType === 'inter_state';
        $cgstTotal = (float) ($pcBuilder->cgst_amount ?? 0);
        $sgstTotal = (float) ($pcBuilder->sgst_amount ?? 0);
        $igstTotal = (float) ($pcBuilder->igst_amount ?? 0);
        $derivedCgst = 0;
        $derivedSgst = 0;
        $derivedIgst = 0;
        $derivedGst  = 0;
        foreach ($products as $__item) {
            if (
                isset($__item['gst_rate']) && (float) $__item['gst_rate'] > 0
            ) {
                $hasAnyGst = true;
                break;
            }
            if (
                isset($__item['gst_amount']) && (float) $__item['gst_amount'] > 0
            ) {
                $hasAnyGst = true;
                break;
            }
        }
        $hasAnyGst = $hasAnyGst ?? false;
    @endphp
    <div class="page">
        <div class="top-bar"></div>
        <table class="header">
            <tr>
                <td class="header-left">
                    <div style="width: 100%;">
                        <table style="width: 100%; border-collapse: collapse; margin-bottom: 12px;">
                            <tr>
                                <td style="width: 90px; vertical-align: middle; padding: 0;">
                                    @if(file_exists($logoPath))
                                        <img src="{{ $logoPath }}" class="logo" alt="Logo">
                                    @endif
                                </td>
                                <td style="vertical-align: middle; padding: 0 0 0 30px;">
                                    <h3 style="margin: 0; color: #111827; font-size: 16px; font-weight: bold;">
                                       {{ config('app.name') }}
                                    </h3>
                                </td>
                            </tr>
                        </table>
                        <div class="company-details">
                            Office No. 506, 5th Floor,
                            Maruti Millennium Tower Maruti Chowk,
                            Eternal HighTech Pvt. Ltd.
                            Pune Banglore Highway Pashan Exit.
                            Next to Tata Showroom, Baner,
                            Pune, Maharashtra - 411045<br>
                            <strong>Phone:</strong>
                            +91 97675 55737
                            &nbsp;&nbsp;&nbsp;
                            <strong>Email:</strong>
                            {{ config('mail.from.address') }}<br>
                            <strong>Website:</strong>
                        </div>
                    </div>
                </td>
                <td class="header-right">
                    <div class="invoice-box">
                        <div class="invoice-title">
                            INVOICE
                        </div>
                        <div class="invoice-subtitle">
                            PC Builder Order
                        </div>
                        <div class="invoice-detail">
                            <strong>Invoice No:</strong>
                            {{ $pcBuilder->builder_number }}
                        </div>
                        <div class="invoice-detail">
                            <strong>Order Date:</strong>
                            {{ optional($pcBuilder->created_at)->format('d M Y') }}
                        </div>
                    </div>
                </td>
            </tr>
        </table>
        <table class="information">
            <tr>
                <td class="information-box">
                    <div class="customer-name">
                        {{ $customerName }}
                    </div>
                    <div class="information-text">
                        @if($customerEmail)
                            {{ $customerEmail }}
                        @endif
                        @if($pcBuilder->mobile_number)
                            {{ $pcBuilder->mobile_number }}<br>
                        @endif
                        @if($pcBuilder->address)
                            {{ $pcBuilder->address }}<br>
                        @endif
                        @if($pcBuilder->city)
                            {{ $pcBuilder->city }}
                        @endif
                        @if($pcBuilder->state)
                            , {{ $pcBuilder->state }}
                        @endif
                        @if($pcBuilder->city || $pcBuilder->state)
                        @endif
                        @if($pcBuilder->pincode)
                            {{ $pcBuilder->pincode }}
                        @endif
                        @if($pcBuilder->country)
                            {{ $pcBuilder->country }}
                        @endif
                    </div>
                </td>
            </tr>
        </table>
        <div class="configuration-header">
            <div class="configuration-title">
                PC Configuration
            </div>
            <div class="configuration-description">
                Selected components included in this PC Builder order
            </div>
        </div>
        <table class="products">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">
                        #
                    </th>
                    <th class="text-left" style="width: 25%;">
                        Product
                    </th>
                    <th class="text-center" style="width: 11%;">
                        Product Type
                    </th>
                    <th class="text-center" style="width: 6%;">
                        Qty
                    </th>
                    <th class="text-right" style="width: 11%;">
                        Price
                    </th>
                    @if($hasAnyGst)
                        @if($isIntraState)
                            <th class="text-center" style="width: 7%;">
                                CGST
                            </th>
                            <th class="text-right" style="width: 9%;">
                                CGST Amt
                            </th>
                            <th class="text-center" style="width: 7%;">
                                SGST
                            </th>
                            <th class="text-right" style="width: 9%;">
                                SGST Amt
                            </th>
                        @else
                            <th class="text-center" style="width: 8%;">
                                IGST
                            </th>
                            <th class="text-right" style="width: 11%;">
                                IGST Amt
                            </th>
                        @endif
                    @endif
                    <th class="text-right" style="width: 12%;">
                        Total
                    </th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $index => $item)
                @php
                    $productId = $item['product_id'] ?? ($item['id'] ?? null);
                    if (!$productId && isset($item['product']) && is_array($item['product'])) {
                        $productId = $item['product']['id'] ?? null;
                    }
                    $product = null;
                    if ($productId) {
                        $product = \App\Models\Product::with('gst')->find($productId);
                    }
                    $productName = $product->name
                        ?? ($item['product_name']
                        ?? ($item['name']
                        ?? ($item['title'] ?? 'Product')));
                    $productType = $item['product_type']
                        ?? ($item['type']
                        ?? ($item['builder_type']
                        ?? ($item['category'] ?? 'PC Component')));
                    $sku = $product->sku
                        ?? ($item['sku'] ?? '');
                    $quantity = (float) (
                        $item['quantity']
                        ?? ($item['qty'] ?? 1)
                    );
                    $unitPrice = $item['price']
                        ?? ($item['sale_price']
                        ?? ($item['unit_price']
                        ?? ($item['amount']
                        ?? ($product->sale_price
                        ?? ($product->price ?? 0)))));
                    $unitPrice = (float) $unitPrice;
                    $baseAmount = $unitPrice * $quantity;
                    $gstType = strtolower(
                        trim(
                            (string) (
                                $product->gst_type
                                ?? 'no'
                            )
                        )
                    );
                    $storedGstRate   = isset($item['gst_rate'])   ? (float) $item['gst_rate']   : 0;
                    $storedGstAmount = isset($item['gst_amount']) ? (float) $item['gst_amount'] : 0;
                    $storedCgstRate  = isset($item['cgst_rate'])  ? (float) $item['cgst_rate']  : 0;
                    $storedCgstAmt   = isset($item['cgst_amount'])? (float) $item['cgst_amount']: 0;
                    $storedSgstRate  = isset($item['sgst_rate'])  ? (float) $item['sgst_rate']  : 0;
                    $storedSgstAmt   = isset($item['sgst_amount'])? (float) $item['sgst_amount']: 0;
                    $storedIgstRate  = isset($item['igst_rate'])  ? (float) $item['igst_rate']  : 0;
                    $storedIgstAmt   = isset($item['igst_amount'])? (float) $item['igst_amount']: 0;
                    $gstRate = 0;
                    if ($storedGstRate > 0) {
                        $gstRate = $storedGstRate;
                    } elseif ($gstType === 'yes' && $product && $product->gst) {
                        $gstRate = (float) (
                            $product->gst->gst_amount
                            ?? ($product->gst->rate
                            ?? ($product->gst->gst_rate
                            ?? ($product->gst->percentage ?? 0)))
                        );
                    }
                    $itemGstAmount = $storedGstAmount > 0
                        ? $storedGstAmount
                        : ($gstRate > 0 ? ($baseAmount * $gstRate / 100) : 0);

                    $cgstRate   = $storedCgstRate;
                    $cgstAmount = $storedCgstAmt;
                    $sgstRate   = $storedSgstRate;
                    $sgstAmount = $storedSgstAmt;
                    $igstRate   = $storedIgstRate;
                    $igstAmount = $storedIgstAmt;

                    if ($itemGstAmount > 0 && $cgstAmount === 0 && $sgstAmount === 0 && $igstAmount === 0) {
                        if ($isIntraState) {
                            $cgstRate   = $gstRate / 2;
                            $sgstRate   = $gstRate / 2;
                            $cgstAmount = $itemGstAmount / 2;
                            $sgstAmount = $itemGstAmount / 2;
                        } else {
                            $igstRate   = $gstRate;
                            $igstAmount = $itemGstAmount;
                        }
                    }

                    $itemTotal = $baseAmount + $itemGstAmount;
                    $derivedGst  += $itemGstAmount;
                    $derivedCgst += $cgstAmount;
                    $derivedSgst += $sgstAmount;
                    $derivedIgst += $igstAmount;

                    $hasGst = $gstRate > 0;
                @endphp
                <tr>
                    <td class="text-center">
                        {{ $index + 1 }}
                    </td>
                    <td class="text-left">
                        <div class="product-name">
                            {{ $productName }}
                        </div>
                        @if($sku)
                            <div class="product-sku">
                                SKU: {{ $sku }}
                            </div>
                        @endif
                    </td>
                    <td class="text-center">
                        <div class="component-type">
                            {{ $productType }}
                        </div>
                    </td>
                    <td class="text-center">
                        {{ rtrim(
                            rtrim(
                                number_format(
                                    $quantity,
                                    2,
                                    '.',
                                    ''
                                ),
                                '0'
                            ),
                            '.'
                        ) }}
                    </td>
                    <td class="text-right">
                        ₹{{ number_format($unitPrice, 2) }}
                    </td>
                    @if($hasAnyGst)
                        @if($isIntraState)
                            {{-- CGST --}}
                            <td class="text-center">
                                @if($cgstRate > 0)
                                    <span class="gst-yes">
                                        {{ rtrim(rtrim(number_format($cgstRate, 2), '0'), '.') }}%
                                    </span>
                                @else
                                    <span class="gst-no">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($cgstAmount > 0)
                                    ₹{{ number_format($cgstAmount, 2) }}
                                @else
                                    -
                                @endif
                            </td>

                            {{-- SGST --}}
                            <td class="text-center">
                                @if($sgstRate > 0)
                                    <span class="gst-yes">
                                        {{ rtrim(rtrim(number_format($sgstRate, 2), '0'), '.') }}%
                                    </span>
                                @else
                                    <span class="gst-no">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($sgstAmount > 0)
                                    ₹{{ number_format($sgstAmount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                        @else
                            {{-- IGST --}}
                            <td class="text-center">
                                @if($igstRate > 0)
                                    <span class="gst-yes">
                                        {{ rtrim(rtrim(number_format($igstRate, 2), '0'), '.') }}%
                                    </span>
                                @else
                                    <span class="gst-no">-</span>
                                @endif
                            </td>
                            <td class="text-right">
                                @if($igstAmount > 0)
                                    ₹{{ number_format($igstAmount, 2) }}
                                @else
                                    -
                                @endif
                            </td>
                        @endif
                    @endif
                    <td class="text-right">
                        ₹{{ number_format($itemTotal, 2) }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="{{ $hasAnyGst ? ($isIntraState ? 10 : 8) : 6 }}" class="text-center" style="padding: 20px; color: #9ca3af;">
                        No PC components found.
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <table class="bottom">
            <tr>
                <td class="payment-column">
                    <div class="payment-box">
                        <div class="payment-title">
                            Payment Information
                        </div>
                        <div class="payment-method">
                            {{ $paymentMethod }}
                        </div>
                        <div class="payment-text">
                            <strong>
                                Payment Status:
                            </strong>
                            {{ $paymentStatusText }}
                            @if($pcBuilder->razorpay_payment_id)
                                <br>
                                <strong>
                                    Transaction ID:
                                </strong>
                                {{ $pcBuilder->razorpay_payment_id }}
                            @endif
                            @if($pcBuilder->razorpay_order_id)
                                <br>
                                <strong>
                                    Razorpay Order:
                                </strong>
                                {{ $pcBuilder->razorpay_order_id }}
                            @endif
                        </div>
                    </div>
                </td>
                <td class="total-column">
                    @php
                        $displayCgst = $cgstTotal > 0 ? $cgstTotal : $derivedCgst;
                        $displaySgst = $sgstTotal > 0 ? $sgstTotal : $derivedSgst;
                        $displayIgst = $igstTotal > 0 ? $igstTotal : $derivedIgst;
                        $displayGst  = $gstTotal  > 0 ? $gstTotal  : $derivedGst;
                    @endphp
                    <table class="summary">
                        <tr>
                            <td class="summary-label">
                            Subtotal
                            </td>
                            <td class="summary-value">
                                ₹{{ number_format($subtotal, 2) }}
                            </td>
                        </tr>
                        @if($hasAnyGst)
                            @if($isIntraState)
                                <tr>
                                    <td class="summary-label">
                                        CGST
                                    </td>
                                    <td class="summary-value">
                                        ₹{{ number_format($displayCgst, 2) }}
                                    </td>
                                </tr>
                                <tr>
                                    <td class="summary-label">
                                        SGST
                                    </td>
                                    <td class="summary-value">
                                        ₹{{ number_format($displaySgst, 2) }}
                                    </td>
                                </tr>
                            @else
                                <tr>
                                    <td class="summary-label">
                                        IGST
                                    </td>
                                    <td class="summary-value">
                                        ₹{{ number_format($displayIgst, 2) }}
                                    </td>
                                </tr>
                            @endif
                        @endif
                        @if($shipping > 0)
                            <tr>
                                <td class="summary-label">
                                    Shipping
                                </td>
                                <td class="summary-value">
                                    ₹{{ number_format($shipping, 2) }}
                                </td>
                            </tr>
                        @endif
                        @if($discount > 0)
                            <tr>
                                <td class="summary-label">
                                    Discount
                                </td>
                                <td class="discount">
                                    -₹{{ number_format($discount, 2) }}
                                </td>
                            </tr>
                        @endif
                        <tr class="grand-total">
                            <td class="summary-label">
                                Grand Total
                            </td>
                            <td class="summary-value">
                                ₹{{ number_format($total, 2) }}
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        @if($pcBuilder->order_notes)
            <div class="notes">
                <div class="notes-title">
                Order Notes
                </div>
                <div class="notes-text">
                    {{ $pcBuilder->order_notes }}
                </div>
            </div>
        @endif
        <div class="footer">
            <div class="footer-title">
                Thank you for choosing {{ config('app.name') }}
            </div>
            <div class="footer-text">
                This is a computer-generated invoice and does not require a signature.
            </div>
        </div>
    </div>
</body>
</html>
