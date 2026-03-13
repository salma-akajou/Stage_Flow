<?php

namespace App\Services;

use App\Models\Etudiant;
use Illuminate\Pagination\LengthAwarePaginator;

class FavoriService extends BaseService
{
    public function __construct()
    {
        $this->model = new Etudiant();
    }

    public function toggle(int $etudiantId, int $offreId): array
    {
        $etudiant = $this->findOrFail($etudiantId);
        $result = $etudiant->favoris()->toggle($offreId);

        return [
            'attached' => count($result['attached']) > 0,
            'detached' => count($result['detached']) > 0,
        ];
    }

    public function list(int $etudiantId, int $perPage = 9): LengthAwarePaginator
    {
        $etudiant = $this->findOrFail($etudiantId);
        return $etudiant->favoris()->with('entreprise')->latest()->paginate($perPage);
    }
}
