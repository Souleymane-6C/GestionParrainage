<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ElecteurErreur extends Model
{
    use HasFactory;

    protected $fillable = [
        'electeur_id',
        'erreur_type', 
        'description', 
        'tentative_upload_id',
    ];

    // Relation avec le modèle Electeur
    public function electeur()
    {
        return $this->belongsTo(Electeur::class);
    }

    // Relation avec l'historique d'upload
    public function historiqueUpload()
    {
        return $this->belongsTo(HistoriqueUpload::class, 'tentative_upload_id');
    }
}
