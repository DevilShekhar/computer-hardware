<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderProduct extends Model
{
    use HasFactory;

    protected $table = 'builder_products';

    protected $fillable = [
        'product_id',
        'builder_type_id',
        'builder_brand_id',
        'builder_category_id',
        'builder_sub_category_id',
        'sort_order',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    public function builderType()
    {
        return $this->belongsTo(BuilderType::class, 'builder_type_id');
    }

    public function builderBrand()
    {
        return $this->belongsTo(BuilderBrand::class, 'builder_brand_id');
    }

    public function builderCategory()
    {
        return $this->belongsTo(BuilderCategory::class, 'builder_category_id');
    }

    public function builderSubCategory()
    {
        return $this->belongsTo(BuilderSubCategory::class, 'builder_sub_category_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}