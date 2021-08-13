<?php

namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifiedListener
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        try{
            $email = $event->user->email;
            $name = $event->user->name;
            if(Carbon::parse($event->user->created_at)->gt(now()->subHour())){
                Mail::send('emails.welcome', [
                    'name' => $name
                ], function ($m) use ($email) {
                    $m->to($email)->subject(__('Welcome'));
                });
            }

        }catch (\Exception $e){}

    }
}
