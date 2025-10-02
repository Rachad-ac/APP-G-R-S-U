<?php

namespace App\Mail;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ValidationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $reservation;
    public $decision;

    public function __construct(Reservation $reservation, $decision)
    {
        $this->reservation = $reservation;
        $this->decision = $decision;
    }

    public function build()
    {
        return $this->subject('Statut de votre réservation')
                    ->view('emails.validation')
                    ->withSwiftMessage(function ($message) {
                        $message->getHeaders()->addTextHeader('X-Mailer', 'Laravel');
                    });
    }
}
