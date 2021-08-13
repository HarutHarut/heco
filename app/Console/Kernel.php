<?php

namespace App\Console;

use App\Console\Commands\CheckNotificationStatus;
use App\Console\Commands\NewFilterResult;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        CheckNotificationStatus::class,
        NewFilterResult::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        if(config('app.env') != 'production'){
            $schedule->command('notification_chenge')->hourly();
        }
        $schedule->command('new_filter_result')->daily();
        $schedule->command('sold_bike')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
