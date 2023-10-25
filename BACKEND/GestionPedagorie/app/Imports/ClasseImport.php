<?php

namespace App\Imports;

use App\Models\Classe;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ClasseImport implements ToModel
{
    /**
    * @param Collection $collection
    */
    public function model(array $row)
    {
        return new Classe([
            'libelle' => $row[0],
            'filliere_id' => $row[1],
            'niveau_id' => $row[2],
            'effectif' => $row[3],
            // Autres colonnes si nécessaire
        ]);
    }
}
