<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'product_id',
        'discount_type',
        'discount_value',
        'minimum_order_value',
        'usage_limit',
        'used_count',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'minimum_order_value' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'status' => 'boolean',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
