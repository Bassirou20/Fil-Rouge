<?php

namespace App\Http\Controllers;

use App\Models\Classe;
use App\Models\Etudiant;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportStudents;
use App\Models\Classe_annee_scolaire;
use App\Models\AnneeScolaire;

class InscrireEtudiantController extends Controller
{
    public function importStudents(Request $request)
    {
        $file = $request->file('file');
        if ($file === null) {
            response()->json(['message' => 'gfdydyddydy']);
        }


        $import = new ImportStudents();
        Excel::import($import, $file);
        return response()->json(['données renvoyés']);
    }
}
