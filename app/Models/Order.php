<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'order_number',
        'customer_name',
        'email',
        'mobile_number',
        'address',
        'city',
        'state',
        'pincode',
        'country',
        'subtotal',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'payment_method',
        'payment_status',
        'status',
        'cancel_reason',
        'cancel_remark',
        'cancelled_at',
        'order_notes',
        'ship_to_different',
        'shipping_name',
        'shipping_mobile',
        'shipping_address',
        'shipping_city',
        'shipping_state',
        'shipping_pincode',
        'shipping_country',
        'razorpay_order_id',
        'razorpay_payment_id',
        'razorpay_signature',
        'customer_upi_id',
        'return_reason',
        'refund_status',
        'refund_method',
        'refund_amount',
        'refund_reason',
        'refund_remark',
        'refunded_at',
        'razorpay_refund_id',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'status' => 'integer',
        'cancelled_at' => 'datetime',
        'refunded_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistories()
    {
        return $this->hasMany(OrderStatusHistory::class);
    }

    public function latestStatusHistory()
    {
        return $this->hasOne(OrderStatusHistory::class)->latestOfMany();
    }

    public function getStatusNameAttribute()
    {
        return match ((int) $this->status) {
            0 => 'Pending',
            1 => 'Confirmed',
            2 => 'Processing',
            3 => 'Shipped',
            4 => 'Delivered',
            default => 'Unknown',
        };
    }
}
