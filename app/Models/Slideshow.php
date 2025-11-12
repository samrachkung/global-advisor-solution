<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slideshow extends Model
{
    protected $fillable = [
        'image',
        'link',
        'order',
        'status'
    ];
    public function translations()
    {
        return $this->hasMany(SlideshowTranslation::class, 'slideshow_id');
    }

    public function translation($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }


    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
