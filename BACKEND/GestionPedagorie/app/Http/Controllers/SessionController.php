<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Cour;
use App\Models\Salle;
use App\Models\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sessions = Session::with(['cours.professeur', 'salle', 'cours.classe'])->get();
        return response()->json($sessions);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        try {
            DB::beginTransaction();


            $request->validate([
                'date' => 'required|date',
                'heure_debut' => 'required|numeric',
                'heure_fin' => 'required|numeric|gt:heure_debut',
                'etat' => 'required|string',
                'cour_id' => 'required|exists:cours,id',
                'salle_id' => 'required|exists:salles,id',
            ]);

            $date = $request->input('date');
            $heureDebut = $request->input('heure_debut');
            $heureFin = $request->input('heure_fin');
            $etat = $request->input('etat');
            $courId = $request->input('cour_id');
            $salleId = $request->input('salle_id');

            $cours = Cour::find($courId);
            if (!$cours) {
                return response()->json(['message' => 'Le cours n\'existe pas'], 404);
            }

            $dureeSession = $heureFin - $heureDebut;

            if ($cours->quota_horaire < $dureeSession) {
                return response()->json(['message' => 'Le quota horaire du professeur est insuffisant'], 400);
            }

            $salle = Salle::find($salleId);
            if (!$salle) {
                return response()->json(['message' => 'La salle n\'existe pas'], 404);
            }

            if ($salle->isOccupied($date, $heureDebut, $heureFin)) {
                return response()->json(['message' => 'La salle est déjà occupée à ce moment-là'], 400);
            }

            if ($salle->isReservedForDuration($date, $heureDebut, $heureFin)) {
                return response()->json(['message' => 'La salle est déjà réservée pour une durée similaire'], 400);
            }
            // dd);
            DB::insert('insert into sessions (date,heure_debut,heure_fin,etat,cour_id,salle_id ) values (?,?,?,?,?,?)', [$date, $heureDebut, $heureFin, $etat, $courId, $salleId]);

            $cours->heure_restant -= $dureeSession;
            $cours->save();

            DB::commit();

            return response()->json(['message' => 'Session planifiée avec succès', 'data'], 201);
        } catch (\Exception $e) {
            DB::rollBack();

            return response()->json(['message' => 'Une erreur est survenue lors de la planification de la session', 'error' => $e->getMessage()], 500);
        }
    }
    public function filterByDate(Request $request)
    {
        $date = $request->input('date');

        $sessions = Session::where('date', $date)->get();

        return response()->json(['sessions' => $sessions]);
    }


    public function filterByClasse(Request $request)
    {
        $classeId = $request->input('classe_id');

        $sessions = Session::where('classe_id', $classeId)->get();

        return response()->json(['sessions' => $sessions]);
    }


    public function filterByMonth(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');

        $sessions = Session::whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get();

        return response()->json(['sessions' => $sessions]);
    }

    public function filterByProfesseur(Request $request)
    {
        $professeurId = $request->input('professeur_id');

        $sessions = Session::where('professeur_id', $professeurId)->get();

        return response()->json(['sessions' => $sessions]);
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

    public function annuler($id)
    {
        $session = Session::find($id);

        if (!$session) {
            return response()->json(['message' => 'Session non trouvée'], 404);
        }

        if ($session->etat === 'annulé') {
            return response()->json(['message' => 'La session est déjà annulée'], 400);
        }

        $session->etat = 'annulé';
        $session->save();

        return response()->json(['message' => 'La session a été annulée avec succès']);
    }
}
