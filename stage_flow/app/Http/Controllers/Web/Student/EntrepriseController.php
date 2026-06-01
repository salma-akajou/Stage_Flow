<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;

use App\Services\EntrepriseService;
use App\Services\OffreService;
use Illuminate\Http\JsonResponse;

class EntrepriseController extends Controller
{
    public function showAjax(int $id, EntrepriseService $entrepriseService, OffreService $offreService): JsonResponse
    {
        try {
            $entrepriseService->incrementViews($id);
            $entreprise = $entrepriseService->getDetails($id);
            $logoUrl = $entreprise->logo ? asset('storage/' . $entreprise->logo) : null;
            $lettreInitiale = substr($entreprise->nom_entreprise, 0, 1);
            $offres = $offreService->getActiveByEntreprise($id, 3);

            return response()->json([
                'success' => true,
                'data' => [
                    'entreprise' => [
                        ...$entreprise->toArray(),
                        'logoUrl' => $logoUrl,
                        'lettreInitiale' => $lettreInitiale
                    ],
                    'offres' => $offres
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Entreprise introuvable'
            ], 404);
        }
    }
}
