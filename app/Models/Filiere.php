<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Filiere extends Model
{
    use HasFactory;

    protected $fillable = ['nom', 'code', 'description'];

    // Une matière peut avoir plusieurs cours
    public function cours()
    {
        return $this->hasMany(Cours::class);
    }
}
