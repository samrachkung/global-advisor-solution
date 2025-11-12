<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogCategoryTranslation extends Model
{
    protected $fillable = [
        'category_id',
        'language_id',
        'name',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(BlogCategory::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
