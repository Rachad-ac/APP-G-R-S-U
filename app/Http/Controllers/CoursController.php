<?php

namespace App\Http\Controllers;

use App\Models\Cours;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CoursController extends Controller
{
    public function index()
    {
        return response()->json(Cours::all(), 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:cours,code',
            'matiere_id' => 'nullable|integer',
            'filiere_id' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $cours = Cours::create($request->only(['nom', 'code', 'matiere_id', 'filiere_id']));

        return response()->json($cours, 201);
    }

    public function show($id)
    {
        $cours = Cours::find($id);

        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }

        return response()->json($cours, 200);
    }

    public function update(Request $request, $id)
    {
        $cours = Cours::find($id);

        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }

        $cours->update($request->only(['nom', 'code', 'matiere_id', 'filiere_id']));

        return response()->json($cours, 200);
    }

    public function destroy($id)
    {
        $cours = Cours::find($id);

        if (!$cours) {
            return response()->json(['message' => 'Cours non trouvé'], 404);
        }

        $cours->delete();

        return response()->json(['message' => 'Cours supprimé avec succès'], 200);
    }
}
