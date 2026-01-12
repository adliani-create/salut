<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'semester',
        'sks',
        'ipk',
        'ips',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
