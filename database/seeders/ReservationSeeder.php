<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Reservation;
use App\Models\User;
use App\Models\Salle;

class ReservationSeeder extends Seeder
{
//     public function run(): void
//     {
//         $user = User::first();
//         $salle = Salle::first();
//
//         if ($user && $salle) {
//             Reservation::create([
//                 'user_id'    => $user->id,
//                 'salle_id'   => $salle->id,
//                 'date_debut' => Carbon::now()->addDays(1)->setTime(10, 0),
//                 'date_fin'   => Carbon::now()->addDays(1)->setTime(12, 0),
//                 'statut'     => 'en_attente',
//                 'motif'      => 'Cours test'
//             ]);
//
//             Reservation::create([
//                 'user_id'    => $user->id,
//                 'salle_id'   => $salle->id,
//                 'date_debut' => Carbon::now()->addDays(2)->setTime(14, 0),
//                 'date_fin'   => Carbon::now()->addDays(2)->setTime(16, 0),
//                 'statut'     => 'confirmee',
//                 'motif'      => 'Conférence de test'
//             ]);
//         }
//     }
}
