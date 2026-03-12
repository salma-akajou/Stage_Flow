<?php

namespace App\Services;

use App\Models\Etudiant;

class EtudiantService
{
    public function updateProfile(int $id, array $data): bool
    {
        $etudiant = Etudiant::findOrFail($id);
        
        if (isset($data['photo'])) {
            // Update photo logic here
        }

        return $etudiant->update($data);
    }

    public function incrementViews(int $id): void
    {
        Etudiant::where('user_id', $id)->increment('vues');
    }
}

