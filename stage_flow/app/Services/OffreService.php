<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\Ville;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
class OffreService extends BaseService
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->model = new Offre();
        $this->notificationService = $notificationService;
    }

    /**
     * Recherche avancée avec filtres (Utilisée par Étudiant et Entreprise)
     */
    public function search(array $filters = [], int $perPage = 9, bool $includeMeta = false): LengthAwarePaginator|array
    {
        $query = $this->model->newQuery()->with(['entreprise', 'ville'])->withCount('candidatures');

        if (!empty($filters['entreprise_id'])) {
            $query->where('entreprise_id', $filters['entreprise_id']);
        }

        if (!empty($filters['titre'])) {
            $query->where('titre', 'like', '%' . $filters['titre'] . '%');
        }

        if (!empty($filters['secteur'])) {
            $query->where('secteur', $filters['secteur']);
        }

        if (!empty($filters['ville_id'])) {
            $query->where('ville_id', $filters['ville_id']);
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['type_stage'])) {
            $query->where('type_stage', $filters['type_stage']);
        }

        $results = $query->latest()->paginate($perPage);

        if ($includeMeta) {
            return [
                'offres' => $results,
                'villes' => Ville::all(),
                'secteurs' => $this->model->distinct()->pluck('secteur'),
                'existingCompetences' => $this->model->whereNotNull('competences_techniques')
                    ->pluck('competences_techniques')
                    ->flatten()
                    ->unique()
                    ->values(),
            ];
        }

        return $results;
    }


    /**
     * Détails complets d'une offre 
     */
    public function getDetails(int $id): Offre
    {
        return Offre::with(['entreprise', 'ville'])->findOrFail($id);
    }

    public function getRecommended(int $limit = 3): Collection
    {
        return $this->model->with(['entreprise', 'ville'])
            ->where('status', 'Active')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getActiveByEntreprise(int $entrepriseId, int $limit = 3): Collection
    {
        return $this->model->where('entreprise_id', $entrepriseId)
            ->where('status', 'Active')
            ->withCount('candidatures')
            ->latest()
            ->take($limit)
            ->get();
    }

    public function publierOffre(int $entrepriseId, array $data, string $secteur): Offre
    {
        $data['entreprise_id'] = $entrepriseId;
        $data['secteur'] = $secteur;

        $offre = $this->create($data);

        // Notify all students
        $students = User::role('etudiant')->get();
        
        $entrepriseNom = $offre->entreprise->nom_entreprise ?? 'Une entreprise';
        $title = "Nouvelle offre de stage";
        $message = "L'entreprise {$entrepriseNom} a publié une nouvelle offre : \"{$offre->titre}\".";

        foreach ($students as $student) {
            $this->notificationService->createNotification(
                $student->id,
                'new_offre',
                $title,
                $message,
                [
                    'offre_id' => $offre->id,
                    'entreprise_id' => $entrepriseId
                ]
            );
        }

        return $offre;
    }

    public function updateOffre(int $id, array $data, string $secteur): Offre
    {
        $data['secteur'] = $secteur;

        return $this->update($id, $data);
    }
}
