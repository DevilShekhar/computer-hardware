<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>
        PC Builder Order Confirmed
    </title>

    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
        }

        .email-wrapper {
            width: 100%;
            padding: 30px 0;
        }

        .email-container {
            max-width: 900px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #eeeeee;
            border-radius: 8px;
            overflow: hidden;
        }

        .header {
            padding: 25px;
            text-align: center;
            border-bottom: 1px solid #eeeeee;
        }

        .header img {
            max-width: 220px;
            max-height: 80px;
        }

        .content {
            padding: 30px;
        }

        .success-title {
            margin: 0 0 15px;
            font-size: 24px;
            color: #198754;
        }

        .text {
            font-size: 15px;
            line-height: 1.6;
            margin-bottom: 15px;
        }

        .order-box {
            margin-top: 25px;
            border: 1px solid #dddddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .order-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .order-box td {
            padding: 12px 15px;
            border-bottom: 1px solid #eeeeee;
            vertical-align: top;
        }

        .order-box tr:last-child td {
            border-bottom: none;
        }

        .order-box td:first-child {
            width: 40%;
            font-weight: 600;
            background-color: #fafafa;
        }

        .products {
            margin-top: 30px;
        }

        .products h3 {
            margin-bottom: 15px;
        }

        .products-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .products table {
            width: 100%;
            min-width: 750px;
            border-collapse: collapse;
        }

        .products th,
        .products td {
            padding: 10px 8px;
            border: 1px solid #dddddd;
            text-align: left;
            font-size: 13px;
        }

        .products th {
            background-color: #f8f8f8;
            font-weight: 600;
        }

        .products td.number,
        .products th.number {
            text-align: right;
            white-space: nowrap;
        }

        .products td.center,
        .products th.center {
            text-align: center;
        }

        .products .product-name {
            min-width: 180px;
        }

        .products .sku {
            min-width: 100px;
        }

        .total-box {
            margin-top: 25px;
            border: 1px solid #dddddd;
            border-radius: 6px;
            overflow: hidden;
        }

        .total-box table {
            width: 100%;
            border-collapse: collapse;
        }

        .total-box td {
            padding: 12px 15px;
            border-bottom: 1px solid #eeeeee;
        }

        .total-box tr:last-child td {
            border-bottom: none;
        }

        .total-label {
            font-weight: 600;
        }

        .total-value {
            text-align: right;
            white-space: nowrap;
        }

        .grand-total td {
            font-size: 18px;
            font-weight: bold;
            background-color: #f8f8f8;
        }

        .footer {
            padding: 20px 30px;
            background-color: #f8f8f8;
            text-align: center;
            font-size: 13px;
            line-height: 1.6;
            color: #777777;
        }

        @media only screen and (max-width: 600px) {

            .email-wrapper {
                padding: 10px 0;
            }

            .email-container {
                width: 100%;
                border-radius: 0;
            }

            .content {
                padding: 20px;
            }

            .header {
                padding: 20px;
            }

            .order-box td:first-child {
                width: 45%;
            }

            .products-wrapper {
                overflow-x: auto;
            }

            .products table {
                min-width: 750px;
            }
        }
    </style>
</head>

<body>

<div class="email-wrapper">

    <div class="email-container">

        {{-- =========================================================
             HEADER
        ========================================================== --}}
        <div class="header">

            <img
                src="{{ asset('assets/img/logo.png') }}"
                alt="{{ config('app.name') }}"
            >

        </div>


        {{-- =========================================================
             CONTENT
        ========================================================== --}}
        <div class="content">

            {{-- Payment Successful --}}
            <h1 class="success-title">
                Payment Successful
            </h1>


            {{-- Customer Greeting --}}
            <p class="text">
                Hello {{ $pcBuilder->customer_name }},
            </p>


            <p class="text">
                Your PC Builder order has been successfully confirmed.
                We have received your payment and your order is now being processed.
            </p>


            {{-- =====================================================
                 ORDER DETAILS
            ====================================================== --}}
            <div class="order-box">

                <table>

                    <tr>
                        <td>
                            Builder Number
                        </td>

                        <td>
                            {{ $pcBuilder->builder_number }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Payment Method
                        </td>

                        <td>
                            {{ ucfirst($pcBuilder->payment_method) }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Payment Status
                        </td>

                        <td>
                            {{ ucfirst($pcBuilder->payment_status) }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Order Status
                        </td>

                        <td>
                            {{ ucfirst($pcBuilder->status) }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Customer Name
                        </td>

                        <td>
                            {{ $pcBuilder->customer_name }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Email
                        </td>

                        <td>
                            {{ $pcBuilder->email }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Mobile Number
                        </td>

                        <td>
                            {{ $pcBuilder->mobile_number }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Address
                        </td>

                        <td>
                            {{ $pcBuilder->address }},
                            {{ $pcBuilder->city }},
                            {{ $pcBuilder->state }},
                            {{ $pcBuilder->pincode }},
                            {{ $pcBuilder->country }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Razorpay Order ID
                        </td>

                        <td>
                            {{ $pcBuilder->razorpay_order_id }}
                        </td>
                    </tr>


                    <tr>
                        <td>
                            Razorpay Payment ID
                        </td>

                        <td>
                            {{ $pcBuilder->razorpay_payment_id }}
                        </td>
                    </tr>

                </table>

            </div>


            {{-- =====================================================
                 PRODUCTS
            ====================================================== --}}

            @php

                /*
                |--------------------------------------------------------------------------
                | Get Products
                |--------------------------------------------------------------------------
                */

                $products = is_array($pcBuilder->products)
                    ? $pcBuilder->products
                    : json_decode($pcBuilder->products, true);

            @endphp


            @if(!empty($products))

                <div class="products">

                    <h3>
                        PC Builder Products
                    </h3>


                    <div class="products-wrapper">

                        <table>

                            <thead>

                                <tr>

                                    <th class="product-name">
                                        Component
                                    </th>

                                    <th class="sku">
                                        SKU
                                    </th>

                                    <th class="center">
                                        Qty
                                    </th>

                                    <th class="number">
                                        Price
                                    </th>

                                    <th class="number">
                                        GST %
                                    </th>

                                    <th class="number">
                                        GST Amount
                                    </th>

                                    <th class="number">
                                        Total
                                    </th>

                                </tr>

                            </thead>


                            <tbody>

                                @foreach($products as $product)

                                    @php

                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product Price
                                        |--------------------------------------------------------------------------
                                        */

                                        $price = (float) (
                                            $product['price'] ?? 0
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Quantity
                                        |--------------------------------------------------------------------------
                                        */

                                        $quantity = (int) (
                                            $product['quantity'] ?? 1
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | GST Rate
                                        |--------------------------------------------------------------------------
                                        */

                                        $gstRate = (float) (
                                            $product['gst_rate'] ?? 0
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | GST Amount
                                        |--------------------------------------------------------------------------
                                        |
                                        | Controller already stores the total GST
                                        | amount for this product based on quantity.
                                        |
                                        */

                                        $gstAmount = (float) (
                                            $product['gst_amount'] ?? 0
                                        );


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Product Subtotal
                                        |--------------------------------------------------------------------------
                                        */

                                        $productSubtotal = $price * $quantity;


                                        /*
                                        |--------------------------------------------------------------------------
                                        | Total Including GST
                                        |--------------------------------------------------------------------------
                                        */

                                        $productTotal = $productSubtotal + $gstAmount;

                                    @endphp


                                    <tr>

                                        {{-- Component --}}
                                        <td class="product-name">
                                            {{ $product['product_name'] ?? 'Product' }}
                                        </td>


                                        {{-- SKU --}}
                                        <td class="sku">
                                            {{ $product['sku'] ?? '-' }}
                                        </td>


                                        {{-- Quantity --}}
                                        <td class="center">
                                            {{ $quantity }}
                                        </td>


                                        {{-- Price --}}
                                        <td class="number">
                                            ₹{{ number_format($price, 2) }}
                                        </td>


                                        {{-- GST Percentage --}}
                                        <td class="number">
                                            {{ number_format($gstRate, 2) }}%
                                        </td>


                                        {{-- GST Amount --}}
                                        <td class="number">
                                            ₹{{ number_format($gstAmount, 2) }}
                                        </td>


                                        {{-- Total --}}
                                        <td class="number">
                                            <strong>
                                                ₹{{ number_format($productTotal, 2) }}
                                            </strong>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            @endif


            {{-- =====================================================
                 ORDER TOTALS
            ====================================================== --}}

            <div class="total-box">

                <table>

                    {{-- Subtotal --}}
                    <tr>

                        <td class="total-label">
                            Subtotal
                        </td>

                        <td class="total-value">
                            ₹{{ number_format((float) $pcBuilder->subtotal, 2) }}
                        </td>

                    </tr>


                    {{-- GST --}}
                    <tr>

                        <td class="total-label">
                            GST
                        </td>

                        <td class="total-value">
                            ₹{{ number_format((float) $pcBuilder->gst_amount, 2) }}
                        </td>

                    </tr>


                    {{-- Shipping --}}
                    <tr>

                        <td class="total-label">
                            Shipping
                        </td>

                        <td class="total-value">
                            ₹{{ number_format((float) $pcBuilder->shipping_amount, 2) }}
                        </td>

                    </tr>


                    {{-- Discount --}}
                    <tr>

                        <td class="total-label">
                            Discount
                        </td>

                        <td class="total-value">
                            ₹{{ number_format((float) $pcBuilder->discount_amount, 2) }}
                        </td>

                    </tr>


                    {{-- Grand Total --}}
                    <tr class="grand-total">

                        <td>
                            Grand Total
                        </td>

                        <td class="total-value">
                            ₹{{ number_format((float) $pcBuilder->total_amount, 2) }}
                        </td>

                    </tr>

                </table>

            </div>


            {{-- =====================================================
                 THANK YOU
            ====================================================== --}}

            <p class="text" style="margin-top: 25px;">

                Thank you for choosing us for your custom PC build.

            </p>

        </div>


        {{-- =========================================================
             FOOTER
        ========================================================== --}}
        <div class="footer">

            <p>
                This is an automated email.
                Please do not reply to this email.
            </p>

            <p>
                &copy; {{ date('Y') }}
                {{ config('app.name') }}.
                All rights reserved.
            </p>

        </div>

    </div>

</div>

</body>
</html>