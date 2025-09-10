<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index()
{
    try {
        $comments = Comment::with(['tache', 'auteur'])->get();
        return response()->json(['data' => $comments], 200);
    } catch (\Exception $e) {
        return response()->json([
            'error' => $e->getMessage(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
}


    public function store(Request $request)
    {
        $validated = $request->validate([
            'texte' => 'required|string',
            'auteur_id' => 'required|exists:users,id',
            'task_id' => 'required|exists:taches,id',
        ]);

        $comment = Comment::create($validated);
        return response()->json($comment, 201);
    }

    public function show($id)
    {
        $comment = Comment::with(['tache', 'auteur'])->findOrFail($id);
        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);

        $validated = $request->validate([
            'texte' => 'sometimes|required|string',
        ]);

        $comment->update($validated);
        return response()->json($comment);
    }

    public function destroy($id)
    {
        Comment::destroy($id);
        return response()->json(['message' => 'Commentaire supprimé.']);
    }

    public function commentsByTask($taskId)
    {
        return Comment::where('task_id', $taskId)->with('auteur')->get();
    }
}
