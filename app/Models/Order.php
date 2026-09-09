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
        'order_notes',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'shipping_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'total_amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
