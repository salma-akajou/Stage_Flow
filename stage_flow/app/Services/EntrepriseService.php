<?php

namespace App\Services;

use App\Models\Entreprise;

class EntrepriseService
{
    public function updateProfile(int $id, array $data): bool
    {
        $entreprise = Entreprise::findOrFail($id);
        
        if (isset($data['logo'])) {
            $data['logo'] = $data['logo']->store('logos', 'public');
        }

        return $entreprise->update($data);
    }

    public function incrementViews(int $id): void
    {
        Entreprise::where('user_id', $id)->increment('vues');
    }
}

