<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DgeController;
use App\Http\Controllers\ElecteurController;
use App\Http\Controllers\ParrainageController;
use App\Http\Controllers\CandidatController;
use App\Http\Controllers\HistoriqueUploadController;

Route::prefix('dge')->name('dge.')->group(function() {
    Route::get('/dashboard', [DgeController::class, 'dashboard'])->name('dashboard');
    Route::get('/import', [DgeController::class, 'import'])->name('import');
    Route::post('/import', [DgeController::class, 'importStore'])->name('import.store');
    Route::get('/gestion-periode', [DgeController::class, 'gestionPeriode'])->name('gestion_periode');
    Route::post('/gestion-periode', [DgeController::class, 'storePeriode'])->name('periode.store');
    Route::get('/ajout-candidat', [DgeController::class, 'ajoutCandidat'])->name('ajout_candidat');
    Route::post('/ajout-candidat', [DgeController::class, 'storeCandidat'])->name('candidat.store');
    Route::get('/statistiques', [DgeController::class, 'statistiques'])->name('statistiques');
    
    
    
    // Routes pour le ParrainageController
    Route::post('/parrainage', [ParrainageController::class, 'store'])->name('parrainage.store');
    Route::get('/parrainages/{candidatId}', [ParrainageController::class, 'parrainagesCandidat'])->name('parrainages_candidat');
     // Routes pour les électeurs à problème et historique des uploads
     Route::get('/electeurs-erreurs', [DgeController::class, 'electeursErreurs'])->name('electeurs_erreurs');
     
     
     // amodifier en ajoutant id comme suit
     //Route::get('historique-upload/{id}', [DgeController::class, 'historiqueUpload'])->name('dge.historique_upload');
    Route::get('/historique-upload', [DgeController::class, 'historiqueUpload'])->name('historique_upload');
});

Route::get('/', function () {
    return view('welcome');
});
