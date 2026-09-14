<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function download(Order $order)
    {
        $order->load([
            'user',
            'items.product.gst',
        ]);
        $subtotal = 0;
        $totalGst = 0;
        foreach ($order->items as $item) {
            $quantity = (int) $item->quantity;
            $price = (float) $item->price;
            $itemSubtotal = round(
                $price * $quantity,
                2
            );
            $hasGst = false;
            if ($item->product) {
                $hasGst = strtolower(
                    trim((string) $item->product->gst_type)
                ) === 'yes';
            }
            $gstRate = 0;
            if ($hasGst && $item->product && $item->product->gst) {
                $gstRate = (float) $item->product->gst->gst_amount;
            }
            $itemGst = 0;
            if ($hasGst && $gstRate > 0) {
                $itemGst = round(
                    ($itemSubtotal * $gstRate) / 100,
                    2
                );
            }
            $subtotal += $itemSubtotal;
            $totalGst += $itemGst;
        }
        $subtotal = round($subtotal, 2);
        $totalGst = round($totalGst,2);
        $discount = (float) (
            $order->discount_amount ?? 0
        );
        $discount = round($discount,2);
        $shipping = (float) (
            $order->shipping_amount ?? 0
        );
        $shipping = round($shipping, 2);
        $taxableAmount = $subtotal - $discount;
        if ($taxableAmount < 0) {
            $taxableAmount = 0;
        }
        $taxableAmount = round( $taxableAmount, 2);
        $grandTotal = round(
            $taxableAmount +
            $shipping +
            $totalGst,
            2
        );
        $pdf = Pdf::loadView(
            'admin.invoices.index',
            [
                'order' => $order,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'shipping' => $shipping,
                'taxableAmount' => $taxableAmount,
                'totalGst' => $totalGst,
                'grandTotal' => $grandTotal,
            ]
        );
        $pdf->setPaper('A4','portrait');
        return $pdf->download('invoice-' . $order->order_number .'.pdf');
    }
}