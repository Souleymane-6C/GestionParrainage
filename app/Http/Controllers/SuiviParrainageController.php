<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Candidat;
use App\Models\Parrainage;
use Illuminate\Support\Facades\Validator;

class SuiviParrainageController extends Controller
{
    // Authentifier un candidat pour accéder à son suivi
    public function authentifier(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:candidats,email',
            'code_auth' => 'required|string|size:6',
        ]);

        $candidat = Candidat::where('email', $request->email)
                            ->where('code_auth', $request->code_auth)
                            ->first();

        if (!$candidat) {
            return response()->json(['message' => 'Code ou email incorrect !'], 401);
        }

        return response()->json(['message' => 'Authentification réussie', 'candidat_id' => $candidat->id]);
    }

    // Voir l'évolution des parrainages du candidat
    public function index($id)
    {
        $candidat = Candidat::findOrFail($id);
        $parrainages = Parrainage::where('candidat_id', $id)
                                ->selectRaw('DATE(created_at) as date, COUNT(*) as nombre')
                                ->groupBy('date')
                                ->orderBy('date', 'DESC')
                                ->get();

        return view('candidats.suivi', compact('candidat', 'parrainages'));
    }
}
