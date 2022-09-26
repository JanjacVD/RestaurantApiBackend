<?php

namespace App\Listeners;

use App\Events\NewReservationPending;
use App\Jobs\SendContactEmail;
use App\Mail\BookingPending;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendReservationPendingNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\NewReservationPending  $event
     * @return void
     */
    public function handle(NewReservationPending $event)
    {
        $guestInfo = $event->guestInfo;
        SendContactEmail::dispatch($guestInfo)->onQueue('low');
    }
}
