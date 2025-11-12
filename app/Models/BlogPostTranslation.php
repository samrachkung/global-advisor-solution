<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogPostTranslation extends Model
{
    protected $fillable = [
        'post_id',
        'language_id',
        'title',
        'excerpt',
        'content',
        'meta_title',
        'meta_description'
    ];

    public function post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
