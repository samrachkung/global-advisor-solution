<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class JobPosition extends Model
{
    use HasSlug;

    protected $fillable = [
        'slug',
        'department',
        'location',
        'employment_type',
        'salary_range',
        'application_deadline',
        'status'
    ];

    protected $casts = [
        'application_deadline' => 'date',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function translations()
    {
        return $this->hasMany(JobPositionTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
            ->where(function($q) {
                $q->whereNull('application_deadline')
                  ->orWhere('application_deadline', '>=', now());
            });
    }
}
