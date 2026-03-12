<?php

namespace App\Services;

use App\Models\Candidature;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;


class CandidatureService
{
    public function postuler(int $etudiantId, int $offreId, array $data): Candidature
    {
        if (isset($data['cv'])) {
            $data['cv_path'] = $data['cv']->store('cvs', 'public');
        }

        if (isset($data['photo'])) {
            $data['photo_path'] = $data['photo']->store('photos', 'public');
        }

        return Candidature::create([
            'etudiant_id' => $etudiantId,
            'offre_id' => $offreId,
            'statut' => 'En attente',
            'telephone' => $data['telephone'],
            'message_motivation' => $data['message_motivation'],
            'photo' => $data['photo_path'] ?? null,
            'portfolio_url' => $data['portfolio_url'] ?? null,
            'cv_path' => $data['cv_path'] ?? null, // Note: Logic depends on if we link to DocumentCv model or just path
        ]);
    }

    public function listEtudiantCandidatures(int $etudiantId, array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = Candidature::where('etudiant_id', $etudiantId)->with('offre.entreprise');

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }
        
        if (!empty($filters['search'])) {
            $query->whereHas('offre', function($q) use ($filters) {
                $q->where('titre', 'like', '%' . $filters['search'] . '%');
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function listEntrepriseCandidatures(int $entrepriseId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Candidature::whereHas('offre', function($q) use ($entrepriseId) {
            $q->where('entreprise_id', $entrepriseId);
        })->with(['etudiant.user', 'offre']);

        if (!empty($filters['offre_id'])) {
            $query->where('offre_id', $filters['offre_id']);
        }

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        return $query->latest()->paginate($perPage);
    }

    public function changeStatus(int $id, string $status): bool
    {
        $candidature = Candidature::findOrFail($id);
        return $candidature->update(['statut' => $status]);
    }

    public function delete(int $id): bool
    {
        $candidature = Candidature::findOrFail($id);
        return $candidature->delete();
    }
}
