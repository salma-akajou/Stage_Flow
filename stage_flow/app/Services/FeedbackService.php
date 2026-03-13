<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Pagination\LengthAwarePaginator;

class FeedbackService extends BaseService
{
    public function __construct()
    {
        $this->model = new Feedback();
    }

    public function getLandingFeedbacks(int $limit = 3)
    {
        return $this->model->with('auteur')->where('valide', true)->latest()->take($limit)->get();
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

    public function search(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = $this->model->with('auteur');

        if (!empty($filters['search'])) {
            $query->where('texte', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }
}