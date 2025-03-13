<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use App\Models\ElecteurTemp;

class ElecteurController extends Controller
{
    /**
     * Affiche le formulaire d'inscription d'un électeur.
     */
    public function create()
    {
        return view('electeur.inscription');
    }

    /**
     * Enregistre un nouvel électeur après validation des données.
     */
    public function store(Request $request)
{
    $request->validate([
        'numero_carte_electeur' => 'required|string|unique:electeurs,numero_carte_electeur',
        'numero_cni' => 'required|string|unique:electeurs,numero_cni',
        'nom_famille' => 'required|string',
        'bureau_vote' => 'required|string',
        'telephone' => 'required|string|unique:electeurs,telephone',
        'email' => 'required|email|unique:electeurs,email',
        'password' => 'required|string|min:6|confirmed',
    ]);

    // Générer un code d'authentification aléatoire
    $code_auth = rand(10000, 99999);

    // Enregistrer l'électeur
    $electeur = Electeur::create([
        'numero_carte_electeur' => $request->numero_carte_electeur,
        'numero_cni' => $request->numero_cni,
        'nom_famille' => $request->nom_famille,
        'bureau_vote' => $request->bureau_vote,
        'telephone' => $request->telephone,
        'email' => $request->email,
        'password' => bcrypt($request->password), // Hash du mot de passe
        'code_authentification' => $code_auth,
    ]);

    return redirect()->route('electeur.login')->with('success', 'Inscription réussie ! Veuillez vous connecter.');
}
    /**
     * Affiche le formulaire de connexion.
     */
    public function showLogin()
    {
        return view('electeur.login');
    }

    /**
     * Authentifie l'électeur avec son numéro de carte et son mot de passe.
     */
    public function authenticate(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string',
            'password' => 'required|string',
            'code_auth' => 'required|string'
        ]);

        $electeur = Electeur::where('numero_carte', $request->numero_carte)->first();

        if (!$electeur || !Hash::check($request->password, $electeur->password) || $electeur->code_auth !== $request->code_auth) {
            throw ValidationException::withMessages([
                'numero_carte' => ['Les informations sont incorrectes.'],
            ]);
        }

        Auth::login($electeur);

        return redirect()->route('electeur.dashboard')->with('success', 'Connexion réussie !');
    }

    /**
     * Affiche le tableau de bord de l'électeur.
     */
    public function dashboard()
    {
        return view('electeur.dashboard');
    }

    /**
     * Déconnecte l'électeur et le redirige vers la page d'accueil.
     */
    public function logout()
    {
        Auth::logout();
        return redirect()->route('home')->with('success', 'Déconnexion réussie.');
    }

    public function importElecteurs(Request $request)
    {
        $file = $request->file('file');
    
        if (!$file->isValid()) {
            return response()->json(['message' => 'Fichier invalide'], 400);
        }
    
        $handle = fopen($file->getRealPath(), 'r');
        $header = fgetcsv($handle);
    
        while ($row = fgetcsv($handle)) {
            $data = [
                'numero_carte_electeur' => $row[0] ?? null,
                'numero_cin' => $row[1] ?? null,
                'nom_famille' => $row[2] ?? null,
                'bureau_vote' => $row[3] ?? null,
                'telephone' => $row[4] ?? null,
                'email' => $row[5] ?? null,
            ];
    
            // Vérification si l'email et le téléphone existent déjà
            if (
                ElecteurTemp::where('telephone', $data['telephone'])->exists() ||
                ElecteurTemp::where('email', $data['email'])->exists()
            ) {
                return response()->json(['message' => 'Téléphone ou email déjà utilisé par un autre électeur.'], 400);
            }
    
            ElecteurTemp::create($data);
        }
    
        fclose($handle);
    
        return response()->json(['message' => 'Importation réussie et en attente de validation'], 201);
    }

    
}
