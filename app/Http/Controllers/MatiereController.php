<?php

namespace App\Http\Controllers;

use App\Models\Matiere;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MatiereController extends Controller
{
    public function index()
    {
        return response()->json(Matiere::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:matieres,code',
            'description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $matiere = Matiere::create($request->only(['nom', 'code', 'description']));

        return response()->json($matiere, 201);
    }

    public function show($id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json(['message' => 'Matière non trouvée'], 404);
        }

        return response()->json($matiere, 200);
    }

    public function update(Request $request, $id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json(['message' => 'Matière non trouvée'], 404);
        }

        $matiere->update($request->only(['nom', 'code', 'description']));

        return response()->json($matiere, 200);
    }

    public function destroy($id)
    {
        $matiere = Matiere::find($id);

        if (!$matiere) {
            return response()->json(['message' => 'Matière non trouvée'], 404);
        }

        $matiere->delete();

        return response()->json(['message' => 'Matière supprimée avec succès'], 200);
    }
}
