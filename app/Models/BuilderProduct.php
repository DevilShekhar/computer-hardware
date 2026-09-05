<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderProduct extends Model
{
    use HasFactory;
    protected $table = 'builder_products';
    protected $fillable = [
        'builder_type_id',
        'product_type',
        'product_id',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];
    protected $casts = [
        'builder_type_id' => 'integer',
        'product_id'      => 'integer',
        'sort_order'      => 'integer',
        'status'          => 'boolean',
    ];
    public function builderType()
    {
        return $this->belongsTo(
            BuilderType::class,
            'builder_type_id'
        );
    }
    public function getProductTypeNameAttribute()
    {
        return $this->product_type;
    }
    public function product()
    {
        return $this->belongsTo(
            Product::class,
            'product_id'
        );
    }
    public function createdBy()
    {
        return $this->belongsTo(
            User::class,
            'created_by'
        );
    }
    public function updatedBy()
    {
        return $this->belongsTo(
            User::class,
            'updated_by'
        );
    }
}