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
//Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
//Route::post('/register', [AuthController::class, 'register'])->name('register');

// Routes de connexion
//Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
//Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

// Déconnexion
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');




// Vérifiez si une route `/dge/register` existe
Route::prefix('dge')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('dge.register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('dge.register');
});

// Routes de connexion des utilisateurs
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('user.login.form');
Route::post('/login', [AuthController::class, 'login'])->name('user.login');

// Déconnexion des utilisateurs
Route::post('/logout', [AuthController::class, 'logout'])->name('user.logout');




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


        Route::post('/electeurs-erreurs/delete/{id}', [DgeController::class, 'supprimerElecteur'])->name('electeursErreurs.delete');
        Route::post('/electeurs-erreurs/correction/{id}', [DgeController::class, 'corrigerElecteur'])->name('electeursErreurs.correction');

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




// Formulaire de saisie du numéro de carte du candidat
Route::get('/candidat/inscription', [CandidatController::class, 'searchForm'])->name('candidat.inscription.form');
Route::post('/candidat/inscription', [CandidatController::class, 'verifyCandidat'])->name('candidat.inscription.verify');

// Formulaire pour compléter l'inscription du candidat
Route::get('/candidat/complement/{id}', [CandidatController::class, 'complementForm'])->name('candidat.complement.form');
Route::post('/candidat/complement/{id}', [CandidatController::class, 'finalizeCandidat'])->name('candidat.complement.finalize');


// Connexion des candidats
Route::get('/candidat/login', [CandidatController::class, 'showLoginForm'])->name('candidat.login.form');
Route::post('/candidat/login', [CandidatController::class, 'login'])->name('candidat.login');

// Traiter la connexion du candidat
Route::post('/candidat/authenticate', [CandidatController::class, 'authenticate'])->name('candidat.authenticate');


// Déconnexion des candidats
Route::post('/candidat/logout', [CandidatController::class, 'logout'])->name('candidat.logout');

// Liste et détails des candidats
Route::get('/candidats', [CandidatController::class, 'liste'])->name('candidat.liste');
Route::get('/candidat/details/{id}', [CandidatController::class, 'details'])->name('candidat.details');


// Page de demande et saisie du code
Route::get('/candidat/details/code/{id}', [CandidatController::class, 'showCodeVerificationPage'])->name('candidat.details.code');
Route::post('/candidat/details/code', [CandidatController::class, 'verifyCodeForDetails'])->name('candidat.details.verify'); //yavait details.verify

// Génération d'un nouveau code d'authentification pour les candidats
Route::post('/candidat/generer-code/{id}', [CandidatController::class, 'genererNouveauCode'])->name('candidat.generer_code');

// Suivi des parrainages d’un candidat
Route::get('/candidat/suivi', [CandidatController::class, 'suivi'])->name('candidat.suivi');
Route::get('/candidat/accueil', [CandidatController::class, 'accueil'])->name('candidat.accueil');


// Page de vérification
Route::get('/candidat/verification/{id}', [CandidatController::class, 'verificationCode'])->name('candidat.verification');



// Validation du code et accès aux détails
Route::post('/candidat/valider-code/{id}', [CandidatController::class, 'validerCodeCandidat'])->name('candidat.valider_code');

Route::get('/candidat/verification/{id}', [CandidatController::class, 'verificationCode'])->name('candidat.verification_code');






// ROUTES POUR ELECTEURS

// Formulaire d'inscription des électeurs
//Route::get('/electeur/inscription', [ElecteurController::class, 'showRegisterForm'])->name('electeur.inscription.form');
//Route::post('/electeur/inscription', [ElecteurController::class, 'register'])->name('electeur.inscription');

// Connexion des électeurs
//Route::get('/electeur/login', [ElecteurController::class, 'showLoginForm'])->name('electeur.login.form');
//Route::post('/electeur/login', [ElecteurController::class, 'login'])->name('electeur.login');

// Déconnexion des électeurs
//Route::post('/electeur/logout', [ElecteurController::class, 'logout'])->name('electeur.logout');

// Tableau de bord des électeurs
//Route::get('/electeur/dashboard', [ElecteurController::class, 'dashboard'])->name('electeur.dashboard');














// ✅ Routes pour le suivi des parrainages
// Consultation du suivi des parrainages d'un candidat
Route::get('/suivi-parrainages/{candidat_id}', [CandidatController::class, 'index'])->name('suivi.parrainages');

// Connexion pour accéder au suivi des parrainages
Route::post('/suivi-parrainages/connexion', [SuiviParrainageController::class, 'connexion'])->name('suivi.connexion');


//ROUTES POUR PROCESSUS PARRAINAGE


// Affichage des candidats pour le parrainage
Route::get('/parrainage', [ParrainageController::class, 'choisirCandidat'])->name('parrainage.choisir');

// Enregistrement du parrainage
Route::post('/parrainage/enregistrer', [ParrainageController::class, 'enregistrerParrainage'])->name('parrainage.enregistrer');

// Formulaire de validation du parrainage
Route::get('/parrainage/validation', [ParrainageController::class, 'showValidation'])->name('parrainage.valider');

// Validation du parrainage après réception du code de validation
Route::post('/parrainage/validation', [ParrainageController::class, 'validerParrainage'])->name('parrainage.validation');





// GROUPE DES ROUTES POUR LES ÉLECTEURS
 Route::prefix('electeur')->name('electeur.')->group(function () {
    // Page d'inscription
    Route::get('/inscription', [ElecteurController::class, 'showRegisterForm'])->name('inscription');

    Route::post('/inscription', [ElecteurController::class, 'register'])->name('inscription');

    // Page de connexion
    Route::get('/login', [ElecteurController::class, 'login'])->name('login');
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
    
        Route::post('/verifier', [ElecteurController::class, 'verifierInformations'])->name('verifier_informations');

      
        Route::post('/envoyer-code/{id}', [ElecteurController::class, 'sendSms'])->name('envoyer_code');
        Route::get('/verification/{id}', [ElecteurController::class, 'showVerificationPage'])->name('verification');
        Route::post('/valider-code/{id}', [ElecteurController::class, 'validerCodeElecteur'])->name('valider_code');
    
    
    
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