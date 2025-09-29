<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cours extends Model
{
    use HasFactory;

    protected $fillable = ['matiere_id', 'nom_cours', 'description'];

    // Un cours appartient à une matière
    public function matiere()
    {
        return $this->belongsTo(Matiere::class);
    }
}
