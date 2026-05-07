<?php

namespace App\Services;

use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Ville;
use App\Models\Etudiant;
use App\Models\Feedback;
use App\Models\Candidature;
use App\Models\User;

class DashboardService
{
    protected OffreService $offreService;
    protected CandidatureService $candidatureService;

    public function __construct(OffreService $offreService, CandidatureService $candidatureService)
    {
        $this->offreService = $offreService;
        $this->candidatureService = $candidatureService;
    }

    public function getLandingStats(): array
    {
        return [
            'partenaires' => Entreprise::count(),
            'offres_an' => Offre::where('created_at', '>=', now()->subYear())->count(),
            'etudiants' => Etudiant::count(),
            'satisfaction' => Feedback::where('valide', true)->avg('note') ?? 0,
            'rep_moyenne' => '48h', 
        ];
    }

    public function getEtudiantStats(int $etudiantId): array
    {
        $etudiant = Etudiant::findOrFail($etudiantId);
        return [
            'candidatures' => $etudiant->candidatures()->count(),
            'vues' => $etudiant->vues,
            'retenues' => $etudiant->candidatures()->where('statut', 'Accepté')->count(),
            'favoris' => $etudiant->favoris()->count(),
        ];
    }
    public function getEtudiantDashboardData(int $etudiantId): array
    {
        $etudiant = Etudiant::with(['user', 'ville'])->findOrFail($etudiantId);
        
        return [
            'etudiant' => $etudiant,
            'stats' => $this->getEtudiantStats($etudiantId),
            'recommandations' => $this->offreService->getRecommended(3),
            'candidatures_recentes' => $this->candidatureService->getRecentsCandidatures($etudiantId, 3),
        ];
    }

    public function getEntrepriseStats(int $entrepriseId): array
    {
        $entreprise = Entreprise::findOrFail($entrepriseId);
        $offreIds = $entreprise->offres->pluck('id')->toArray();

        return [
            'offres' => $entreprise->offres()->count(),
            'candidatures_recues' => Candidature::whereIn('offre_id', $offreIds)->count(),
            'en_attente' => Candidature::whereIn('offre_id', $offreIds)->where('statut', 'En attente')->count(),
            'vues_offres' => $entreprise->vues,
        ];
    }

    public function getEntrepriseDashboardData(int $entrepriseId): array
    {
        $entreprise = Entreprise::with('user', 'ville')->findOrFail($entrepriseId);
        
        $offresActives = $this->offreService->getActiveByEntreprise($entrepriseId, 3);
        $candidaturesRecentes = $this->candidatureService->getRecentByEntreprise($entrepriseId, 4);

        $activites = collect()
            ->merge($offresActives->map(fn($o) => [
                'type' => 'offre',
                'icon' => 'blue',
                'titre' => 'Offre publiée',
                'description' => 'Nouvelle offre "' . $o->titre . '" mise en ligne',
                'date' => $o->created_at,
                'lien' => route('entreprise.offres.index')
            ]))
            ->merge($candidaturesRecentes->map(fn($c) => [
                'type' => $c->statut === 'En attente' ? 'candidature' : ($c->statut === 'Accepté' ? 'acceptation' : 'refus'),
                'icon' => $c->statut === 'En attente' ? 'indigo' : ($c->statut === 'Accepté' ? 'emerald' : 'rose'),
                'titre' => $c->statut === 'En attente' ? 'Nouvelle candidature reçue' : ($c->statut === 'Accepté' ? 'Candidature acceptée' : 'Candidature refusée'),
                'description' => $c->etudiant->user->prenom . ' ' . $c->etudiant->user->nom . ($c->statut === 'En attente' ? ' a postulé au poste ' : ' pour ') . $c->offre->titre,
                'date' => $c->statut === 'En attente' ? $c->created_at : $c->updated_at,
                'lien' => route('entreprise.candidatures.index')
            ]))
            ->sortByDesc('date')
            ->take(3);

        // Données pour le modale de publication
        $villes = Ville::all();
        $secteurs = Offre::distinct()->pluck('secteur');
        $existingCompetences = Offre::whereNotNull('competences_techniques')
            ->pluck('competences_techniques')
            ->flatten()
            ->unique()
            ->values();

        return [
            'entreprise' => $entreprise,
            'stats' => $this->getEntrepriseStats($entrepriseId),
            'offres_actives' => $offresActives,
            'candidatures_recentes' => $candidaturesRecentes,
            'activites' => $activites,
            'villes' => $villes,
            'secteurs' => $secteurs,
            'existingCompetences' => $existingCompetences
        ];
    }

    public function getAdminStats(): array
    {
        return [
            'total_utilisateurs' => User::count(),
            'total_offres' => Offre::count(),
            'total_commentaires' => Feedback::count(),
            'total_candidatures' => Candidature::count(),
            'repartition_users' => [
                'etudiants' => Etudiant::count(),
                'entreprises' => Entreprise::count(),
            ],
        ];
    }
}
