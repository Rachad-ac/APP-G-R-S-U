<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    // Liste de toutes les salles
    public function index()
    {
        return Salle::with('typeSalle')->get();
    }

    // Ajouter une nouvelle salle
    public function store(Request $request)
    {
        $request->validate([
            'nom_salle' => 'required|string|max:100',
            'capacite' => 'required|integer',
            'localisation' => 'required|string|max:150',
            'id_type_salle' => 'required|exists:type_salles,id_type_salle',
        ]);

        $salle = Salle::create($request->all());
        return response()->json($salle, 201);
    }

    // Détails d’une salle
    public function show($id)
    {
        $salle = Salle::with('typeSalle')->findOrFail($id);
        return response()->json($salle);
    }

    // Modifier une salle
    public function update(Request $request, $id)
    {
        $salle = Salle::findOrFail($id);

        $request->validate([
            'nom_salle' => 'sometimes|string|max:100',
            'capacite' => 'sometimes|integer',
            'localisation' => 'sometimes|string|max:150',
            'id_type_salle' => 'sometimes|exists:type_salles,id_type_salle',
        ]);

        $salle->update($request->all());
        return response()->json($salle);
    }

    // Supprimer une salle
    public function destroy($id)
    {
        $salle = Salle::findOrFail($id);
        $salle->delete();

        return response()->json(['message' => 'Salle supprimée avec succès']);
    }
}
