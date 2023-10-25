<?php

namespace App\Models;


use App\Models\DemandeAnnulation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Professeur extends Model
{
    use HasFactory;
    use HasApiTokens;


    protected $guard = 'professeur';

    public function demandesAnnulation()
    {
        return $this->hasMany(DemandeAnnulation::class, 'professeur_id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
}
