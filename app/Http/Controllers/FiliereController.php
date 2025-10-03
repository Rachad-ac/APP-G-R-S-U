<?php

namespace App\Http\Controllers;

use App\Models\Filiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class FiliereController extends Controller
{
    // Lister toutes les filières
    public function index()
    {
        try {
            $filieres = Filiere::all();
            return response()->json(['success' => true, 'data' => $filieres], 200);
        } catch (Exception $e) {
            return response()->json(['success' => false, 'message' => 'Erreur serveur'], 500);
        }
    }

    // Créer une filière
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:100',
            'code' => 'required|string|max:20|unique:filieres,code',
            'description' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $filiere = Filiere::create($request->only(['nom', 'code', 'description']));

        return response()->json(['success' => true, 'data' => $filiere], 201);
    }

    // Afficher une filière par ID
    public function show($id)
    {
        try {
            $filiere = Filiere::findOrFail($id);
            return response()->json(['success' => true, 'data' => $filiere], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Filière non trouvée'], 404);
        }
    }

    // Mettre à jour une filière
    public function update(Request $request, $id)
    {
        try {
            $filiere = Filiere::findOrFail($id);

            $validator = Validator::make($request->all(), [
                'nom' => 'sometimes|string|max:100',
                'code' => 'sometimes|string|max:20|unique:filieres,code,' . $id,
                'description' => 'nullable|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $filiere->update($request->only(['nom', 'code', 'description']));

            return response()->json(['success' => true, 'data' => $filiere], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Filière non trouvée'], 404);
        }
    }

    // Supprimer une filière
    public function destroy($id)
    {
        try {
            $filiere = Filiere::findOrFail($id);
            $filiere->delete();
            return response()->json(['success' => true, 'message' => 'Filière supprimée'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['success' => false, 'message' => 'Filière non trouvée'], 404);
        }
    }
}
