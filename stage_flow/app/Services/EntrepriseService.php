<?php

namespace App\Services;

use App\Models\Entreprise;
use Illuminate\Support\Facades\Storage;

class EntrepriseService extends BaseService
{
    public function __construct()
    {
        $this->model = new Entreprise();
    }

    public function updateProfile(int $id, array $data): Entreprise
    {
        $entreprise = $this->findOrFail($id);

        if (isset($data['logo'])) {
            if ($entreprise->logo && Storage::disk('public')->exists($entreprise->logo)) {
                Storage::disk('public')->delete($entreprise->logo);
            }
            $data['logo'] = $data['logo']->store('logos/entreprises', 'public');
        }

        if (!empty($data['supprimer_logo'])) {
            if ($entreprise->logo && Storage::disk('public')->exists($entreprise->logo)) {
                Storage::disk('public')->delete($entreprise->logo);
            }
            $data['logo'] = null;
            unset($data['supprimer_logo']);
        }

        return $this->update($id, array_filter([
            'nom_entreprise'    => $data['nom_entreprise'] ?? null,
            'secteur'           => $data['secteur'] ?? null,
            'ville_id'          => $data['ville_id'] ?? null,
            'adresse'           => $data['adresse'] ?? null,
            'email_contact'     => $data['email_contact'] ?? null,
            'bio'               => $data['bio'] ?? null,
            'registre_commerce' => $data['registre_commerce'] ?? null,
            'taille'            => $data['taille'] ?? null,
            'logo'              => array_key_exists('logo', $data) ? $data['logo'] : $entreprise->logo,
        ], fn($val) => !is_null($val)));
    }

    public function incrementViews(int $id): void
    {
        $this->model->where('user_id', $id)->increment('vues');
    }
}
