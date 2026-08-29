<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuilderBrand extends Model
{
    use HasFactory;

    protected $table = 'builder_brands';

    protected $fillable = [
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
}