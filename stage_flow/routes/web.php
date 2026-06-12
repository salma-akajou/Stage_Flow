<?php

use App\Http\Controllers\Web\LandingController;
use App\Http\Controllers\Web\Student\DashboardController;
use App\Http\Controllers\Web\Student\ProfileController;
use App\Http\Controllers\Web\Student\OffreController;
use App\Http\Controllers\Web\Student\EntrepriseController;
use App\Http\Controllers\Web\Student\CandidatureController;
use App\Http\Controllers\Web\Student\FavoriController;
use App\Http\Controllers\Web\Student\FeedbackController as StudentFeedback;
use App\Http\Controllers\Web\Student\NotificationController;
use App\Http\Controllers\Web\Entreprise\FeedbackController as EntrepriseFeedback;
use App\Http\Controllers\Web\Entreprise\DashboardController as EntrepriseDashboard;
use App\Http\Controllers\Web\Entreprise\OffreController as EntrepriseOffre;
use App\Http\Controllers\Web\Entreprise\CandidatureController as EntrepriseCandidature;
use App\Http\Controllers\Web\Entreprise\StudentController as EntrepriseStudent;
use App\Http\Controllers\Web\Entreprise\ProfileController as EntrepriseProfile;
use App\Http\Controllers\Web\Entreprise\NotificationController as EntrepriseNotification;
use App\Http\Controllers\Web\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Web\Admin\UtilisateurController as AdminUser;
use App\Http\Controllers\Web\Admin\FeedbackController as AdminFeedback;
use App\Http\Controllers\Web\Admin\FiliereController;
use App\Http\Controllers\Web\Admin\SecteurController;
use App\Http\Controllers\Web\Admin\EtablissementController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;



Route::get('/', [LandingController::class, 'index'])->name('landing');

Route::middleware(['auth', 'role:etudiant'])->prefix('student')->name('student.')->group(function () {
    Route::prefix('offres')->name('offres.')->group(function () {
        Route::get('/', [OffreController::class, 'index'])->name('index');
        Route::get('/{id}', [OffreController::class, 'show'])->name('show');
    });

    Route::get('/entreprises/{id}/profile', [EntrepriseController::class, 'showAjax'])->name('entreprises.profile.ajax');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/candidatures', [CandidatureController::class, 'index'])->name('candidatures');
    Route::post('/candidatures/{offreId}/postuler', [CandidatureController::class, 'store'])->name('candidatures.store');
    Route::delete('/candidatures/{id}', [CandidatureController::class, 'destroy'])->name('candidatures.destroy');
    
    Route::get('/favoris', [FavoriController::class, 'index'])->name('favoris');
    Route::post('/favoris/{offreId}/toggle', [FavoriController::class, 'toggle'])->name('favoris.toggle');
    Route::post('/feedback/store', [StudentFeedback::class, 'store'])->name('feedback.store');

    Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllRead'])->name('notifications.markAllRead');
});

// Espace Entreprise
Route::middleware(['auth', 'role:entreprise'])->prefix('entreprise')->name('entreprise.')->group(function () {
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
        Route::get('export', [EntrepriseCandidature::class, 'export'])->name('export');
        Route::post('{id}/status', [EntrepriseCandidature::class, 'updateStatus'])->name('update_status');
        Route::get('student/{id}', [EntrepriseStudent::class, 'showAjax'])->name('show_student');
        Route::get('details/{id}', [EntrepriseCandidature::class, 'showCandidatureAjax'])->name('show_details');
    });

    Route::get('profile', [EntrepriseProfile::class, 'index'])->name('profile');
    Route::put('profile', [EntrepriseProfile::class, 'update'])->name('profile.update');

    Route::post('/notifications/{id}/mark-read', [EntrepriseNotification::class, 'markRead'])->name('notifications.markRead');
    Route::post('/notifications/mark-all-read', [EntrepriseNotification::class, 'markAllRead'])->name('notifications.markAllRead');
});

// Espace Admin (accessible par admin ET modérateur)
Route::middleware(['auth', 'role:admin|moderateur'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('dashboard', [AdminDashboard::class, 'index'])->name('dashboard');

    // Gestion des utilisateurs - lecture seule pour tous (admin + modérateur)
    Route::prefix('users')->name('users.')->group(function () {
        Route::get('', [AdminUser::class, 'index'])->name('index');
        Route::get('{id}', [AdminUser::class, 'show'])->name('show');

        // Actions réservées à ceux qui ont la permission gerer-utilisateurs (admin seulement)
        Route::middleware('can:gerer-utilisateurs')->group(function () {
            Route::delete('{id}', [AdminUser::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion des feedbacks (permission: gerer-feedbacks)
    Route::prefix('feedbacks')->name('feedbacks.')->middleware('can:gerer-feedbacks')->group(function () {
        Route::get('', [AdminFeedback::class, 'index'])->name('index');
        Route::post('{id}/approve', [AdminFeedback::class, 'approve'])->name('approve');
        Route::delete('{id}', [AdminFeedback::class, 'destroy'])->name('destroy');
    });

    // Gestion des filières
    Route::prefix('filieres')->name('filieres.')->group(function () {
        Route::get('', [FiliereController::class, 'index'])->name('index');
        Route::middleware('can:gerer-utilisateurs')->group(function () {
            Route::post('', [FiliereController::class, 'store'])->name('store');
            Route::put('{id}', [FiliereController::class, 'update'])->name('update');
            Route::delete('{id}', [FiliereController::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion des secteurs
    Route::prefix('secteurs')->name('secteurs.')->group(function () {
        Route::get('', [SecteurController::class, 'index'])->name('index');
        Route::middleware('can:gerer-utilisateurs')->group(function () {
            Route::post('', [SecteurController::class, 'store'])->name('store');
            Route::put('{id}', [SecteurController::class, 'update'])->name('update');
            Route::delete('{id}', [SecteurController::class, 'destroy'])->name('destroy');
        });
    });

    // Gestion des établissements
    Route::prefix('etablissements')->name('etablissements.')->group(function () {
        Route::get('', [EtablissementController::class, 'index'])->name('index');
        Route::middleware('can:gerer-utilisateurs')->group(function () {
            Route::post('', [EtablissementController::class, 'store'])->name('store');
            Route::put('{id}', [EtablissementController::class, 'update'])->name('update');
            Route::delete('{id}', [EtablissementController::class, 'destroy'])->name('destroy');
        });
    });
});


Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

// Route Chatbot IA
use App\Http\Controllers\Web\ChatbotController;
Route::post('/chatbot/message', [ChatbotController::class, 'handleMessage'])->name('chatbot.message');

