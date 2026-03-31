<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OffreApiController;
use App\Http\Controllers\Api\EtudiantApiController;
use App\Http\Controllers\Api\CandidatureApiController;
use App\Http\Controllers\Api\LandingApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Les routes définies ici seront accessibles via le préfixe /api.
| Elles sont destinées à être consommées par l'application mobile.
|
*/

// --- Route pour la Landing Page ---
Route::get('/landing', [LandingApiController::class, 'index']);

// --- Routes pour les Offres ---
Route::prefix('offres')->group(function () {
    Route::get('/', [OffreApiController::class, 'index']);
    Route::get('/{id}', [OffreApiController::class, 'show']);
});

// --- Routes pour l'Étudiant (Dashboard & Profil) ---
Route::prefix('student/{etudiantId}')->group(function () {
    Route::get('/dashboard', [EtudiantApiController::class, 'dashboard']);
    Route::get('/profile', [EtudiantApiController::class, 'profile']);
    
    // --- Routes pour les Candidatures de l'étudiant ---
    Route::get('/candidatures', [CandidatureApiController::class, 'index']);
});
