<?php

namespace App\Services;

use App\Models\Etudiant;
use Illuminate\Support\Facades\Storage;

class EtudiantService extends BaseService
{
    public function __construct()
    {
        $this->model = new Etudiant();
    }

    public function updateProfile(int $id, array $data): Etudiant
    {
        $etudiant = Etudiant::with('user')->findOrFail($id);
        $user = $etudiant->user;

        $userData = [];
        if (isset($data['prenom'])) $userData['prenom'] = $data['prenom'];
        if (isset($data['nom'])) $userData['nom'] = $data['nom'];

        if (!empty($userData)) {
            $user->update($userData);
        }

        if (isset($data['photo'])) {
            if ($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $data['photo'] = $data['photo']->store('avatars', 'public');
        }


        $etudiant->update(array_filter([
            'ville_id'      => $data['ville_id'] ?? null,
            'etablissement' => $data['etablissement'] ?? null,
            'filiere'       => $data['filiere'] ?? null,
            'niveau_etudes' => $data['niveau_etudes'] ?? null,
            'bio'           => $data['bio'] ?? null,
            'github'        => $data['github'] ?? null,
            'linkedin'      => $data['linkedin'] ?? null,
            'photo'         => $data['photo'] ?? $etudiant->photo,
        ], fn($val) => !is_null($val)));

        return $etudiant;
    }

    public function incrementViews(int $id): void
    {
        $this->model->where('user_id', $id)->increment('vues');
    }
}
