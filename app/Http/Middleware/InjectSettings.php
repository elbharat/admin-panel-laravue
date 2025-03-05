<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Middleware;

class InjectSettings extends Middleware
{
    public function share(Request $request): array
    {
        try {
            $settings = Setting::all(['key', 'value'])->pluck('value', 'key')->toArray();

            return array_merge(parent::share($request), [
                'settings' => [
                    'title' => $settings['website_title'] ?? config('app.name'),
                    'subtitle' => $settings['website_subtitle'] ?? '',
                    'logo' => isset($settings['website_logo']) ? '/storage/' . $settings['website_logo'] : null,
                    'favicon' => isset($settings['website_favicon']) ? '/storage/' . $settings['website_favicon'] : null,
                    'thumbnail' => isset($settings['website_thumbnail']) ? '/storage/' . $settings['website_thumbnail'] : null,
                    'footer' => $settings['footer_copyright'] ?? '',
                ]
            ]);
        } catch (\Exception $e) {
            return array_merge(parent::share($request), [
                'settings' => [
                    'title' => config('app.name'),
                    'subtitle' => '',
                    'logo' => null,
                    'favicon' => null,
                    'thumbnail' => null,
                    'footer' => '© ' . date('Y') . ' ' . config('app.name'),
                ]
            ]);
        }
    }
} 