<?php

namespace App\Http\Controllers;

use App\Services\OffreService;
use App\Models\Ville;
use App\Models\Offre;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OffreController extends Controller
{
    protected OffreService $offreService;

    public function __construct(OffreService $offreService)
    {
        $this->offreService = $offreService;
    }

    public function index(Request $request): View
    {
        $filters = $request->only(['titre', 'secteur', 'ville_id', 'type_stage']);
        $offres = $this->offreService->search($filters);
        
        $villes = Ville::all();
        $secteurs = Offre::select('secteur')->distinct()->pluck('secteur');

        return view('offres.index', compact('offres', 'villes', 'secteurs'));
    }

    public function show(int $id): View
    {
        $offre = $this->offreService->getDetails($id);
        $similaires = $this->offreService->getRecommended(3);

        return view('offres.show', compact('offre', 'similaires'));
    }
}
