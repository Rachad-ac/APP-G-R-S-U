<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Filiere extends Model
{
    protected $fillable = ['nom', 'code', 'description'];

    // Relations (commentées pour éviter blocage)
    // public function cours()
    // {
    //     return $this->hasMany(Cours::class);
    // }
}
