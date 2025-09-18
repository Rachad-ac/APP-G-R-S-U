<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipement extends Model
{
    use HasFactory;

    protected $fillable = ['nom_equipement'];

    /**
     * Relation Many-to-Many avec Reservation
     */
    public function reservations()
    {
        return $this->belongsToMany(Reservation::class, 'detail_reservations')
                    ->withTimestamps();
    }
}
