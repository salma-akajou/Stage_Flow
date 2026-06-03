<?php

namespace App\Services;

use App\Models\Offre;
use App\Models\Ville;
use App\Models\User;
use App\Models\Secteur;
use App\Models\Competence;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use App\Services\NotificationService;

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
        $query = $this->model->newQuery()->with(['entreprise', 'ville', 'secteur', 'competences'])->withCount('candidatures');

        if (!empty($filters['entreprise_id'])) {
            $query->where('entreprise_id', $filters['entreprise_id']);
        }

        if (!empty($filters['titre'])) {
            $query->where('titre', 'like', '%' . $filters['titre'] . '%');
        }

        if (!empty($filters['secteur'])) {
            if (is_numeric($filters['secteur'])) {
                $query->where('secteur_id', $filters['secteur']);
            } else {
                $query->whereHas('secteur', function($q) use ($filters) {
                    $q->where('nom', $filters['secteur']);
                });
            }
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
                'secteurs' => Secteur::all(),
                'existingCompetences' => Competence::all(),
            ];
        }

        return $results;
    }

    /**
     * Détails complets d'une offre 
     */
    public function getDetails(int $id): Offre
    {
        return Offre::with(['entreprise', 'ville', 'secteur', 'competences'])->findOrFail($id);
    }

    public function getRecommended(int $limit = 3): Collection
    {
        return $this->model->with(['entreprise', 'ville', 'secteur', 'competences'])
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

        // Map Secteur
        if (is_numeric($secteur)) {
            $data['secteur_id'] = (int) $secteur;
        } else {
            $sectModel = Secteur::firstOrCreate(['nom' => $secteur]);
            $data['secteur_id'] = $sectModel->id;
        }

        $offre = $this->create($data);

        // Map Competences Many-to-Many
        if (isset($data['competences_techniques'])) {
            $compNames = $data['competences_techniques'];
            if (is_string($compNames)) {
                $decoded = json_decode($compNames, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $compNames = $decoded;
                } else {
                    $compNames = explode('|', $compNames);
                }
            }
            $competenceIds = [];
            if (is_array($compNames)) {
                foreach ($compNames as $compName) {
                    $compName = trim($compName);
                    if (!empty($compName)) {
                        $compModel = Competence::firstOrCreate(['nom' => $compName]);
                        $competenceIds[] = $compModel->id;
                    }
                }
            }
            $offre->competences()->sync($competenceIds);
        }

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
        // Map Secteur
        if (is_numeric($secteur)) {
            $data['secteur_id'] = (int) $secteur;
        } else {
            $sectModel = Secteur::firstOrCreate(['nom' => $secteur]);
            $data['secteur_id'] = $sectModel->id;
        }

        $offre = $this->update($id, $data);

        // Map Competences Many-to-Many
        if (isset($data['competences_techniques'])) {
            $compNames = $data['competences_techniques'];
            if (is_string($compNames)) {
                $decoded = json_decode($compNames, true);
                if (json_last_error() === JSON_ERROR_NONE) {
                    $compNames = $decoded;
                } else {
                    $compNames = explode('|', $compNames);
                }
            }
            $competenceIds = [];
            if (is_array($compNames)) {
                foreach ($compNames as $compName) {
                    $compName = trim($compName);
                    if (!empty($compName)) {
                        $compModel = Competence::firstOrCreate(['nom' => $compName]);
                        $competenceIds[] = $compModel->id;
                    }
                }
            }
            $offre->competences()->sync($competenceIds);
        }

        return $offre;
    }

    /**
     * Retourne la liste de tous les secteurs distincts pour le filtrage
     */
    public function getDistinctSecteurs(): Collection
    {
        return Secteur::all();
    }
}
