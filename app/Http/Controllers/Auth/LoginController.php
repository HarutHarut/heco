<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Bike;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Laravel\Socialite\Facades\Socialite;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers {

        logout as performLogout;
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     *
     */
    public function showLoginForm()
    {
        abort(404);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout(\Illuminate\Http\Request $request)
    {
        $this->performLogout($request);
        return redirect('/');
    }


    /**
     * @param $provider
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToProvider($provider, Request $request)
    {
        $socialite = Socialite::driver($provider);
        if ($scopes = $this->scopes[$provider] ?? null) {
            $socialite->scopes($this->scopes[$provider]);
        }
        Session::put('back_url', url()->previous());
        return $socialite->redirect();
    }

    /**
     * @param $provider
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleProviderCallback($provider)
    {
        $user = Socialite::driver($provider)->user();

        $authUser = $this->findOrCreateUser($user, $provider);
        Auth::login($authUser, true);
        if (Session::get('back_url')) {
            return redirect(Session::get('back_url'));
        }
        return back();
    }


    /**
     * @param $user
     * @param $provider
     * @return mixed
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        }
        $userByEmnail = User::where('email', $user->email)->first();
        if ($userByEmnail) {
            return $userByEmnail;
        }
        $name = explode(' ', $user->name);
        $newUser = User::create([
            'first_name' => $name[0],
            'last_name' => $name[1] ?? $name[0],
            'email' => $user->email ?: $user->id,
            'provider' => $provider,
            'password' => '',
            'email_verified_at' => now(),
            'provider_id' => $user->id,
            'lang_message' => LaravelLocalization::getCurrentLocale()
        ]);

        try {
            $email = $newUser->email;
            App::setLocale($newUser->lang_message);
            Mail::send('emails.welcome', [
                'name' => $newUser->first_name . ' ' . $newUser->last_name
            ], function ($m) use ($email) {
                $m->to($email)->subject(__('Welcome'));
            });
        } catch (\Exception $e) {
        }

        return $newUser;
    }


    /**
     * Handle a login request to the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(\Illuminate\Http\Request $request)
    {
        $this->validateLogin($request);

        // If the class is using the ThrottlesLogins trait, we can automatically throttle
        // the login attempts for this application. We'll key this by the username and
        // the IP address of the client making these requests into this application.
        if (method_exists($this, 'hasTooManyLoginAttempts') &&
            $this->hasTooManyLoginAttempts($request)) {
            $this->fireLockoutEvent($request);

            return $this->sendLockoutResponse($request);
        }

        if ($this->attemptLogin($request)) {
            return $this->sendLoginResponse($request);
        }

        // If the login attempt was unsuccessful we will increment the number of attempts
        // to login and redirect the user back to the login form. Of course, when this
        // user surpasses their maximum number of attempts they will get locked out.
        $this->incrementLoginAttempts($request);

        return $this->sendFailedLoginResponse($request);
    }


    /**
     * Attempt to log the user into the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    protected function attemptLogin(\Illuminate\Http\Request $request)
    {
        $params = $this->credentials($request) + ['status' => 1];
        return $this->guard()->attempt(
            $params, $request->filled('remember')
        );
    }
}
