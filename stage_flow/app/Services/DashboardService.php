<?php

namespace App\Services;

use App\Models\Entreprise;
use App\Models\Offre;
use App\Models\Ville;
use App\Models\Etudiant;
use App\Models\Feedback;
use App\Models\Candidature;
use App\Models\User;
use Illuminate\Support\Facades\DB;

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

    public function getVilles(): \Illuminate\Support\Collection
    {
        return Ville::select('id', 'nom')->get();
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
        $feedbacksAModerer = Feedback::where('valide', false)->count();
        $nouveauxUsersCeMois = User::whereMonth('created_at', now()->month)->count();
        $nouvellesOffresCeMois = Offre::whereMonth('created_at', now()->month)->count();

        // --- Statistiques avancées (UC3) ---

        // Taux d'acceptation des candidatures
        $totalTraitees = Candidature::whereIn('statut', ['Accepté', 'Refusé'])->count();
        $totalAcceptees = Candidature::where('statut', 'Accepté')->count();
        $tauxAcceptation = $totalTraitees > 0 ? round(($totalAcceptees / $totalTraitees) * 100) : 0;

        // Durée moyenne de traitement (en heures) entre postulation et décision
        $dureeTraitement = Candidature::whereIn('statut', ['Accepté', 'Refusé'])
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, date_postulation, updated_at)) as avg_heures')
            ->value('avg_heures');
        $dureeTraitement = $dureeTraitement ? round($dureeTraitement) : 0;

        // Taux d'engagement étudiant (ont posté au moins une candidature)
        $totalEtudiants = Etudiant::count();
        $etudiantsActifs = Etudiant::has('candidatures')->count();
        $tauxEngagement = $totalEtudiants > 0 ? round(($etudiantsActifs / $totalEtudiants) * 100) : 0;

        // Top 3 secteurs par nombre d'offres
        $topSecteurs = Offre::select('secteur', DB::raw('COUNT(*) as total'))
            ->whereNotNull('secteur')
            ->groupBy('secteur')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        // Top 3 villes par nombre d'offres
        $topVilles = Offre::select('ville_id', DB::raw('COUNT(*) as total'))
            ->with('ville:id,nom')
            ->whereNotNull('ville_id')
            ->groupBy('ville_id')
            ->orderByDesc('total')
            ->limit(3)
            ->get();

        return [
            'total_utilisateurs' => User::count(),
            'nouveaux_users_mois' => $nouveauxUsersCeMois,

            'total_offres' => Offre::count(),
            'nouvelles_offres_mois' => $nouvellesOffresCeMois,

            'total_commentaires' => Feedback::count(),
            'feedbacks_a_moderer' => $feedbacksAModerer,

            'total_candidatures' => Candidature::count(),
            'candidatures_semaine' => Candidature::where('created_at', '>=', now()->subWeek())->count(),

            'repartition_users' => [
                'etudiants' => $totalEtudiants,
                'entreprises' => Entreprise::count(),
                'admins' => 1,
            ],

            // KPIs avancés
            'taux_acceptation' => $tauxAcceptation,
            'duree_traitement_heures' => $dureeTraitement,
            'taux_engagement_etudiants' => $tauxEngagement,
            'etudiants_actifs' => $etudiantsActifs,
            'top_secteurs' => $topSecteurs,
            'top_villes' => $topVilles,
        ];
    }

    public function getAdminChartData(): array
    {
        $days = [];
        $data = [];
        $totalSemaine = 0;

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days[] = $date->translatedFormat('D'); 

            $usersCount = User::whereDate('created_at', $date->toDateString())->count();
            $candidaturesCount = Candidature::whereDate('created_at', $date->toDateString())->count();
            $offresCount = Offre::whereDate('created_at', $date->toDateString())->count();
            $feedbacksCount = Feedback::whereDate('created_at', $date->toDateString())->count();
            
            $totalJour = $usersCount + $candidaturesCount + $offresCount + $feedbacksCount;
            $data[] = $totalJour;
            $totalSemaine += $totalJour;
        }

        return [
            'categories' => $days,
            'series' => $data,
            'total' => $totalSemaine,
        ];
    }
}
