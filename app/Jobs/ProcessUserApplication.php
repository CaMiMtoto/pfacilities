<?php

namespace App\Jobs;

use App\Mail\SendUserApplicationMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessUserApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $userApplication;
    public $tries = 5;
    public function __construct($userApplication)
    {
        $this->userApplication=$userApplication;
    }

    public function handle()
    {
        Mail::to($this->userApplication->user)->send(new SendUserApplicationMail($this->userApplication));
    }
}
