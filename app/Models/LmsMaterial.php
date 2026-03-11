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
        'url',
        'source_type',
        'description',
        'thumbnail',
        'duration',
    ];

    public function careerPrograms()
    {
        return $this->belongsToMany(CareerProgram::class, 'career_program_lms_material');
    }

    public function completions()
    {
        return $this->belongsToMany(User::class, 'lms_material_user')
                    ->withPivot('completed_at')
                    ->withTimestamps();
    }
}
