<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentTrack extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'track_name',
        'selected_at',
    ];

    protected $casts = [
        'selected_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
