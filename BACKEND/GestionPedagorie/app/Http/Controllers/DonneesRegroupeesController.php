<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classe ;
use App\Models\Cour;
use App\Models\Module ;
use App\Models\Professeur ;
use App\Models\Salle;
use App\Models\Semestre ;

class DonneesRegroupeesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $donneesRegroupees = [
            'professeurs' =>Professeur::all(),
            'classes' => Classe::all(),
            'salles' => Salle::all(),
            'modules' => Module::all(),
            'semestres' => Semestre::all(),
            'cours' => Cour::all(),
        ];

        return response()->json($donneesRegroupees);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
