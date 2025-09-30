<?php

namespace App\Models;
 use HasFactory;

use Illuminate\Database\Eloquent\Model;

class Matiere extends Model
{

    protected $fillable = ['nom', 'code', 'description'];

    // Relations (commentées pour tests indépendants)
    // Une matière possède plusieurs cours
    // public function cours()
    // {
    //     return $this->hasMany(Cours::class);
    // }
}
