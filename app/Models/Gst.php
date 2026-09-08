<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gst extends Model
{
    protected $fillable = [
        'gst_amount',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'gst_amount' => 'decimal:2',
        'status' => 'boolean',
    ];

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}