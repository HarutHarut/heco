<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdressRequest;
use App\Models\Bike;
use App\Models\Booking;
use App\Models\Message;
use App\Models\User;
use App\Models\ViewedBicycle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Stripe\Stripe;
use Stripe\Transfer;

class ShippingController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cart(Request $request)
    {
        $data = $request->all();
        $package_id = $data['package_id'];
        $bike = Bike::findOrFail($data['bike_id']);

        $message = Message::with('bike')
            ->has('bike')
            ->where('bike_id', $bike->id)
            ->where('sender_id', Auth::id())
            ->where(function ($q) {
                $q->where('status', 2)
                    ->orWhere(function ($query) {
                        $query->where('status', '!=', -1)->whereNotNull('answer');
                    });
            })
            ->first();

        if ($message) {
            $bike = $message->bike;
            $price = $message->answer ?? $message->message ?? $bike->price;
        } else {
            $price = $bike->price;
        }

        $service_fee = config("enums.service_fee.$package_id")['price'];
        $percent = Booking::FEE_PERCENT;

        $total = $price + $service_fee;
        $total += $total * $percent / 100;

        $veviewed_bikes = ViewedBicycle::with('bike')->where('user_id', Auth::id())->limit(3)->get();
        $similar_models = Bike::where('brand_model_id', $bike->brand_model_id)
            ->where('parent_id', 0)->where('id', '!=', $bike->id)->where('status', 'active')->where('send_request', 1)
            ->inRandomOrder()->limit(5)->get();
        return view('shop.cart', compact('price', 'bike', 'total', 'similar_models', 'veviewed_bikes', 'package_id'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function shipping_address(Request $request)
    {
        $bike = Bike::find($request->get('bike_id'));
        return redirect()->route('shipping.address', [
            'bike_id' => $bike->id,
            'shipping_met' => $request->get('shipping_met'),
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function address(Request $request)
    {
        $package_id = $request->get('package_id');
        $bike = Bike::find($request->get('bike_id'));
        $message = Message::with('bike')
            ->has('bike')
            ->where('bike_id', $bike->id)
            ->where('sender_id', Auth::id())
            ->where(function ($q) {
                $q->where('status', 2)
                    ->orWhere(function ($query) {
                        $query->where('status', '!=', -1)->whereNotNull('answer');
                    });
            })
            ->first();
        if ($message) {
            $bike = $message->bike;
            $price = $message->answer ?? $message->message ?? $bike->price;
        } else {
            $price = $bike->price;
        }

        $service_fee = config('enums.service_fee.' . $package_id)['price'];
        $percent = Booking::FEE_PERCENT;
        $total = $price + $service_fee;
        $total += $total * $percent / 100;

        return view('shop.shipping-address', compact('price', 'bike', 'total', 'package_id'));
    }


    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function storeOrder(AdressRequest $request, $bike_id)
    {
        $user = Auth::user();
        $data = $request->validated();
        $bike = Bike::find($bike_id);
        $price = $bike->price;

        $percent = Booking::FEE_PERCENT;
        $package_id = $request->get('package_id');
        $service_fee = config('enums.service_fee.' . $package_id)['price'];
        $save_info = $request->get('save_information') ?? '';

        $message = Message::with('bike')
            ->has('bike')
            ->where('bike_id', $bike->id)
            ->where('sender_id', Auth::id())
            ->where(function ($q) {
                $q->where('status', 2)
                    ->orWhere(function ($query) {
                        $query->where('status', '!=', -1)->whereNotNull('answer');
                    });
            })
            ->first();
        if ($message) {
            $bike = $message->bike;
            $price = $message->answer ?? $message->message ?? $bike->price;
        } else {
            $bike = Bike::findOrFail($bike->id);
            $price = $bike->price;
        }

        $total = $price + $service_fee;
        $total += $total * $percent / 100;
        if ($save_info) {
            $user->update($data);
        }
        $data = [
            "name" => $request->first_name . ' ' . $request->last_name,
            "price" => number_format($total, 2, '.', ''),
            "bike_price" => number_format($price, 2, '.', ''),
            "phone" => $request->phone,
            "city" => $request->city,
            "street" => $request->street,
            "house_number" => $request->house_number,
            "zip" => $request->zip,
            "bike_id" => $bike_id,
            "user_id" => $user->id,
            'is_shipping' => ($package_id == 0) ? 0 : 1,
            'package_id' => $package_id,
            'service_fee' => $service_fee,
            'action_token' => generateRandomString(32)
        ];

        $booking = Booking::create($data);
        return redirect()->route('shipping.info', [
            'booking_id' => $booking->id,
            'package_id' => $package_id
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function cartPay(Request $request)
    {
        $booking = Booking::has('bike')->with('bike')->findOrFail($request->get('booking_id'));
        $bike = $booking->bike;
        $buyer = Auth::user();
        $package_id = $request->query('package_id');
        $message = Message::with('bike')
            ->has('bike')
            ->where('bike_id', $bike->id)
            ->where('sender_id', Auth::id())
            ->where(function ($q) {
                $q->where('status', 2)
                    ->orWhere(function ($query) {
                        $query->where('status', '!=', -1)->whereNotNull('answer');
                    });
            })
            ->first();
        if ($message) {
            $bike = $message->bike;
            $price = $message->answer ?? $message->message ?? $bike->price;
        } else {
            $price = $bike->price;
        }
        return view('shop.cart_pay', compact('price', 'bike', 'buyer', 'booking'));
    }


    /**
     * @param $token
     * @param $type
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function actions($token, $type)
    {
        $booking = Booking::where('action_token', $token)->firstOrFail();

        return view('payments.actions', compact('booking', 'type'));
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actionsStore($id, Request $request)
    {
        $booking = Booking::findOrFail($id);
        $booking->pickup_date = $request->get('pickup_date');
        if ($request->get('type') == 'seller_confirm' && !$request->get('accept')) {
            Mail::send('emails.seller_accepted', [
                'booking' => $booking,
                'type' => 'seller'
            ], function ($m) use ($booking) {
                $m->to($booking->bike->user->email)->subject(__('Order Accepted'));
            });
            Mail::send('emails.seller_accepted', [
                'booking' => $booking,
                'type' => 'buyer'
            ], function ($m) use ($booking) {
                $m->to($booking->user->email)->subject(__('Order Accepted'));
            });
            if (!$request->get('pickup_date')) {
                Mail::send('emails.new_order', [
                    'booking' => $booking,
                ], function ($m) {
                    $m->to(config('mail.adminmail'))->subject('New Bike Order');
                });
            }
        }
        if ($request->get('pickup_date') && !$booking->seller_confirm) {
            //ShippingService::ship($booking);
            Mail::send('emails.new_pickup', [
                'booking' => $booking,
            ], function ($m) use ($booking) {
                $m->to(config('mail.adminmail'))->subject(__('New PickUp'));
            });
        }
        if (($request->get('type') == 'seller_confirm' && $request->get('accept')) || $request->get('type') == 'buyer_confirm') {
            $booking->{$request->get('type')} = 1;
        }

        if ($booking->seller_confirm && $booking->buyer_confirm && $booking->status != 'success') {
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

                } catch (\Exception $e) {
                }
            }
        }
        $booking->save();
        flash()->success(__('Thank you for accept'));
        return redirect()->route('home');
    }


    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function actionsDecline($id, Request $request)
    {
        $booking = Booking::findOrFail($id);

        if ($request->get('type') == 'seller_decline') {
            Mail::send('emails.seller_decline', [
                'booking' => $booking,
                'type' => 'seller'
            ], function ($m) use ($booking) {
                $m->to($booking->bike->user->email)->subject(__('Order Declined'));
            });
            Mail::send('emails.seller_decline', [
                'booking' => $booking,
                'type' => 'buyer'
            ], function ($m) use ($booking) {
                $m->to($booking->user->email)->subject(__('Order Declined'));
            });
        }
        flash()->success(__('You declined order request'));
        return redirect()->route('home');
    }

}
