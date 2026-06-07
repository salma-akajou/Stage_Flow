<?php

namespace App\Http\Controllers\Web\Entreprise;

use App\Http\Controllers\Controller;
use App\Services\EtudiantService;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    protected EtudiantService $etudiantService;

    public function __construct(EtudiantService $etudiantService)
    {
        $this->etudiantService = $etudiantService;
    }

    public function showAjax($id)
    {
        try {
            $etudiant = $this->etudiantService->findOrFail($id);
            $etudiant->load(['user', 'ville']);
            
            $candidatureService = app(\App\Services\CandidatureService::class);
            $recentes = $candidatureService->getRecentsCandidatures($id, 3);
            
            $this->etudiantService->incrementViews($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $etudiant->id,
                    'nom' => $etudiant->user->nom,
                    'prenom' => $etudiant->user->prenom,
                    'email' => $etudiant->user->email,
                    'photo' => $etudiant->photo ? asset('storage/' . $etudiant->photo) : asset('assets/images/default-avatar.png'),
                    'bio' => $etudiant->bio ?? 'Aucune biographie disponible pour le moment.',
                    'ville' => $etudiant->ville->nom ?? 'Non précisée',
                    'etablissement' => $etudiant->etablissement?->nom ?? 'Non renseigné',
                    'filiere' => $etudiant->filiere?->nom ?? 'Étudiant',
                    'niveau' => $etudiant->niveau_etudes ?? 'N/A',
                    'github' => $etudiant->github,
                    'linkedin' => $etudiant->linkedin,
                    'vues' => $etudiant->vues,
                    'candidatures' => $recentes->map(fn($c) => [
                        'id' => $c->id,
                        'offre' => $c->offre->titre,
                        'description' => $c->offre->description,
                        'entreprise' => $c->offre->entreprise->nom_entreprise,
                        'statut' => $c->statut,
                        'secteur' => $c->offre->secteur?->nom ?? 'N/A',
                        'type' => $c->offre->type_stage,
                        'date' => $c->created_at->format('d/m/Y')
                    ])
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }
}
