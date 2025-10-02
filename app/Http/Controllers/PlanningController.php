<?php

namespace App\Http\Controllers;

use App\Models\Planning;
use Illuminate\Http\Request;

class PlanningController extends Controller
{
    // Lister tous les plannings
    public function index()
    {
        $planning = Planning::with(['user', 'salle'])->get();

        return response()->json([
            'message' => 'Liste des planning',
            'data'    => $planning
        ], 201);
    }

    // Créer un planning
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_salle' => 'required|exists:salles,id',
            'id_user' => 'required|exists:users,id',
            'date_debut' => 'required|date',
            'date_fin' => 'required|date|after:date_debut',
            'description' => 'nullable|string',
        ]);

        $planning = Planning::create($validated);

        return response()->json([
            'message' => 'Planning cree avec succes',
            'data'    => $planning
        ], 201);
    }

    // Afficher un planning spécifique
    public function show(Planning $planning)
    {
        $planning->load(['organisateur', 'salle']);

        return response()->json([
            'data'    => $planning
        ], 201);
    }

    // Mettre à jour un planning
    public function update(Request $request, Planning $planning)
    {
        $validated = $request->validate([
            'id_salle' => 'sometimes|exists:salles,id',
            'id_user' => 'sometimes|exists:users,id',
            'date_debut' => 'sometimes|date',
            'date_fin' => 'sometimes|date|after:date_debut',
            'description' => 'nullable|string',
        ]);

        $planning->update($validated);

        return response()->json([
            'message' => 'Planning mise a jour avec succes',
            'data'    => $planning
        ]);
    }

    // Supprimer un planning
    public function destroy($id)
    {
        $planning = Planning::firstOrFail();
        $planning->delete();

        return response()->json([
            'message' => 'Planning supprimer avec succes',
        ]);
    }
}
