<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use App\Provider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

use Socialite;

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

    use AuthenticatesUsers;

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

    public function redirectToProvider($provider)
    {
        if ($provider == 'facebook') {
            return Socialite::driver($provider)->fields([
                'name', 'email', 'gender', 'age_range', 'birthday', 'location', 'hometown'
            ])->scopes([
                'user_gender', 'user_age_range', 'user_birthday', 'user_location', 'user_hometown'
            ])->redirect();
        }
        else if ($provider == 'linkedin') {
            return Socialite::driver($provider)->scopes([
                'r_liteprofile', 'r_emailaddress', 'w_member_social'
            ])->redirect();
        }
    }

    /**
     * Obtain the user information from Facebook.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback($provider)
    {
        $user_social = Socialite::driver($provider)->user();
        if (!$user = User::where('email', $user_social->email)
            ->first()) {
            $user = User::create([
                'email' => $user_social->getEmail(),
                'first_name' => $user_social->first_name,
                'last_name' => $user_social->last_name,
                'profile_picture' => $user_social->avatar_original,
            ]);
            $createProvider = Provider::create([
                'user_id' => $user->id,
                'provider_id' => $user_social->getId(),
                'provider' => $provider,
            ]);
        } 
        else if (!$user_provider = Provider::where('provider_id', $user_social->getID())
                ->where('provider', $provider)
                ->first()) {
            $createProvider = Provider::create([
                'user_id' => $user->id,
                'provider_id' => $user_social->getId(),
                'provider' => $provider,
            ]);        
        }
        else if ($user_provider->user_id != $user->id) {
            $user_provider->update(['user_id' => $user->id]);
        }   
        Auth::login($user, true);
        return redirect($this->redirectTo);
    }
}