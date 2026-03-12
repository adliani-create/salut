<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CareerProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        '_token',
    ];
}
