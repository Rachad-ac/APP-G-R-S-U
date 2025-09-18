<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'salle_id',
        'date_debut',
        'date_fin',
        'statut',
        'motif',
    ];

    protected $casts = [
        'date_debut' => 'datetime',
        'date_fin'   => 'datetime',
    ];

    // Relations
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class);
    }

    public function equipements()
    {
        return $this->belongsToMany(Equipement::class, 'detail_reservations')
                     ->withTimestamps();
    }

    /** Scope utilitaire : vérifier si un créneau se chevauche */
    public function scopeOverlapping($query, int $salleId, $debut, $fin)
    {
        return $query->where('salle_id', $salleId)
            ->where('statut', '!=', 'annulee')
            ->where(function ($q) use ($debut, $fin) {
                $q->whereBetween('date_debut', [$debut, $fin])
                  ->orWhereBetween('date_fin', [$debut, $fin])
                  ->orWhere(function ($qq) use ($debut, $fin) {
                      $qq->where('date_debut', '<=', $debut)
                         ->where('date_fin', '>=', $fin);
                  });
            });
    }
}
