<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Exception;

class ReservationController extends Controller
{
    // Récupérer toutes les réservations
    public function index()
    {
        try {
            $reservations = Reservation::with(['user', 'salle'])->get();

            return response()->json([
                'success' => true,
                'data' => $reservations
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Créer une réservation
    public function store(Request $request)
    {
        try {
            $request->validate([
                'salle_id' => 'required|exists:salles,id',
                'date_debut' => 'required|date|before:date_fin',
                'date_fin' => 'required|date|after:date_debut',
                'motif' => 'nullable|string'
            ]);

            $reservation = Reservation::create([
                'user_id' => Auth::id(),
                'salle_id' => $request->salle_id,
                'date_debut' => $request->date_debut,
                'date_fin' => $request->date_fin,
                'motif' => $request->motif,
                'statut' => 'en_attente'
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Réservation créée avec succès.',
                'data' => $reservation
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Récupérer une réservation par ID
    public function show($id)
    {
        try {
            $reservation = Reservation::with(['user', 'salle'])->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => $reservation
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Réservation non trouvée.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Mettre à jour une réservation
    public function update(Request $request, $id)
    {
        try {
            $reservation = Reservation::findOrFail($id);

            $request->validate([
                'date_debut' => 'sometimes|date|before:date_fin',
                'date_fin' => 'sometimes|date|after:date_debut',
                'statut' => 'sometimes|in:en_attente,confirmee,annulee',
                'motif' => 'nullable|string'
            ]);

            $reservation->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Réservation mise à jour avec succès.',
                'data' => $reservation
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Réservation non trouvée.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        try {
            $reservation = Reservation::findOrFail($id);
            $reservation->delete();

            return response()->json([
                'success' => true,
                'message' => 'Réservation supprimée avec succès.'
            ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Réservation non trouvée.'
            ], 404);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    // Récupérer les réservations de l’utilisateur connecté
    public function mesReservations()
    {
        try {
            $reservations = Reservation::where('user_id', Auth::id())
                ->with('salle')
                ->paginate(10);

            return response()->json([
                'success' => true,
                'data' => $reservations
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur serveur.',
                'details' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
