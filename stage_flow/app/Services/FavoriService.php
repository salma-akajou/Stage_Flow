<?php

namespace App\Services;

use App\Models\Etudiant;
use App\Models\Offre;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FavoriService
{
    public function toggle(int $etudiantId, int $offreId): array
    {
        $etudiant = Etudiant::findOrFail($etudiantId);
        $result = $etudiant->favoris()->toggle($offreId);
        
        return [
            'attached' => count($result['attached']) > 0,
            'detached' => count($result['detached']) > 0,
        ];
    }

    public function list(int $etudiantId, int $perPage = 9): LengthAwarePaginator
    {
        $etudiant = Etudiant::findOrFail($etudiantId);
        return $etudiant->favoris()->with('entreprise')->latest()->paginate($perPage);
    }
}

