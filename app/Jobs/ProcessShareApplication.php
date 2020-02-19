<?php

namespace App\Jobs;

use App\Mail\SendApplicationShared;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ProcessShareApplication implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $sharedApplication;
    public $tries = 5;

    public function __construct($sharedApplication)
    {
        $this->sharedApplication = $sharedApplication;
    }

    public function handle()
    {
        $users = User::with('position')->where('position_id',$this->sharedApplication->postion_id)->get();
        $users = $users->each(function ($user) {
            return $user->email;
        });
        Mail::to($users)->send(new SendApplicationShared($this->sharedApplication));
    }
}
