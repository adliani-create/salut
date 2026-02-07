<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'billing_code',
        'category',
        'amount',
        'semester',
        'status',
        'due_date',
        'payment_proof',
        'payment_date',
        'verified_at',
        'rejection_reason',
        'description',
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
