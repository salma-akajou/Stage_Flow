<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Models\Etudiant;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    /**
     * Affiche le tableau de bord de l'étudiant
     */
    public function index(): View
    {
        $etudiantId = 1; 
        $data = $this->dashboardService->getEtudiantDashboardData($etudiantId);
        
        return view('student.dashboard', $data);
    }
}
