<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\HomeSetting;
use Illuminate\Support\Facades\Storage;

class HomeSettingController extends Controller
{
    public function edit()
    {
        // Get the first record or create default if not exists
        $setting = HomeSetting::firstOrCreate(
            ['id' => 1],
            [
                'hero_title' => 'Selamat Datang di SALUT Indo Global',
                'hero_subtitle' => 'Sentra Layanan Universitas Terbuka',
            ]
        );

        return view('admin.cms.home_settings', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = HomeSetting::firstOrFail();

        $request->validate([
            'hero_title' => 'required|string|max:255',
            'hero_subtitle' => 'nullable|string|max:255',
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240', // Increased to 10MB
            'about_title' => 'nullable|string|max:255',
            'about_content' => 'nullable|string',
            'about_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'whatsapp' => 'nullable|string|max:20',
            'footer_description' => 'nullable|string|max:500',
            'address' => 'nullable|string|max:500',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'instagram_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'google_maps_link' => 'nullable|url|max:500',
        ]);

        $setting->hero_title = $request->hero_title;
        $setting->hero_subtitle = $request->hero_subtitle;
        $setting->about_title = $request->about_title;
        $setting->about_content = $request->about_content;
        $setting->whatsapp = $request->whatsapp;
        
        $setting->footer_description = $request->footer_description;
        $setting->address = $request->address;
        $setting->email = $request->email;
        $setting->phone = $request->phone;
        $setting->instagram_url = $request->instagram_url;
        $setting->tiktok_url = $request->tiktok_url;
        $setting->google_maps_link = $request->google_maps_link;

        if ($request->hasFile('banner_image')) {
            if ($setting->banner_path && Storage::disk('public')->exists($setting->banner_path)) {
                Storage::disk('public')->delete($setting->banner_path);
            }
            $setting->banner_path = $request->file('banner_image')->store('banners', 'public');
        }

        if ($request->hasFile('about_image')) {
            if ($setting->about_image && Storage::disk('public')->exists($setting->about_image)) {
                Storage::disk('public')->delete($setting->about_image);
            }
            $setting->about_image = $request->file('about_image')->store('about', 'public');
        }

        $setting->save();

        return redirect()->back()->with('success', 'Halaman Beranda berhasil diperbarui.');
    }
}
