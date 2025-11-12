<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoanCondition extends Model
{
    protected $fillable = [
        'loan_type_id',
        'currency_type',
        'min_amount',
        'max_amount',
        'max_duration_months',
        'min_age',
        'max_age',
        'max_debt_ratio'
    ];

    protected $casts = [
        'min_amount' => 'decimal:2',
        'max_amount' => 'decimal:2',
        'max_debt_ratio' => 'decimal:2',
    ];

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }
}
