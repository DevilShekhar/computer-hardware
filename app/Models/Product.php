<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_brand_id',
        'category_id',
        'sub_category_id',
        'name',
        'slug',
        'sku',
        'short_description',
        'description',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'price',
        'sale_price',
        'stock_quantity',
        'hsn',
        'gst_rate',
        'warranty_information',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'gst_rate' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function productBrand()
    {
        return $this->belongsTo(ProductBrand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function specifications()
    {
        return $this->hasMany(ProductSpecification::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function builderProducts()
    {
        return $this->hasMany(BuilderProduct::class,'product_id');
    }
}