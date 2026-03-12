<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TutorialSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_name',
        'day',
        'time',
        'link',
    ];
}
