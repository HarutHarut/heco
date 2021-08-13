<?php

namespace App\Console\Commands;

use App\Models\Bike;
use App\Models\Filter;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class NewFilterResult extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'new_filter_result';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Mail filter result new bikes';

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
        $filters = Filter::with('user')->get();

        foreach ($filters as $filter){
            $user = $filter->user;
            $data = $filter->filter;
            $bikes = Bike::whereBetween('created_at', [now(), now()->subDay()->startOfDay()])
                ->when($data['search'], function ($q) use ($data){
                    return $q->where('name', 'LIKE', '%' . $data['search'] . '%');
                })
                ->when(count($data['brand_ids']) && $data['brand_ids'], function ($q) use ($data){
                    return $q->whereIn('brand_id', $data['brand_ids']);
                })
                ->when(count($data['model_ids']), function ($q) use ($data){
                    return $q->whereIn('brand_model_id', $data['model_ids']);
                })
                ->when(count($data['year']), function ($q) use ($data){
                    return $q->whereIn('year', $data['year']);
                })
                ->when(count($data['component_ids']), function ($q) use ($data){
                    return $q->whereIn('component_id', $data['component_ids']);
                })
                ->when(count($data['size']), function ($q) use ($data){
                    return $q->whereIn('frame_size', $data['size']);
                })
                ->when(count($data['condition']), function ($q) use ($data){
                    return $q->whereIn('condition', $data['condition']);
                })
                ->when(count($data['color']), function ($q) use ($data){
                    return $q->whereIn('color', $data['color']);
                })
                ->when($data['min_price'], function ($q) use ($data){
                    return $q->where('price', '>=',  $data['min_price']);
                })
                ->when($data['max_price'], function ($q) use ($data){
                    return $q->where('price', '<=',  $data['max_price']);
                })->get();

            if(count($bikes)){
                Mail::send('emails.filter_result', [
                    'user' => $user
                ], function ($m) use ($user) {
                    $m->to($user->email)->subject(__('New Bikes Available'));
                });
            }

        }
    }
}
