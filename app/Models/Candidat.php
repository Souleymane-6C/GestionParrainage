<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_carte',
        'nom',
        'prenom',
        'date_naissance',
        'email',
        'telephone',
        'parti_politique',
        'slogan',
        'photo',
        'couleur_1',
        'couleur_2',
        'couleur_3',
        'url_info',
    ];

    // Relation avec les codes de sécurité
    public function codesSecurite()
    {
        return $this->hasMany(CodeSecurite::class);
    }
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class, 'candidat_id');
    }
}
