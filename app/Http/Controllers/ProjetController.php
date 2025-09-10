<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Http\Request;

class ProjetController extends Controller
{
    public function index() {
        return response()->json(Projet::with('tache')->get());
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'nom' => 'required|string',
            'description' => 'nullable|string',
            'owner_id' => 'required|exists:users,id',
        ]);

        $project = Projet::create($validated);
        return response()->json($project, 201);
    }

    public function show($id) {
        return Projet::with('tasks')->findOrFail($id);
    }

    public function update(Request $request, $id) {
        $project = Projet::findOrFail($id);
        $project->update($request->only(['nom', 'description']));
        return response()->json($project);
    }

    public function destroy($id) {
        Projet::destroy($id);
        return response()->json(['message' => 'Projet supprimé']);
    }
}
