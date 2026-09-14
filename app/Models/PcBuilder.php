<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PcBuilder extends Model
{
    protected $fillable = [
        'user_id',
        'builder_number',
        'products',
        'subtotal',
        'gst_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'customer_name',
        'email',
        'mobile_number',
        'address',
        'city',
        'state',
        'pincode',
        'country',
        'order_notes',
        'cancel_reason',
        'cancel_remark',
        'cancelled_at',
        'return_reason',
        'return_remark',
        'returned_at',
    ];

    protected $casts = [
        'products' => 'array',
        'subtotal' => 'decimal:2',
        'gst_amount' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function statusHistories()
    {
        return $this->hasMany(PcBuilderStatusHistory::class)->latest();
    }
}
