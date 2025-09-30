<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    // Liste des rôles
    public function index()
    {
        return response()->json(Role::all());
    }

    // Créer un rôle
    public function store(Request $request)
    {
        $request->validate([
            'nom_role' => 'required|unique:roles'
        ]);

        $role = Role::create($request->all());
        return response()->json($role, 201);
    }

    // Supprimer un rôle
    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(['message' => 'Rôle supprimé avec succès']);
    }
}
