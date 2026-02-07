<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_title',
        'hero_subtitle',
        'banner_path',
        'about_title',
        'about_content',
        'about_image',
        'whatsapp',
        'footer_description',
        'address',
        'email',
        'phone',
        'instagram_url',
        'tiktok_url',
        'google_maps_link',
    ];
}
