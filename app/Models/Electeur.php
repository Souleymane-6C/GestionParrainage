<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Electeur extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $guard = 'electeur';

    protected $fillable = [
        'numero_carte_electeur',
        'numero_cni',
        'nom_famille',
        'bureau_vote',
        'telephone',
        'email',
        'password',
        'code_authentification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'code_authentification',
    ];
}
