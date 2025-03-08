<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Cache;

class DashboardService
{
    /**
     * Get dashboard data for admin
     *
     * @return array
     */
    public function getAdminDashboardData()
    {
        // Menggunakan cache untuk meningkatkan performa
        return Cache::remember(
            config('cache-keys.dashboard.admin_data'), 
            config('cache-keys.ttl.medium'), 
            function () {
                return [
                    'stats' => $this->getStats(),
                    'activities' => $this->getRecentActivities(),
                ];
            }
        );
    }

    /**
     * Get dashboard data for user
     *
     * @return array
     */
    public function getUserDashboardData()
    {
        // Data dashboard untuk user biasa
        return [
            'welcomeMessage' => 'Selamat datang di dashboard',
        ];
    }

    /**
     * Get dashboard statistics
     *
     * @return array
     */
    protected function getStats()
    {
        return [
            'users' => User::count(),
            'posts' => 0, // Ganti dengan Posts::count() jika sudah ada model Posts
            'comments' => 0, // Ganti dengan Comments::count() jika sudah ada model Comments
            'views' => 0, // Ganti dengan jumlah views sebenarnya
        ];
    }

    /**
     * Get recent activities
     *
     * @return array
     */
    protected function getRecentActivities()
    {
        // Contoh data aktivitas, bisa diganti dengan data dari database
        return [
            ['user' => 'Admin', 'action' => 'Menambahkan pengguna baru', 'time' => '5 menit yang lalu'],
            ['user' => 'Editor', 'action' => 'Memperbarui artikel', 'time' => '1 jam yang lalu'],
            ['user' => 'User123', 'action' => 'Mengomentari artikel', 'time' => '3 jam yang lalu'],
            ['user' => 'Admin', 'action' => 'Mengubah pengaturan sistem', 'time' => '1 hari yang lalu'],
        ];
    }
} 