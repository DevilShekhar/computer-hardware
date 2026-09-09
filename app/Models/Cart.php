<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    /**
     * Cart belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Cart has many items
     */
    public function items()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Cart items with products
     */
    public function itemsWithProducts()
    {
        return $this->hasMany(CartItem::class)
            ->with('product');
    }
}
