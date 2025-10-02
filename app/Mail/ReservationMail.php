<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    public function build()
    {
        return $this->subject('Nouvelle demande de réservation')
                    ->view('emails.reservation')
                    ->with([
                        'reservation' => $this->reservation,
                    ]);
    }

    /**
     * Ajout de headers personnalisés (optionnel, compatible Laravel 9+)
     */
    public function envelope()
    {
        return new \Illuminate\Mail\Mailables\Envelope(
            subject: 'Nouvelle demande de réservation',
            headers: [
                'X-Mailer' => 'Laravel'
            ]
        );
    }
}
