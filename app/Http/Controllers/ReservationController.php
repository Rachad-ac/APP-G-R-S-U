<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Salle;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\ReservationMail;
use App\Mail\ValidationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ReservationController extends Controller
{
    // Liste des réservations
    public function index()
    {
        return Reservation::with(['salle', 'user'])->get();
    }

    public function mesReservations($id)
    {
        $reservations = Reservation::where('id_user', $id)->with('salle')->get();
        
        return response()->json([
            'success' => true,
            'data' => $reservations
        ]);
    }

    public function valider($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'Validée';
        $reservation->save();

        Mail::to($reservation->user->email)
            ->send(new ValidationMail($reservation, 'validée'));

        Notification::create([
            'message'       => "Votre réservation de la salle {$reservation->salle->nom} a été validée.",
            'dateEnvoi'     => now(),
            'lu'            => false,
            'id_user'       => $reservation->id_user,
            'id_reservation'=> $reservation->id_reservation,
        ]);

        return response()->json(['message' => 'Réservation validée et notification envoyée']);
    }

    public function refuser($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'Refusée';
        $reservation->save();

        Mail::to($reservation->user->email)
            ->send(new ValidationMail($reservation, 'refusée'));

        Notification::create([
            'message'       => "Votre réservation de la salle {$reservation->salle->nom} a été refusée.",
            'dateEnvoi'     => now(),
            'lu'            => false,
            'id_user'       => $reservation->id_user,
            'id_reservation'=> $reservation->id_reservation,
        ]);

        return response()->json(['message' => 'Réservation refusée et notification envoyée']);
    }

    // Store avec validation
   public function store(Request $request)
    {
        try {
            $request->validate([
                'id_user'         => 'required|exists:users,id',
                'id_salle'        => 'required|exists:salles,id_salle',
                'date_debut'      => 'required|date|before:date_fin',
                'date_fin'        => 'required|date|after:date_debut',
                'type_reservation'=> 'required|in:Cours,Examen,Evenement',
                'statut'          => 'nullable|in:En attente,Validée,Refusée,Annulée',
            ]);

            $data = $request->all();
            $data['statut'] = $data['statut'] ?? 'En attente';

            $reservation = Reservation::create($data);

            Mail::to('bent35005@gmail.com')->send(new ReservationMail($reservation));

            Notification::create([
                'message'       => "Nouvelle demande de réservation pour la salle {$reservation->salle->nom}",
                'dateEnvoi'     => now(),
                'lu'            => false,
                'id_user'       => 1,
                'id_reservation'=> $reservation->id_reservation,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Réservation créée et demande envoyée',
                'reservation' => $reservation
            ], 201);

        } catch (\Exception $e) {
            // Log l'erreur mais ne bloque pas la création
            Log::error('Erreur envoi email: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création de la réservation'
            ], 500);
        }
    }


    // Update
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);

        $request->validate([
            'id_user'         => 'required|exists:users,id',
            'id_salle'        => 'required|exists:salles,id_salle',
            'date_debut'      => 'sometimes|date|before:date_fin',
            'date_fin'        => 'sometimes|date|after:date_debut',
            'statut'          => 'nullable|in:En attente,Validée,Refusée,Annulée',
            'type_reservation'=> 'required|in:Cours,Examen,Evenement',
        ]);

        $reservation->update($request->all());

        Notification::create([
            'message'       => "Votre réservation pour la salle {$reservation->salle->nom} a été mise à jour.",
            'dateEnvoi'     => now(),
            'lu'            => false,
            'id_user'       => $reservation->id_user,
            'id_reservation'=> $reservation->id_reservation,
        ]);

        return response()->json($reservation);
    }

    public function search(Request $request)
    {
        $query = Reservation::query();

        if ($request->filled('id_salle')) {
            $query->where('id_salle', $request->id_salle);
        }

        if ($request->filled('date')) {
            $query->whereDate('date_debut', '<=', $request->date)
                  ->whereDate('date_fin', '>=', $request->date);
        }

        if ($request->filled('statut')) {
            $query->where('statut', $request->statut);
        }

        return response()->json($query->get());
    }


    // Supprimer une réservation

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return response()->json(['message' => 'Réservation supprimée avec succès']);
    }
}
