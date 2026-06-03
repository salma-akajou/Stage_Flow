<?php

namespace App\Services;

use App\Models\Etablissement;
use Illuminate\Pagination\LengthAwarePaginator;

class EtablissementService extends BaseService
{
    public function __construct()
    {
        $this->model = new Etablissement();
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
