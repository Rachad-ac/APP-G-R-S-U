<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_salle';

    protected $fillable = [
        'nom_salle',
        'capacite',
        'localisation',
        'id_type_salle',
    ];

    // Une salle peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_salle', 'id_salle');
    }

    // Une salle appartient à un type
    public function typeSalle()
    {
        return $this->belongsTo(TypeSalle::class, 'id_type_salle', 'id_type_salle');
    }
}
