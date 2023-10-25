<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;


    public function isOccupied($date, $heureDebut, $heureFin)
    {
        // Votre logique pour vérifier si la salle est occupée à ce moment-là
        // Par exemple, vous pouvez interroger la base de données pour voir s'il y a des sessions existantes qui chevauchent ce moment.

        $sessions = Session::where('salle_id', $this->id)
            ->where('date', $date)
            ->where(function ($query) use ($heureDebut, $heureFin) {
                $query->where(function ($q) use ($heureDebut, $heureFin) {
                    $q->where('heure_debut', '<', $heureFin)
                        ->where('heure_fin', '>', $heureDebut);
                });
            })
            ->count();

        return $sessions > 0;
    }

    public function isReservedForDuration($date, $heureDebut, $heureFin)
{
    // Vérifie si la salle est déjà réservée pour une durée similaire à la nouvelle session
    $existingSessions = $this->sessions()->where('date', $date)
        ->where(function ($query) use ($heureDebut, $heureFin) {
            $query->where(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureDebut)
                    ->where('heure_fin', '>', $heureDebut);
            })->orWhere(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '<', $heureFin)
                    ->where('heure_fin', '>', $heureFin);
            })->orWhere(function ($q) use ($heureDebut, $heureFin) {
                $q->where('heure_debut', '>=', $heureDebut)
                    ->where('heure_fin', '<=', $heureFin);
            });
        })
        ->count();

    return $existingSessions > 0;
}

// public function occupy($date, $heureDebut, $heureFin)
// {
//     // Marque la salle comme occupée pour la nouvelle session
//     $this->sessions()->create([
//         'date' => $date,
//         'heure_debut' => $heureDebut,
//         'heure_fin' => $heureFin,
//         'cour' => $heureFin,
//         'etat' => 'annulé',
//     ]);
// }

public function sessions()
{
    return $this->hasMany(Session::class);
}
}
