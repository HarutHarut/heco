<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Event;

class RoutesTranslation
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
        if (Auth::check()){
            if (Auth::user()->lang_message != app()->getLocale()){
                Auth::user()->update([
                    'lang_message' => app()->getLocale()
                ]);
            }
        }
    }
}
