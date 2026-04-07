<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use App\Services\EtudiantService;
use App\Services\FavoriService;
use App\Models\Etudiant;
use App\Models\Ville;
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
        $etudiantId = 1;
        $etudiant = Etudiant::find($etudiantId);
        $data = $this->dashboardService->getEtudiantDashboardData($etudiantId);
        
        return view('student.dashboard', array_merge($data, ['etudiant' => $etudiant]));
    }

    public function profile(): View
    {
        $etudiantId = 1;
        $etudiant = Etudiant::with('user', 'ville')->find($etudiantId);
        $villes = Ville::all();
        
        return view('student.profile', compact('etudiant', 'villes'));
    }

    public function updateProfile(Request $request)
    {
        $etudiantId = 1;
        $this->etudiantService->updateProfile($etudiantId, $request->all());
        
        return back()->with('success', 'Profil mis à jour !');
    }
}
