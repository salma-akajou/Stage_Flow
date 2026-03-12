<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeedbackService
{
    public function create(int $auteurId, array $data): Feedback
    {
        return Feedback::create([
            'auteur_id' => $auteurId,
            'note' => $data['note'],
            'texte' => $data['texte'],
            'valide' => false,
        ]);
    }

    public function getLandingFeedbacks(int $limit = 3)
    {
        return Feedback::with('auteur')->where('valide', true)->latest()->take($limit)->get();
    }

    public function moderate(int $id, string $action): bool
    {
        $feedback = Feedback::findOrFail($id);
        if ($action === 'valider') {
            return $feedback->update(['valide' => true]);
        }
        return $feedback->delete();
    }

    public function search(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Feedback::with('auteur');

        if (!empty($filters['search'])) {
            $query->where('texte', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }
}