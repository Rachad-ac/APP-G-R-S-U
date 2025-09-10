<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['texte', 'auteur_id', 'task_id'];

    public function auteur() {
        return $this->belongsTo(User::class, 'auteur_id');
    }

    public function tache() {
        return $this->belongsTo(Tache::class);
    }
}
