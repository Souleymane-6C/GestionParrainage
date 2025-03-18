<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Parrainage;
use App\Models\Candidat;
use App\Models\Electeur;
use App\Models\SuiviParrainage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ParrainageController extends Controller
{
    /**
     * Affiche la liste des candidats pour permettre à l'électeur de faire son choix.
     */
    public function choisirCandidat()
    {
        $candidats = Candidat::all();
        return view('electeur.parrainage', compact('candidats'));
    }

    /**
     * Enregistre le parrainage après validation.
     */
    public function enregistrerParrainage(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string|exists:electeurs_valides,numero_carte_electeur',
            'numero_cni' => 'required|string|exists:electeurs_valides,numero_cni',
            'code_auth' => 'required|string',
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        // Vérifier que l'électeur existe et que son code d'authentification est valide
        $electeur = Electeur::where('numero_carte_electeur', $request->numero_carte)
                            ->where('numero_cni', $request->numero_cni)
                            ->first();

        if (!$electeur || $electeur->code_authentification !== $request->code_auth) {
            return back()->withErrors(['code_auth' => 'Code d’authentification incorrect.']);
        }

        // Vérifier que l'électeur n'a pas déjà parrainé
        if (Parrainage::where('electeur_id', $electeur->id)->exists()) {
            return back()->withErrors(['numero_carte' => 'Vous avez déjà parrainé un candidat.']);
        }

        // Générer un code de validation unique pour confirmer le parrainage
        $code_validation = rand(10000, 99999);

        // Enregistrer le parrainage
        $parrainage = Parrainage::create([
            'electeur_id' => $electeur->id,
            'candidat_id' => $request->candidat_id,
            'code_validation' => $code_validation,
            'valide' => false,
        ]);

        // 📌 Incrémenter le nombre de parrainages du candidat dans SuiviParrainage
        SuiviParrainage::updateOrCreate(
            [
                'candidat_id' => $request->candidat_id,
                'date_suivi' => Carbon::today()->toDateString(), // Date du jour
            ],
            [
                'nombre_parrainages' => DB::raw('nombre_parrainages + 1') // Incrémentation
            ]
        );

        // 📌 Envoyer le code de validation par mail
        Mail::raw("Votre code de validation est : $code_validation", function ($message) use ($electeur) {
            $message->to($electeur->email)->subject('Code de validation du parrainage');
        });

        return redirect()->route('parrainage.valider')->with('success', 'Parrainage enregistré ! Un code de validation vous a été envoyé.');
    }

    /**
     * Affiche le formulaire de validation du parrainage.
     */
    public function showValidation()
    {
        return view('electeur.validation');
    }

    /**
     * Valide définitivement le parrainage.
     */
    public function validerParrainage(Request $request)
    {
        $request->validate([
            'numero_carte' => 'required|string|exists:electeurs_valides,numero_carte_electeur',
            'code_validation' => 'required|string',
        ]);

        // Vérifier si un parrainage avec ce code existe
        $parrainage = Parrainage::whereHas('electeur', function ($query) use ($request) {
            $query->where('numero_carte_electeur', $request->numero_carte);
        })->where('code_validation', $request->code_validation)
          ->first();

        if (!$parrainage) {
            return back()->withErrors(['code_validation' => 'Code de validation incorrect.']);
        }

        // Marquer le parrainage comme valide
        $parrainage->update(['valide' => true]);

        return redirect()->route('electeur.dashboard')->with('success', 'Votre parrainage a été validé avec succès !');
    }
}
