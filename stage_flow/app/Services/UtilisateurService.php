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

    private function buildUsersQuery(array $filters = [])
    {
        $query = $this->model->newQuery();

        // Ne pas afficher les administrateurs dans la liste de gestion
        $query->whereDoesntHave('roles', function($q) {
            $q->where('name', 'admin');
        });

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('nom', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('prenom', 'like', '%' . $filters['search'] . '%')
                  ->orWhere('email', 'like', '%' . $filters['search'] . '%');
            });
        }



        if (!empty($filters['role'])) {
            if ($filters['role'] === 'etudiant') {
                $query->has('etudiant');
            } elseif ($filters['role'] === 'entreprise') {
                $query->has('entreprise');
            } elseif ($filters['role'] === 'moderateur') {
                $query->whereHas('roles', function($q) {
                    $q->where('name', 'moderateur');
                });
            }
        }

        return $query->latest();
    }

    public function listUsers(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        return $this->buildUsersQuery($filters)->paginate($perPage);
    }




    public function getUserDetails(int $id)
    {
        return $this->model->with([
            'etudiant.ville', 
            'etudiant.etablissement',
            'entreprise.ville', 
            'entreprise.secteur', 
            'feedbacks' => fn($q) => $q->latest()->take(5),
            'etudiant.candidatures.offre',
            'entreprise.offres' => fn($q) => $q->withCount('candidatures')->latest()->take(5)
        ])->findOrFail($id);
    }



    public function deleteUser(int $id): ?bool
    {
        return $this->delete($id);
    }
}

