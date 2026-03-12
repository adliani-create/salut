<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeSetting;
use App\Models\News;

class PublicController extends Controller
{
    public function index()
    {
        $setting = HomeSetting::first();
        // Fallback for defaults if DB empty (though I should have seeded, but code-level fallback is safe)
        if (!$setting) {
            $setting = new HomeSetting([
                'hero_title' => 'Selamat Datang di SALUT Indo Global',
                'hero_subtitle' => 'Sentra Layanan Universitas Terbuka',
            ]);
        }

        $latestNews = News::where('status', 'published')
                          ->latest('published_at')
                          ->limit(3)
                          ->get();

        $advantages = \App\Models\LandingItem::where('section', 'advantage')->orderBy('order_index')->get();
        // If empty, we can provide defaults or handle in view. Let's assume view handles emptiness.
        
        $studies = \App\Models\LandingItem::where('section', 'study')->orderBy('order_index')->get();

        return view('welcome', compact('setting', 'latestNews', 'advantages', 'studies'));
    }

    public function showNews($slug)
    {
        $news = News::where('slug', $slug)
                    ->where('status', 'published')
                    ->firstOrFail();

        return view('news.show', compact('news'));
    }
}
