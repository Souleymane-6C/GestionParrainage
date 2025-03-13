<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElecteurTemp extends Model
{
    use HasFactory;

    protected $table = 'electeurs_temp';

    protected $fillable = [
        'numero_carte_electeur',
        'numero_cin',
        'nom_famille',
        'bureau_vote',
        'telephone',
        'email',
    ];
}

