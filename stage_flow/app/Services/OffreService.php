<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Pagination\LengthAwarePaginator;

class OffreService extends BaseService
{
    public function __construct()
    {
        $this->model = new Offre();
    }

    public function search(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = $this->model->with('entreprise', 'ville');

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

        return $query->latest()->paginate($perPage);
    }

    public function getDetails(int $id): Offre
    {
        return Offre::with('entreprise', 'ville')->findOrFail($id);
    }

    public function getRecommended(int $limit = 3)
    {
        return $this->model->with('entreprise')->where('status', 'Active')->latest()->take($limit)->get();
    }
}
