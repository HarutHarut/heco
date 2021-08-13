<?php

namespace App\Console\Commands;

use App\Imports\Bikeimport;
use App\Models\Bike;
use App\Models\Booking;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Console\Command;

class FixDB extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fix:db';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fix database data';

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
//        Excel::import(new Bikeimport(), public_path('files/bikes_x.xlsx'));

        $users = User::has('bookings')->get();
        foreach ($users as $user) {
            $bookings = $user->bookings()->where(function ($q) {
                $q->where('status','success');
            })->get();
            foreach ($bookings as $key => $booking) {
                $booking->stage = ($key == 0) ? 'new' : 'ret';
                $booking->save();
            }
        }
        dd('done');
    }
}
