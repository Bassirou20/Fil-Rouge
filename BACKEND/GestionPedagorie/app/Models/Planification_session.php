<?php

namespace App\Models;

use App\Models\Salle;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Planification_session extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'date',
        'heure_debut',
        'heure_fin',
        'etat',
        'planification_cours_id',
        'salle_id',
    ];

    // Vous pouvez également définir des relations avec d'autres modèles ici, par exemple :

    // Relation avec le modèle PlanificationCours
    public function planificationCours()
    {
        return $this->belongsTo(PlanificationCours::class, 'planification_cours_id');
    }
    public function professeur()
    {
        return $this->belongsTo(Professeur::class, 'professeur_id');
    }

    public function cours()
    {
        return $this->belongsTo(Cours::class, 'planification_cour_id');
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'classes_id');
    }
    // Relation avec le modèle Salle
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }
}
