<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;

class MatiereController extends Controller
{
    /**
     * Afficher la liste de toutes les matières
     */
    public function index()
    {
        $matieres = Matiere::orderBy('nom')->get();
        
        return response()->json([
            'success' => true,
            'data' => $matieres,
            'count' => $matieres->count()
        ]);
    }

    /**
     * Créer une nouvelle matière
     */
    public function store(Request $request)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'nullable|string|max:50|unique:matieres,code',
            'description' => 'nullable|string'
        ]);

        $matiere = Matiere::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Matière créée avec succès',
            'data' => $matiere
        ], 201);
    }

    /**
     * Afficher une matière spécifique
     */
    public function show($id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json([
                'success' => false,
                'message' => 'Matière non trouvée'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $matiere
        ]);
    }

    /**
     * Mettre à jour une matière
     */
    public function update(Request $request, $id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json([
                'success' => false,
                'message' => 'Matière non trouvée'
            ], 404);
        }

        $request->validate([
            'nom' => 'sometimes|required|string|max:255',
            'code' => 'nullable|string|max:50|unique:matieres,code,' . $id . ',id_matiere',
            'description' => 'nullable|string'
        ]);

        $matiere->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Matière mise à jour avec succès',
            'data' => $matiere
        ]);
    }

    /**
     * Supprimer une matière
     */
    public function destroy($id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json([
                'success' => false,
                'message' => 'Matière non trouvée'
            ], 404);
        }

        $matiere->delete();

        return response()->json([
            'success' => true,
            'message' => 'Matière supprimée avec succès'
        ]);
    }

    /**
     * Rechercher des matières par nom ou code
     */
    public function search(Request $request)
    {
        $query = $request->input('query');

        $matieres = Matiere::where('nom', 'LIKE', "%{$query}%")
                           ->orWhere('code', 'LIKE', "%{$query}%")
                           ->orderBy('nom')
                           ->get();

        return response()->json([
            'success' => true,
            'data' => $matieres,
            'count' => $matieres->count()
        ]);
    }
}