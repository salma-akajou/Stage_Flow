<?php

use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\CandidatureApiController;
use App\Http\Controllers\Api\EtudiantApiController;
use App\Http\Controllers\Api\LandingApiController;
use App\Http\Controllers\Api\OffreApiController;
use App\Http\Controllers\Api\FavoriApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Les routes définies ici seront accessibles via le préfixe /api.
| Elles sont destinées à être consommées par l'application mobile.
|
|*/

// --- Route pour la Landing Page ---
Route::get('/landing', [LandingApiController::class, 'index']);
Route::get('/villes', [LandingApiController::class, 'villes']);
Route::get('/secteurs', [LandingApiController::class, 'secteurs']);

// --- Routes pour les Offres ---
Route::prefix('offres')->group(function () {
    Route::get('/', [OffreApiController::class, 'index']);
    Route::get('/{id}', [OffreApiController::class, 'show']);
});

// --- Routes d'Authentification ---
Route::post('/auth/login', [AuthApiController::class, 'login']);
Route::post('/auth/register', [AuthApiController::class, 'register']);

// --- Routes Protégées par Sanctum ---
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/auth/logout', [AuthApiController::class, 'logout']);

    // --- Routes pour l'Étudiant (Dashboard & Profil) ---
    Route::prefix('student/{etudiantId}')->group(function () {
        Route::get('/dashboard', [EtudiantApiController::class, 'dashboard']);
        Route::get('/profile', [EtudiantApiController::class, 'profile']);
        
        // --- Routes pour les Candidatures de l'étudiant ---
        Route::get('/candidatures', [CandidatureApiController::class, 'index']);

        // --- Routes pour les Favoris de l'étudiant ---
        Route::get('/favoris', [FavoriApiController::class, 'index']);
        Route::get('/favoris/ids', [FavoriApiController::class, 'ids']);
        Route::post('/favoris/{offreId}/toggle', [FavoriApiController::class, 'toggle']);
    });
});
