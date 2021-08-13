<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\Booking;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $current_week = now()->weekOfYear;
        $chart_data = [];
        $bike_data = [];
        $seller_data = [];
        $buyer_data = [];
        $j = 0;
        for ($i = $current_week; $i > ($current_week - 4); $i--) {
            $start = Carbon::now();
            $start->setISODate(date('Y'), $i);
            $start = $start->startOfWeek();
            $end = Carbon::now();
            $end->setISODate(date('Y'), $i);
            $end = $end->endOfWeek();
            $users = User::whereBetween('created_at', [$start, $end])->count();
            $bikes_avg = Bike::where('status', 'active')->where('send_request', 1)
                ->where('parent_id', 0)->whereBetween('created_at', [$start, $end])->avg('price');
            $buyers = User::whereBetween('created_at', [$start, $end])->whereHas('bookings', function ($q) {
                return $q->where('bookings.status', 'success');
            })->count();
            $sellers = User::whereBetween('created_at', [$start, $end])->whereHas('sell_bikes')->count();
            $first_sell = Bike::where('parent_id', 0)
                ->whereNotIn('status', ['deleted', 'pending'])
                ->where('stage', 'new')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $retention_sells = Bike::where('parent_id', 0)
                ->whereNotIn('status', ['deleted', 'pending'])
                ->where('stage', 'ret')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $first_buy = Booking::where('status', 'success')
                ->where('stage', 'new')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $retention_buys = Booking::where('status', 'success')
                ->where('stage', 'ret')
                ->whereBetween('created_at', [$start, $end])
                ->count();

            $chart_data[$j]['category'] = 'KW ' . $i;
            $bike_data[$j]['category'] = 'KW ' . $i;
            $seller_data[$j]['category'] = 'KW ' . $i;
            $buyer_data[$j]['category'] = 'KW ' . $i;
            $chart_data[$j]['all'] = $users;
            $bike_data[$j]['all'] = number_format($bikes_avg, 2, '.', ',');
            $chart_data[$j]['buyers'] = $buyers;
            $chart_data[$j]['sellers'] = $sellers;
            $seller_data[$j]['new'] = $first_sell;
            $seller_data[$j]['retention'] = $retention_sells;
            $buyer_data[$j]['new'] = $first_buy;
            $buyer_data[$j]['retention'] = $retention_buys;
            $j++;
        }
        $chart_data = json_encode(array_reverse($chart_data));
        $bike_data = json_encode(array_reverse($bike_data));
        $seller_data = json_encode(array_reverse($seller_data));
        $buyer_data = json_encode(array_reverse($buyer_data));
        return view('dashboard.dashboard', compact('chart_data', 'bike_data', 'seller_data', 'buyer_data'));
    }
}
