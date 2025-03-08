<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'username' => 'admin',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $admin->assignRole('admin');

        $user = User::create([
            'name' => 'User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => Hash::make('password'),
            'is_admin' => false,
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        $user->assignRole('user');
    }
} 