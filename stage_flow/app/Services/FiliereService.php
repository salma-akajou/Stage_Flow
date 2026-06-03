<?php

namespace App\Services;

use App\Models\Filiere;
use Illuminate\Pagination\LengthAwarePaginator;


class FiliereService extends BaseService
{
    public function __construct()
    {
        $this->model = new Filiere();
    }

    public function search(array $filters = [], int $perPage = 9): LengthAwarePaginator
    {
        $query = $this->model->newQuery();

        if (!empty($filters['search'])) {
            $query->where('nom', 'like', '%' . $filters['search'] . '%');
        }

        return $query->latest()->paginate($perPage);
    }
}
