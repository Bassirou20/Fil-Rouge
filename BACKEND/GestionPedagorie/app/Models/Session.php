<?php

namespace App\Models;

use App\Models\Cour;
use App\Models\Salle;
use App\Models\Classe;
use App\Models\Professeur;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Session extends Model
{
    use HasFactory;

    protected $fillable=['date','heure_debut','heure_fin','cour_id','salle_id'];


    public function cours()
    {
        return $this->belongsTo(Cour::class,"cour_id");
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }
    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }
}
