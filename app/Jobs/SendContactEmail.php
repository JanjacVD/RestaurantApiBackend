<?php

namespace App\Jobs;

use App\Mail\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendContactEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public $email;
    public $name;
    public $subject;
    public $msg;
    public function __construct($email, $name, $subject, $msg)
    {
        $this->email = $email;
        $this->name = $name;
        $this->subject = $subject;
        $this->msg = $msg;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to(env('CONTACT_MAIL'))->send(
            new Contact($this->email, $this->name, $this->subject, $this->msg)
        );
    }
}
