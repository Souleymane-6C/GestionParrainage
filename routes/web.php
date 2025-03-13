<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DgeController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\HistoriqueUploadController;
use App\Http\Controllers\SuiviParrainageController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AuthController;



// Routes d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Routes de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Déconnexion
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Middleware pour protéger les pages sensibles
Route::middleware(['auth'])->group(function () {
    Route::prefix('dge')->name('dge.')->group(function() {
        Route::get('/dashboard', [DgeController::class, 'dashboard'])->name('dashboard');
        Route::get('/import', [DgeController::class, 'import'])->name('import');
        Route::post('/import', [DgeController::class, 'importStore'])->name('import.store');
        Route::get('/gestion-periode', [DgeController::class, 'gestionPeriode'])->name('gestion_periode');
        Route::post('/gestion-periode', [DgeController::class, 'storePeriode'])->name('periode.store');
        Route::get('/ajout-candidat', [DgeController::class, 'ajoutCandidat'])->name('ajout_candidat');
        Route::post('/ajout-candidat', [DgeController::class, 'storeCandidat'])->name('candidat.store');
        Route::get('/statistiques', [DgeController::class, 'statistiques'])->name('statistiques');
        Route::post('/gestion-periode/toggle/{id}', [DgeController::class, 'togglePeriode'])->name('toggle_periode');


        Route::post('/valider-electeurs', [DgeController::class, 'validerElecteurs'])->name('validerElecteurs');

        // Routes pour le ParrainageController
        Route::post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');
        Route::get('/parrainages/{candidatId}', [ParrainageController::class, 'parrainagesCandidat'])->name('parrainages_candidat');
        
        // Routes pour les électeurs à problème et historique des uploads
        Route::get('/electeurs-erreurs', [DgeController::class, 'electeursErreurs'])->name('electeurs_erreurs');
        Route::get('/historique-upload', [DgeController::class, 'historiqueUpload'])->name('historique_upload');
    });
});

Route::get('/', function () {
    return view('welcome');
});








// ✅ Routes pour la gestion des candidats
Route::prefix('candidat')->group(function () {
    Route::get('/', [CandidatController::class, 'accueil'])->name('candidat.accueil');
    Route::get('/inscription', [CandidatController::class, 'showForm'])->name('candidat.inscription.form');
    Route::post('/inscription', [CandidatController::class, 'verifierCandidat'])->name('candidat.inscription');
    Route::post('/inscription/finaliser', [CandidatController::class, 'inscrire'])->name('candidat.inscription.finaliser');
    Route::get('/liste', [CandidatController::class, 'liste'])->name('candidat.liste');
    Route::get('/details/{id}', [CandidatController::class, 'details'])->name('candidat.details');
    Route::get('/renvoyer-code/{id}', [CandidatController::class, 'renvoyerCode'])->name('candidat.renvoyerCode');
    Route::get('/suivi', [CandidatController::class, 'suivi'])->name('candidat.suivi');
});

// ✅ Routes pour le suivi des parrainages
Route::prefix('suivi-parrainages')->group(function () {
    Route::get('/{candidat_id}', [SuiviParrainageController::class, 'index'])->name('suivi.parrainages'); // Suivi des parrainages d'un candidat
    Route::post('/connexion', [SuiviParrainageController::class, 'connexion'])->name('suivi.connexion'); // Connexion via code d'authentification
});




Route::prefix('candidats')->group(function () {
    Route::get('/', [CandidatController::class, 'index'])->name('candidats.index');
    Route::get('/create', [CandidatController::class, 'create'])->name('candidats.create');
    Route::post('/', [CandidatController::class, 'store'])->name('candidats.store');
    Route::get('/{id}', [CandidatController::class, 'show'])->name('candidats.show');
    Route::post('/{id}/generer-code', [CandidatController::class, 'genererCode'])->name('candidats.generer_code');
});






// GROUPE DES ROUTES POUR LES ÉLECTEURS
Route::prefix('electeur')->name('electeur.')->group(function () {
    // Page d'inscription
    Route::get('/inscription', [ElecteurController::class, 'create'])->name('inscription');
    Route::post('/store', [ElecteurController::class, 'store'])->name('store');

    // Page de connexion
    Route::get('/login', [ElecteurController::class, 'showLogin'])->name('login');
    Route::post('/authenticate', [ElecteurController::class, 'authenticate'])->name('authenticate');

    // Routes protégées (nécessitent d'être connecté)
    Route::middleware('auth:electeur')->group(function () {
        // Tableau de bord
        Route::get('/dashboard', [ElecteurController::class, 'dashboard'])->name('dashboard');

        // Page de parrainage
        Route::get('/parrainage', [ParrainageController::class, 'create'])->name('parrainage');
        Route::post('/parrainage/store', [ParrainageController::class, 'store'])->name('store_parrainage');

        // Déconnexion
        Route::post('/logout', [ElecteurController::class, 'logout'])->name('logout');
    });
});
Route::get('/suivi-parrainages/{id}', [SuiviParrainageController::class, 'index'])->name('suivi.parrainages');

Route::middleware(['auth:electeur'])->group(function () {
    // Afficher la liste des candidats pour choisir un parrainage
    Route::get('/parrainage/choisir', [ParrainageController::class, 'choisirCandidat'])->name('parrainage.choisir');

    // Enregistrer un parrainage
    Route::post('/parrainage/enregistrer', [ParrainageController::class, 'enregistrerParrainage'])->name('parrainage.enregistrer');

    // Afficher la page de validation du parrainage
    Route::get('/parrainage/valider', [ParrainageController::class, 'showValidation'])->name('parrainage.valider');

    // Valider un parrainage avec le code reçu
    Route::post('/parrainage/valider', [ParrainageController::class, 'validerParrainage'])->name('parrainage.valider.post');
});


Route::middleware(['auth.electeur'])->group(function () {
    Route::get('/electeur/dashboard', [ElecteurController::class, 'dashboard'])->name('electeur.dashboard');
});



Route::post('/logout', function () {
    Auth::logout();
    return redirect('/'); // Redirige vers l'accueil après déconnexion
})->name('logout');