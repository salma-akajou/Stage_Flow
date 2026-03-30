<?php

use App\Http\Controllers\LandingController;
use App\Http\Controllers\EtudiantController;
use App\Http\Controllers\OffreController;
use App\Http\Controllers\CandidatureController;
use App\Http\Controllers\FavoriController;
use App\Http\Controllers\FeedbackController;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('offres')->name('offres.')->group(function () {
    Route::get('/', [OffreController::class, 'index'])->name('index');
    Route::get('/{id}', [OffreController::class, 'show'])->name('show');
});

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [EtudiantController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [EtudiantController::class, 'profile'])->name('profile');
    Route::post('/profile/update', [EtudiantController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures');
    Route::post('/candidatures/{offreId}/postuler', [CandidatureController::class, 'store'])->name('candidatures.store');
    
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris');
    Route::post('/favoris/{offreId}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');
});

Route::post('/feedback/store', [FeedbackController::class, 'store'])->name('feedback.store');
