<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Filiere extends Model
{
<<<<<<< HEAD:app/Models/Matiere.php
    use HasFactory;

    protected $fillable = ['nom', 'code', 'description'];

    // Une matière peut avoir plusieurs cours
    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
=======
    protected $fillable = ['nom', 'code', 'description'];

    // Relations (commentées pour éviter blocage)
    // public function cours()
    // {
    //     return $this->hasMany(Cours::class);
    // }
>>>>>>> origin/abdou:app/Models/Filiere.php
}
