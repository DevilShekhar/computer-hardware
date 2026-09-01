<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderSubCategory extends Model
{
    use HasFactory;

    protected $table = 'builder_sub_categories';

    protected $fillable = [
        'builder_type_id',
        'brand_id',
        'category_id',
        'name',
        'slug',
        'sub_cat_image',
        'meta_title',
        'meta_keywords',
        'meta_description',
        'created_by',
        'updated_by',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function builderType()
    {
        return $this->belongsTo(BuilderType::class, 'builder_type_id');
    }

    public function brand()
    {
        return $this->belongsTo(BuilderBrand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(BuilderCategory::class, 'category_id');
    }

    public function builderProducts()
    {
        return $this->hasMany(BuilderProduct::class, 'builder_sub_category_id');
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