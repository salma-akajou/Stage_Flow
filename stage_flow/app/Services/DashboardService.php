<?php

namespace App\Services;

use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Etudiant;
use App\Models\Feedback;
use App\Models\Candidature;
use App\Models\User;

class DashboardService
{
    public function getLandingStats(): array
    {
        return [
            'partenaires' => Entreprise::count(),
            'offres_an' => Offre::where('created_at', '>=', now()->subYear())->count(),
            'etudiants' => Etudiant::count(),
            'satisfaction' => Feedback::where('valide', true)->avg('note') ?? 0,
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

    public function getEntrepriseStats(int $entrepriseId): array
    {
        $entreprise = Entreprise::findOrFail($entrepriseId);
        return [
            'offres' => $entreprise->offres()->count(),
            'candidatures_recues' => Candidature::whereIn('offre_id', $entreprise->offres->pluck('id'))->count(),
            'en_attente' => Candidature::whereIn('offre_id', $entreprise->offres->pluck('id'))->where('statut', 'En attente')->count(),
            'vues_offres' => $entreprise->vues,
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
            ]
        ];
    }
}
