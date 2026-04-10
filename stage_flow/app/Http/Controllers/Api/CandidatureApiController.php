<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CandidatureService;
use Illuminate\Http\JsonResponse;


class CandidatureApiController extends Controller
{
    protected CandidatureService $candidatureService;

    public function __construct(CandidatureService $candidatureService)
    {
        $this->candidatureService = $candidatureService;
    }

    /**
     * Retourne les candidatures pour un étudiant donné
     */
    public function index($etudiantId): JsonResponse
    {
        try {
            $candidatures = $this->candidatureService->listEtudiantCandidatures($etudiantId, []);
            
            return response()->json([
                'success' => true,
                'data' => $candidatures
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la récupération des candidatures'
            ], 500);
        }
    }
}
