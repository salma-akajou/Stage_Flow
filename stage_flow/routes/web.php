<?php

use App\Http\Controllers\Web\LandingController;
use App\Http\Controllers\Web\EtudiantController;
use App\Http\Controllers\Web\OffreController;
use App\Http\Controllers\Web\EntrepriseController;
use App\Http\Controllers\Web\CandidatureController;
use App\Http\Controllers\Web\FavoriController;
use App\Http\Controllers\Web\FeedbackController;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('offres')->name('offres.')->group(function () {
    Route::get('/', [OffreController::class, 'index'])->name('index');
    Route::get('/{id}', [OffreController::class, 'show'])->name('show');
});

Route::get('/entreprises/{id}/profile', [EntrepriseController::class, 'showAjax'])->name('entreprises.profile.ajax');

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [EtudiantController::class, 'profile'])->name('profile');
    Route::put('/profile/update', [EtudiantController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures');
    Route::get('/offres/{offreId}/postuler', [CandidatureController::class, 'create'])->name('candidatures.create');
    Route::post('/candidatures/{offreId}/postuler', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris');
    Route::post('/favoris/{offreId}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');
});

Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
