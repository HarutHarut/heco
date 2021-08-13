<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Account;
use Stripe\Payout;
use Stripe\Stripe;

class PayoutController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $balance = 0;
        $account = null;
        if(auth()->user()->account){
            Stripe::setApiKey(config('services.stripe.secret'));
            Stripe::setApiVersion(config('services.stripe.version'));
            $account = Account::retrieve(auth()->user()->account->account_id);
            $balance_object = \Stripe\Balance::retrieve(
                ['stripe_account' => auth()->user()->account->account_id]
            );

            $pending = 0;
            foreach($balance_object->pending as $item){
             //   $pending += $item->amount;
            }
            $available = 0;
            foreach($balance_object->available as $item){
                $available += $item->amount;
            }
          $balance = $pending + $available;
        }

        $payouts = \App\Models\Payout::where('user_id', Auth::id())->latest()->paginate(50);

        return view('profile.payout', compact('balance', 'account', 'payouts'));
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function payout()
    {
        $user = Auth::user();
        $account = $user->account;

        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            Stripe::setApiVersion(config('services.stripe.version'));

            $balance_object = \Stripe\Balance::retrieve(
                ['stripe_account' => auth()->user()->account->account_id]
            );

            $pending = 0;
            foreach($balance_object->pending as $item){
                //   $pending += $item->amount;
            }
            $available = 0;
            foreach($balance_object->available as $item){
                $available += $item->amount;
            }
            $balance = $pending + $available;

            $payout = Payout::create(array(
                "amount" => $balance,
                "currency" => "eur",
            ), array("stripe_account" => $account->account_id));

            \App\Models\Payout::create([
                'user_id' => $user->id,
                'amount' => $balance,
                'payout_id' => $payout->id,
            ]);

        } catch (\Exception $e) {
            flash()->warning($e->getMessage());
            return back();
        }
        flash()->success(__('Successfull payout'));
        return back();
    }
}
