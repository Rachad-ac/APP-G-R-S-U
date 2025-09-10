<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        return response()->json(Tache::with(['projets', 'assignee'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'titre' => 'required|string',
            'description' => 'nullable|string',
            'etat' => 'in:À faire,En cours,Terminée',
            'deadline' => 'nullable|date',
            'project_id' => 'required|exists:projets,id',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task = Tache::create($validated);
        return response()->json($task, 201);
    }

    public function show($id)
    {
        $task = Tache::with(['projets', 'assignee', 'comments'])->findOrFail($id);
        return response()->json($task);
    }

    public function update(Request $request, $id)
    {
        $task = Tache::findOrFail($id);

        $validated = $request->validate([
            'titre' => 'sometimes|required|string',
            'description' => 'nullable|string',
            'etat' => 'in:À faire,En cours,Terminée',
            'deadline' => 'nullable|date',
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $task->update($validated);
        return response()->json($task);
    }

    public function destroy($id)
    {
        Tache::destroy($id);
        return response()->json(['message' => 'Tâche supprimée.']);
    }

    public function tasksByProject($projectId)
    {
        return Tache::where('project_id', $projectId)->with(['assignee', 'comments'])->get();
    }
}
