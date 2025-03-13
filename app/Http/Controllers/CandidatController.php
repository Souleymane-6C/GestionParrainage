<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Parrainage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class CandidatController extends Controller
{
    /**
     * Afficher l'accueil du candidat.
     */
    public function accueil()
    {
        return view('candidat.accueil');
    }

    /**
     * Afficher le formulaire d'inscription du candidat.
     */
    public function showForm()
    {
        return view('candidat.inscription');
    }

    /**
     * Vérifier le numéro de carte d'électeur avant inscription.
     */
    public function verifierCandidat(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string'
        ]);
        // Vider la session avant de commencer une nouvelle vérification
    Session::forget('candidat');

        // Vérifier si le candidat existe dans la base de données en utilisant 'numero_carte'
        $candidat = Candidat::where('numero_carte', $request->numero_carte)->first();

        if (!$candidat) {
            return back()->with('error', 'Le candidat considéré n’est pas présent dans le fichier électoral.');
        }

        // Enregistrer les informations du candidat dans la session
        Session::put('candidat', [
            'numero_carte' => $candidat->numero_carte,
            'nom' => $candidat->nom,
            'prenom' => $candidat->prenom,
            'date_naissance' => $candidat->date_naissance
        ]);

        return back();  // Rediriger en arrière pour afficher le formulaire suivant
    }

    /**
     * Finaliser l'inscription du candidat.
     */
    public function inscrire(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string|exists:candidats,numero_carte',
            'email' => 'required|email|unique:candidats,email',
            'telephone' => 'required|string|unique:candidats,telephone',
            'parti_politique' => 'nullable|string',
            'slogan' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
            'couleur_1' => 'nullable|string',
            'couleur_2' => 'nullable|string',
            'couleur_3' => 'nullable|string',
            'url_page' => 'nullable|url',
        ]);
    
        // Récupérer le candidat existant via son numéro de carte
        $candidat = Candidat::where('numero_carte', $request->numero_carte)->first();
    
        if (!$candidat) {
            return back()->with('error', 'Candidat introuvable.');
        }
    
        // Enregistrer la photo si elle est présente
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('candidats', 'public');
            $candidat->photo = $photoPath;
        }
    
        // Mettre à jour les informations complémentaires en ignorant les valeurs nulles
        $candidat->update([
            'email' => $request->email,
            'telephone' => $request->telephone,
            'parti_politique' => $request->parti_politique ?? $candidat->parti_politique,
            'slogan' => $request->slogan ?? $candidat->slogan,
            'couleur_1' => $request->couleur_1 ?? $candidat->couleur_1,
            'couleur_2' => $request->couleur_2 ?? $candidat->couleur_2,
            'couleur_3' => $request->couleur_3 ?? $candidat->couleur_3,
            'url_info' => $request->url_page ?? $candidat->url_info,
        ]);
    
        // Envoyer un mail de confirmation
        Mail::raw("Votre inscription est finalisée.", function ($message) use ($candidat) {
            $message->to($candidat->email)->subject("Confirmation d'inscription");
        });
    
        // Nettoyer la session après inscription
        Session::forget('candidat');
    
        // Redirection vers l'accueil du candidat
        return redirect()->route('candidat.accueil')->with('success', 'Inscription finalisée avec succès.');
    }

    /**
     * Afficher la liste des candidats.
     */
    public function liste()
    {
        $candidats = Candidat::all();
        return view('candidat.liste', compact('candidats'));
    }

    /**
     * Afficher les détails d’un candidat.
     */
    public function details($id)
    {
        $candidat = Candidat::findOrFail($id);
        return view('candidat.details', compact('candidat'));
    }

    /**
     * Générer un nouveau code d'authentification.
     */
    public function renvoyerCode($id)
    {
        $candidat = Candidat::findOrFail($id);
        $nouveauCode = rand(100000, 999999);
        $candidat->update(['code_auth' => $nouveauCode]);

        Mail::raw("Votre nouveau code d'authentification est : {$nouveauCode}", function ($message) use ($candidat) {
            $message->to($candidat->email)->subject("Nouveau code d'authentification");
        });

        return back()->with('success', 'Nouveau code envoyé avec succès.');
    }

    /**
     * Suivi des parrainages.
     */
    public function suivi()
    {
        $nombreParrainages = Parrainage::count();
        $historiqueParrainages = Parrainage::selectRaw('DATE(created_at) as date, COUNT(*) as nombre')
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->pluck('nombre', 'date');

        return view('candidat.suivi', compact('nombreParrainages', 'historiqueParrainages'));
    }
}