<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etudiant extends Model
{
    use HasFactory;

    protected $table = 'etudiants';

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'genre',
        'CNI',
    ];

    public function inscriptions()
    {
        return $this->hasMany(InscrireEtudiant::class, 'etudiant_id');
    }
}
