<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role): Response
    {
<<<<<<< HEAD
        if ($request->user()?->role !== $role) {
=======
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Non authentifié'], 401);
        }

        $userRole = Role::where('id_role', $user->id_role)->first();
        
        if (!$userRole || $userRole->nom_role !== $role) {
>>>>>>> origin/jerry
            return response()->json(['message' => 'Accès refusé. Rôle requis : ' . $role], 403);
        }

        return $next($request);
        }

        
}
