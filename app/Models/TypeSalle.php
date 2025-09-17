<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypeSalle extends Model
{
    protected $primaryKey = 'id_type_salle';
    protected $fillable = ['libelle_type'];

    public function salles()
    {
        return $this->hasMany(Salle::class, 'id_type_salle', 'id_type_salle');
    }
}

