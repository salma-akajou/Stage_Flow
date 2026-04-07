<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Candidature;
use App\Models\Etudiant;
use App\Models\Offre;
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
        $etudiant = Etudiant::find($etudiantId);
        $filters = $request->only(['statut', 'search']);
        $candidatures = $this->candidatureService->listEtudiantCandidatures($etudiantId, $filters);

        $stats = [
            'total' => Candidature::where('etudiant_id', $etudiantId)->count(),
            'attente' => Candidature::where('etudiant_id', $etudiantId)->where('statut', 'En attente')->count(),
            'accepte' => Candidature::where('etudiant_id', $etudiantId)->where('statut', 'Accepté')->count(),
            'refuse' => Candidature::where('etudiant_id', $etudiantId)->where('statut', 'Refusé')->count(),
        ];

        return view('student.candidatures.index', compact('candidatures', 'etudiant', 'stats'));
    }

    public function create(int $offreId): View
    {
        $etudiantId = 1;
        $etudiant = Etudiant::find($etudiantId);
        $offre = Offre::with('entreprise')->findOrFail($offreId);
        
        return view('student.candidatures.create', compact('offre', 'etudiant'));
    }

    public function store(Request $request, int $offreId)
    {
        $etudiantId = 1;
        $this->candidatureService->postuler($etudiantId, $offreId, $request->all());
        
        return redirect()->route('student.candidatures')->with('success', 'Candidature envoyée !');
    }

    public function destroy(int $id)
    {
        $etudiantId = 1;
        $candidature = $this->candidatureService->findOrFail($id);

        if ($candidature->etudiant_id !== $etudiantId) {
            abort(403);
        }

        if ($candidature->statut !== 'En attente') {
            return back()->with('error', 'Impossible de retirer une candidature déjà traitée.');
        }

        $this->candidatureService->delete($id);

        return back()->with('success', 'Candidature retirée avec succès.');
    }
}
