<?php

namespace App\Http\Controllers;

use App\Http\Requests\AccountRequset;
use App\Models\Account;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\File;
use Stripe\Stripe;
use Stripe\Token;

class AccountController extends Controller
{
    const COUNTRY = 'DE';

    const MCC = '5940';

    /**
     * @param AccountRequset $requset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AccountRequset $request)
    {
        try {
            Stripe::setApiKey(config('services.stripe.secret'));
            Stripe::setApiVersion(config('services.stripe.version'));
            $stripe_account = \Stripe\Account::create([
                "country" => self::COUNTRY,
                "type" => 'custom',
                "email" => \auth()->user()->email,
                'capabilities' => [
                    'transfers' => [
                        'requested' => true,
                    ],
                    'card_payments' => ['requested' => true],
                ],
                "payout_schedule" => [
                    "interval" => "manual"
                ],
            ]);

            $user = Auth::user();
            $data = $request->all();
            $data['account_id'] = $stripe_account->id;
            $account = Account::create($data);
            $user->account_id = $account->id;
            $user->save();
            $status_verified = $stripe_account->legal_entity->verification->status;
            if(!$user->birth_date){
                flash()->warning(__('Please fill all fields in Personal Information Page'));
                return back();
            }
            $stripe_account->business_url = config('app.url');
            $stripe_account->mcc = self::MCC;
            $stripe_account->legal_entity->dob->day = $user->birth_date->format('d');
            $stripe_account->legal_entity->dob->month = $user->birth_date->format('m');
            $stripe_account->legal_entity->dob->year = $user->birth_date->format('Y');
            $stripe_account->legal_entity->first_name = $user->first_name;
            $stripe_account->legal_entity->last_name = $user->last_name;
            $stripe_account->legal_entity->type = "individual";
            $stripe_account->legal_entity->personal_email = $user->email;
            $stripe_account->legal_entity->personal_phone_number = $user->phone;
            $stripe_account->legal_entity->address = [
                'city' => $user->city,
                'line1' => $user->street . ' ' . $user->house_number,
                'postal_code' => $user->zip,
                'state' => $user->state,
                'country' => self::COUNTRY
            ];

            $btoken = Token::create([
                "bank_account" => [
                    "country" => self::COUNTRY,
                    "currency" => 'EUR',
                    "account_holder_name" => $user->name,
                    "account_holder_type" => "individual",
                    "account_number" => $request->get('account_number'),
                ]
            ]);

            $piitoken = Token::create(array(
                "pii" => array(
                    "personal_id_number" => $request->get('personal_id_number'),
                )
            ));

            $stripe_account->external_account = $btoken->id;
            $stripe_account->tos_acceptance->date = time();
            $stripe_account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];

            if ($status_verified != 'verified') {

                $stripe_account->legal_entity->personal_id_number = $piitoken->id;
            }

            $stripe_account->save();

        } catch (\Exception $e) {
            flash()->warning($e->getMessage());
            return back();
        }


        flash()->success(__('Account Added'));
        return back();
    }

    /**
     * @param AccountRequset $requset
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AccountRequset $request)
    {
        $user = Auth::user();
        $account = $user->account;
        $account->update($request->all());
        Stripe::setApiKey(config('services.stripe.secret'));
        Stripe::setApiVersion(config('services.stripe.version'));
        $stripe_account = \Stripe\Account::retrieve($account->account_id);
        try{
            $status_verified = $stripe_account->legal_entity->verification->status;
            if(!$user->birth_date){
                flash()->warning(__('Please fill all fields in Personal Information Page'));
                return back();
            }
            $stripe_account->business_url = config('app.url');
            $stripe_account->mcc = self::MCC;
            $stripe_account->legal_entity->dob->day = $user->birth_date->format('d');
            $stripe_account->legal_entity->dob->month = $user->birth_date->format('m');
            $stripe_account->legal_entity->dob->year = $user->birth_date->format('Y');
            $stripe_account->legal_entity->first_name = $user->first_name;
            $stripe_account->legal_entity->last_name = $user->last_name;
            $stripe_account->legal_entity->type = "individual";
            $stripe_account->legal_entity->personal_email = $user->email;
            $stripe_account->legal_entity->personal_phone_number = $user->phone;
            $stripe_account->legal_entity->address = [
                'city' => $user->city,
                'line1' => $user->street . ' ' . $user->house_number,
                'postal_code' => $user->zip,
                'state' => $user->state,
                'country' => self::COUNTRY
            ];

            $btoken = Token::create([
                "bank_account" => [
                    "country" => self::COUNTRY,
                    "currency" => 'EUR',
                    "account_holder_name" => $user->name,
                    "account_holder_type" => "individual",
                    "account_number" => $request->get('account_number'),
                ]
            ]);

            $piitoken = Token::create(array(
                "pii" => array(
                    "personal_id_number" => $request->get('personal_id_number'),
                )
            ));

            $stripe_account->external_account = $btoken->id;
            $stripe_account->tos_acceptance->date = time();
            $stripe_account->tos_acceptance->ip = $_SERVER['REMOTE_ADDR'];

            if ($status_verified != 'verified') {

                $stripe_account->legal_entity->personal_id_number = $piitoken->id;
            }

            $stripe_account->save();

        } catch (\Exception $e) {
            flash()->warning($e->getMessage());
            return back();
        }
        flash()->success(__('Account Updated'));
        return back();
    }

    /**
     * Upload Document for Verification
     * @param $type
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateFile($type, Request $request)
    {
        if ($request->file('document')) {
            $user = Auth::user();
            try {
                Stripe::setApiKey(config('services.stripe.secret'));
                Stripe::setApiVersion(config('services.stripe.version'));
                $account_id = $user->account->account_id;
                $fp = fopen($request->file('document')->getRealPath(), 'r');
                $file = File::create(
                    [
                        "purpose" => $type,
                        "file" => $fp
                    ],
                    ["stripe_account" => $account_id]
                );
                $account = \Stripe\Account::retrieve($account_id);
                if($type == 'identity_document'){
                    $account->legal_entity->verification->document = $file->id;
                }else{
                    $account->legal_entity->verification->additional_document = $file->id;
                }

                $account->save();

            } catch (\Exception $e) {
                flash()->warning($e->getMessage());
                return back();
            }
            flash()->success(__('Stripe File Uploaded! Please wait for profile verification'));
        }else{
            flash()->warning(__('Please upload file'));
        }

        return back();
    }
}
