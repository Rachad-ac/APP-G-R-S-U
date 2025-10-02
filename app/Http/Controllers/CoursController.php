<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;

class CoursController extends Controller
{
    /**
     * Afficher la liste des cours
     */
    public function index()
    {
        $cours = Cours::with(['matiere', 'filiere'])->latest()->get();
        return response()->json(
            [
                'message' => 'Listes des cours',
                'data' => $cours
            ]
        );
    }

    /**
     * Enregistrer un nouveau cours
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:cours,code',
            'description' => 'nullable|string',
            'id_matiere' => 'required|exists:matieres,id_matiere',
            'id_filiere' => 'required|exists:filieres,id_filiere',
        ]);

        $cours = Cours::create($validated);
        $cours->load(['matiere', 'filiere']);

        return response()->json([
            'message' => 'Cours créé avec succès',
            'data' => $cours
        ], 201);
    }

    /**
     * Mettre à jour un cours
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:cours,code,' . $cours->id_cours,
            'description' => 'nullable|string',
            'id_matiere' => 'required|exists:matieres,id_matiere',
            'id_filiere' => 'required|exists:filieres,id_filiere',
        ]);

        $cours = Cours::findOrFail($id);
        $cours->update($validated);
        $cours->load(['matiere', 'filiere']);

        return response()->json([
            'message' => 'Cours modifié avec succès',
            'data' => $cours
        ]);
    }

    /**
     * Supprimer un cours
     */
    public function destroy($id)
    {
        $cours = Cours::findOrFail($id);
        $cours->delete();

        return response()->json([
            'message' => 'Cours supprimé avec succès'
        ]);
    }
}