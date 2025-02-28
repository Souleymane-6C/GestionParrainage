<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Candidat extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom',
        'prenom',
        'parti_politique',
    ];

    // Définir la relation entre Candidat et Parrainage
    public function parrainages()
    {
        return $this->hasMany(Parrainage::class);
    }
}
