<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = ['slug', 'template', 'status'];

    public function translations()
    {
        return $this->hasMany(PageTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
