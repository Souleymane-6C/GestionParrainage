<?php

namespace App\Http\Controllers;

use App\Models\PeriodeParrainage;
use App\Models\Candidat;
use App\Models\Parrainage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ElecteurErreur;
use App\Models\HistoriqueUpload;

class DgeController extends Controller
{
    // Affichage du dashboard
    public function dashboard()
    {
        $parrainages = Parrainage::all();
        return view('dge.dashboard', compact('parrainages'));
    }

    // Affichage du formulaire d'importation de fichier
    public function import()
    {
        return view('dge.import');
    }

    // Traitement de l'importation de fichier CSV
    public function importStore(Request $request)
    {
        $request->validate([
            'fichier_electeurs' => 'required|file|mimes:csv,txt',
            'checksum' => 'required|string',
        ]);

        $file = $request->file('fichier_electeurs');
        $fileHash = hash_file('sha256', $file);

        if ($fileHash !== $request->checksum) {
            return back()->with('error', 'Le checksum du fichier ne correspond pas.');
        }

        // Enregistrer le fichier et traiter son contenu
        $path = $file->storeAs('uploads', 'electeurs.csv');

        // Traiter le fichier CSV ici (ajout d'une logique pour valider et stocker les électeurs)
        
        return back()->with('success', 'Fichier importé avec succès.');
    }

    // Affichage du formulaire de gestion de la période de parrainage
    public function gestionPeriode()
{
    // On récupère la période actuelle s'il y en a une
    $periode = PeriodeParrainage::latest()->first();

    // On retourne la vue avec la période (ou null si aucune période n'est définie)
    return view('dge.gestion_periode', compact('periode'));
}


    // Enregistrement des dates de la période de parrainage
    public function storePeriode(Request $request)
    {
        $request->validate([
            'date_debut' => 'required|date|after_or_equal:today',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        $periode = PeriodeParrainage::firstOrCreate([]);
        $periode->date_debut = $request->date_debut;
        $periode->date_fin = $request->date_fin;
        $periode->save();

        return redirect()->route('dge.gestion_periode')->with('success', 'Période de parrainage mise à jour.');
    }

    // Affichage du formulaire d'ajout d'un candidat
    public function ajoutCandidat()
    {
        return view('dge.ajout_candidat');
    }

    // Enregistrement d'un candidat
    public function storeCandidat(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'numero_carte' => 'required|string|unique:candidats,numero_carte|max:20',
        'date_naissance' => 'required|date|before:today',
    ]);

    Candidat::create([
        'nom' => $request->nom,
        'prenom' => $request->prenom,
        'numero_carte' => $request->numero_carte,
        'date_naissance' => $request->date_naissance,
    ]);

    return redirect()->route('dge.ajout_candidat')->with('success', 'Candidat ajouté avec succès.');
}


    // Affichage des statistiques des parrainages
    public function statistiques()
    {
        $parrainages = Parrainage::with('candidat')->get();
        return view('dge.statistiques', compact('parrainages'));
    }

    public function electeursErreurs()
{
    $electeursErreurs = ElecteurErreur::all();
    return view('electeurs_erreurs', compact('electeursErreurs'));
}

public function historiqueUpload($id)
{
    $historiqueUpload = HistoriqueUpload::with('electeursErreurs')->findOrFail($id);
    return view('historique_upload', compact('historiqueUpload'));
}
}


