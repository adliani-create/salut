<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prospect extends Model
{
    use HasFactory;

    protected $fillable = [
        'affiliator_id',
        'name',
        'whatsapp',
        'school_origin',
        'program_interest',
        'status',
    ];

    public function affiliator()
    {
        return $this->belongsTo(User::class, 'affiliator_id');
    }
}
