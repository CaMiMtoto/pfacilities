<?php

namespace App\Jobs;

use App\Mail\SendApplicationMail;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ProcessApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $userApplication;
    public $tries = 5;

    public function __construct($userApplication)
    {
        $this->userApplication = $userApplication;
    }

    public function handle()
    {
        $users = User::where('role', '!=', 'normal')->get();
        if ($this->userApplication->status == 'verified') {
            $users = User::where('role', 'inspector')->get();
        } elseif ($this->userApplication->status == 'inspected') {
            $users = User::where('role', 'approval')->get();
        } elseif ($this->userApplication->status == 'approved') {
            $users = User::where('role', 'certifier')->get();
        }
        $users = $users->each(function ($user) {
            return $user->email;
        });
        Mail::to($users)->send(new SendApplicationMail($this->userApplication));
    }
}

