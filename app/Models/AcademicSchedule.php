<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicSchedule extends Model
{
    protected $fillable = [
        'title',
        'type',
        'date',
        'time',
        'deadline',
        'target_semester',
        'prodi_id',
        'user_id',
    ];

    protected $casts = [
        'date' => 'date',
        'deadline' => 'datetime',
    ];

    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
