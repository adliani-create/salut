<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class webinar extends Model
{
    use HasFactory;

    protected $fillable = [
        'topic',
        'speaker',
        'date',
        'time',
        'link',
        'description',
    ];
}
