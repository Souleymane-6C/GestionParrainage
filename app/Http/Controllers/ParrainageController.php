<?php

namespace App\Http\Controllers;

use App\Models\Candidat;
use App\Models\Electeur;
use App\Models\Parrainage;
use Illuminate\Http\Request;

class ParrainageController extends Controller
{
    // Enregistrement d'un parrainage pour un électeur
    public function store(Request $request)
    {
        $request->validate([
            'electeur_id' => 'required|exists:electeurs,id',
            'candidat_id' => 'required|exists:candidats,id',
        ]);

        Parrainage::create([
            'electeur_id' => $request->electeur_id,
            'candidat_id' => $request->candidat_id,
            'date_parrainage' => now(),
        ]);

        return back()->with('success', 'Parrainage ajouté avec succès.');
    }

    // Affichage des parrainages d'un candidat
    public function parrainagesCandidat($candidatId)
    {
        $candidat = Candidat::findOrFail($candidatId);
        $parrainages = Parrainage::where('candidat_id', $candidatId)->get();
        return view('dge.parrainages_candidat', compact('candidat', 'parrainages'));
    }
}
