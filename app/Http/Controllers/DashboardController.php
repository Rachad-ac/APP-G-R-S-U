<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Reservation;
use App\Models\Salle;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function stats()
    {
        return response()->json([
            'total_users' => User::count(),
            'total_salles' => Salle::count(),
            'reservations' => Reservation::count(),
            'reservations_en_attente' => Reservation::where('statut', 'en_attente')->count(),
            'reservations_validees' => Reservation::where('statut', 'valide')->count(),
            'reservations_refusees' => Reservation::where('statut', 'refuse')->count(),
        ]);
    }
}

