<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderCategory extends Model
{
    use HasFactory;

    protected $table = 'builder_categories';

    protected $fillable = [
        'brand_id',
        'name',
        'slug',
        'cat_image',
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

    public function brand()
    {
        return $this->belongsTo(BuilderBrand::class, 'brand_id');
    }
    public function subCategories()
    {
        return $this->hasMany(BuilderSubCategory::class, 'category_id');
    }
    public function builderProducts()
    {
        return $this->hasMany(
            BuilderProduct::class,
            'builder_category_id'
        );
    }
}