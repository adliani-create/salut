<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Training extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'program',
        'instructor',
        'date',
        'time',
        'location',
        'description',
    ];

    public function careerPrograms()
    {
        return $this->belongsToMany(CareerProgram::class, 'career_program_training');
    }
}
