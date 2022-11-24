<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BookingSuccess extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $guest;
    public $qr;
    public function __construct($guest, $qr)
    {
        $this->guest = $guest;
        $this->qr = $qr;
    }

    public function build()
    {
        return $this->from(env('RESERVATION_MAIL'), env('APP_NAME'))->subject('See you soon')->view('emails.reservations.guest.success');
    }
}
