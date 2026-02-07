<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'title',
        'image',
        'description',
        'order_index',
    ];
}
