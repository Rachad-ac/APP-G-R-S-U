<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReservationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;

    /**
     * Create a new message instance.
     */
    public function __construct(Reservation $reservation)
    {
        $this->reservation = $reservation;
    }

    /**
     * Build the message.
     */
    public function build()
    {
        return $this->subject('Nouvelle demande de réservation')
                    ->view('emails.reservation')
                    ->with([
                        'reservation' => $this->reservation,
                    ])
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()->addTextHeader('X-Mailer', 'Laravel');
                    });
    }
}
