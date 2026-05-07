<?php

namespace App\Http\Controllers\Web\Entreprise;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $entrepriseId = 6; 
        $data = $this->dashboardService->getEntrepriseDashboardData($entrepriseId);
        
        return view('entreprise.dashboard', $data);
    }
}
