<?php

namespace App\Http\Controllers;

use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    /**
     * Afficher tous les équipements.
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => Equipement::all()
        ]);
    }

    /**
     * Créer un nouvel équipement.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom_equipement' => 'required|string|unique:equipements,nom_equipement',
        ]);

        $equipement = Equipement::create($request->only('nom_equipement'));

        return response()->json([
            'success' => true,
            'message' => 'Équipement créé avec succès.',
            'data' => $equipement
        ], 201);
    }

    /**
     * Afficher un équipement par son ID.
     */
    public function show(Equipement $equipement)
    {
        return response()->json([
            'success' => true,
            'data' => $equipement
        ]);
    }

    /**
     * Mettre à jour un équipement.
     */
    public function update(Request $request, Equipement $equipement)
    {
        $request->validate([
            'nom_equipement' => 'required|string|unique:equipements,nom_equipement,' . $equipement->id,
        ]);

        $equipement->update($request->only('nom_equipement'));

        return response()->json([
            'success' => true,
            'message' => 'Équipement mis à jour avec succès.',
            'data' => $equipement
        ]);
    }

    /**
     * Supprimer un équipement.
     */
    public function destroy(Equipement $equipement)
    {
        $equipement->delete();

        return response()->json([
            'success' => true,
            'message' => 'Équipement supprimé avec succès.'
        ]);
    }
}
