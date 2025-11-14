<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'customer_name',
        'email',
        'phone_number',
        'loan_amount',
        'loan_type_id',
        'consultation',
        'consultation_fee',
        'consultation_date',
        'consultation_time',
        'status',
        'shared_to_telegram',
        'owner_id',
        'attachment',
        'created_by',
    ];

    protected $casts = [
        'loan_amount' => 'decimal:2',
        'consultation_fee' => 'decimal:2',
        'consultation_date' => 'date',
        'consultation_time' => 'datetime:H:i:s',
        'shared_to_telegram' => 'bool',
    ];
    public function creator() { return $this->belongsTo(\App\Models\User::class, 'created_by'); }
    public function loanType()
    {
        return $this->belongsTo(\App\Models\LoanType::class);
    }
    public function owner()
    {
        return $this->belongsTo(\App\Models\User::class, 'owner_id');
    }
}
