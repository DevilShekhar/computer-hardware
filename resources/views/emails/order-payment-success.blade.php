<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        {{ strtolower($order->payment_method) === 'cod' ? 'Order Confirmation' : 'Payment Successful' }}
    </title>
</head>
<body style="margin:0; padding:0; background:#f4f6f8; font-family:Arial, Helvetica, sans-serif; color:#222;">
@php
    $isCod = strtolower((string) $order->payment_method) === 'cod';
    $gstAmount = 0;
    $gstRates = [];
    foreach ($order->items as $item) {
        $product = $item->product;
        if ($product && $product->gst_type === 'yes' && $product->gst) {
            $gstRate = (float) $product->gst->gst_amount;
            $itemTotal = (float) $item->total;
            $gstRates[] = $gstRate;
            $gstAmount += ($itemTotal * $gstRate) / 100;
        }
    }
    $gstRates = array_unique($gstRates);
    if (count($gstRates) === 1) {
        $gstLabel = number_format((float) reset($gstRates), 0) . '%';
    } elseif (count($gstRates) > 1) {
        $gstLabel = implode('% + ', array_map(function ($rate) {
            return number_format((float) $rate, 0);
        }, $gstRates)) . '%';
    } else {
        $gstLabel = 'Non-GST';
    }
@endphp
<table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4f6f8; padding:30px 15px;">
    <tr>
        <td align="center">
            <table width="760" cellpadding="0" cellspacing="0" border="0" style="max-width:760px; width:100%; background:#ffffff; border-radius:10px; overflow:hidden;">
                <tr>
                    <td style="background:#111827; padding:28px 35px; text-align:center;">
                        <img src="{{ url('assets/img/logo.png') }}" alt="METAVERSE INFO"  width="180"
                            style="display:block; margin:0 auto; max-width:180px; height:auto; border:0;">
                        <div style="font-size:13px; color:#cbd5e1; margin-top:10px;">
                            Your trusted computer hardware store
                        </div>
                    </td>
                </tr>
                <tr>
                    <td style="padding:35px;">
                        @if($isCod)
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:8px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <div style="font-size:21px; font-weight:bold; color:#1d4ed8;">
                                            Order Confirmed
                                        </div>
                                        <div style="font-size:14px; color:#374151; margin-top:7px; line-height:1.6;">
                                            Your order has been successfully placed with
                                            <strong>Cash on Delivery</strong>.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        @else
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#ecfdf5; border:1px solid #a7f3d0; border-radius:8px;">
                                <tr>
                                    <td style="padding:20px;">
                                        <div style="font-size:21px; font-weight:bold; color:#047857;">
                                            Payment Successful
                                        </div>
                                        <div style="font-size:14px; color:#374151; margin-top:7px; line-height:1.6;">
                                            Your payment has been successfully received and your order has been confirmed.
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        @endif
                        <div style="height:25px;"></div>
                        <p style="margin:0 0 12px 0; font-size:15px; color:#111827;">
                            Hello
                            <strong>
                                {{ $order->user->name ?? $order->customer_name ?? 'Customer' }}
                            </strong>,
                        </p>
                        @if($isCod)
                            <p style="margin:0 0 25px 0; font-size:14px; color:#4b5563; line-height:1.7;">
                                Thank you for shopping with <strong>METAVERSE INFO</strong>.
                                Your order has been successfully placed with
                                <strong>Cash on Delivery</strong>.
                                Below are your complete order details.
                            </p>
                        @else
                            <p style="margin:0 0 25px 0; font-size:14px; color:#4b5563; line-height:1.7;">
                                Thank you for shopping with <strong>METAVERSE INFO</strong>.
                                Your payment has been successfully verified.
                                Below are your complete order details.
                            </p>
                        @endif
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb; border-radius:8px; margin-bottom:28px;">
                            <tr>
                                <td width="50%" style="padding:15px 18px; border-bottom:1px solid #e5e7eb;">
                                    <div style="font-size:11px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">
                                        Order Number
                                    </div>
                                    <div style="font-size:14px; font-weight:bold; color:#111827; margin-top:5px;">
                                        {{ $order->order_number }}
                                    </div>
                                </td>
                                <td width="50%" style="padding:15px 18px; border-bottom:1px solid #e5e7eb;">
                                    <div style="font-size:11px; color:#6b7280; text-transform:uppercase; letter-spacing:0.5px;">
                                        Order Date
                                    </div>
                                    <div style="font-size:14px; font-weight:bold; color:#111827; margin-top:5px;">
                                        {{ $order->created_at ? $order->created_at->format('d M Y, h:i A') : '-' }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <div style="font-size:18px; font-weight:bold; color:#111827; margin-bottom:12px;">
                            Order Items
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0"  style="border-collapse:collapse; margin-bottom:28px;">
                            <thead>
                                <tr style="background:#f3f4f6;">
                                    <th align="left"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        Product
                                    </th>
                                    <th align="left"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        SKU
                                    </th>
                                    <th align="center"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        Qty
                                    </th>
                                    <th align="right"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        Price
                                    </th>
                                    <th align="right"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        GST
                                    </th>
                                    <th align="right"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        GST Amount
                                    </th>
                                    <th align="right"
                                        style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                        Total
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                    @php
                                        $product = $item->product;
                                        $gstRate = 0;
                                        $itemGstAmount = 0;
                                        if ( $product &&  $product->gst_type === 'yes' && $product->gst) 
                                        {
                                            $gstRate = (float) $product->gst->gst_amount;
                                            $itemTotal = (float) $item->total;
                                            $itemGstAmount = ($itemTotal * $gstRate) / 100;
                                        }
                                        $itemTotalWithGst = (float) $item->total + $itemGstAmount;
                                    @endphp
                                    <tr>
                                        <td style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#111827;">
                                            <strong>
                                                {{ $item->product_name }}
                                            </strong>
                                        </td>
                                        <td style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#4b5563;">
                                            {{ $item->sku ?? '-' }}
                                        </td>
                                        <td align="center"
                                            style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                            {{ $item->quantity }}
                                        </td>
                                        <td align="right"
                                            style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                            ₹{{ number_format((float) $item->price, 2) }}
                                        </td>
                                        <td align="right" style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                            @if($gstRate > 0)
                                                {{ number_format($gstRate, 0) }}%
                                            @else
                                                Non-GST
                                            @endif
                                        </td>
                                        <td align="right"
                                            style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; color:#374151;">
                                            ₹{{ number_format($itemGstAmount, 2) }}
                                        </td>
                                        <td align="right"
                                            style="padding:12px 10px; border:1px solid #e5e7eb; font-size:12px; font-weight:bold; color:#111827;">
                                            ₹{{ number_format($itemTotalWithGst, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div style="font-size:18px; font-weight:bold; color:#111827; margin-bottom:12px;">
                            Payment Details
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0"  style="border:1px solid #e5e7eb; border-radius:8px; margin-bottom:28px;">
                            <tr>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; width:40%; font-size:13px; color:#6b7280;">
                                    Customer Name
                                </td>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#111827; font-weight:bold;">
                                    {{ $order->customer_name ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#6b7280;">
                                    Email
                                </td>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#111827;">
                                    {{ $order->email ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#6b7280;">
                                    Mobile Number
                                </td>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#111827;">
                                    {{ $order->mobile_number ?? '-' }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#6b7280;">
                                    Payment Method
                                </td>
                                <td style="padding:11px 15px; border-bottom:1px solid #e5e7eb; font-size:13px; color:#111827; font-weight:bold;">
                                    @if($isCod)
                                        Cash on Delivery
                                    @else
                                        Razorpay
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:11px 15px; font-size:13px; color:#6b7280;">
                                    Payment Status
                                </td>
                                <td style="padding:11px 15px; font-size:13px; font-weight:bold; color:#111827;">
                                    @if($isCod)
                                        Pending - Pay on Delivery
                                    @else
                                        Paid
                                    @endif
                                </td>
                            </tr>
                        </table>
                        <div style="font-size:18px; font-weight:bold; color:#111827; margin-bottom:12px;">
                            Order Summary
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb; border-radius:8px; margin-bottom:28px;">
                            <tr>
                                <td style="padding:12px 15px; font-size:13px; color:#6b7280;">
                                    Subtotal
                                </td>
                                <td align="right"
                                    style="padding:12px 15px; font-size:13px; color:#111827;">
                                    ₹{{ number_format((float) $order->subtotal, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 15px; font-size:13px; color:#6b7280;">
                                    Shipping
                                </td>
                                <td align="right"
                                    style="padding:12px 15px; font-size:13px; color:#111827;">
                                    ₹{{ number_format((float) $order->shipping_amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 15px; font-size:13px; color:#6b7280;">
                                    Discount
                                </td>
                                <td align="right"
                                    style="padding:12px 15px; font-size:13px; color:#111827;">
                                    ₹{{ number_format((float) $order->discount_amount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 15px; font-size:13px; color:#6b7280;">
                                    GST
                                </td>
                                <td align="right"
                                    style="padding:12px 15px; font-size:13px; font-weight:bold; color:#111827;">
                                    {{ $gstLabel }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:12px 15px; font-size:13px; color:#6b7280;">
                                    GST Amount
                                </td>
                                <td align="right"
                                    style="padding:12px 15px; font-size:13px; color:#111827;">
                                    ₹{{ number_format($gstAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td style="padding:16px 15px; border-top:2px solid #111827; font-size:15px; font-weight:bold; color:#111827;">
                                    Total Amount
                                </td>
                                <td align="right"
                                    style="padding:16px 15px; border-top:2px solid #111827; font-size:16px; font-weight:bold; color:#111827;">
                                    ₹{{ number_format((float) $order->total_amount, 2) }}
                                </td>
                            </tr>
                        </table>
                        <div style="font-size:18px; font-weight:bold; color:#111827; margin-bottom:12px;">
                            Delivery Address
                        </div>
                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb; border-radius:8px; margin-bottom:28px;">
                            <tr>
                                <td style="padding:18px;">
                                    <div style="font-size:14px; font-weight:bold; color:#111827; margin-bottom:8px;">
                                        {{ $order->customer_name ?? '-' }}
                                    </div>
                                    <div style="font-size:13px; color:#4b5563; line-height:1.7;">
                                        {{ $order->address ?? '-' }}<br>
                                        {{ $order->city ?? '-' }},
                                        {{ $order->state ?? '-' }}
                                        - {{ $order->pincode ?? '-' }}<br>
                                        {{ $order->country ?? 'India' }}
                                    </div>
                                </td>
                            </tr>
                        </table>
                        @if(!empty($order->order_notes))
                            <div style="font-size:18px; font-weight:bold; color:#111827; margin-bottom:12px;">
                                Order Notes
                            </div>
                            <table width="100%" cellpadding="0" cellspacing="0" border="0" style="border:1px solid #e5e7eb; border-radius:8px; margin-bottom:28px;">
                                <tr>
                                    <td style="padding:15px; font-size:13px; color:#4b5563; line-height:1.6;">
                                        {{ $order->order_notes }}
                                    </td>
                                </tr>
                            </table>
                        @endif
                        @if($isCod)
                            <p style="margin:0 0 15px 0; font-size:14px; color:#4b5563; line-height:1.7;">
                                We will keep you updated about your order status and delivery.
                                Please keep the order amount ready at the time of delivery.
                            </p>
                        @else
                            <p style="margin:0 0 15px 0; font-size:14px; color:#4b5563; line-height:1.7;">
                                We will keep you updated about your order status and delivery.
                                Thank you for choosing METAVERSE INFO.
                            </p>
                        @endif
                        <p style="margin:0; font-size:14px; color:#111827; line-height:1.7;">
                            Thank you for choosing <strong>METAVERSE INFO</strong>.
                        </p>
                    </td>
                </tr>
                <tr>
                    <td style="background:#111827; padding:22px 30px; text-align:center;">
                        <img src="{{ url('assets/img/logo.png') }}"  alt="METAVERSE INFO" width="130"
                            style="display:block; margin:0 auto 10px auto; max-width:130px; height:auto; border:0;">
                        <div style="font-size:12px; color:#9ca3af; line-height:1.6;">
                            This is an automated order confirmation email.<br>
                            Please do not reply to this email.
                        </div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>