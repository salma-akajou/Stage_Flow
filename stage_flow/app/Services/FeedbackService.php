<?php

namespace App\Services;

use App\Models\Feedback;
use App\Services\BaseService; 
use Illuminate\Pagination\LengthAwarePaginator;

class FeedbackService extends BaseService
{
    public function __construct()
    {
        $this->model = new Feedback(); 
    }

    public function getLandingFeedbacks(int $limit = 3)
    {
        return $this->model->with(['auteur.etudiant', 'auteur.entreprise'])->where('valide', true)->latest()->take($limit)->get();
    }

    public function moderate(int $id, string $action): bool
    {
        $feedback = $this->findOrFail($id);
        if ($action === 'valider') {
            $feedback->update(['valide' => true]);
            return true;
        }
        return (bool) $feedback->delete();
    }

    public function search(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = $this->model->with(['auteur.etudiant', 'auteur.entreprise']);

        if (!empty($filters['search'])) {
            $query->where('texte', 'like', '%' . $filters['search'] . '%');
        }

        if (isset($filters['valide']) && $filters['valide'] !== '') {
            $query->where('valide', $filters['valide']);
        }

        if (!empty($filters['role'])) {
            if ($filters['role'] === 'etudiant') {
                $query->whereHas('auteur', function($q) {
                    $q->has('etudiant');
                });
            } elseif ($filters['role'] === 'entreprise') {
                $query->whereHas('auteur', function($q) {
                    $q->has('entreprise');
                });
            }
        }

        return $query->latest()->paginate($perPage);
    }
}