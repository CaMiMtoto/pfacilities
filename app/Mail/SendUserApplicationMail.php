<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendUserApplicationMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $userApplication;

    public function __construct($userApplication)
    {
        $this->userApplication = $userApplication;
    }

    public function build()
    {
        $address = 'info@moh.gov.rw';
        $subject = 'Application Update';
        $name = 'Ministry Of Health';

        return $this->view('emails.status.application_status_changed')
            ->from($address, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
//            ->replyTo($address, $name)
            ->subject($subject)
            ->with(['app' => $this->userApplication]);
    }
}
