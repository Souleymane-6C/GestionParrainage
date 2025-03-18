<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElecteurValide extends Model
{
    use HasFactory;

    protected $table = 'electeurs_valides';

    protected $fillable = [
        'numero_carte_electeur',
        'numero_cni',
        'nom_famille',
        'prenom',
        'bureau_vote',
        'date_naissance',
        'lieu_naissance',
        'sexe',
    ];

    protected $casts = [
        'date_naissance' => 'date',
        'sexe' => 'string',
    ];
}
