<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CollateralType extends Model
{
    protected $fillable = ['loan_type_id'];

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function translations()
    {
        return $this->hasMany(CollateralTypeTranslation::class);
    }

    public function translation($locale = null)
    {
        $locale = $locale ?? app()->getLocale();
        return $this->translations()
            ->whereHas('language', fn($q) => $q->where('code', $locale))
            ->first();
    }
}
