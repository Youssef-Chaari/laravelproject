<?php

use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\VoitureController;
use App\Http\Controllers\Front\AnnonceController;
use App\Http\Controllers\Front\ForumController;
use App\Http\Controllers\Front\DevisController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\MarqueController;
use App\Http\Controllers\Admin\VehiculeController;
use App\Http\Controllers\Admin\ClientController;
use Illuminate\Support\Facades\Route;

// ─── Espace Authentifié Client (Aucun Guest toléré, bloque l'admin) ──────────
Route::middleware(['auth', 'client'])->group(function () {
    
    Route::get('/', [HomeController::class, 'index'])->name('home');

    // Voitures Neuves
    Route::prefix('voitures-neuves')->name('voitures.')->group(function () {
        Route::get('/', [VoitureController::class, 'index'])->name('index');
        Route::get('/{slug}', [VoitureController::class, 'marque'])->name('marque');
        Route::get('/{marqueSlug}/{vehiculeSlug}', [VoitureController::class, 'show'])->name('show');
        Route::post('/{marqueSlug}/{vehiculeSlug}/devis', [DevisController::class, 'generate'])->name('devis');
    });

    // Comparateur
    Route::get('/comparer', [VoitureController::class, 'compare'])->name('comparer');

    // Occasions
    Route::prefix('occasions')->name('occasions.')->group(function () {
        Route::get('/', [AnnonceController::class, 'index'])->name('index');
        Route::get('/mes-annonces', [AnnonceController::class, 'myAds'])->name('myAds');
        Route::get('/deposer', [AnnonceController::class, 'create'])->name('create');
        Route::post('/', [AnnonceController::class, 'store'])->name('store');
        
        // Les routes avec le paramètre {annonce} doivent être après les routes statiques
        Route::get('/{annonce}', [AnnonceController::class, 'show'])->name('show')->whereNumber('annonce');
        Route::get('/{annonce}/editer', [AnnonceController::class, 'edit'])->name('edit');
        Route::put('/{annonce}', [AnnonceController::class, 'update'])->name('update');
        Route::delete('/{annonce}', [AnnonceController::class, 'destroy'])->name('destroy');
    });

    // Forum
    Route::prefix('forum')->name('forum.')->group(function () {
        Route::get('/', [ForumController::class, 'index'])->name('index');
        Route::post('/', [ForumController::class, 'store'])->name('store');
        Route::get('/{topic}', [ForumController::class, 'show'])->name('show');
        Route::delete('/{topic}', [ForumController::class, 'destroy'])->name('destroy');
        Route::post('/{topic}/comment', [ForumController::class, 'storeComment'])->name('comment.store');
        Route::delete('/comment/{comment}', [ForumController::class, 'destroyComment'])->name('comment.destroy');
        Route::post('/{topic}/like', [ForumController::class, 'toggleTopicLike'])->name('like');
        Route::post('/comment/{comment}/like', [ForumController::class, 'toggleCommentLike'])->name('comment.like');
    });

    // Profil Utilisateur
    Route::get('/profile', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [\App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─── Admin Auth (no middleware – public) ─────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',  [AdminAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
    Route::post('/logout',[AdminAuthController::class, 'logout'])->name('logout');
});

// ─── Admin Protected Routes ───────────────────────────────────────────────────
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Marques CRUD
    Route::resource('marques', MarqueController::class)->names('marques');

    // Vehicules CRUD
    Route::resource('vehicules', VehiculeController::class)->names('vehicules');

    // Clients
    Route::prefix('clients')->name('clients.')->group(function () {
        Route::get('/',               [ClientController::class, 'index'])->name('index');
        Route::get('/{client}',       [ClientController::class, 'show'])->name('show');
        Route::patch('/{client}/toggle', [ClientController::class, 'toggle'])->name('toggle');
    });

    // Forum Moderation
    Route::get('/forum', [\App\Http\Controllers\Admin\ForumController::class, 'index'])->name('forum.index');
    Route::delete('/forum/topic/{topic}', [\App\Http\Controllers\Admin\ForumController::class, 'destroy'])->name('forum.topic.destroy');

    // Occasions Moderation
    Route::get('/annonces', [\App\Http\Controllers\Admin\AnnonceController::class, 'index'])->name('annonces.index');
    Route::get('/annonces/{annonce}', [\App\Http\Controllers\Admin\AnnonceController::class, 'show'])->name('annonces.show');
    Route::patch('/annonces/{annonce}/valider', [\App\Http\Controllers\Admin\AnnonceController::class, 'validateAd'])->name('annonces.valider');
    Route::patch('/annonces/{annonce}/rejeter', [\App\Http\Controllers\Admin\AnnonceController::class, 'rejectAd'])->name('annonces.rejeter');
    Route::delete('/annonces/{annonce}', [\App\Http\Controllers\Admin\AnnonceController::class, 'destroy'])->name('annonces.destroy');
});

require __DIR__.'/auth.php';

