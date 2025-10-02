<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;
use App\Models\Equipement;
use Illuminate\Http\Request;

class EquipementController extends Controller
{
    // Liste des équipements
    public function index()
    {
        $equipements = Equipement::all();
        return response()->json($equipements, 200);
    }

    // Créer un équipement
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'quantite' => 'required|integer|min:1',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $equipement = Equipement::create($request->only(['nom', 'quantite', 'description']));

        return response()->json($equipement, 201);
    }

    // Afficher un équipement
    public function show($id)
    {
        $equipement = Equipement::find($id);

        if (!$equipement) {
            return response()->json(['message' => 'Équipement non trouvé'], 404);
        }

        return response()->json($equipement, 200);
    }

    // Mettre à jour un équipement
    public function update(Request $request, $id)
    {
        $equipement = Equipement::find($id);

        if (!$equipement) {
            return response()->json(['message' => 'Équipement non trouvé'], 404);
        }

        $equipement->update($request->only(['nom', 'quantite', 'description']));

        return response()->json($equipement, 200);
    }

    // Supprimer un équipement
    public function destroy($id)
    {
        $equipement = Equipement::find($id);

        if (!$equipement) {
            return response()->json(['message' => 'Équipement non trouvé'], 404);
        }

        $equipement->delete();

        return response()->json(['message' => 'Équipement supprimé avec succès'], 200);
    }
}
