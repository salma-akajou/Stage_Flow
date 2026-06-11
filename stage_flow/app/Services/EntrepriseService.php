<?php

namespace App\Services;

use App\Models\Entreprise;
use App\Models\Secteur;
use Illuminate\Support\Facades\Storage;

class EntrepriseService extends BaseService
{
    public function __construct()
    {
        $this->model = new Entreprise();
    }

    public function updateProfile(int $id, array $data): Entreprise
    {
        $entreprise = Entreprise::with('user')->findOrFail($id);
        $user = $entreprise->user;

        $userData = [];
        if (isset($data['prenom'])) $userData['prenom'] = $data['prenom'];
        if (isset($data['nom'])) $userData['nom'] = $data['nom'];

        if (!empty($userData)) {
            $user->update($userData);
        }

        if (isset($data['logo'])) {
            if ($entreprise->logo && Storage::disk('public')->exists($entreprise->logo)) {
                Storage::disk('public')->delete($entreprise->logo);
            }
            $data['logo'] = $data['logo']->store('logos/entreprises', 'public');
        }

        $updateData = [
            'nom_entreprise'    => $data['nom_entreprise'] ?? null,
            'ville_id'          => $data['ville_id'] ?? null,
            'adresse'           => $data['adresse'] ?? null,
            'email_contact'     => $data['email_contact'] ?? null,
            'bio'               => $data['bio'] ?? null,
            'registre_commerce' => $data['registre_commerce'] ?? null,
            'taille'            => $data['taille'] ?? null,
            'logo'              => array_key_exists('logo', $data) ? $data['logo'] : $entreprise->logo,
        ];

        if (isset($data['secteur_id'])) {
            $updateData['secteur_id'] = $data['secteur_id'];
        } elseif (isset($data['secteur'])) {
            $sect = Secteur::where('nom', $data['secteur'])->first();
            if ($sect) {
                $updateData['secteur_id'] = $sect->id;
            }
        }

        $entreprise->update(array_filter($updateData, fn($val) => !is_null($val)));

        return $entreprise;
    }

    public function incrementViews(int $id): void
    {
        $this->model->where('user_id', $id)->increment('vues');
    }

    public function getDetails(int $id): Entreprise
    {
        return Entreprise::with(['ville', 'secteur'])->findOrFail($id);
    }
}
