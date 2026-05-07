<?php

use App\Http\Controllers\Web\LandingController;
use App\Http\Controllers\Web\Student\DashboardController;
use App\Http\Controllers\Web\Student\ProfileController;
use App\Http\Controllers\Web\Student\OffreController;
use App\Http\Controllers\Web\Student\EntrepriseController;
use App\Http\Controllers\Web\Student\CandidatureController;
use App\Http\Controllers\Web\Student\FavoriController;
use App\Http\Controllers\Web\Student\FeedbackController as StudentFeedback;
use App\Http\Controllers\Web\Entreprise\FeedbackController as EntrepriseFeedback;
use App\Http\Controllers\Web\Entreprise\DashboardController as EntrepriseDashboard;
use App\Http\Controllers\Web\Entreprise\OffreController as EntrepriseOffre;
use App\Http\Controllers\Web\Entreprise\CandidatureController as EntrepriseCandidature;
use App\Http\Controllers\Web\Entreprise\StudentController as EntrepriseStudent;
use App\Http\Controllers\Web\Entreprise\ProfileController as EntrepriseProfile;
use Illuminate\Support\Facades\Route;

Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::prefix('offres')->name('offres.')->group(function () {
    Route::get('/', [OffreController::class, 'index'])->name('index');
    Route::get('/{id}', [OffreController::class, 'show'])->name('show');
});

Route::get('/entreprises/{id}/profile', [EntrepriseController::class, 'showAjax'])->name('entreprises.profile.ajax');

Route::prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures');
    Route::post('/candidatures/{offreId}/postuler', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris');
    Route::post('/favoris/{offreId}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');
    Route::post('/feedback/store', [StudentFeedback::class, 'store'])->name('feedback.store');
});

// Espace Entreprise (Sans Auth pour le moment)
Route::prefix('entreprise')->name('entreprise.')->group(function () {
    Route::get('dashboard', [EntrepriseDashboard::class, 'index'])->name('dashboard');
    Route::post('/feedback/store', [EntrepriseFeedback::class, 'store'])->name('feedback.store');
    
    Route::prefix('offres')->name('offres.')->group(function () {
        Route::get('', [EntrepriseOffre::class, 'index'])->name('index');
        Route::post('', [EntrepriseOffre::class, 'store'])->name('store');
        Route::get('{id}/edit', [EntrepriseOffre::class, 'edit'])->name('edit');
        Route::put('{id}', [EntrepriseOffre::class, 'update'])->name('update');
        Route::delete('{id}', [EntrepriseOffre::class, 'destroy'])->name('destroy');
    });

    Route::prefix('candidatures')->name('candidatures.')->group(function () {
        Route::get('', [EntrepriseCandidature::class, 'index'])->name('index');
        Route::post('{id}/status', [EntrepriseCandidature::class, 'updateStatus'])->name('update_status');
        Route::get('student/{id}', [EntrepriseStudent::class, 'showAjax'])->name('show_student');
        Route::get('details/{id}', [EntrepriseCandidature::class, 'showCandidatureAjax'])->name('show_details');
    });

    Route::get('profile', [EntrepriseProfile::class, 'index'])->name('profile');
    Route::put('profile', [EntrepriseProfile::class, 'update'])->name('profile.update');
});

