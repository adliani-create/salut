<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PointLedger extends Model
{
    protected $fillable = [
        'user_id',
        'type',
        'amount',
        'source_id',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function source()
    {
        return $this->belongsTo(User::class, 'source_id');
    }

    public function sourceUser()
    {
        return $this->belongsTo(User::class, 'source_id');
    }
}
