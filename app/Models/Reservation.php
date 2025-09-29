<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    // Champs modifiables en masse
    protected $fillable = [
        'user_id',
        'salle_id',
        'date_debut',
        'date_fin',
        'motif',
        'statut'
    ];

    /*



    Une réservation appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    Une réservation concerne une salle
    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    Une réservation peut concerner un cours
    public function cours()
    {
        return $this->belongsTo(Cours::class);
    }
        */
}
