<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cour extends Model
{
    use HasFactory;


    protected $fillable = [
        'professeur_id',
        'classe_id',
        'semestre_id',
        'module_id',
        'quota_horaire',
    ];

    public function professeur()
    {
        return $this->belongsTo(Professeur::class);
    }

    public function classe()
    {
        return $this->belongsTo(Classe::class);
    }

    public function semestre()
    {
        return $this->belongsTo(Semestre::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

}
