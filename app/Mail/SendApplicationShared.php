<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendApplicationShared extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $sharedApplication;

    /**
     * Create a new message instance.
     *
     * @param $sharedApplication
     */
    public function __construct($sharedApplication)
    {
        $this->sharedApplication = $sharedApplication;
    }


    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $address = 'info@moh.gov.rw';
        $subject = 'Application Update';
        $name = 'Ministry Of Health';

        return $this->view('emails.status.application_shared')
            ->from($address, $name)
            ->cc($address, $name)
            ->bcc($address, $name)
            ->subject($subject)
            ->with(['app' => $this->sharedApplication]);
    }
}
