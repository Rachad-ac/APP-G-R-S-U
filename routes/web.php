<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservationMail;
use App\Models\Reservation;

Route::get('/test-email-reel', function () {
    try {
        Mail::raw('Ceci est un VRAI email envoyé depuis localhost!', function ($message) {
            $message->to('bent35005@gmail.com')  // Mettez votre email ici
                    ->subject('Test Email Réel depuis Localhost');
        });
        
        return 'Email réel envoyé! Vérifiez votre boîte de réception.';
    } catch (\Exception $e) {
        return 'Erreur: ' . $e->getMessage();
    }
});