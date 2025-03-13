<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuiviParrainage extends Model
{
    use HasFactory;

    protected $fillable = ['candidat_id', 'date_suivi', 'nombre_parrainages'];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}
