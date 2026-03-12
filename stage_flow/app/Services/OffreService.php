<?php

namespace App\Services;

use App\Models\Offre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class OffreService
{
    public function search(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = Offre::query();

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

        return $query->with('entreprise')->latest()->paginate($perPage);
    }

    public function getDetails(int $id): Offre
    {
        return Offre::with('entreprise')->findOrFail($id);
    }

    public function create(array $data): Offre
    {
        return Offre::create($data);
    }

    public function update(int $id, array $data): bool
    {
        $offre = Offre::findOrFail($id);
        return $offre->update($data);
    }

    public function delete(int $id): bool
    {
        $offre = Offre::findOrFail($id);
        return $offre->delete();
    }

    public function getLandingFeatured(int $limit = 6)
    {
        return Offre::with('entreprise')->where('status', 'Active')->latest()->take($limit)->get();
    }
}
