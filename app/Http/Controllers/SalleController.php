<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
    // Liste de toutes les salles
    public function index()
    {
        $salles = Salle::all();

        return response()->json([
            'message' => 'Liste des salles',
            'data'    => $salles
        ], 200);
    }

    // Ajouter une nouvelle salle
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom'   => 'required|string|max:100',
            'type_salle'   => 'required|in:TP,Amphi,Cours', 
            'capacite'    => 'required|integer|min:1',
            'localisation'=> 'required|string|max:150',
        ]);

        $salle = Salle::create($validated);

        return response()->json([
            'message' => 'Salle cree avec succes',
            'data'    => $salle
        ], 201);
    }

    // Pour voir une salle précise
    public function show($id)
    {
        $salle = Salle::where('id_salle', $id)->firstOrFail();
        return response()->json([
            'message' => 'Salle trouvee',
            'data'    => $salle
        ], 200);
    }

    // Modifier une salle
    public function update(Request $request, $id)
    {
        $salle = Salle::where('id_salle', $id)->firstOrFail();

        $validated = $request->validate([
            'nom'   => 'sometimes|string|max:100',
            'type_salle'   => 'sometimes|in:TP,Amphi,Cours', 
            'capacite'    => 'sometimes|integer|min:1',
            'localisation'=> 'sometimes|string|max:150',
        ]);

        $salle->update($validated);

        return response()->json([
            'message' => 'Salle mise a jour avec succes',
            'data'    => $salle
        ], 200);
    }

    // Recherche filtrée
    public function search(Request $request)
    {
        $query = Salle::query();

        // Recherche par nom
        if ($request->has('nom')) {
            $query->where('nom', 'like', '%' . $request->nom . '%');
        }

        // Recherche par type
        if ($request->has('type_salle')) {
            $query->where('type_salle', $request->type_salle);
        }

        // Recherche par capacité minimale
        if ($request->has('capacite')) {
            $query->where('capacite', '>=', $request->capacite);
        }

        return response()->json($query->get());
    }

    // Supprimer une salle
    public function destroy($id)
    {
        $salle = Salle::where('id_salle', $id)->firstOrFail();
        $salle->delete();
        return response()->json(['message' => 'Salle supprimee avec succes']);
    }
}
