<?php

namespace App\Http\Controllers;

use App\Models\Planification_session;
use Illuminate\Http\Request;

class PlaningsessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = Planification_session::with(['professeur','salle', 'classe'])->get();
        return response()->json($sessions);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'heure_debut' => 'required|date_format:H:i:s',
            'heure_fin' => 'required|date_format:H:i:s',
            'etat' => 'required|string',
            'cours_id' => 'required|exists:cours,id',
            'salle_id' => 'required|exists:salles,id',
        ]);

        $planificationSession = Planification_session::create($request->all());

        return response()->json(['message' => 'Planification de session créée avec succès', 'data' => $planificationSession], 201);
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
