<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $primaryKey = 'id_utilisateur';
    protected $fillable = ['nom', 'prenom', 'email', 'mot_de_passe', 'id_role'];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_utilisateur', 'id_utilisateur');
    }
}
