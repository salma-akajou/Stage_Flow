<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;

use App\Services\EntrepriseService;
use App\Services\OffreService;
use App\Models\Entreprise;
use Illuminate\Http\JsonResponse;

class EntrepriseController extends Controller
{
    /**
     * Retourne les données d'une entreprise pour affichage dans un modal AJAX
     */
    public function showAjax(int $id, EntrepriseService $entrepriseService, OffreService $offreService): JsonResponse
    {
        try {
            // Incrémenter les vues
            $entrepriseService->incrementViews($id);

            // Récupérer les détails de l'entreprise avec sa ville
            $entreprise = Entreprise::with('ville')->findOrFail($id);

            // Formater le logo
            $logoUrl = $entreprise->logo ? asset('storage/' . $entreprise->logo) : null;
            $lettreInitiale = substr($entreprise->nom_entreprise, 0, 1);

            // Récupérer les 3 dernières offres actives de cette entreprise
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
