<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Electeur;
use App\Models\ElecteurValide;
use App\Models\Parrainage;
use App\Models\CodeSecurite;
use Illuminate\Support\Facades\Mail;
use App\Mail\CodeSecuriteMail;
use Twilio\Rest\Client;
use App\Models\PeriodeParrainage;
use App\Mail\CodeAuthentificationMail;
use Illuminate\Support\Facades\Log;


class ElecteurController extends Controller
{
    /**
     * Affichage du formulaire d'inscription des électeurs (parrains)
     */
    public function showRegisterForm()
    {
        return view('electeur.inscription');
    }

    public function showLoginForm()
    {
        return view('electeur.login');
    }
    
    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('electeur.accueil')->with('success', 'Déconnexion réussie.');
    }
    
    public function accueil()
    {
        return view('electeur.accueil');
    }




    public function verifier(Request $request)
    {
        // Validation des informations de l'électeur
        $request->validate([
            'numero_carte_electeur' => 'required|string|exists:electeurs_valides,numero_carte_electeur',
            'numero_cni' => 'required|string|exists:electeurs_valides,numero_cni',
            'nom_famille' => 'required|string|exists:electeurs_valides,nom_famille',
            'bureau_vote' => 'required|string|exists:electeurs_valides,bureau_vote',
        ]);
    
        // Vérification de l'existence de l'électeur dans la table des électeurs valides
        $electeurValide = ElecteurValide::where([
            ['numero_carte_electeur', $request->numero_carte_electeur],
            ['numero_cni', $request->numero_cni],
            ['nom_famille', $request->nom_famille],
            ['bureau_vote', $request->bureau_vote],
        ])->first();
    
        if (!$electeurValide) {
            return back()->with('error', 'Les informations fournies sont incorrectes.');
        }
    
        // Sauvegarder les données dans la session pour les pré-remplir dans le formulaire d'inscription
        session([
            'numero_carte_electeur' => $request->numero_carte_electeur,
            'numero_cni' => $request->numero_cni,
            'nom_famille' => $request->nom_famille,
            'bureau_vote' => $request->bureau_vote,
        ]);
    
        // Afficher le formulaire d'inscription
        return back()->with('verifier', true)
                     ->with('success', 'Vérification réussie ! Veuillez maintenant compléter votre inscription.');
    }
    






    /**
     * Vérification des informations et inscription du parrain (électeur)
     */
    public function register(Request $request)
    {
        // Validation des informations d'inscription
        $request->validate([
            'numero_carte_electeur' => 'required|string|exists:electeurs_valides,numero_carte_electeur',
            'numero_cni' => 'required|string|exists:electeurs_valides,numero_cni',
            'nom_famille' => 'required|string|exists:electeurs_valides,nom_famille',
            'bureau_vote' => 'required|string|exists:electeurs_valides,bureau_vote',
            'telephone' => 'required|string|unique:electeurs,telephone',
            'email' => 'required|email|unique:electeurs,email',
        ]);
    
        // Vérification si l'électeur existe déjà
        $electeurExist = Electeur::where('numero_carte_electeur', $request->numero_carte_electeur)
            ->orWhere('numero_cni', $request->numero_cni)
            ->orWhere('email', $request->email)
            ->exists();
    
        if ($electeurExist) {
            return back()->with('error', 'Cet électeur est déjà enregistré avec le même numéro de carte ou email.')->withInput();
        }
    
        // Enregistrement de l'électeur dans la table `electeurs`
        $electeur = Electeur::create([
            'numero_carte_electeur' => $request->numero_carte_electeur,
            'numero_cni' => $request->numero_cni,
            'nom_famille' => $request->nom_famille,
            'bureau_vote' => $request->bureau_vote,
            'telephone' => $request->telephone,
            'email' => $request->email,
        ]);
    
        // Génération du code d'authentification
        $code = rand(100000, 999999);
        $electeur->update(['code_authentification' => $code]);
    
        // Envoi du code d'authentification par email et SMS
        Mail::to($electeur->email)->send(new CodeSecuriteMail($code));
        $this->sendSms($electeur->telephone, "Votre code d'authentification est : $code");
    
        // Retourner une réponse JSON ou rediriger vers la page de vérification
        return redirect()->route('electeur.verification', $electeur->id)
                         ->with('success', 'Inscription réussie ! Vérifiez votre email et votre SMS pour obtenir votre code d’authentification.');
    }
    
    



   


    public function validerCodeElecteur(Request $request, $id)
{
    $request->validate([
        'code' => 'required|string|size:6',
    ]);

    $electeur = Electeur::findOrFail($id);

    if ($electeur->code_authentification !== $request->code) {
        return back()->with('error', 'Code incorrect ou expiré.');
    }

    session(['electeur_id' => $electeur->id]);

    return redirect()->route('electeur.dashboard')->with('success', 'Connexion réussie.');
}






    /**
     * Vérification et connexion de l'électeur avec son code d'authentification
     */
    public function login(Request $request)
    {
        // Validation des données fournies par l'utilisateur
        $request->validate([
            'numero_carte_electeur' => 'required|string|exists:electeurs,numero_carte_electeur',
            'code_authentification' => 'required|string',
        ]);
    
        // Recherche de l'électeur dans la base de données en fonction du numéro de carte et du code d'authentification
        $electeur = Electeur::where([
            ['numero_carte_electeur', $request->numero_carte_electeur],
            ['code_authentification', $request->code_authentification],
        ])->first();
    
        // Si l'électeur n'est pas trouvé, retourner une erreur
        if (!$electeur) {
            return back()->with('error', 'Code incorrect ou électeur non trouvé.');
        }
    
        // Si l'électeur est trouvé, on enregistre son ID dans la session pour le connecter
        session(['electeur_id' => $electeur->id]);
    
        // Rediriger vers le dashboard de l'électeur avec un message de succès
        return redirect()->route('electeur.dashboard')->with('success', 'Connexion réussie.');
    }
    
    /**
     * Dashboard de l'électeur après connexion
     */
    public function dashboard()
    {
        $electeur = Electeur::findOrFail(session('electeur_id'));
       
        return view('electeur.dashboard', compact('electeur'));
    }


    public function showVerificationPage($id)
{
    $electeur = Electeur::findOrFail($id);
    return view('electeur.verification_code', compact('electeur'));
}

    /**
     * Fonction pour envoyer un SMS via Twilio
     */
    private function sendSms($telephone, $message)
    {
        try {
            $sid = env('AC0239e45fa76d7ce36f061bc31e234ea0');
            $token = env('398d1dcd5b59ffee4f334508c44002b9');
            $twilioNumber = env('778504096');

            $client = new Client($sid, $token);
            $client->messages->create(
                $telephone,
                [
                    'from' => $twilioNumber,
                    'body' => $message
                ]
            );
        } catch (\Exception $e) {
            Log::error("Erreur lors de l'envoi du SMS : " . $e->getMessage());
        }
    }
}
