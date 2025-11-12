<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobApplication extends Model
{
    protected $fillable = [
        'job_position_id',
        'full_name',
        'email',
        'phone',
        'resume',
        'cover_letter',
        'status'
    ];

    public function jobPosition()
    {
        return $this->belongsTo(JobPosition::class);
    }
}
