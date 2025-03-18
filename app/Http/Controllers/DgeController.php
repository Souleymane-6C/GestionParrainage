<?php

namespace App\Http\Controllers;

use App\Models\PeriodeParrainage;
use App\Models\Candidat;
use App\Models\Parrainage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\ElecteursErreurs;
use App\Models\HistoriqueUpload;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DgeController extends Controller
{
    // 📌 Fonction pour récupérer l'adresse IP de l'utilisateur
    private function getUserIp()
    {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]);
        }
        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
    }

    // 📌 Affichage du dashboard
    public function dashboard()
    {
        $candidats = Candidat::withCount('parrainages')->get();
        $periode = PeriodeParrainage::latest()->first();
        return view('dge.dashboard', compact('candidats', 'periode'));
    }

    // 📌 Ajout de candidats
    public function ajoutCandidat()
    {
        $candidats = Candidat::orderBy('nom', 'asc')->get();
        return view('dge.ajout_candidat', compact('candidats'));
    }

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
    // Récupérer tous les candidats avec le nombre de parrainages (relation avec parrainages)
    $candidats = Candidat::withCount('parrainages')->get();

    return view('dge.statistiques', compact('candidats'));
}




public function electeursErreurs()
{
    // Récupérer uniquement les électeurs en erreur
    $electeursErreurs = DB::table('electeurs_erreurs')->get();

    return view('dge.electeurs_erreurs', compact('electeursErreurs'));
}


    
    // 📌 Affichage du formulaire d'importation
    public function import()
    {
        return view('dge.import');
    }


    public function historiqueUpload()
{
    $historiqueUploads = HistoriqueUpload::with('electeursErreurs')->get();
    return view('dge.historique_upload', compact('historiqueUploads'));
}


    // 📌 Traitement de l'importation d'un fichier CSV
    public function importStore(Request $request)
    {
        $request->validate([
            'fichier_electeurs' => 'required|file|mimes:csv,txt',
            'checksum' => 'required|string',
        ]);

        $file = $request->file('fichier_electeurs');
        $fileHash = hash_file('sha256', $file);
        $nomFichier = $file->getClientOriginalName();
        $ipAddress = $this->getUserIp();

        // 📌 Vérification du fichier avec la procédure PL/SQL
        $result = DB::select("CALL ControlerFichierElecteurs(?, ?, ?, ?, @resultat)", [
            $fileHash,
            $request->checksum,
            $nomFichier,
            $ipAddress
        ]);
        $validation = DB::select("SELECT @resultat as resultat")[0]->resultat;

        if ($validation == 0) {
            return back()->with('error', 'Le fichier est invalide (checksum incorrect ou format non conforme).');
        }

        // 📌 Stocker le fichier
        $filePath = $file->storeAs('uploads', $nomFichier);

        // 📌 Enregistrer l'upload dans l'historique
        $historiqueUpload = HistoriqueUpload::create([
            'nom_fichier' => $nomFichier,
            'user_id' => Auth::id(),
            'ip_address' => $ipAddress,
            'checksum' => $fileHash,
            'status' => 'pending'
        ]);

        // 📌 Traiter le fichier CSV
        $this->processCsvFile($filePath, $historiqueUpload->id);

        return back()->with('success', 'Fichier importé avec succès.');
    }

    // 📌 Traitement du fichier CSV et insertion dans `electeurs_temp`
    private function processCsvFile($filePath, $uploadId)
    {
        $file = fopen(storage_path("app/" . $filePath), "r");
        $header = fgetcsv($file);
        $electeursValidés = [];
    
        while ($row = fgetcsv($file)) {
            $electeursValidés[] = [
                'numero_carte_electeur' => $row[0] ?? null,        // Colonne 1 : numéro carte électeur
                'numero_cni' => $row[1] ?? null,                  // Colonne 2 : numéro CNI
                'nom_famille' => $row[2] ?? null,                 // Colonne 3 : nom famille
                'prenom' => $row[3] ?? null,                      // Colonne 4 : prénom
                'bureau_vote' => $row[4] ?? null,                 // Colonne 5 : bureau de vote
                'date_naissance' => $row[5] ?? null,              // Colonne 6 : date de naissance
                'lieu_naissance' => $row[6] ?? null,              // Colonne 7 : lieu de naissance
                'sexe' => $row[7] ?? null,                        // Colonne 8 : sexe
            ];
        }
        fclose($file);
    
        // 📌 Insertion des électeurs dans `electeurs_temp`
        if (!empty($electeursValidés)) {
            DB::table('electeurs_temp')->insertOrIgnore($electeursValidés);
        }
    
        // 📌 Exécuter la procédure stockée pour traiter les erreurs
        DB::statement("CALL ControlerElecteurs()");
    
        // 📌 Vérifier s'il y a des erreurs après exécution de la procédure
        $nbErreurs = DB::table('electeurs_erreurs')->where('tentative_upload_id', $uploadId)->count();
    
        // 📌 Mise à jour du statut de l'upload dans `historique_uploads`
        $historique = HistoriqueUpload::find($uploadId);
        $historique->status = ($nbErreurs > 0) ? 'error' : 'success';
        $historique->save();
    }
    

    public function togglePeriode($id)
{
    $periode = PeriodeParrainage::findOrFail($id);
    $periode->etat = !$periode->etat; // Inverser l'état : 0 -> 1, 1 -> 0
    $periode->save();

    return redirect()->route('dge.gestion_periode')
        ->with('success', 'La période de parrainage a été ' . ($periode->etat ? 'ouverte' : 'fermée') . ' avec succès.');
}





public function validerElecteurs()
{
    // Vérifier si des électeurs sont en attente de validation
    $electeursTemp = DB::table('electeurs_temp')->get();
    $electeursErreurs = DB::table('electeurs_erreurs')->get();

     // Vérifier s'il y a des erreurs dans les électeurs
     if ($electeursErreurs->isNotEmpty()) {
        return back()->with('error', 'Il y a des erreurs dans le fichier. Vous devez les corriger avant de valider.');
    }

    if ($electeursTemp->isEmpty()) {
        return back()->with('error', 'Aucun électeur à valider.');
    }

   

    // Appel de la procédure pour valider les électeurs
    DB::statement("CALL ValiderImportation()");

    // Retourner un message de succès
    return back()->with('success', 'Tous les électeurs valides ont été transférés.');
}



    // 📌 Finalisation de l'importation des électeurs
   /* public function validerElecteurs()
    {
        $electeursTemp = DB::table('electeurs_temp')->get();
        if ($electeursTemp->isEmpty()) {
            return back()->with('error', 'Aucun électeur à valider.');
        }
    
        // Vérifier s'il y a des erreurs
        $nbErreurs = ElecteursErreurs::count();
        if ($nbErreurs > 0) {
            return back()->with('error', 'Impossible de valider tant qu\'il y a des erreurs.');
        }
    
        // 📌 Appel de la procédure `ValiderImportation()`
        DB::statement("CALL ValiderImportation()");
    
        return back()->with('success', 'Tous les électeurs valides ont été transférés.');
    }*/
    


    public function corrigerElecteur(Request $request, $id)
{
    $electeur = ElecteursErreurs::find($id);

    if (!$electeur) {
        return back()->with('error', 'Électeur introuvable.');
    }

    // Insertion de l'électeur corrigé dans la table `electeurs_temp`
    DB::table('electeurs_temp')->insert([
        'numero_carte_electeur' => $request->numero_carte_electeur,
        'numero_cni' => $request->numero_cni,
        'nom_famille' => $request->nom_famille,
        'prenom' => $request->prenom,
        'bureau_vote' => $request->bureau_vote,
        'date_naissance' => $request->date_naissance,
        'lieu_naissance' => $request->lieu_naissance,
        'sexe' => $request->sexe,
        
    ]);
    // Supprimer les anciennes erreurs pour l'électeur avant de le traiter
DB::table('electeurs_erreurs')
->where('numero_carte_electeur', $request->numero_carte_electeur)
->orWhere('numero_cni', $request->numero_cni)
->delete();


    // 📌 Exécuter la procédure stockée pour contrôler l'électeur
    DB::statement("CALL ControlerElecteurs()");

    // Vérifier si l'électeur a été déplacé dans `electeurs_erreurs`
    $electeurEnErreur = DB::table('electeurs_erreurs')
        ->where('numero_carte_electeur', $request->numero_carte_electeur)
        ->orWhere('numero_cni', $request->numero_cni)
        ->first();

    if ($electeurEnErreur) {
        // Si l'électeur est toujours dans `electeurs_erreurs`, afficher un message d'erreur
        return back()->with('error', "L'électeur contient encore des erreurs et n'a pas été validé.");
    }

    // Suppression de l'électeur de la table `electeurs_erreurs` après validation
    $electeur->delete();

    return back()->with('success', 'Électeur corrigé et validé avec succès.');
}


public function supprimerElecteur($id)
{
    $electeur = ElecteursErreurs::find($id);

    if (!$electeur) {
        return back()->with('error', 'Électeur introuvable.');
    }

    $electeur->delete();
    return back()->with('success', 'Électeur supprimé avec succès.');
}






    // 📌 Gestion de la période de parrainage
    public function gestionPeriode()
    {
        $periode = PeriodeParrainage::orderBy('id', 'desc')->first(); // Récupérer la dernière période
        return view('dge.gestion_periode', compact('periode'));
    }
    

    public function storePeriode(Request $request)
{
    $request->validate([
        'date_debut' => 'required|date|after_or_equal:today',
        'date_fin' => 'required|date|after:date_debut',
    ]);

    $periode = PeriodeParrainage::latest()->first(); // Récupérer la dernière période

    if ($periode) {
        if ($periode->etat == 1) {
            return redirect()->route('dge.gestion_periode')
                ->with('error', 'Vous ne pouvez pas modifier une période active.');
        }
        // Mettre à jour la période existante
        $periode->date_debut = $request->date_debut;
        $periode->date_fin = $request->date_fin;
    } else {
        // Créer une nouvelle période si aucune n'existe
        $periode = new PeriodeParrainage();
        $periode->date_debut = $request->date_debut;
        $periode->date_fin = $request->date_fin;
    }

    $periode->save();

    return redirect()->route('dge.gestion_periode')->with('success', 'Période de parrainage mise à jour.');
}

    
}
