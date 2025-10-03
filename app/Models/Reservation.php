<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_reservation';


    protected $fillable = [
        'id_user',
        'id_salle',
        'id_cours',
        'date_debut',
        'date_fin',
        'type_reservation',
        'statut',
    ];

    // Une réservation appartient à un utilisateur
    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    // Une réservation concerne une salle
    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle', 'id_salle');
    }

    // Une réservation concerne une salle
    public function cours()
    {
        return $this->belongsTo(Cours::class, 'id_cours', 'id_cours');
    }
}

