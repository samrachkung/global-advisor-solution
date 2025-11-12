<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPositionTranslation extends Model
{
    protected $fillable = [
        'job_position_id',
        'language_id',
        'title',
        'description',
        'requirements',
        'responsibilities',
        'benefits'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
