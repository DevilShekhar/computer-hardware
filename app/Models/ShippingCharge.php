<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingCharge extends Model
{
    protected $fillable = [
        'name',
        'state',
        'city',
        'pincode',
        'charges',
        'created_by',
        'updated_by',
    ];
}
