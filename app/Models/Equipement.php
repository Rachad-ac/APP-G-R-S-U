<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    protected $fillable = ['nom', 'quantite', 'description'];

    // Relations (commentées pour tests indépendants)
    // Un équipement appartient à une salle
    // public function salle()
    // {
    //     return $this->belongsTo(Salle::class);
    // }
}
