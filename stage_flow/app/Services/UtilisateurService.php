<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class UtilisateurService extends BaseService
{
    public function __construct()
    {
        $this->model = new User();
    }

    public function listUsers(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nom', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('prenom', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }

        if (!empty($filters['statut'])) {
            $query->where('statut', $filters['statut']);
        }

        if (!empty($filters['role'])) {
            if ($filters['role'] === 'etudiant') {
                $query->has('etudiant');
            } elseif ($filters['role'] === 'entreprise') {
                $query->has('entreprise');
            }
        }

        return $query->latest()->paginate($perPage);
    }

    public function getUserDetails(int $id)
    {
        return $this->model->with([
            'etudiant.ville', 
            'entreprise.ville', 
            'feedbacks' => fn($q) => $q->latest()->take(5),
            'etudiant.candidatures.offre',
            'entreprise.offres' => fn($q) => $q->withCount('candidatures')->latest()->take(5)
        ])->findOrFail($id);
    }

    public function suspendUser(int $id): bool
    {
        $user = $this->findOrFail($id);
        if ($user) {
            $user->statut = 'suspendu';
            return $user->save();
        }
        return false;
    }

    public function reactivateUser(int $id): bool
    {
        $user = $this->findOrFail($id);
        if ($user) {
            $user->statut = 'actif';
            return $user->save();
        }
        return false;
    }

    public function deleteUser(int $id): ?bool
    {
        return $this->delete($id);
    }
}
