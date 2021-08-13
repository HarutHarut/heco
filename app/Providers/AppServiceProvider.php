<?php

namespace App\Providers;

use App\Models\Favorite;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['dashboard.layouts.app', 'layouts.app'], function ($view) {
            $user_id = auth()->id();

            $count = Favorite::where('user_id', $user_id)->whereHas('bike', function ($q) {
                return $q->where('status', 'active');
            })->count();

            $compaire_count = 0;
            $bikes = Session::get('bike_ids');
            if ($bikes) {
                foreach ($bikes as $item) {
                    $compaire_count++;
                }
            }

            $message = Message::where('sender_id', $user_id)->where('read_at', 2)->exists();

//            if ($message) {
                $notification_count = Message::where('sender_id', $user_id)->where('read_at', 2)->orWhere(function ($q) use($user_id){
                    return $q->where('recivient_id', $user_id)->where('read_at', 0);
                })->count();
//            }else{
//                $notification_count = Message::where('recivient_id', $user_id)->where('read_at', 0)->count();
//            }

            $view->with([
                'count' => $count,
                'compaire_count' => $compaire_count,
                'notification_count' => $notification_count,
            ]);
        });

    }
}
