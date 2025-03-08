<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * @var DashboardService
     */
    protected $dashboardService;

    /**
     * DashboardController constructor.
     *
     * @param DashboardService $dashboardService
     */
    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

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
            $data = $this->dashboardService->getAdminDashboardData();
        } else {
            $data = $this->dashboardService->getUserDashboardData();
        }

        return Inertia::render('Dashboard/Dashboard', $data);
    }
} 