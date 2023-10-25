<?php

namespace App\Imports;

use App\Models\Classe;
use App\Models\Etudiant;
use App\Models\AnneeScolaire;
use App\Models\Classe_annee_scolaire;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class ImportStudents implements ToModel
{
    public $data = [];

    public function model(array $row)
    {
        $this->data[] = $row;

        return new Etudiant([
            'nom' => $row[0],
            'prenom' => $row[1],
            'email' => $row[2],
            'password' => bcrypt($row[3]),
            'genre' => $row[4],
            'CNI' => $row[5],
            'classe' => $row[6],
        ]);
        $classeName = $row[6];

            $classe = Classe::where('libelle', $classeName)->first();

            if (!$classe) {
            } else {
                $etudiant = new Etudiant([
                    'nom' => $row[0],
                    'prenom' => $row[1],
                    'email' => $row[2],
                    'password' => bcrypt($row[3]),
                    'genre' => $row[4],
                    'CNI' => $row[5],
                ]);

                $etudiant->save();


                $anneeScolaireName = $row['annee_scolaire'];

                $anneeScolaire = AnneeScolaire::where('libelle', $anneeScolaireName)->first();

                if ($anneeScolaire) {
                    $association = new Classe_annee_scolaire([
                        'classe_id' => $classe->id,
                        'annee_scolaire_id' => $anneeScolaire->id,
                    ]);

                    $association->save();
                }
            }
    }

    // public function rules(): array
    // {
    //     return [
    //         '0' => 'required',
    //         '1' => 'required',
    //         '2' => 'required|email|unique:etudiants,email',
    //         '3' => 'required',
    //         '4' => 'required|in:masculin,feminin',
    //         '5' => 'required|numeric|unique:etudiants,CNI',
    //         '6' => 'required',
    //     ];
    // }
}
