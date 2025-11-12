<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlideshowTranslation extends Model
{
    protected $fillable = [
        'slideshow_id',
        'language_id',
        'title',
        'description',
        'button_text'
    ];

    public function slideshow()
    {
        return $this->belongsTo(Slideshow::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
