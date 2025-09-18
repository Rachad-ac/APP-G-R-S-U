<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Liste des réservations
    public function index(Request $request)
    {
        $query = Reservation::with(['user','salle','equipements'])
            ->orderByDesc('date_debut');

        if ($request->filled('salle_id')) {
            $query->where('salle_id', $request->salle_id);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json([
            'success' => true,
            'data' => $query->get()
        ]);
    }

    // Créer une réservation
    public function store(Request $request)
    {
        $data = $request->validate([
            'salle_id'      => 'required|exists:salles,id',
            'date_debut'    => 'required|date|before:date_fin',
            'date_fin'      => 'required|date|after:date_debut',
            'motif'         => 'nullable|string',
            'equipements'   => 'array',
            'equipements.*' => 'exists:equipements,id'
        ]);

        // Vérifier disponibilité
        $overlap = Reservation::overlapping($data['salle_id'], $data['date_debut'], $data['date_fin'])->exists();
        if ($overlap) {
            return response()->json([
                'success' => false,
                'message' => 'Salle déjà réservée pour ce créneau.'
            ], 422);
        }

        $reservation = Reservation::create([
            'user_id'    => Auth::id(),
            'salle_id'   => $data['salle_id'],
            'date_debut' => $data['date_debut'],
            'date_fin'   => $data['date_fin'],
            'statut'     => 'en_attente',
            'motif'      => $data['motif'] ?? null,
        ]);

        if (!empty($data['equipements'])) {
            $reservation->equipements()->sync($data['equipements']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Réservation créée avec succès',
            'data' => $reservation->load(['salle','equipements'])
        ], 201);
    }

    // Afficher une réservation
    public function show(Reservation $reservation)
    {
        return response()->json([
            'success' => true,
            'data' => $reservation->load(['user','salle','equipements'])
        ]);
    }

    // Mettre à jour une réservation
    public function update(Request $request, Reservation $reservation)
    {
        $data = $request->validate([
            'date_debut'    => 'sometimes|date|before:date_fin',
            'date_fin'      => 'sometimes|date|after:date_debut',
            'statut'        => 'sometimes|in:en_attente,confirmee,annulee',
            'motif'         => 'nullable|string',
            'equipements'   => 'array',
            'equipements.*' => 'exists:equipements,id'
        ]);

        // Vérif conflit si modification des dates
        if (isset($data['date_debut']) || isset($data['date_fin'])) {
            $debut = $data['date_debut'] ?? $reservation->date_debut;
            $fin   = $data['date_fin'] ?? $reservation->date_fin;

            $overlap = Reservation::overlapping($reservation->salle_id, $debut, $fin)
                ->where('id','!=',$reservation->id)->exists();

            if ($overlap) {
                return response()->json([
                    'success' => false,
                    'message' => 'Salle déjà réservée pour ce créneau.'
                ], 422);
            }
        }

        $reservation->update($data);

        if (isset($data['equipements'])) {
            $reservation->equipements()->sync($data['equipements']);
        }

        return response()->json([
            'success' => true,
            'message' => 'Réservation mise à jour',
            'data' => $reservation->fresh()->load(['salle','equipements'])
        ]);
    }

    // Supprimer
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();

        return response()->json([
            'success' => true,
            'message' => 'Réservation supprimée.'
        ]);
    }

    // Voir mes réservations (pour User connecté)
    public function mesReservations()
    {
        return response()->json([
            'success' => true,
            'data' => Reservation::with(['salle','equipements'])
                ->where('user_id', Auth::id())
                ->orderByDesc('date_debut')
                ->get()
        ]);
    }
}
