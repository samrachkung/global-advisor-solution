<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollateralTypeTranslation extends Model
{
    protected $fillable = [
        'collateral_type_id',
        'language_id',
        'name',
        'description'
    ];

    public function collateralType()
    {
        return $this->belongsTo(CollateralType::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
