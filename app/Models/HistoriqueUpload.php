<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoriqueUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'utilisateur', 
        'ip', 
        'checksum', 
        'date_upload', 
        'status',
    ];
    public function user()
{
    return $this->belongsTo(User::class, 'user_id');
}
// ✅ Définition de la relation avec `ElecteursErreurs`
public function electeursErreurs()
{
    return $this->hasMany(ElecteursErreurs::class, 'tentative_upload_id');
}
}
