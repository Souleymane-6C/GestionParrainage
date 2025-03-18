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

    /**
     * Vérification des informations et inscription du parrain (électeur)
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'numero_carte_electeur' => 'required|string|exists:electeurs_valides,numero_carte_electeur|unique:electeurs,numero_carte_electeur',
                'numero_cni' => 'required|string|exists:electeurs_valides,numero_cni|unique:electeurs,numero_cni',
                'nom_famille' => 'required|string|exists:electeurs_valides,nom_famille',
                'bureau_vote' => 'required|string|exists:electeurs_valides,bureau_vote',
                'telephone' => 'required|string|unique:electeurs,telephone',
                'email' => 'required|email|unique:electeurs,email',
            ]);
    
            // Vérifier si la période de parrainage est active
            $periode = PeriodeParrainage::latest()->first();
            if (!$periode || now()->greaterThanOrEqualTo($periode->date_fin)) {
                return response()->json(['error' => 'La période de parrainage est terminée.'], 400);
            }
    
            // Vérification de l'existence de l'électeur dans les électeurs valides
            $electeurValide = ElecteurValide::where([
                ['numero_carte_electeur', $request->numero_carte_electeur],
                ['numero_cni', $request->numero_cni],
                ['nom_famille', $request->nom_famille],
                ['bureau_vote', $request->bureau_vote],
            ])->first();
    
            if (!$electeurValide) {
                return response()->json(['error' => 'Les informations fournies sont incorrectes.'], 400);
            }
    
            // Enregistrement de l'électeur dans la table electeurs
            $electeur = Electeur::create([
                'numero_carte_electeur' => $request->numero_carte_electeur,
                'numero_cni' => $request->numero_cni,
                'nom_famille' => $request->nom_famille,
                'bureau_vote' => $request->bureau_vote,
                'telephone' => $request->telephone,
                'email' => $request->email,
            ]);
    
            // Génération et envoi du code d'authentification
            $code = rand(100000, 999999);
            $electeur->update(['code_authentification' => $code]);
    
            // Envoi par mail
            Mail::to($electeur->email)->send(new CodeSecuriteMail($code));
    
            // Envoi par SMS
            $this->sendSms($electeur->telephone, "Votre code d'authentification est : $code");
    
            // Retourner une réponse JSON
            return response()->json([
                'success' => 'Inscription réussie ! Vérifiez votre email et SMS pour votre code d’authentification.',
                'redirect' => route('electeur.verification', $electeur->id)
            ], 200);
    
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue. ' . $e->getMessage()], 500);
        }
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
        $request->validate([
            'numero_carte_electeur' => 'required|string|exists:electeurs,numero_carte_electeur',
            'code_authentification' => 'required|string',
        ]);

        $electeur = Electeur::where([
            ['numero_carte_electeur', $request->numero_carte_electeur],
            ['code_authentification', $request->code_authentification],
        ])->first();

        if (!$electeur) {
            return back()->with('error', 'Code incorrect ou électeur non trouvé.');
        }

        session(['electeur_id' => $electeur->id]);
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
