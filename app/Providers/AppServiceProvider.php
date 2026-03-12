<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            // Share home settings with all views
            if (\Illuminate\Support\Facades\Schema::hasTable('home_settings')) {
                $setting = \App\Models\HomeSetting::first();
                // Create default if not exists to avoid null on fresh install
                if (!$setting) {
                    $setting = new \App\Models\HomeSetting([
                        'hero_title' => 'Selamat Datang di SALUT Indo Global',
                        'hero_subtitle' => 'Sentra Layanan Universitas Terbuka',
                    ]);
                }
                \Illuminate\Support\Facades\View::share('homeSetting', $setting);
            }
        } catch (\Exception $e) {
            // Log::error('Failed to share homeSetting: ' . $e->getMessage());
        }
        
        \Illuminate\Pagination\Paginator::useBootstrapFive();
    }
}
