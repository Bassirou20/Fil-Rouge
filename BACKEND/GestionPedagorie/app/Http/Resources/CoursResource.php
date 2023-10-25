<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CoursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray( $request)
    {
        return [
            'id' => $this->id,
            'professeur' => $this->professeur->nom_Complet,
            'classe' => $this->classe->libelle,
            'semestre' => $this->semestre->libelle,
            'module' => $this->module->libelle,
            'quota_horaire' => $this->quota_horaire,
            // Ajoutez d'autres données selon vos besoins
        ];
    }
}
