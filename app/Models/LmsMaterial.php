<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LmsMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'file_path',
        'description',
    ];

    public function careerPrograms()
    {
        return $this->belongsToMany(CareerProgram::class, 'career_program_lms_material');
    }
}
