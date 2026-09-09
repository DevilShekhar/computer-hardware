<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatusHistory extends Model
{
    const STATUS_PENDING = 0;
    const STATUS_CONFIRMED = 1;
    const STATUS_PROCESSING = 2;
    const STATUS_SHIPPED = 3;
    const STATUS_DELIVERED = 4;

    const STATUS_CANCELLED = 5;
    const STATUS_FAILED = 6;
    const STATUS_REFUNDED = 7;

    protected $fillable = [
        'order_id',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'status' => 'integer',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function getStatusNameAttribute()
    {
        return match ($this->status) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_CONFIRMED => 'Confirmed',
            self::STATUS_PROCESSING => 'Processing',
            self::STATUS_SHIPPED => 'Shipped',
            self::STATUS_DELIVERED => 'Delivered',
            self::STATUS_CANCELLED => 'Cancelled',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_REFUNDED => 'Refunded',
            default => 'Unknown',
        };
    }
}