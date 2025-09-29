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
        return Reservation::with(['salle', 'user'])->get();
    }

    //  Créer une réservation (avec vérification de disponibilité)
    public function store(Request $request)
    {
        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_salle' => 'required|exists:salles,id_salle',
            'date_debut' => 'required|date|before:date_fin',
            'date_fin' => 'required|date|after:date_debut',
            'status'    => 'nullable|in:En attente,Confirmee,Annulee',
            'type_reservation' => 'required|in:Cours,Examen,Evenement',
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
            ->where('status', '!=', 'Annulee')
            ->exists();

        if ($conflit) {
            return response()->json(['message' => 'Salle deja reservée pour ce creneau'], 409);
        }

        $data = $request->all();

        // voir si statut est dans les donnees sinon force "En attente"
        if (!isset($data['statut'])) {
            $data['statut'] = 'En attente';
        }

        $reservation = Reservation::create($data);

        return response()->json([
            'message' => 'RESERVATION CREE AVEC SUCCES',
            'reservation' => $reservation
        ], 201);
    }

    //  Détails d’une réservation
    public function show($id)
    {
        $reservation = Reservation::with(['salle', 'user'])->findOrFail($id);
        return response()->json($reservation);
    }

    // Mettre à jour une réservation
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'id_user' => 'required|exists:users,id',
            'id_salle' => 'required|exists:salles,id_salle',
            'date_debut' => 'sometimes|date|before:date_fin',
            'date_fin' => 'sometimes|date|after:date_debut',
            'status'    => 'nullable|in:En attente,Confirmee,Annulee',
            'type_reservation' => 'required|in:Cours,Examen,Evenement',
        ]);

        $reservation->update($request->all());
        return response()->json($reservation);
    }

    // Recherche d'une réservation
    public function search(Request $request)
    {
        $query = Reservation::query();

        // Recherche par id_salle
        if ($request->has('id_salle') && !empty($request->id_salle)) {
            $query->where('id_salle', $request->id_salle);
        }

        // Recherche par date 
        if ($request->has('date') && !empty($request->date)) {
            $query->whereDate('date_debut', '<=', $request->date)
                  ->whereDate('date_fin', '>=', $request->date);
        }

        // Recherche par statut
        if ($request->has('status') && !empty($request->status)) {
            $query->where('status', $request->status);
        }

        $reservations = $query->get();

        return response()->json($reservations);
    }

    // Supprimer une réservation
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée avec succès']);
    }

    // Valider une réservation
    public function valider($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'Confirmee') {
            return response()->json([
                'message' => 'La reservation est deja confirmee'
            ], 400);
        }

        $reservation->update(['status' => 'Confirmee']);

        return response()->json([
            'message' => 'Reservation validee avec succes',
            'reservation' => $reservation
        ], 200);
    }

    // Rejeter une réservation
    public function rejeter($id)
    {
        $reservation = Reservation::findOrFail($id);

        if ($reservation->status === 'Annulee') {
            return response()->json([
                'message' => 'La reservation est deja annulee'
            ], 400);
        }

        $reservation->update(['status' => 'Annulee']);

        return response()->json([
            'message' => 'Reservation rejetee avec succes',
            'reservation' => $reservation
        ], 200);
    }
}
