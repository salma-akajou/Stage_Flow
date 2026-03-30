<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use App\Services\EtudiantService;
use App\Services\FavoriService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EtudiantController extends Controller
{
    protected DashboardService $dashboardService;
    protected EtudiantService $etudiantService;
    protected FavoriService $favoriService;

    public function __construct(
        DashboardService $dashboardService, 
        EtudiantService $etudiantService,
        FavoriService $favoriService
    ) {
        $this->dashboardService = $dashboardService;
        $this->etudiantService = $etudiantService;
        $this->favoriService = $favoriService;
    }

    public function dashboard(): View
    {
        $etudiantId = 1; // Simulation d'utilisateur connecté
        $data = $this->dashboardService->getEtudiantDashboardData($etudiantId);
        
        return view('student.dashboard', $data);
    }

    public function profile(): View
    {
        $etudiantId = 1;
        $etudiant = $this->etudiantService->findOrFail($etudiantId);
        
        return view('student.profile', compact('etudiant'));
    }

    public function updateProfile(Request $request)
    {
        $etudiantId = 1;
        $this->etudiantService->updateProfile($etudiantId, $request->all());
        
        return back()->with('success', 'Profil mis à jour !');
    }
}
