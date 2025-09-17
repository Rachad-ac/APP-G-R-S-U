<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_reservation';

    protected $fillable = [
        'id_utilisateur',
        'id_salle',
        'date_debut',
        'date_fin',
        'statut',
    ];

    // Une réservation appartient à un utilisateur
    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'id_utilisateur', 'id_utilisateur');
    }

    // Une réservation concerne une salle
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle', 'id_salle');
    }
}

