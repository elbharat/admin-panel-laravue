<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Insert default settings
        $settings = [
            'website_title' => 'Admin Panel LaraVue',
            'website_subtitle' => 'Laravel 12 + Vue.js + Shadcn UI',
            'website_logo' => null,
            'website_favicon' => null,
            'website_thumbnail' => null,
            'footer_copyright' => '© ' . date('Y') . ' Admin Panel LaraVue',
        ];

        foreach ($settings as $key => $value) {
            DB::table('settings')->insert([
                'key' => $key,
                'value' => $value,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('settings');
    }
}; 