<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderType extends Model
{
    use HasFactory;

    protected $table = 'builder_types';

    protected $fillable = [
        'name',
        'slug',
        'image',
        'description',
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

    public function builderTypeProducts()
    {
        return $this->hasMany(BuilderTypeProduct::class, 'builder_type_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
    public function builderBrands()
    {
        return $this->hasMany(BuilderBrand::class, 'builder_type_id');
    }
    public function builderCategories()
    {
        return $this->hasMany(BuilderCategory::class,'builder_type_id');
    }
}