<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\RoleUser;
use App\Services\ShippingService;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // for test
//        $booking = Booking::latest()->first();
//        ShippinsgService::ship($booking);
        (new \App\Services\SeoService())->seoForPage('home');
        return view('home');
    }
}
