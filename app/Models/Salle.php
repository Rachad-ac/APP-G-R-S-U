<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Salle extends Model
{
    use HasFactory;

    protected $fillable = [
        'nom_salle',
        'capacite',
        'localisation',
        'type_salle_id',
        'is_active'
    ];

    public function typeSalle()
    {
        return $this->belongsTo(TypeSalle::class, 'type_salle_id');
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
