<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

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
        Inertia::share('settings', [
            'websiteTitle' => config('app.name'),
            'websiteSubtitle' => '',
            'websiteLogo' => null,
            'websiteFavicon' => null,
            'websiteThumbnail' => null,
            'footerCopyright' => '© ' . date('Y') . ' ' . config('app.name'),
        ]);
    }
}
