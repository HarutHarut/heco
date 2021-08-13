<?php

namespace App\Console\Commands;

use App\Models\Bike;
use App\Models\Message;
use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Mail;

class CheckNotificationStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'notification_chenge';

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
        $approve = Message::where('updated_at', '<', Carbon::now()->subDay())
            ->where(function ($query) {
                $query->where('status', 2);
            })->get();
        foreach ($approve as $item) {
            $bike = Bike::find($item->bike_id);
            $bike->update([
                'status' => 'active'
            ]);
            Message::where('bike_id', $item->bike_id)->update([
                'status' => -1
            ]);

            $user = $item->sender;
            $email = $item->sender->email;
            try {
                App::setLocale($user->lang_message);
                Mail::send('emails.notifications', [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'type' => 'Timelimit is exceeded'
                ], function ($m) use ($email) {
                    $m->to($email)->subject(__('Timelimit is exceeded'));
                });
            } catch (\Exception $e) {}
        }
    }
}
