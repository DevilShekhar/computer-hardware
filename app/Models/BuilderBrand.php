<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderBrand extends Model
{
    use HasFactory;

    protected $table = 'builder_brands';

    protected $fillable = [
        'builder_type_id',
        'name',
        'slug',
        'brand_image',
        'status',
        'created_by',
        'updated_by',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];
    public function categories()
    {
        return $this->hasMany(BuilderCategory::class, 'brand_id');
    }
    public function builderType()
    {
        return $this->belongsTo(BuilderType::class, 'builder_type_id');
    }
    public function builderProducts()
    {
        return $this->hasMany(BuilderProduct::class,'builder_brand_id');
    }
}