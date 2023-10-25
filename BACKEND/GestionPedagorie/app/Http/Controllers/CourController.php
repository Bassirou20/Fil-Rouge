<?php

namespace App\Http\Controllers;

use App\Http\Resources\CoursResource;
use App\Models\Cour;
use Illuminate\Http\Request;

class CourController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cours = Cour::all();

        return CoursResource::collection($cours);
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {

    //         // Validez et traitez les données du formulaire ici, par exemple, avec $request->validate(...)

    //         $cours = Cour::create([
    //             'professeur_id' => $request->input('professeur_id'),
    //             'classe_id' => $request->input('classe_id'),
    //             'semestre_id' => $request->input('semestre_id'),
    //             'module_id' => $request->input('module_id'),
    //             'quota_horaire' => $request->input('quota_horaire'),
    //         ]);

    //         return new CoursResource($cours);
    // }

    public function store(Request $request)
    {
        // Validez et traitez les données du formulaire ici, par exemple, avec $request->validate(...)

        // Vérifiez si un cours similaire existe déjà
        $coursExistant = Cour::where([
            'professeur_id' => $request->input('professeur_id'),
            'module_id' => $request->input('module_id')
            
        ])->first();

        if ($coursExistant) {
            return response()->json(['message' => 'Ce cours existe déjà.'], 400);
        }

        $cours = Cour::create([
            'professeur_id' => $request->input('professeur_id'),
            'classe_id' => $request->input('classe_id'),
            'semestre_id' => $request->input('semestre_id'),
            'module_id' => $request->input('module_id'),
            'quota_horaire' => $request->input('quota_horaire'),
        ]);

        return new CoursResource($cours);
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
