<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeSecurite extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidat_id',
        'code',
        'envoye_a',
        'expiration',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class);
    }
}
