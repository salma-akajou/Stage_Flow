<?php

namespace App\Services;

use App\Models\Feedback;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class FeedbackService
{
    public function create(int $auteurId, array $data): Feedback
    {
        return Feedback::create([
            'user_id' => $auteurId,
            'note' => $data['note'],
            'commentaire' => $data['commentaire'],
            'valide' => false, // Requires admin validation
        ]);
    }

    public function getLandingFeedbacks(int $limit = 3)
    {
        return Feedback::with('user')->where('valide', true)->latest()->take($limit)->get();
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
        $query = Feedback::with('user');

        if (!empty($filters['role'])) {
            // Logic to filter by user role (requires role relation or join)
        }

        if (!empty($filters['search'])) {
            $query->where('commentaire', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }
}
