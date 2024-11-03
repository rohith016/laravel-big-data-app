<?php

namespace App\Jobs;

use App\Mail\SendUserMail;
use Illuminate\Bus\Batchable;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Batchable;


    public $users;

    /**
     * Create a new job instance.
     */
    public function __construct($users)
    {
        $this -> users = $users;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        foreach($this -> users as $user){
            Mail::to($user[1])->send(new SendUserMail($user));
        }
    }
}
