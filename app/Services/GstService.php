<?php

namespace App\Services;

class GstService
{
    public function calculate($cartItems, string $state): array
    {
        $isMaharashtra = strtolower(trim($state)) === 'maharashtra';

        $gstAmount  = 0;
        $cgstAmount = 0;
        $sgstAmount = 0;
        $igstAmount = 0;

        $items = [];

        foreach ($cartItems as $item) {
            $product = $item->product;

            $price     = (float) $item->price;
            $quantity  = (int) $item->quantity;
            $itemTotal = $price * $quantity;

            $gstRate = 0;

            if ($product && $product->gst_type === 'yes' && $product->gst) {
                $gstRate = (float) $product->gst->gst_amount;
            }

            $itemGstAmount = $gstRate > 0 ? ($itemTotal * $gstRate) / 100 : 0;

            $itemCgstRate = $itemCgstAmount = 0;
            $itemSgstRate = $itemSgstAmount = 0;
            $itemIgstRate = $itemIgstAmount = 0;

            if ($isMaharashtra && $gstRate > 0) {
                $itemCgstRate   = $gstRate / 2;
                $itemSgstRate   = $gstRate / 2;
                $itemCgstAmount = $itemGstAmount / 2;
                $itemSgstAmount = $itemGstAmount / 2;

                $cgstAmount += $itemCgstAmount;
                $sgstAmount += $itemSgstAmount;
            } elseif ($gstRate > 0) {
                $itemIgstRate   = $gstRate;
                $itemIgstAmount = $itemGstAmount;

                $igstAmount += $itemIgstAmount;
            }

            $gstAmount += $itemGstAmount;

            $items[] = [
                'product_id'   => $item->product_id,
                'product_name' => $product->name ?? '',
                'sku'          => $product->sku ?? null,
                'price'        => $price,
                'quantity'     => $quantity,

                'gst_rate'     => $gstRate,
                'gst_amount'   => $itemGstAmount,

                'cgst_rate'    => $itemCgstRate,
                'cgst_amount'  => $itemCgstAmount,

                'sgst_rate'    => $itemSgstRate,
                'sgst_amount'  => $itemSgstAmount,

                'igst_rate'    => $itemIgstRate,
                'igst_amount'  => $itemIgstAmount,
            ];
        }

        return [
            'gst_type'    => $isMaharashtra ? 'intra_state' : 'inter_state',
            'gst_amount'  => $gstAmount,
            'cgst_amount' => $cgstAmount,
            'sgst_amount' => $sgstAmount,
            'igst_amount' => $igstAmount,
            'items'       => $items,
        ];
    }
}
