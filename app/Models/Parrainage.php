<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parrainage extends Model
{
    use HasFactory;

    protected $fillable = [
        'electeur_id', 
        'candidat_id', 
        'date_parrainage',
    ];

    // Relation avec le modèle Electeur
    public function electeur()
    {
        return $this->belongsTo(Electeur::class);
    }

    // Relation avec le modèle Candidat
    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}
