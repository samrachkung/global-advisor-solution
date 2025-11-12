<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanTypeTranslation extends Model
{
    protected $fillable = [
        'loan_type_id',
        'language_id',
        'title',
        'description',
        'conditions',
        'collateral_info'
    ];

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function language()
    {
        return $this->belongsTo(Language::class);
    }
}
