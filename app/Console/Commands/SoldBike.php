<?php

namespace App\Console\Commands;

use App\Models\Bike;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;

class SoldBike extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sold_bike';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Bike::whereHas('booking', function ($q) {
            return $q->where('bookings.created_at', '<', now()->subDay());
        })->where('is_sold', 1)->update([
            'status' => 'inactive'
        ]);
    }
}
