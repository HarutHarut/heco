<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Services\ShippingService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Stripe\Checkout\Session;
use Stripe\Stripe;
use Stripe\Transfer;

class StripeController extends Controller
{
    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function pay($id, Request $request)
    {
        $booking = Booking::findOrFail($id);

        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiVersion(config('services.stripe.version'));
        $session = Session::create([
//            'payment_method_types' => ['card'],
            'mode' => 'payment',
            'line_items' => [
                [
                    'name' => 'Buycycle',
                    'description' => 'Bike: ' . $booking->bike->name,
                    'amount' => $booking->price * 100,
                    'currency' => 'eur',
                    'quantity' => 1,
                ],
            ],
            'customer_email' => auth()->user()->email,
            'success_url' => route('pay.result', 'success'),
            'cancel_url' => route('pay.result', 'cancel'),
        ]);

        $booking->token = $session->id;
        $booking->status = 'pending';
        $booking->save();

        return redirect()->route('pay.redirect', $session->id);
    }


    /**
     * @param $session_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function redirect($session_id)
    {
        return view('payments.redirect', compact('session_id'));
    }


    /**
     * @param Request $request
     */
    public function sessionSuccess(Request $request)
    {
        $object = $request['data']['object'];
        $booking = Booking::where('token', $object['id'])->where('status', 'pending')->first();
        if ($booking) {
//            Mail::raw(json_encode($request->all()), function ($m){
//                $m->to('josh.alecyan@gmail.com')->subject('Webhook details');
//            });
            $booking->payment_id = $object['payment_intent'];
            $booking->status = 'paid';
            $booking->save();
            $bike = $booking->bike;
            $bike->is_sold = 1;
            $bike->save();

            Mail::send('emails.order', [
                'data' => $booking,
                'type' => 'seller'
            ], function ($m) use ($booking) {
                $m->to($booking->bike->user->email)->subject(__('Bike payment request'));
            });
            Mail::send('emails.order', [
                'data' => $booking,
                'type' => 'buyer'
            ], function ($m) use ($booking) {
                $m->to($booking->user->email)->subject(__('Bike payment request'));
            });

        }
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Stripe\Exception\ApiErrorException
     */
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $bike = $booking->bike;
        $user = $bike->user;

        if ($user->account) {
            Stripe::setApiKey(config('services.stripe.secret'));
            Stripe::setApiVersion(config('services.stripe.version'));
            try {
                $transfer = Transfer::create(array(
                    'amount' => $booking->bike_price * 100,
                    'currency' => 'eur',
                    'destination' => $user->account->account_id
                ));
                $booking->status = 'success';
                $booking_cnt = $user->bookings->where('status', 'success')->count();
                $booking->stage = ($booking_cnt == 0) ? 'new' : 'ret';
                $booking->save();

                flash()->success(__('Booking Confirmed'));
            } catch (\Exception $e) {
                flash()->warning($e->getMessage());
                return back();
            }
        } else {
            flash()->success(__('User account problem'));
        }
        return back();
    }


    /**
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function result($type)
    {
        return view('payments.result', compact('type'));
    }

}
