<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     *
     * @return \Inertia\Response
     */
    public function index()
    {
        $user = auth()->user();
        $data = [];

        // Jika user adalah admin, tambahkan data statistik
        if ($user->hasRole('admin')) {
            $data = [
                'stats' => [
                    'users' => User::count(),
                    'posts' => 0, // Ganti dengan Posts::count() jika sudah ada model Posts
                    'comments' => 0, // Ganti dengan Comments::count() jika sudah ada model Comments
                    'views' => 0, // Ganti dengan jumlah views sebenarnya
                ],
                'activities' => [
                    ['user' => 'Admin', 'action' => 'Menambahkan pengguna baru', 'time' => '5 menit yang lalu'],
                    ['user' => 'Editor', 'action' => 'Memperbarui artikel', 'time' => '1 jam yang lalu'],
                    ['user' => 'User123', 'action' => 'Mengomentari artikel', 'time' => '3 jam yang lalu'],
                    ['user' => 'Admin', 'action' => 'Mengubah pengaturan sistem', 'time' => '1 hari yang lalu'],
                ],
            ];
        }

        return Inertia::render('Dashboard/Dashboard', $data);
    }
}
