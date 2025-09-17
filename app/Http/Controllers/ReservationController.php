<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Salle;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    //  Liste des réservations
    public function index()
    {
        return Reservation::with(['salle', 'utilisateur'])->get();
    }

    //  Créer une réservation (avec vérification de disponibilité)
    public function store(Request $request)
    {
        $request->validate([
            'id_utilisateur' => 'required|exists:utilisateurs,id_utilisateur',
            'id_salle' => 'required|exists:salles,id_salle',
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut',
        ]);

        // Vérification disponibilité
        $conflit = Reservation::where('id_salle', $request->id_salle)
            ->where(function ($q) use ($request) {
                $q->whereBetween('date_debut', [$request->date_debut, $request->date_fin])
                  ->orWhereBetween('date_fin', [$request->date_debut, $request->date_fin])
                  ->orWhere(function ($q2) use ($request) {
                      $q2->where('date_debut', '<=', $request->date_debut)
                         ->where('date_fin', '>=', $request->date_fin);
                  });
            })
            ->where('statut', '!=', 'Annulée')
            ->exists();

        if ($conflit) {
            return response()->json(['message' => 'Salle déjà réservée pour ce créneau'], 409);
        }

        $reservation = Reservation::create($request->all());
        return response()->json($reservation, 201);
    }

    //  Détails d’une réservation
    public function show($id)
    {
        $reservation = Reservation::with(['salle', 'utilisateur'])->findOrFail($id);
        return response()->json($reservation);
    }

    // Mettre à jour une réservation
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'date_debut' => 'sometimes|date|before:date_fin',
            'date_fin' => 'sometimes|date|after:date_debut',
            'statut' => 'sometimes|in:En attente,Confirmée,Annulée',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée avec succès']);
    }
}
