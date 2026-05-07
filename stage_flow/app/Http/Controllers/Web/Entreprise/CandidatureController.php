<?php

namespace App\Http\Controllers\Web\Entreprise;

use App\Http\Controllers\Controller;
use App\Models\Entreprise;
use App\Services\CandidatureService;
use Illuminate\Http\Request;

class CandidatureController extends Controller
{
    protected CandidatureService $candidatureService;

    public function __construct(CandidatureService $candidatureService)
    {
        $this->candidatureService = $candidatureService;
    }

    public function index(Request $request)
    {
        $entrepriseId = 6; 
        $entreprise = Entreprise::findOrFail($entrepriseId);
        
        $filters = $request->only(['offre_id', 'statut', 'search']);
        $candidatures = $this->candidatureService->listEntrepriseCandidatures($entrepriseId, $filters);
        $offres = $entreprise->offres()->get();

        if ($request->ajax()) {
            return view('components.entreprise.candidatures.table', compact('candidatures'))->render();
        }

        return view('entreprise.candidatures.index', compact('entreprise', 'candidatures', 'offres'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Accepté,Refusé'
        ]);

        $success = $this->candidatureService->changeStatus($id, $request->status);

        return response()->json([
            'success' => $success,
            'message' => 'Statut mis à jour avec succès.',
            'new_status' => $request->status
        ]);
    }

    public function showCandidatureAjax($id)
    {
        $candidature = $this->candidatureService->findWithDetails($id);
        
        return response()->json([
            'success' => true,
            'data' => [
                'id' => $candidature->id,
                'nom_complet' => $candidature->etudiant->user->prenom . ' ' . $candidature->etudiant->user->nom,
                'specialite' => $candidature->etudiant->filiere ?? 'Candidat Etudiant',
                'bio' => $candidature->etudiant->bio ?? 'Aucune bio renseignée.',
                'motivation' => $candidature->message_motivation,
                'cv_url' => $candidature->cv_id ? asset('storage/' . $candidature->cv->file_path) : null,
                'portfolio' => $candidature->portfolio_url,
                'telephone' => $candidature->telephone,
                'email' => $candidature->etudiant->user->email,
                'photo' => $candidature->photo ? asset('storage/' . $candidature->photo) : asset('assets/images/default-avatar.png'),
                'statut' => $candidature->statut,
            ]
        ]);
    }
}
