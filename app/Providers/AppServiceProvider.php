<?php

namespace App\Providers;

use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        Vite::prefetch(concurrency: 3);

        // Share settings with all views
        View::composer('*', function ($view) {
            $view->with('settings', [
                'title' => \App\Models\Setting::get('website_title', config('app.name')),
                'subtitle' => \App\Models\Setting::get('website_subtitle', ''),
                'logo' => \App\Models\Setting::get('website_logo', ''),
                'favicon' => \App\Models\Setting::get('website_favicon', ''),
                'thumbnail' => \App\Models\Setting::get('website_thumbnail', ''),
                'footer_copyright' => \App\Models\Setting::get('footer_copyright', '© ' . date('Y') . ' ' . config('app.name')),
            ]);
        });
    }
}
