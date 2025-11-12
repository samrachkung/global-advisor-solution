<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PageTranslation extends Model
{
    protected $fillable = [
        'page_id',
        'language_id',
        'title',
        'meta_title',
        'meta_description',
        'content'
    ];

    public function page()
    {
        return $this->belongsTo(Page::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
