<?php

namespace App\Services;

use App\Models\Candidature;
use App\Models\DocumentCv;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class CandidatureService extends BaseService
{
    public function __construct()
    {
        $this->model = new Candidature();
    }

    public function postuler(int $etudiantId, int $offreId, array $data): Candidature
    {
        $cvId = null;
        if (isset($data['cv'])) {
            $path = $data['cv']->store('cvs', 'public');
            $cv = DocumentCv::create([
                'file_path' => $path,
                'etudiant_id' => $etudiantId,
                'date_upload' => now(),
            ]);
            $cvId = $cv->id;
        }

        $photoPath = null;
        if (isset($data['photo'])) {
            $photoPath = $data['photo']->store('photos/candidatures', 'public');
        }

        return $this->create([
            'etudiant_id'        => $etudiantId,
            'offre_id'           => $offreId,
            'cv_id'              => $cvId,
            'statut'             => 'En attente',
            'telephone'          => $data['telephone'] ?? 'Non renseigné',
            'message_motivation' => $data['message_motivation'] ?? '',
            'photo'              => $photoPath,
            'portfolio_url'      => $data['portfolio_url'] ?? null,
        ]);
    }

    public function listEtudiantCandidatures(int $etudiantId, array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = $this->model->where('etudiant_id', $etudiantId)->with('offre.entreprise');

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['search'])) {
            $query->whereHas('offre', function ($q) use ($filters) {
                $q->where('titre', 'like', '%' . $filters['search'] . '%')
                  ->orWhereHas('entreprise', function ($q2) use ($filters) {
                      $q2->where('nom_entreprise', 'like', '%' . $filters['search'] . '%');
                  });
            });
        }

        return $query->latest()->paginate($perPage);
    }

    public function listEntrepriseCandidatures(int $entrepriseId, array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->whereHas('offre', function ($q) use ($entrepriseId) {
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
        return (bool) $this->update($id, ['statut' => $status]);
    }

    public function delete(int $id): ?bool
    {
        $candidature = $this->findOrFail($id);

        if ($candidature->photo && Storage::disk('public')->exists($candidature->photo)) {
            Storage::disk('public')->delete($candidature->photo);
        }

        return $candidature->delete();
    }

    public function getRecentsCandidatures(int $etudiantId, int $limit = 3)
    {
        return $this->model->where('etudiant_id', $etudiantId)
            ->with(['offre.entreprise.user'])
            ->latest()
            ->take($limit)
            ->get();
    }

    public function getRecentByEntreprise(int $entrepriseId, int $limit = 4)
    {
        return $this->model->whereHas('offre', function ($q) use ($entrepriseId) {
                $q->where('entreprise_id', $entrepriseId);
            })
            ->with(['etudiant.user', 'offre'])
            ->latest()
            ->take($limit)
            ->get();
    }
}
