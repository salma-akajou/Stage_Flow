<?php

namespace App\Http\Controllers;

use App\Services\CandidatureService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CandidatureController extends Controller
{
    protected CandidatureService $candidatureService;

    public function __construct(CandidatureService $candidatureService)
    {
        $this->candidatureService = $candidatureService;
    }

    public function index(Request $request): View
    {
        $etudiantId = 1;
        $filters = $request->only(['statut', 'search']);
        $candidatures = $this->candidatureService->listEtudiantCandidatures($etudiantId, $filters);

        return view('student.candidatures', compact('candidatures'));
    }

    public function store(Request $request, int $offreId)
    {
        $etudiantId = 1;
        $this->candidatureService->postuler($etudiantId, $offreId, $request->all());
        
        return redirect()->route('student.candidatures')->with('success', 'Candidature envoyée !');
    }
}
