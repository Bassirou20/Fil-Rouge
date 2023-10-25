<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InscrireEtudiant extends Model
{
    use HasFactory;

    public function classeAnnee()
    {
        return $this->belongsTo(ClasseAnnee::class, 'classeannee_id');
    }

    public function etudiant()
    {
        return $this->belongsTo(Etudiant::class, 'etudiant_id');
    }

    protected $table = 'inscrire_etudiants';

    protected $fillable = [
        'classeannee_id',
        'etudiant_id',
    ];
}
