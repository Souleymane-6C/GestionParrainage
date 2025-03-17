<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodeSecurite extends Model
{
    use HasFactory;

    protected $table = 'codes_securite';

    protected $fillable = [
        'candidat_id',
        'code',
        'newcode',
        'envoye_a',
        'expiration',
    ];

    protected $casts = [
        'expiration' => 'datetime',
        'envoye_a' => 'string',
    ];

    public function candidat()
    {
        return $this->belongsTo(Candidat::class, 'candidat_id');
    }
}
