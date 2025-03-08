<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'Admin Panel',
                'type' => 'string',
                'group' => 'general',
            ],
            [
                'key' => 'app_description',
                'value' => 'Admin Panel with Laravel and Vue.js',
                'type' => 'string',
                'group' => 'general',
            ],
            [
                'key' => 'app_logo',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
            [
                'key' => 'app_favicon',
                'value' => null,
                'type' => 'image',
                'group' => 'general',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::firstOrCreate(['key' => $setting['key']], $setting);
        }
    }
} 