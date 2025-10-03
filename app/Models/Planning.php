<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Planning extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_planning';

    protected $fillable = [
        'id_salle',
        'id_user',
        'date_debut',
        'date_fin',
        'description',
    ];

    // Relations
    public function organisateur()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function salle()
    {
        return $this->belongsTo(Salle::class, 'id_salle');
    }
}

