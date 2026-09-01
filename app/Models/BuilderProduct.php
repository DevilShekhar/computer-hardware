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

    /*
    |--------------------------------------------------------------------------
    | Main Product
    |--------------------------------------------------------------------------
    */

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Builder Brand
    |--------------------------------------------------------------------------
    */

    public function builderBrand()
    {
        return $this->belongsTo(
            BuilderBrand::class,
            'builder_brand_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Builder Category
    |--------------------------------------------------------------------------
    */

    public function builderCategory()
    {
        return $this->belongsTo(
            BuilderCategory::class,
            'builder_category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Builder Sub Category
    |--------------------------------------------------------------------------
    */

    public function builderSubCategory()
    {
        return $this->belongsTo(
            BuilderSubCategory::class,
            'builder_sub_category_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Created By
    |--------------------------------------------------------------------------
    */

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Updated By
    |--------------------------------------------------------------------------
    */

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}