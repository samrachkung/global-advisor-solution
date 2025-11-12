<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class BlogPost extends Model
{
    use HasSlug;

    protected $fillable = [
        'category_id',
        'author_id',
        'slug',
        'featured_image',
        'published_at',
        'status',
        'views_count'
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function category()
    {
        return $this->belongsTo(BlogCategory::class, 'category_id');
    }

    public function author()
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function translations()
    {
        return $this->hasMany(BlogPostTranslation::class, 'post_id'); // Changed from blog_post_id
    }

    public function translation($locale = null)
    {
        $locale = $locale ?: app()->getLocale();
        return $this->translations()
            ->whereHas('language', function($q) use ($locale) {
                $q->where('code', $locale);
            })
            ->first();
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published')
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function incrementViews()
    {
        $this->increment('views_count');
    }
}
