<?php

namespace App\Http\Controllers\Dashboard;

use App\Exports\PurchaseExport;
use App\Models\Booking;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $search = $request->get('search', null);
        $bookings = Booking::when($search, function ($query) use ($search) {
            $query
                ->whereHas('bike', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                })
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%");
                    $q->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('token', 'like', "%{$search}%");
        })->when($request->get('status'), function ($q) use ($request){
            return $q->where('status', $request->get('status'));
        })->orderBy('id', 'DESC')->paginate(10);

        return view('dashboard.bookings.index', compact('bookings'));
    }


    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function purchase(Request $request)
    {

        $search = $request->get('search', null);
        $sort = $request->sort;

        $purchases = Booking::where('status', 'success')->when($search, function ($query) use ($search) {
            $query->where(function ($x) use ($search) {
                $x->whereHas('user', function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('email', 'LIKE', "%{$search}%");
                })->orWhere(function ($q) use ($search) {
                    $q->where('name', 'LIKE', "%{$search}%")
                        ->orWhere('price', 'LIKE', "%{$search}%")
                        ->orWhere('id', 'LIKE', "%{$search}%");
                });
            });
        })->when(!$sort, function ($q) {
            $q->orderBy('id', 'DESC');
        })->sortable()->paginate(10);


        return view('dashboard.bookings.purchase', compact('purchases'));
    }

    /**
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function export()
    {
        return (new PurchaseExport())->download('purchases.xlsx');
    }

}
