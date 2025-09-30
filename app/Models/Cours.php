<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use HasFactory;

class Cours extends Model
{

    protected $fillable = ['nom', 'code', 'description', 'id_matiere', 'id_filiere'];

    // Relations (commentées pour tests indépendants)
    // Un cours appartient à une matière
    public function matiere()
     {
         return $this->belongsTo(Matiere::class);
     }

    // Un cours appartient à une filière
     public function filiere()
     {
         return $this->belongsTo(Filiere::class);
     }

    // Un cours peut avoir plusieurs enseignants
    public function enseignants()
    {
        return $this->belongsToMany(User::class);
    }

    // Un cours peut être lié à plusieurs réservations
    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
