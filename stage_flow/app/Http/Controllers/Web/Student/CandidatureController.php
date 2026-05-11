<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\StoreCandidatureRequest;
use App\Models\Candidature;
use App\Models\Etudiant;
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
        $etudiantId = auth()->id();
        $filters = $request->only(['statut', 'search']);
        
        $data = $this->candidatureService->listEtudiantCandidatures($etudiantId, $filters, 9, true);
        
        $etudiant = auth()->user()->etudiant;

        return view('student.candidatures.index', array_merge($data, ['etudiant' => $etudiant]));
    }


    public function store(StoreCandidatureRequest $request, int $offreId)
    {
        $etudiantId = auth()->id();
        $validated = $request->validated();
        
        $validated['cv'] = $request->file('cv');
        $validated['photo'] = $request->file('photo');
        
        $this->candidatureService->postuler($etudiantId, $offreId, $validated);
        
        return redirect()->route('student.candidatures')->with('success', 'Candidature envoyée !');
    }

    public function destroy(int $id)
    {
        $etudiantId = auth()->id();
        $candidature = Candidature::findOrFail($id);

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
