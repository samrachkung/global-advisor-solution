<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = ['code', 'name', 'is_default', 'status'];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
