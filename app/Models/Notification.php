<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'message',
        'dateEnvoi',
        'lu',
        'id_user',
        'id_reservation',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user' , 'id_user');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'id_reservation' , 'id_reservation');
    }
}

