<?php

namespace App\Services;


use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class SettingService extends Controller
{
    /**
     * @param $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public  function changePassword($request)
    {
        if (!Hash::check($request['current_password'], Auth()->user()->getAuthPassword())) {

            return redirect()->back()->withErrors(['current_password' => [0 => __("Please enter current right password")]]);

        }
        Auth()->user()->password = bcrypt($request->get('password_confirmation'));
        Auth()->user()->save();

        flash()->success(__('dashboard_success.password_updated'));

        return redirect()->back();
    }


}
