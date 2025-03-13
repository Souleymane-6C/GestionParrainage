<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parrain extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_carte',
        'numero_cni',
        'nom',
        'bureau_de_vote',
        'email',
        'telephone',
        'code_authentification',
        'code_verification',
    ];

    public function parrainage()
    {
        return $this->hasOne(Parrainage::class);
    }
}
