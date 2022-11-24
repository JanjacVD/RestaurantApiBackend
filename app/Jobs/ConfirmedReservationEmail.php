<?php

namespace App\Jobs;

use App\Mail\BookingSuccess;
use App\Mail\NewReservation;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ConfirmedReservationEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $res;
    public $qr;
    public function __construct($res, $qr)
    {
        $this->res = $res;
        $this->qr = $qr;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->res->email)->send(
            new BookingSuccess($this->res, $this->qr)
        );
    }
}
