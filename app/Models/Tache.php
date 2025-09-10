<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tache extends Model
{
    use HasFactory;

    protected $fillable = ['titre', 'description', 'etat', 'deadline', 'project_id', 'assigned_to'];

    public function projet() {
        return $this->belongsTo(Projet::class);
    }

    public function assignee() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }
}

