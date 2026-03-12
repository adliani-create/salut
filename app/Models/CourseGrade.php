<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseGrade extends Model
{
    use HasFactory;

    protected $fillable = [
        'academic_record_id',
        'course_code',
        'course_name',
        'sks',
        'grade_letter',
        'grade_point',
    ];

    public function academicRecord()
    {
        return $this->belongsTo(AcademicRecord::class);
    }
}
