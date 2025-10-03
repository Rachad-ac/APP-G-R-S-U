<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_salle';
    protected $fillable = [
        'nom',
        'type_salle',
        'capacite',
        'localisation',
    ];

    // Une salle peut avoir plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'id_salle', 'id_salle');
    }
    
    public function equipements()
     {
         return $this->hasMany(Equipement::class, 'id_salle');
     }
}
