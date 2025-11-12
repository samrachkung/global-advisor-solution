<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Complaint extends Model
{
    protected $fillable = [
        'reference_number',
        'customer_name',
        'customer_email',
        'customer_phone',
        'loan_type_id',
        'subject',
        'description',
        'attachment',
        'status',
        'priority',
        'assigned_to',
        'resolved_at'
    ];

    protected $casts = [
        'resolved_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($complaint) {
            $complaint->reference_number = 'CMP-' . strtoupper(Str::random(10));
        });
    }

    public function loanType()
    {
        return $this->belongsTo(LoanType::class);
    }

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function responses()
    {
        return $this->hasMany(ComplaintResponse::class);
    }
}
