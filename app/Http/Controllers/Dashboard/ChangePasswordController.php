<?php


namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\PasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\SettingService;

class ChangePasswordController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        return view('dashboard.settings.password');
    }


    /**
     * @param PasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(PasswordRequest $request)
    {

        return (new SettingService())->changePassword($request);

    }

}
