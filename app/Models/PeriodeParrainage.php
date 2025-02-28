<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class PeriodeParrainage extends Model
{
    use HasFactory;

    protected $fillable = [
        'date_debut', 
        'date_fin',
    ];

    // Définir une méthode pour vérifier si la période est valide (avant de commencer ou après la fin)
    public function isActive()
    {
        $currentDate = Carbon::now(); // Utilisation de Carbon pour la date actuelle
        return $currentDate->between($this->date_debut, $this->date_fin);
    }
}
