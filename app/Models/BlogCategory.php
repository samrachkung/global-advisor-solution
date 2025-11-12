<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogCategory extends Model
{
    use HasSlug;

    protected $fillable = ['slug', 'status'];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('slug');
    }

    public function translations()
    {
        return $this->hasMany(BlogCategoryTranslation::class, 'category_id');
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category_id');
    }
}
