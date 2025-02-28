<?php

namespace App\Http\Controllers;

use App\Models\HistoriqueUpload;
use App\Models\Electeur;
use App\Models\ElecteurErreur;
use Illuminate\Http\Request;

class ElecteurController extends Controller
{
    // Validation des électeurs après importation du fichier
    public function validerElecteurs(Request $request)
    {
        $electeurs = Electeur::all(); // Récupérer les électeurs à valider (par exemple, ceux dans la table temporaire)

        // Logique de validation des électeurs (contrôle des CIN, numéros d'électeurs, etc.)
        
        foreach ($electeurs as $electeur) {
            // Effectuer les vérifications et enregistrer les erreurs dans ElecteurErreur
        }

        return back()->with('success', 'Électeurs validés.');
    }

    // Affichage des erreurs des électeurs
    public function erreursElecteurs()
    {
        $erreurs = ElecteurErreur::all();
        return view('dge.erreurs_electeurs', compact('erreurs'));
    }

    // Gestion des tentatives d'upload et enregistrement dans l'historique
    public function historiqueUpload(Request $request)
    {
        $historique = HistoriqueUpload::all();
        return view('dge.historique_upload', compact('historique'));
    }
}
