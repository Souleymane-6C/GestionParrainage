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
     // 📌 Ajoute cette méthode dans la classe pour qu'elle soit reconnue
     private function getUserIp() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ipList = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($ipList[0]); // Prend la première IP de la liste
        }

        return $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'; // Valeur par défaut si aucune IP n'est trouvée
    }



    // Affichage du dashboard
    public function dashboard()
    {
        $parrainages = Parrainage::all();
        return view('dge.dashboard', compact('parrainages'));
    }
    public function ajoutCandidat()
{
    $candidats = Candidat::orderBy('nom', 'asc')->get(); // Trier les candidats par ordre alphabétique
    return view('dge.ajout_candidat', compact('candidats'));
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
    
        // 📌 Récupérer l'adresse IP avec la fonction universelle
        $ipAddress = $this->getUserIp();
        
        // 📌 Récupérer l'utilisateur connecté
        $userId = Auth::id() ?? null; 
    
        // 📌 Enregistrer le fichier et traiter son contenu
        $filePath = $file->storeAs('uploads', 'electeurs.csv');
    
        // 📌 Ajouter l'historique de l'upload
        $historiqueUpload = HistoriqueUpload::create([
            'nom_fichier' => 'electeurs.csv',
            'user_id' => $userId,
            'ip_address' => $ipAddress,
            'checksum' => $fileHash,
            'file_hash' => $fileHash, // Ajout de file_hash
            'status' => 'success'
        ]);
    
        // 📌 Traitement du fichier CSV
        $this->processCsvFile($filePath, $historiqueUpload->id);
    
        return back()->with('success', 'Fichier importé avec succès.');
    }
    
    


    private function processCsvFile($filePath, $uploadId)
    {
        $file = fopen(storage_path("app/" . $filePath), "r");
        $header = fgetcsv($file);
        $errors = [];
        $electeursValides = [];
    
        while ($row = fgetcsv($file)) {
            $data = [
                'numero_carte_electeur' => $row[0] ?? 'Non renseigné',
                'numero_cin' => $row[1] ?? 'Non renseigné',
                'nom_famille' => $row[2] ?? 'Non renseigné',
                'prenom' => $row[3] ?? 'Non renseigné',
                'date_naissance' => $row[4] ?? 'Non renseigné',
                'lieu_naissance' => $row[5] ?? 'Non renseigné',
                'sexe' => $row[6] ?? 'Non renseigné',
            ];
    
            if (in_array('Non renseigné', $data)) {
                $errors[] = array_merge($data, [
                    'nature_erreur' => 'Données incomplètes',
                    'description_erreur' => 'Un ou plusieurs champs sont vides.',
                    'tentative_upload_id' => $uploadId
                ]);
            } else {
                $electeursValides[] = $data;
            }
        }
        fclose($file);
    
        // Enregistrement des erreurs
        if (!empty($errors)) {
            ElecteursErreurs::insert($errors);
        }
    
        // Enregistrement des électeurs valides
        if (!empty($electeursValides)) {
            DB::table('electeurs_temp')->insertOrIgnore($electeursValides);
        }
    
        // Mise à jour du statut de l'historique
        $historique = HistoriqueUpload::find($uploadId);
        $historique->status = empty($errors) ? 'success' : 'error';
        $historique->error_message = empty($errors) ? null : 'Des erreurs ont été détectées';
        $historique->save();
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
// Affichage du formulaire d'ajout d'un candidat + liste des candidats


// Enregistrement d'un candidat
public function storeCandidat(Request $request)
{
    $request->validate([
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'numero_carte' => 'required|string|unique:candidats,numero_carte|max:20',
        'date_naissance' => 'required|date|before:today',
    ]);

    try {
        Candidat::create([
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'numero_carte' => $request->numero_carte,
            'date_naissance' => $request->date_naissance,
        ]);

        return redirect()->route('dge.ajout_candidat')->with('success', 'Candidat ajouté avec succès.');
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'ajout.');
    }
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
        $electeursErreurs = ElecteursErreurs::all();
        return view('dge.electeurs_erreurs', compact('electeursErreurs'));

    }
    
public function historiqueUpload()
{
    $historiqueUploads = HistoriqueUpload::with('electeursErreurs')->get();
    return view('dge.historique_upload', compact('historiqueUploads'));
}


public function validerElecteurs()
{
    // Vérifier si des électeurs sont en attente
    $electeursTemp = DB::table('electeurs_temp')->get();

    if ($electeursTemp->isEmpty()) {
        return back()->with('error', 'Aucun électeur à valider.');
    }

    // Insérer dans la table persistante `electeurs_valides`
    DB::table('electeurs_valides')->insert(
        $electeursTemp->map(function ($electeur) {
            return (array) $electeur;
        })->toArray()
    );

    // Supprimer les électeurs de la table temporaire
    DB::table('electeurs_temp')->delete();

    return back()->with('success', 'Tous les électeurs ont été validés et stockés définitivement.');
}
}


