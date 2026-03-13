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
        $etudiant = $this->findOrFail($id);

        if (isset($data['photo'])) {
            if ($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $data['photo'] = $data['photo']->store('photos/etudiants', 'public');
        }

        if (!empty($data['supprimer_photo'])) {
            if ($etudiant->photo && Storage::disk('public')->exists($etudiant->photo)) {
                Storage::disk('public')->delete($etudiant->photo);
            }
            $data['photo'] = null;
            unset($data['supprimer_photo']);
        }

        return $this->update($id, array_filter([
            'ville_id'      => $data['ville_id'] ?? null,
            'etablissement' => $data['etablissement'] ?? null,
            'filiere'       => $data['filiere'] ?? null,
            'niveau_etudes' => $data['niveau_etudes'] ?? null,
            'bio'           => $data['bio'] ?? null,
            'github'        => $data['github'] ?? null,
            'linkedin'      => $data['linkedin'] ?? null,
            'photo'         => array_key_exists('photo', $data) ? $data['photo'] : $etudiant->photo,
        ], fn($val) => !is_null($val)));
    }

    public function incrementViews(int $id): void
    {
        $this->model->where('user_id', $id)->increment('vues');
    }
}
