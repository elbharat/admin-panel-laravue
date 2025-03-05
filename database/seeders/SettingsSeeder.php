<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                'key' => 'website_title',
                'value' => 'Admin Panel LaraVue',
                'group' => 'website',
                'type' => 'text',
                'description' => 'Judul website',
            ],
            [
                'key' => 'website_subtitle',
                'value' => 'Laravel 12 + Vue.js + Shadcn UI',
                'group' => 'website',
                'type' => 'text',
                'description' => 'Subtitle website',
            ],
            [
                'key' => 'website_logo',
                'value' => null,
                'group' => 'website',
                'type' => 'image',
                'description' => 'Logo website',
            ],
            [
                'key' => 'website_favicon',
                'value' => null,
                'group' => 'website',
                'type' => 'image',
                'description' => 'Favicon website',
            ],
            [
                'key' => 'website_thumbnail',
                'value' => null,
                'group' => 'website',
                'type' => 'image',
                'description' => 'Thumbnail/OG Image website',
            ],
            [
                'key' => 'footer_copyright',
                'value' => '© ' . date('Y') . ' Admin Panel LaraVue',
                'group' => 'website',
                'type' => 'text',
                'description' => 'Teks copyright di footer',
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
