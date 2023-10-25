<?php

namespace App\Http\Controllers;

use App\Models\Session;
use App\Models\Professeur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfesseurController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::guard('professeur')->attempt($credentials)) {
            $professeur = Professeur::where('email', $request->email)->first();
            $token = $professeur->createToken('professeur-token')->plainTextToken;

            return response([
                'professeur' => $professeur,
                'token' => $token,
            ]);
        }

        return response()->json(['message' => 'Email ou mot de passe invalides.'], 401);
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

    public function rechercherProfesseur(Request $request)
    {
        $query = $request->input('query');

        // Assurez-vous que la requête a au moins deux caractères
        if (strlen($query) < 2) {
            return response()->json(['message' => 'La recherche doit contenir au moins deux caractères.'], 400);
        }

        // Effectuez la recherche des professeurs
        $professeurs = Professeur::where('nom_Complet', 'like', '%' . $query . '%')->get();

        // Pour chaque professeur, récupérez la liste de ses sessions planifiées
        $resultats = [];
        foreach ($professeurs as $professeur) {
            $sessions = Session::where('cour_id', $professeur->cours->id)->get();

            $resultats[] = [
                'professeur' => $professeur,
                'sessions' => $sessions,
            ];
        }

        return response()->json($resultats);
    }
}
