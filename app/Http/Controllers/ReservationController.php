<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Salle;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Mail\ReservationMail;
use App\Mail\ValidationMail;
use Illuminate\Support\Facades\Mail;


class ReservationController extends Controller
{
    //  Liste des réservations
    public function index()
    {
        return Reservation::with(['salle', 'user'])->get();
    }

    public function mesReservations(Request $request, $id) {
        $reservations = Reservation::where('id_user', $id)->get();
        
        return response()->json([
            'success' => true,
            'data' => $reservations
        ]);
    }

    public function reserver(Request $request)
    {
        $reservation = Reservation::create([
            'id_user' =>$request->id_user,
            'id_salle' => $request->salle_id,
            'date_debut' => $request->date_debut,
            'date_fin' => $request->date_fin,
            'type_reservation' => $request->type_reservation
        ]);

        // Mail à l’admin
        Mail::to('bent35005@gmail.com')->send(new ReservationMail($reservation));

        // Sauvegarder en base une notification pour l’admin
        Notification::create([
            'message' => "Nouvelle demande de réservation pour la salle {$reservation->salle->nom}",
            'dateEnvoi' => now(),
            'lu' => false,
            'id_user' => 1, 
            'id_reservation' => $reservation->id_reservation,
        ]);

        return response()->json(['message' => 'Demande envoyée avec succès']);
    }

    public function valider($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'valide';
        $reservation->save();

        // Mail au demandeur (peut être étudiant ou enseignant)
        Mail::to($reservation->user->email)
            ->send(new ValidationMail($reservation, 'valide'));

        // Sauvegarder en base une notification pour le demandeur
        Notification::create([
            'message'       => "Votre réservation de la salle {$reservation->salle->nom} a été validée.",
            'dateEnvoi'     => now(),
            'lu'            => false,
            'id_user'        => $reservation->id_user,
            'id_reservation' => $reservation->id_reservation,
        ]);

        return response()->json(['message' => 'Réservation validée, mail envoyé et notification enregistrée']);
    }

    public function refuser($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->statut = 'refuse';
        $reservation->save();

        Mail::to($reservation->user->email)
            ->send(new ValidationMail($reservation, 'refuse'));

        // Sauvegarder en base une notification pour le demandeur
        Notification::create([
            'message'       => "Votre réservation de la salle {$reservation->salle->nom} a été refusée.",
            'dateEnvoi'     => now(),
            'lu'            => false,
            'id_user'        => $reservation->id_user,
            'id_reservation' => $reservation->id_reservation,
        ]);

        return response()->json(['message' => 'Réservation refusée, mail envoyé et notification enregistrée']);
    }



    // Créer une réservation (avec vérification de disponibilité)
public function store(Request $request)
{
    $request->validate([
        'id_user' => 'required|exists:users,id',
        'id_salle' => 'required|exists:salles,id_salle',
        'date_debut' => 'required|date|before:date_fin',
        'date_fin' => 'required|date|after:date_debut',
        'statut' => 'nullable|in:En attente,Confirmee,Annulee',
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
        ->where('statut', '!=', 'Annulee') // Correction: statut au lieu de status
        ->exists();

    if ($conflit) {
        return response()->json([
            'success' => false,
            'message' => 'Salle déjà réservée pour ce créneau'
        ], 409);
    }

    $data = $request->all();

    // Voir si statut est dans les données sinon force "En attente"
    if (!isset($data['statut'])) {
        $data['statut'] = 'En attente';
    }

    $reservation = Reservation::create($data);

    // Mail à l'admin
    try {
        Mail::to('bent35005@gmail.com')->send(new ReservationMail($reservation));

        // Sauvegarder en base une notification pour l’admin
        Notification::create([
            'message' => "Nouvelle demande de réservation pour la salle {$reservation->salle->nom}",
            'dateEnvoi' => now(),
            'lu' => false,
            'id_user' => 1, 
            'id_reservation' => $reservation->id_reservation,
        ]);

    } catch (\Exception $e) {
        // Log l'erreur mais ne bloque pas la création
        \Log::error('Erreur envoi email: ' . $e->getMessage());
    }

    // UN SEUL return à la fin
    return response()->json([
        'success' => true,
        'message' => 'Réservation créée avec succès et Demande envoyée avec succès',
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

}
