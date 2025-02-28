<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Electeur extends Model
{
    use HasFactory;

    // Définir les propriétés fillables pour éviter les attaques de type mass-assignment
    protected $fillable = [
        'numero_cin', 
        'numero_electeur', 
        'nom', 
        'prenom', 
        'date_naissance', 
        'lieu_naissance', 
        'sexe', 
        'email', 
        'adresse', 
        'status',  // Statut pour savoir si l'électeur est valide ou non
    ];

    // Définir la relation entre Electeur et Parrainage
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class);
    }
}
